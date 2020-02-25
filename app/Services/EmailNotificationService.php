<?php


namespace App\Services;


use App\Mail\Organization\OrganizationSignupEmail;
use App\Mail\AdminNotifications\SignUpEmailNotification;
use App\Mail\User\UserSignupEmail;
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
        Mail::to($this->getAdminEmail())->queue(new SignUpEmailNotification($data));
        Mail::to($this->getUserEmail($data))->queue(new UserSignupEmail($data));
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
        Mail::to($this->getAdminEmail())->queue(new SignUpEmailNotification($data));
        Mail::to($this->getUserEmail($data))->queue(new OrganizationSignupEmail($data));
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
