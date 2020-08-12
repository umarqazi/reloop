<?php

namespace App\Console\Commands;

use App\Http\Controllers\PayfortController;
use App\Services\Admin\SubscriptionSerivce;
use App\Services\ISubscriptionSubType;
use App\Services\IUserSubscriptionStatus;
use App\Services\UserCardService;
use App\Services\UserService;
use App\UserSubscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

/**
 * Class SubscriptionRenew
 *
 * @package   App\Console\Commands
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Aug 08, 2020
 * @project   reloop
 */
class SubscriptionRenew extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscription:renew';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Renew users subscriptions';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $userSubscriptions = UserSubscription::where('subscription_type', ISubscriptionSubType::NORMAL)->get();
        foreach ($userSubscriptions as $userSubscription){

            if(strtotime($userSubscription->end_date) < strtotime(date('Y-m-d, h:i:s'))
            && $userSubscription->status != IUserSubscriptionStatus::CANCELLED
            && $userSubscription->status != IUserSubscriptionStatus::COMPLETED){

                $authUser = App::make(UserService::class)->findById($userSubscription->user_id);
                $userCard = App::make(UserCardService::class)->findByUserId($userSubscription->user_id);
                $subscription = App::make(SubscriptionSerivce::class)->findById($userSubscription->subscription_id)->first();

                if($authUser && $subscription && $userCard){
                    App::make(PayfortController::class)->recurring(
                        $subscription->price, $authUser->email, $userCard->token_name, $userSubscription->id
                    );
                }
            }
        }
    }
}
