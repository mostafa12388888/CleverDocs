<?php

namespace App\Services\CompanyAbout;

use App\Enum\Company\AvatarEnum;
use App\Exceptions\cantDeleteIsKeyContentException;
use App\Exceptions\CanDeleteMyAccountException;
use App\Exceptions\Contact\CanDeleteContactHasUserOrKeyContactException;
use App\Http\Filters\Filter;
use App\Repository\CompanyAbout\ContactRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Throwable;

class ContactService extends MainService
{
    /**
     * @var ContactRepository
     */

    protected MainRepository $repository;
    /**
     * @param ContactRepository $repository
     */

    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function index(int $page, int $perPage,?Filter $filter=null): mixed
    {
        return  $this->repository->index($page, $perPage, $filter);
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
    public function lookupPaginate(int $page, int $perPage,?Filter $filter=null): mixed
    {
        return  $this->repository->lookupPaginate($page, $perPage, $filter);
    }
    /**
     * store
     *
     * @param mixed $contact
     * @return mixed
     * @throws Throwable
     */
    public function store(array $contact): mixed
    {
        return $this->applyTransaction(function () use ($contact) {
            $image = isset($contact["image"]) ? UploadImage($contact["image"], "Contacts", "logo") : null;

            if(isset($contact['isKeyContact']) &&  $contact['isKeyContact']){
                $this->updateManyWhere(["company_id"=> $contact["companyId"],"is_key_contact"=>true],
                 [
                  "is_key_contact"=>false,
                 ]
                );
            }

            return $this->add([
                'phone1' => $contact['phone1'],
                'phone2' => $contact['phone2'] ?? null,
                'is_key_contact' => $contact['isKeyContact'] ?? false,
                'position' =>isset($contact['position'])? json_encode($contact['position']):null,
                "image" => $image,
                'company_id' => $contact['companyId'],
                'contact_email' => $contact['email'],
                "name" => json_encode($contact['name']),
                'address' =>isset($contact['address'])?json_encode($contact['address']):null,
                "created_by" => auth()->id(),
            ]);
        });
    }

    /**
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws Throwable
     */
    public function markContact(int $id,array $data):mixed
    {
        $contact = $this->findOrFail($id);
        $this->updateManyWhere(["company_id" =>$contact->company_id,"is_key_contact" => true],
            [
                "is_key_contact" => false,
            ]);

        $contact->update([
            "is_key_contact" => (bool)$data['isKeyContact'],
        ]);
        return $contact;
    }
    /**
     * updateAvatar
     *
     * @param  mixed $id
     * @param  mixed $avatarId
     * @return mixed
     */
    public function updateAvatar(int $id,int $avatarId=0):mixed
    {
        $contact = $this->findOrFail($id);
        $contact->update([
            "avatar_id" =>$avatarId,
        ]);
        return AvatarEnum::findById($avatarId);
    }

    /**
     * changePicture
     *
     * @param mixed $id
     * @param int|null $fileId
     * @return mixed
     */
    public function changePicture(int $id, ?int $fileId):mixed
    {
        return  $this->handleSingleFileableUpdate($id, $fileId);
    }

    /**
     * update
     *
     * @param mixed $id
     * @param mixed $data
     * @return mixed
     * @throws Throwable
     */
    public function update(int $id, array $data): mixed
    {
        return $this->applyTransaction(function () use ($id, $data) {
            $contact = $this->findOrFail($id);
            $image = $contact->image;
//            if (isset($data["image"])) {
//                deleteImage($image, "logo");
//                $image = UploadImage($data["image"], "Contacts", "logo");
//            }

            if (isset($data['isKeyContact']) && $data['isKeyContact']) {
                $this->updateManyWhere(["company_id" => $data["companyId"],"is_key_contact" => true],
                    [
                        "is_key_contact" => false,
                    ]);
            }
            $contactData= $this->repository->update($contact->id, [
                'phone1' => $data['phone1'],
                'phone2' => $data['phone2'] ?? null,
                'is_key_contact' => $data['isKeyContact'] ?? false,
                'position' => isset($data['position'])? json_encode($data['position']):null,
                'company_id' => $data['companyId'],
                "image" => $image,
                'contact_email' => $data['email'],
                "name" => json_encode($data['name']),
                'address' => isset($data['address'])? json_encode($data['address']):null,
                "updated_by" => auth()->id(),
            ]);
            app(UserService::class)->updateManyWhere(['contact_id'=>$contactData->id],["contact_name"=>$contactData->name]);
            return $contactData;
        });
    }

    /**
     * @param int $id
     * @return bool|null
     * @throws CanDeleteMyAccountException
     * @throws Throwable
     * @throws cantDeleteIsKeyContentException
     */
    public function destroy(int $id): ?bool
    {
         $contact=$this->find($id);
         if(!$contact) return false;
        $this->_validateDelete($contact);
        $this->repository->update($id, ['deleted_by' => auth()->id(),
        ]);
        return $this->repository->delete([$id]);
    }

    /**
     * @param array $contact
     * @return void
     * @throws CanDeleteContactHasUserOrKeyContactException
     * @throws Throwable
     */
    public function bulkDelete(array $contact): void
    {
        $idDelete=[];
        $ids=[];
        foreach ($contact["ids"] as $contactId){
        $contactData=$this->find($contactId);
        if ($contactData?->user)
            $ids[]=trans('validation.messages.cant_delete_has_user').$contactData->contact_email;
        else if ($contactData?->is_key_contact)
           $ids[]=trans('validation.messages.cant_delete_is_key_contact').$contactData->contact_email;
        else
            $idDelete[]=$contactId;
        }
        $this->updateWhereIn("id",$idDelete, [
            'deleted_by' => auth()->id(),
        ]);
        $this->delete($idDelete);
        $this->_validateDeleteArray($ids);

    }

    /**
     * _validateDelete
     *
     * @param $contact
     * @return void
     * @throws CanDeleteMyAccountException
     * @throws cantDeleteIsKeyContentException
     */
    private function _validateDelete($contact): void
    {
        if ($contact?->is_key_contact) throw new cantDeleteIsKeyContentException();
        if ($contact?->user) throw new CanDeleteMyAccountException();
    }

    /**
     * _validateDeleteArray
     *
     * @param mixed $deleteArray
     * @return void
     * @throws CanDeleteContactHasUserOrKeyContactException
     */
    private function _validateDeleteArray(array $deleteArray): void
    {
        if(!empty($deleteArray)) {
            throw new CanDeleteContactHasUserOrKeyContactException(errors :$deleteArray);
        }
    }
}

