<?php


namespace App\Services;


use App\Notifications\OneSignalNotification;

/**
 * Class OneSignalNotificationService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 11, 2020
 * @project   reloop
 */
class OneSignalNotificationService
{
    /**
     * Property: userService
     *
     * @var UserService
     */
    private $userService;
    /**
     * Property: oneSignalNotification
     *
     * @var OneSignalNotification
     */
    private $oneSignalNotification;

    /**
     * OneSignalNotificationService constructor.
     * @param UserService $userService
     * @param OneSignalNotification $oneSignalNotification
     */
    public function __construct(UserService $userService,
                                OneSignalNotification $oneSignalNotification
    )
    {
        $this->userService = $userService;
        $this->oneSignalNotification = $oneSignalNotification;
    }

    /**
     * Method: oneSignalNotificationService
     *
     * @param $userId
     * @param $message
     * @param $orderNumber
     *
     * @return void
     */
    public function oneSignalNotificationService($userId, $message, $orderNumber)
    {
        $authUser = $this->userService->findById($userId);
        if($authUser && $authUser->player_id){

            foreach ($authUser->player_id as $currentPlayerId) {

                $playerId = $currentPlayerId;
                $authUser->setPlayerId([$playerId]);
                $authUser->setLoginSuccessMsg($message);
                $authUser->setOrderNumber($orderNumber);

                $authUser->notify($this->oneSignalNotification);
            }
        }
    }
}
