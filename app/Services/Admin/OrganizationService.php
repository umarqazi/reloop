<?php


namespace App\Services\Admin;


use App\Repositories\Admin\OrganizationRepo;
use App\Repositories\Admin\UserRepo;
use App\Services\Admin\BaseService;
use App\Services\Admin\UserService;
use App\Services\IUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Services\EmailNotificationService;

class OrganizationService extends BaseService
{

    private $organizationRepo;
    private $userService;
    /**
     * Property: emailNotificationService
     *
     * @var EmailNotificationService
     */
    private $emailNotificationService;
    /**
     * ProductService constructor.
     */

    public function __construct(UserService $userService,EmailNotificationService $emailNotificationService)
    {
        $organizationRepo =  $this->getRepo(OrganizationRepo::class);
        $this->organizationRepo = new $organizationRepo;
        $this->userService = $userService;
        $this->emailNotificationService = $emailNotificationService;
    }


    /**
     * @param array $data
     * @return bool
     */
    public function insert($request)
    {
        $data = $request->except('_token');
        DB::beginTransaction();
        $organization  =  parent::create($data);
        if($organization){
            $subscriptionData = array(
                'organization_id'     => $organization->id,
                'email'               => $data['email'],
                'phone_number'        => $data['phone_number'],
                'password'            => $data['password'],
                'address'             => $data['address'],
                'status'              => 1,
                'user_type'           => IUserType::ORGANIZATION,
            );
            $this->userService->create($subscriptionData);
            DB::commit();
            $this->emailNotificationService->adminOrganizationCreateEmail($data);
            return true ;
            }
        else {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param array $data
     * @param  int $id
     * @return bool
     */
    public function upgrade($id, $request)
    {
        $data = $request->except('_token', 'email','phone_number','status');

        return  parent::update($id, $data);
    }

    /**
     * $param $id
     */

    public function delete(int $id)
    {
     $organization = $this->organizationRepo->findById($id);
     foreach($organization->users as $user){
         $this->userService->destroy($user->id);
     }
     return $this->destroy($id);
    }

}
