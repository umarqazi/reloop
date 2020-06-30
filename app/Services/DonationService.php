<?php


namespace App\Services;
use App\Donation;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class DonationService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 06, 2020
 * @project   reloop
 */
class DonationService extends BaseService
{

    /**
     * Property: model
     *
     * @var Donation
     */
    private $model;
    /**
     * Property: donationProductService
     *
     * @var DonationProductService
     */
    private $donationProductService;
    /**
     * Property: userService
     *
     * @var UserService
     */
    private $userService;

    public function __construct(Donation $model, DonationProductService $donationProductService, UserService $userService)
    {
        parent::__construct();
        $this->model = $model;
        $this->donationProductService = $donationProductService;
        $this->userService = $userService;
    }
    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() method.
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * Method: findByUserId
     *
     * @param $userId
     *
     * @return mixed
     */
    public function findByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->with([
            'donationProduct' => function ($query){
                return $query->with('category');
            }
        ])->get();
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: donations
     *
     * @param IForm $donationForm
     *
     * @return array
     */
    public function donations(IForm $donationForm)
    {
        if ($donationForm->fails()) {

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $donationForm->errors()
            );
        }

        $donation = $this->donationProductService->findById($donationForm->product_id);
        if($donation){

            $authUser = $this->userService->findById(auth()->id());
            if($authUser->reward_points >= $donation->redeem_points){

                $authUser->reward_points = $authUser->reward_points - $donation->redeem_points;
                $authUser->update();

                $this->model->create([
                    'user_id' => auth()->id(),
                    'donation_product_id' => $donation->id,
                    'redeemed_points' => $donation->redeem_points
                ]);

                return ResponseHelper::responseData(
                    Config::get('constants.INVALID_DONATION_SUCCESS'),
                    IResponseHelperInterface::SUCCESS_RESPONSE,
                    true,
                    [
                        'remainingPoints' => $authUser->reward_points
                    ]
                );
            } else{

                return ResponseHelper::responseData(
                    Config::get('constants.INVALID_DONATION_POINTS'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    [
                        "invalid_points" => [
                            Config::get('constants.INVALID_DONATION_POINTS')
                        ]
                    ]
                );
            }
        }

        return ResponseHelper::responseData(
            Config::get('constants.INVALID_DONATION_PRODUCT'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            [
                "invalid_product_id" => [
                    Config::get('constants.INVALID_DONATION_PRODUCT')
                ]
            ]
        );
    }

    /**
     * Method: rewardsHistory
     *
     * @param $userId
     *
     * @return array
     */
    public function rewardsHistory($userId)
    {
        $rewardsHistory = $this->findByUserId($userId);

        return ResponseHelper::responseData(
            Config::get('constants.DONATION_HISTORY'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $rewardsHistory
        );
    }

    /**
     * Method: redeemedReloopDonations
     *
     * @param null $addresses
     *
     * @return mixed
     */
    public function redeemedReloopDonations($addresses = null)
    {
        $redeemedReloopDonations = $this->model->sum('redeemed_points');
        return $redeemedReloopDonations;
    }
}
