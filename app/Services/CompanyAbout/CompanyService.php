<?php

namespace App\Services\CompanyAbout;

use App\Exceptions\CanDeleteContentException;
use App\Exceptions\Company\CanDeleteCompanyHasContactException;
use App\Http\Filters\Filter;
use App\Models\CompanyAbout\Company;
use App\Models\Form\ProjectAssignedCompany;
use App\Repository\CompanyAbout\CompanyRepository;
use App\Repository\MainRepository;
use App\Services\FileableService;
use App\Services\MainService;
use Throwable;

class CompanyService extends MainService
{

    /**
     * @var CompanyRepository
     */

    protected MainRepository $repository;
    /**
     * @param CompanyRepository $repository
     */

    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * uploadLogo
     *
     * @param  mixed $logo
     * @return void
     */
    public function uploadLogo($logo)
    {
        if ($logo->hasFile('logo')) {
            $photo = $logo->file('logo');
            $fileName = $photo->getClientOriginalName();
            return $logo->file('logo')->storeAs("Logo", $fileName, 'logo');
        }
        return 0;
    }

    /**
     * store
     *
     * @param mixed $data
     * @return mixed
     * @throws \Throwable
     */
    public function store(array $data): mixed
    {
        return $this->applyTransaction(function () use ($data) {
            $companyData = $data['companyData'];
            $company = $this->add([
                'name' => $companyData['name'],
                'email' => $companyData['email'],
                'phone1' => $companyData['phone1'],
                'phone2' => $companyData['phone2'] ?? null,
                'registration' => $companyData['registration']?? null,
                'tax' => $companyData['taxNo']?? null,
                'vat' => $companyData['vatNo']?? null,
                'tax_percentage' => $companyData['taxPercent']?? null,
                'vat_percentage' => $companyData['vatPercent']?? null,
                'company_filed' => $companyData['field']?? null,
                'address' =>isset($companyData['address'])?json_encode($companyData['address']):null,
                "created_by" => auth()->user()->id,
            ]);
            if(isset($data['projectId']))
                app(ProjectAssignedCompany::class)->insert(['project_id'=>$data['projectId'],'company_id'=>$company->id,]);
            $data['keyContact']['companyId'] = $company->id;
            $data['keyContact']["isKeyContact"]=1;
             app(ContactService::class)->store($data['keyContact']);

            $this->_handleCompanyLogo($company, $companyData['logoId'] ?? null);

            return $company;
        });
    }

    /**
     * update
     *
     * @param int $id
     * @param mixed $data
     * @return mixed
     * @throws \Throwable
     */
    public function update(int $id, array $data): mixed
    {
        return $this->applyTransaction(function () use ($id, $data) {
            $companyData = $data['companyData'];
            $company=  $this->repository->update($id, [
                'name' => $companyData['name'] ?? null,
                'email' => $companyData['email'] ?? null,
                'phone1' => $companyData['phone1']?? null,
                'phone2' => $companyData['phone2'] ?? null,
                'registration' => $companyData['registration']??null,
                'tax' => $companyData['taxNo']??null,
                'vat' => $companyData['vatNo']??  null,
                'tax_percentage' => $companyData['taxPercent']?? null,
                'vat_percentage' => $companyData['vatPercent']??null,
                'company_filed' => $companyData['field']??null,
                'address' =>isset($companyData['address'])?json_encode($companyData['address']):null,
                "updated_by" => auth()->user()->id,
            ]);

            $this->_handleCompanyLogo($company, $companyData['logoId'] ?? null);

            return $company;
        });
    }

    /**
     * index
     *
     * @param mixed $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function index(int $page, int $perPage , ?Filter $filter=null): mixed
    {
        return  $this->repository->index($page, $perPage,$filter);
    }
    /**
     * getDataExport
     *
     * @param  mixed $filter
     * @return void
     */
    public function getDataExport(?Filter $filter = null)
    {
        return $this->repository->index(1, 2, $filter, false);
    }
    /**
     * lookup
     *
     * @param  mixed $filter
     * @return mixed
     */
    public function lookup(?Filter $filter=null): mixed
    {
        return  $this->repository->lookup($filter);
    }
    /**
     * lookupPaginate
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookupPaginate(int $page, int $perPage , ?Filter $filter=null): mixed
    {
        return  $this->repository->lookupPaginate($page, $perPage,$filter);
    }

    /**
     * destroy
     *
     * @param mixed $companyId
     * @return mixed
     * @throws CanDeleteContentException | Throwable
     */
    public function destroy(mixed $companyId): mixed
    {

        //get company with contacts that has users
        $company = $this->firstBy(['id' => $companyId], with: ['contacts' => function ($query) {
            $query->whereHas('user');
        }]);

        if (!$company) return true;
        if (!$this->_validateDelete($company)) throw new CanDeleteContentException();

        $this->repository->update($companyId, [
            'deleted_by' => auth()->user()->id,
        ]);

        if($company?->logo) deleteImage($company->logo, "logo");

        return $this->delete([$companyId]);
    }

    /**
     * @param array $data
     * @return void
     * @throws CanDeleteCompanyHasContactException
     * @throws Throwable
     */
    public function bulkDelete(array $data): void
    {
        $idDelete = [];
        $ids = [];
        $companies = $this->findAllByWhereIn('id', $data["ids"] ?? [], with: ['contacts' => function ($query) {
            $query->whereHas('user');
        }]);

        foreach ($companies as $company) {

            if (!$this->_validateDelete($company))
                $ids[] = trans('validation.messages.cant_delete_has_contact') . $company->email;
            else
                $idDelete[] = $company->id;
        }

        $this->repository->updateWhereIn("id", $idDelete, [
            'deleted_by' => auth()->user()->id,
        ]);
        $this->delete($idDelete);

        $this->_validateDeleteArray($ids);
    }


    /**
     * _validateDelete
     *
     * @param mixed $company
     * @return bool
     */
    private function _validateDelete(mixed $company): bool
    {
        if ($company?->contacts->count()) return false;

        return true;
    }

    /**
     * _validateDeleteArray
     *
     * @param mixed $deleteArray
     * @return void
     * @throws CanDeleteCompanyHasContactException
     */
    private function _validateDeleteArray(array $deleteArray): void
    {
        if(!empty($deleteArray)) {
            throw new CanDeleteCompanyHasContactException(errors :$deleteArray);
        }
    }

    /**
     * @param int $fileId
     * @param mixed $company
     * @return void
     */
    function _handleCompanyLogo( mixed $company, ?int $fileId=null,): void
    {
        if ($fileId) {
            app(FileableService::class)->updateOrCreate([
                'file_id' => $fileId,
                'fileable_id' => $company->id,
                'fileable_type' => $this->repository->model(),
            ], [
                'fileable_id' => $company->id,
                'fileable_type' => $this->repository->model()
            ]);
        } else {
            app(FileableService::class)->deleteCollectionBy([
                'fileable_id' => $company->id,
                'fileable_type' => $this->repository->model()
            ]);
        }
    }

    private function _submissions():void
    {
       //TODO:submissions validations after submission business
    }


}
