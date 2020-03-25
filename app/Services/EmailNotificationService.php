<?php


namespace App\Services;


use App\Mail\admin\OrderAssignmentNotification;
use App\Mail\admin\OrganizationSignUpRequestNotification;
use App\Mail\admin\PasswordResetNotification;
use App\Mail\admin\SignUpNotification;
use App\Mail\order\DriverOrderAssigned;
use App\Mail\order\UserOrderAssigned;
use App\Mail\organization\OrganizationSignupEmail;
use App\Mail\User\AdminOrganizationCreate;
use App\Mail\User\AdminUserCreate;
use App\Mail\User\AdminSupervisorCreate;
use App\Mail\User\AdminDriverCreate;
use App\Mail\user\PasswordResetEmail;
use App\Mail\user\SignupEmail;
use Illuminate\Support\Facades\Mail;

/**
 * Class EmailNotificationService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 21, 2020
 * @project   reloop
 */
class EmailNotificationService
{

    /**
     * Method: userSignUpEmail
     *
     * @param $data
     *
     * @return void
     */
    public function userSignUpEmail($data)
    {
        Mail::to($this->getAdminEmail())->queue(new SignUpNotification($data));
        Mail::to($this->getUserEmail($data))->queue(new SignupEmail($data));
    }

    /**
     * Method: organizationSignUpEmail
     *
     * @param $data
     *
     * @return void
     */
    public function organizationSignUpEmail($data)
    {
        Mail::to($this->getAdminEmail())->queue(new OrganizationSignUpRequestNotification($data));
        Mail::to($this->getUserEmail($data))->queue(new OrganizationSignupEmail($data));
    }

    /**
     * Method: passwordReset
     *
     * @param $data
     *
     * @return void
     */
    public function passwordReset($data)
    {
        Mail::to($this->getAdminEmail())->queue(new PasswordResetNotification($data));
        Mail::to($this->getUserEmail($data))->queue(new PasswordResetEmail($data));
    }

    /**
     * Method: adminUserCreateEmail
     *
     * @param $data
     *
     * @return void
     */

    public  function adminUserCreateEmail($data){
        Mail::to($this->getUserEmail($data))->queue(new AdminUserCreate($data));
    }

    /**
     * Method: adminSupervisorCreateEmail
     *
     * @param $data
     *
     * @return void
     */

    public function adminSupervisorCreateEmail($data){
        Mail::to($this->getUserEmail($data))->queue(new AdminSupervisorCreate($data));
    }

    /**
     * Method: adminDriverCreateEmail
     *
     * @param $data
     *
     * @return void
     */

    public function adminDriverCreateEmail($data){
        Mail::to($this->getUserEmail($data))->queue(new AdminDriverCreate($data));
    }

    /**
     * Method: adminDriverCreateEmail
     *
     * @param $data
     *
     * @return void
     */

    public function adminOrganizationCreateEmail($data){
        Mail::to($this->getUserEmail($data))->queue(new AdminOrganizationCreate($data));
    }

    /**
     * Method: userOrderAssignedEmail
     *
     * @param $data
     *
     * @return void
     */

    public function userOrderAssignedEmail($data){
        Mail::to($this->getUserEmail($data))->queue(new UserOrderAssigned($data));
    }

    /**
     * Method: driverOrderAssignedEmail
     *
     * @param $data
     *
     * @return void
     */

    public function driverOrderAssignedEmail($data){
        Mail::to($this->getUserEmail($data))->queue(new DriverOrderAssigned($data));
    }

    /**
     * Method: adminOrderAssignmentNotification
     *
     * @param $data
     *
     * @return void
     */

    public function adminOrderAssignmentNotification($data){
        Mail::to($this->getAdminEmail())->queue(new OrderAssignmentNotification($data));
    }

    /**
     * Method: getAdminEmail
     *
     *
     * @return mixed
     */
    private function getAdminEmail()
    {
        return env('ADMIN_EMAIL');
    }

    /**
     * Method: getUserEmail
     *
     * @param $data
     *
     * @return mixed|string
     */
    private function getUserEmail($data)
    {
        return $data['email'] ?? '';
    }
}
