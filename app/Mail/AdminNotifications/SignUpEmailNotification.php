<?php

namespace App\Mail\AdminNotifications;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class SignUpEmailNotification
 *
 * @package   App\Mail\AdminNotifications
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 21, 2020
 * @project   reloop
 */
class SignUpEmailNotification extends Mailable
{
    use Queueable, SerializesModels;
    private $data;

    /**
     * SignUpEmailNotification constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Method: build
     *
     *
     *
     * @return SignUpEmailNotification
     */
    public function build()
    {
        return $this->view('email.admin.signup_notification', ['data' => $this->data]);
    }
}
