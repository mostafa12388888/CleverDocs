<?php
namespace App\Services\CompanyAbout;

use App\Exceptions\CanDeleteUserException;
use App\Exceptions\Users\CanNotChangeNewPasswordSameOldPasswordException;
use App\Exceptions\CanNotChangeUserPasswordException;
use App\Exceptions\Users\ContactAlreadyHasUserException;
use App\Repository\CompanyAbout\UserRepository;
use App\Repository\MainRepository;
use App\Services\MainService;
use Illuminate\Contracts\Queue\EntityNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\InvalidLoginCredentialsException;
use App\Exceptions\UnAuthorizedActionException;
use App\Exceptions\Users\CanDeleteIsDefaultUserException;
use App\Http\Filters\Filter;
use App\Services\Form\UserAssignProjectService;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserService extends MainService
{
    /**
     * @var UserRepository
     */
    protected MainRepository $repository;
    /**
     * __construct
     *
     * @param  mixed $repository
     * @return void
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct($repository);
    }


    /**
     * index
     *
     * @param mixed $page
     * @param mixed $perPage
     * @param Filter|null $filter
     * @return mixed
     */
    public function index(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->index($page, $perPage,$filter);
    }
    /**
     * lookUpPagination
     *
     * @param  mixed $page
     * @param  mixed $perPage
     * @param  mixed $filter
     * @return mixed
     */
    public function lookUpPagination(int $page, int $perPage,?Filter $filter = null): mixed
    {
        return $this->repository->lookUpPagination($page, $perPage,$filter);
    }

    /**
     * show
     *
     * @param  mixed $id
     * @return mixed
     */
    public function show(int $id): mixed
    {
        $resource =  $this->repository->show($id);
        if (!$resource) throw new EntityNotFoundException('User',$id);
        $projectsGroupedByWbs =  $resource->projects ? $resource->projects->groupBy('w_b_s_id')->map(function ($item, $key) {
            return (object)[
                'wbs_id' => $key,
                'wbs_title' => $item[0]['wbs']['title'],
                'projects' => $item
            ];
        })->values() : [];

        $resource->projectsGroupedByWbs = collect($projectsGroupedByWbs);
        return $resource;
    }

    /**
     * @param array $data
     * @return mixed
     * @throws ContactAlreadyHasUserException
     * @throws \Throwable
     */
    public function store(array $data): mixed
    {
        $this->_validateStore($data["contactId"]);
        return $this->applyTransaction(function () use ($data) {
           $contact= app(ContactService::class)->find($data['contactId']);
        $user= $this->add([
            'contact_id' => $data['contactId'],
            'password' => Hash::make($data['password']),
            'role_id' => $data['roleId'],
            'is_active' => $data['isActive'],
            'code' => $data['code'],
            'email' => $data['email'],
            "contact_name"=>$contact->name,
            "created_by" => auth()->user()->id,
        ]);
        if(isset($data["projectIds"]))
        App(UserAssignProjectService::class)->assignProjectsToUser($user->id,$data["projectIds"]);

        return $this->show($user->id);
      });
    }



    /**
     * @param $id
     * @return void
     * @throws ContactAlreadyHasUserException|\Throwable
     */
    public function _validateStore($id): void
    {
        $user = $this->firstBy(['contact_id'=> $id]);
        if($user) throw new ContactAlreadyHasUserException();
    }

    /**
     * update
     *
     * @param  mixed $id
     * @param  mixed $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        $user=$this->findOrFail($id);
        $this->_validateUserIsDefault($user->is_default);
        $user = $this->repository->update($id, [
            'role_id' => $data['roleId'],
            'is_active' => $data['isActive'],
            'code' => $data['code'],
            'email' => $data['email'],
            "updated_by"=>auth()->user()->id,
        ]);
        if (!$user->is_active && $user->tokens()->count() > 0)
            $user->tokens()->delete();
        return $this->show($user->id);

    }

/**
 * updatePassword
 *
 * @param  mixed $data
 * @param  mixed $id
 * @return mixed
 */
public function updatePassword(array $data,int $id):mixed
{
    $user=$this->findOrFail($id);
     $this->repository->update($id,['password' => Hash::make($data['newPassword'])]);
      if ($user->tokens()->count() > 0)
        $user->tokens()->delete();
    return $user;
}

/**
 * updateUserPassword
 *
 * @param  mixed $data
 * @param  mixed $id
 * @return mixed
 */
public function updateUserPassword(array $data):mixed
{
    $id=auth()->id();
    $user= $this->findOrFail($id);
    $this->_validateUserIsDefault($user->is_default);
$this->_validateUser($id, $data['oldPassword'],$data['newPassword']);
 $this->repository->update($id,['password' => Hash::make($data['newPassword'])]);
 if ($user->tokens()->count() > 0)$user->tokens()->delete();
    return $user;
}
/**
     * changeMyPicture
     *
     * @param  mixed $data
     * @return mixed
     */
    public function changeMyPicture($data):mixed
    {
        App(ContactService::class)->updateAvatar(auth()->user()->contact_id);
        return App(ContactService::class)->changePicture(auth()->user()->contact_id, $data["pictureId"] ?? null);
    }
    /**
     * updateAvatar
     *
     * @param  mixed $data
     * @return mixed
     */
    public function updateAvatar($data):mixed
    {
        return App(ContactService::class)->updateAvatar(auth()->user()->contact_id, $data["avatarId"] ?? 0);
    }
    /**
     * changePicture
     *
     * @param  mixed $data
     * @return mixed
     */
    public function changePicture($data):mixed
    {
       $user= $this->findOrFail($data["userId"]);
        return App(ContactService::class)->changePicture($user->contact_id, $data["pictureId"] ?? null);
    }
/**
 * _validateUser
 *
 * @param  mixed $id
 * @param  mixed $oldPassword
 * @return void
 */
public function _validateUser(int $id,string $oldPassword,string $newPassword): void
{
        $password=$this->findOrFail($id)->password;
        if (!Hash::check($oldPassword,$password)) throw new CanNotChangeUserPasswordException();
        if (Hash::check($newPassword,$password)) throw new CanNotChangeNewPasswordSameOldPasswordException();
}

    /**
     * deleteUser
     *
     * @param  mixed $id
     * @return mixed
     */
    public function deleteUser(int $id): mixed
    {
        $user=$this->find($id);
        if(!$user) return false;
        $this->_validateUserIsDefault($user->is_default);
        $this->repository->update($id, ['deleted_by' => auth()->user()->id]);
        return $this->delete([$id]);
    }
         /**
     * bulkDelete
     *
     * @param  mixed $wbsId
     * @return mixed
     */
    public function bulkDelete(array $user): void
    {
        $idDelete=[];
        $ids=[];
        foreach ($user["ids"] as $userId){
        $userData= $this->find($userId);
        if ($userData?->is_default)
            $ids[]=trans('validation.messages.cant_delete_is_default_user').$userData->email;
        else
            $idDelete[]=$userId;
        }
        $this->updateWhereIn("id",$idDelete, [
            'deleted_by' => auth()->user()->id,
            ]);
        $this->delete($idDelete);
        $this->_validateDeleteArray($ids);
    }

    /**
     * _validateUserIsDefault
     *
     * @param  mixed $isDefault
     * @return void
     */
    public function _validateUserIsDefault($isDefault):void
    {
        if($isDefault) throw new CanDeleteUserException();
    }

        /**
     * _validateDeleteArray
     *
     * @param  mixed $deleteArray
     * @return void
     */
    private function _validateDeleteArray(array $deleteArray): void
    {
        if(!empty($deleteArray)) {
            throw new CanDeleteIsDefaultUserException(errors :$deleteArray);
        }
    }
      /**
     * getRepository
     *
     * @return UserRepository
     */
    public function getUsersForExport(?Filter $filter = null)
    {
        return $this->repository->exportAll($filter);
    }
}

