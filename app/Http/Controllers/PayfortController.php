<?php

namespace App\Http\Controllers;

use App\Forms\Checkout\BuyPlanForm;
use App\Forms\Checkout\BuyProductForm;
use App\Jobs\SaveOrderDetailsJob;
use App\Jobs\SaveSubscriptionDetailsJob;
use App\Services\PaymentService;
use App\Services\ProductService;
use App\Services\TransactionService;
use App\Services\UserCardService;
use App\Services\UserService;
use App\Services\UserSubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

/**
 * Class PayfortController
 *
 * @package   App\Http\Controllers
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Aug 08, 2020
 * @project   reloop
 */
class PayfortController extends Controller
{
    public $gatewayHost        = 'https://checkout.payfort.com/';
    public $gatewaySandboxHost = 'https://sbcheckout.payfort.com/';
    public $language           = 'en';
    public $command            = 'PURCHASE';
    private $sandboxMode;
    private $merchantIdentifier;
    private $accessCode;
    private $SHARequestPhrase;
    private $SHAResponsePhrase;
    private $currency;
    private $SHAType;
    private $order_number;
    private $productService;

    /**
     * PayfortController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->sandboxMode        = env('PAYFORT_USE_SANDBOX');
        $this->merchantIdentifier = env('PAYFORT_MERCHANT_IDENTIFIER');
        $this->accessCode         = env('PAYFORT_ACCESS_CODE');
        $this->SHARequestPhrase   = env('PAYFORT_SHA_REQUEST_PHRASE');
        $this->SHAResponsePhrase  = env('PAYFORT_SHA_RESPONSE_PHRASE');
        $this->currency           = env('PAYFORT_CURRENCY');
        $this->SHAType            = env('PAYFORT_SHA_TYPE');
        $this->productService     = $productService;
    }

    /**
     * Method: paymentPage
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentPage()
    {
        return view('payment-page');
    }

    /**
     * Method: merchantConfirmationPage
     *
     * @param Request $request
     *
     * @return void
     */
    public function merchantConfirmationPage(Request $request)
    {
        $buyProductDetails = session('buyProductDetails');
        $userDetails = App::make(UserService::class)->findById($buyProductDetails['user_id']);

        $request['buyProductDetails'] = $buyProductDetails;
        $request['userDetails'] = $userDetails;

        $this->merchantPageNotifyFort($request->all());
    }

    /**
     * Method: createToken
     *
     * @param Request $request
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createToken(Request $request)
    {
        if (array_key_exists('subscription_id', $request->all())){

            $buyProductForm = new BuyPlanForm();
            $buyProductForm->loadFromArray($request->all());
            $this->byPlanSession($buyProductForm);
        } else {

            $buyProductForm = new BuyProductForm();
            $buyProductForm->loadFromArray($request->all());
            $this->byProductSession($buyProductForm);
        }
        $tokenName = false;
        if($buyProductForm->token_name && $buyProductForm->card_security_code){

            $tokenName = true;
            $form = [
                'token_name' => $buyProductForm->token_name,
                'card_security_code' => $buyProductForm->card_security_code,
            ];
            return view('payment-confirmation', compact('form', 'tokenName'));
        } else {

            $merchantReference = $this->generateMerchantReference();
            $returnUrl = route('token-response');
            if ($this->sandboxMode) {
                $gatewayUrl = $this->gatewaySandboxHost . 'FortAPI/paymentPage';
            } else {
                $gatewayUrl = $this->gatewayHost . 'FortAPI/paymentPage';
            }

            $merchantPageParams         = array(
                'service_command'       =>'TOKENIZATION',
                'access_code'           => $this->accessCode,
                'merchant_identifier'   => $this->merchantIdentifier,
                'merchant_reference'    => $merchantReference,
                'language'              => $this->language,
                'return_url'            => $returnUrl,
            );
            $merchantPageParams['signature'] = $this->calculateSignature($merchantPageParams, 'request');
            $merchantPageParams['card_number'] = $buyProductForm->card_number;
            $merchantPageParams['expiry_date'] = $buyProductForm->expiry_date;
            $merchantPageParams['card_security_code'] = $buyProductForm->card_security_code;
            $postData = $merchantPageParams;

            $form = $this->getPaymentForm($gatewayUrl, $postData);
            return view('payment-confirmation', compact('form', 'tokenName'));
        }
    }

    /**
     * Method: getPaymentForm
     *
     * @param $gatewayUrl
     * @param $postData
     *
     * @return string
     */
    public function getPaymentForm($gatewayUrl, $postData)
    {
        $form = '<form name="payfort_payment_form" id="payfort_payment_form" method="post" action="' . $gatewayUrl . '">';
        foreach ($postData as $k => $v) {
            $form .= '<input type="hidden" name="' . $k . '" value="' . $v . '">';
        }
        $form .= '<input type="submit" class="confirm-btn" id="submit" value="Confirm">';
        return $form;
    }

    /**
     * Method: byPlanSession
     *
     * @param $data
     *
     * @return void
     */
    public function byPlanSession($data)
    {
        session([
            'buyProductDetails' => [
                'user_id' => $data->user_id,
                'total' => $data->total,
                'coupon_id' => $data->coupon_id,
                'card_security_code' => $data->card_security_code,
                'token_name' => $data->token_name,
                'subscription_id' => $data->subscription_id,
                'subscription_type' => $data->subscription_type,
            ]
        ]);
    }

    /**
     * Method: byProductSession
     *
     * @param $data
     *
     * @return void
     */
    public function byProductSession($data)
    {
        session([
            'buyProductDetails' => [
                'user_id' => $data->user_id,
                'total' => $data->total,
                'subtotal' => $data->subtotal,
                'points_discount' => $data->points_discount,
                'coupon_id' => $data->coupon_id,
                'first_name' => $data->first_name,
                'last_name' => $data->last_name,
                'email' => $data->email,
                'phone_number' => $data->phone_number,
                'location' => $data->location,
                'latitude' => $data->latitude,
                'longitude' => $data->longitude,
                'city_id' => $data->city_id,
                'district_id' => $data->district_id,
                'products' => $data->products,
                'organization_name' => $data->organization_name,
                'card_security_code' => $data->card_security_code,
                'token_name' => $data->token_name,
            ]
        ]);
    }

    /**
     * Method: tokenResponse
     *
     * @return array|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tokenResponse()
    {
        $fortParams = $_POST;
        $responseParamSignature = $fortParams['signature'];
        unset($fortParams['signature']);
        $responseNewSignature = $this->calculateSignature($fortParams, 'response');
        if($fortParams['response_message'] == 'Success'
            && $fortParams['response_code'] == '18000'
            && $responseNewSignature == $responseParamSignature){

            $buyProductDetails = session('buyProductDetails');
            $data = [
                'user_id' => $buyProductDetails['user_id'],
                'card_number' => $fortParams['card_number'],
                'signature' => $responseParamSignature,
                'expiry_date' => $fortParams['expiry_date'],
                'merchant_reference' => $fortParams['merchant_reference'],
                'token_name' => $fortParams['token_name'],
                'card_security_code' => $buyProductDetails['card_security_code'],
            ];
            if(array_key_exists('subscription_type', $buyProductDetails)
                && $buyProductDetails['subscription_type'] == 1) {
                $userCards = App::make(UserCardService::class)->findByUserId($buyProductDetails['user_id']);
                if ($userCards) {
                    $userCards->default = false;
                    $userCards->update();
                }
                $data['default'] = true;
            }

            $saveCardDetails = App::make(UserCardService::class)->saveCardDetails($data);
            $userDetails = App::make(UserService::class)->findById($buyProductDetails['user_id']);

            $fortParams['buyProductDetails'] = $buyProductDetails;
            $fortParams['userDetails'] = $userDetails;

            $host2HostParams = $this->merchantPageNotifyFort($fortParams);
            return view('response-payfort-page', compact('host2HostParams'));
        } else {
            return $_POST;
        }
    }

    /**
     * Method: merchantPageNotifyFort
     *
     * @param $fortParams
     *
     * @return false|mixed
     */
    public function merchantPageNotifyFort($fortParams)
    {
        $postData      = array(
            'merchant_reference'  => $this->generateMerchantReference(),
            'access_code'         => $this->accessCode,
            'command'             => $this->command,
            'merchant_identifier' => $this->merchantIdentifier,
            'customer_ip'         => $_SERVER['REMOTE_ADDR'],
            'amount'              => $this->convertFortAmount($fortParams['buyProductDetails']['total'], $this->currency),
            'currency'            => strtoupper($this->currency),
            'customer_email'      => $fortParams['userDetails']->email,
            'customer_name'       => $fortParams['userDetails']->first_name. ' ' .$fortParams['userDetails']->last_name,
            'language'            => $this->language,
            'return_url'          => route('payment-response'),
            'merchant_extra'      => 'RE' . strtotime(now()),
            'token_name'          => $fortParams['token_name'],
            'merchant_extra1'     => $fortParams['buyProductDetails']['user_id'],
        );
        if ($fortParams['buyProductDetails']['coupon_id'] != null){
            $postData['merchant_extra4'] = $fortParams['buyProductDetails']['coupon_id'];
        }
        if(array_key_exists('subscription_id', $fortParams['buyProductDetails']) &&
            array_key_exists('subscription_type', $fortParams['buyProductDetails'])){
            $productDetails = $fortParams['buyProductDetails']['subscription_id'];
            $productType = $fortParams['buyProductDetails']['subscription_type'];

            $postData['merchant_extra2'] = $productDetails;
            $postData['merchant_extra3'] = $productType;

        } else {

            $productDetails = $fortParams['buyProductDetails']['products'];
            $tmpArr = array();
            foreach ($productDetails as $sub) {
                $tmpArr[] = implode(',', $sub);
            }
            $result = implode(',', $tmpArr);
            $postData['merchant_extra2'] = $result;
        }
        if(!array_key_exists('card_number', $fortParams)
            && !array_key_exists('expiry_date', $fortParams)){

            $postData['card_security_code'] = $fortParams['card_security_code'];
        }

        //calculate request signature
        $signature             = $this->calculateSignature($postData, 'request');
        $postData['signature'] = $signature;
        //dd($postData);

        if ($this->sandboxMode) {
            $gatewayUrl = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        }
        else {
            $gatewayUrl = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
        }
        $array_result = $this->callApi($postData, $gatewayUrl);
        if ($array_result['response_code'] == '20064' && isset($array_result['_3ds_url'])) {
            echo "<html><body onLoad=\"javascript: window.top.location.href='" . $array_result['_3ds_url'] . "'\"></body></html>";
        }

        return  $array_result;
    }

    /**
     * Method: callApi
     *
     * @param $postData
     * @param $gatewayUrl
     *
     * @return false|mixed
     */
    public function callApi($postData, $gatewayUrl)
    {
        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        $useragent = "Mozilla/5.0 (Windows NT 6.1; WOW64; rv:20.0) Gecko/20100101 Firefox/20.0";
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json;charset=UTF-8',
            //'Accept: application/json, application/*+json',
            //'Connection:keep-alive'
        ));
        curl_setopt($ch, CURLOPT_URL, $gatewayUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_ENCODING, "compress, gzip");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
        //curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0); // The number of seconds to wait while trying to connect
        //curl_setopt($ch, CURLOPT_TIMEOUT, Yii::app()->params['apiCallTimeout']); // timeout in seconds
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));

        $response = curl_exec($ch);

        //$response_data = array();
        //parse_str($response, $response_data);
        curl_close($ch);

        $xml = simplexml_load_string($response, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $array_result = json_decode($json,TRUE);

        if (!$response || empty($array_result)) {
            return false;
        }
        return $array_result;
    }

    /**
     * Method: paymentResponse
     *
     * @return array
     */
    public function paymentResponse()
    {
        $responsePayfort = $_POST;
        $responseParamSignature = $responsePayfort['signature'];
        unset($responsePayfort['signature']);
        $responseNewSignature = $this->calculateSignature($responsePayfort, 'response');
        //$buyProductDetails = session('buyProductDetails');
        //$requestData = (object) $buyProductDetails;

        if ($responsePayfort['response_message'] == 'Success' && $responseParamSignature == $responseNewSignature){

            $this->order_number = 'RE' . strtotime(now());
            if(array_key_exists('merchant_extra3', $responsePayfort)){
                $planDetails = $this->productService->findSubscriptionById($responsePayfort['merchant_extra2']);
                $data = [
                    'payfort_response' => $responsePayfort,
                    'product_details' => $planDetails,
                    //'request_data' => $requestData,
                    'user_id' => $responsePayfort['merchant_extra1'],
                    'order_number' => $responsePayfort['merchant_extra']
                ];
                //SaveSubscriptionDetailsJob::dispatch($data);
                App::make(PaymentService::class)->afterCheckout($data);
            } else {

                $products = $responsePayfort['merchant_extra2'];
                $explodeProducts = explode(",",$products);
                $productsQty = array_chunk($explodeProducts, 2);

                $productDetails = $this->productService->findProductById($productsQty);

                $data = [
                    'payfort_response' => $responsePayfort,
                    'product_details' => $productDetails,
                    //'request_data' => $requestData,
                    'user_id' => $responsePayfort['merchant_extra1'],
                    'order_number' => $responsePayfort['merchant_extra']
                ];
                //SaveOrderDetailsJob::dispatch($data);
                App::make(PaymentService::class)->afterBuyProduct($data);
            }
            session()->flush();
            return $responsePayfort;
        }else{
            return $_POST;
        }
    }

    /**
     * Method: directFeedbackResponse
     *
     * @return array
     */
    public function directFeedbackResponse()
    {
        $responsePayfort = $_POST;
        $responseParamSignature = $responsePayfort['signature'];
        unset($responsePayfort['signature']);
        $responseNewSignature = $this->calculateSignature($responsePayfort, 'response');

        if ($_POST['response_message'] == 'Success' && $responseParamSignature == $responseNewSignature){

            $this->order_number = 'RE' . strtotime(now());
            if(array_key_exists('merchant_extra3', $responsePayfort)){
                $planDetails = $this->productService->findSubscriptionById($responsePayfort['merchant_extra2']);
                $data = [
                    'payfort_response' => $responsePayfort,
                    'product_details' => $planDetails,
                    'user_id' => $responsePayfort['merchant_extra1'],
                    'order_number' => $responsePayfort['merchant_extra']
                ];
                App::make(PaymentService::class)->afterCheckout($data);
            } else {

                $products = $responsePayfort['merchant_extra2'];
                $explodeProducts = explode(",",$products);
                $productsQty = array_chunk($explodeProducts, 2);
                $productDetails = $this->productService->findProductById($productsQty);

                $data = [
                    'payfort_response' => $responsePayfort,
                    'product_details' => $productDetails,
                    'user_id' => $responsePayfort['merchant_extra1'],
                    'order_number' => $responsePayfort['merchant_extra']
                ];
                App::make(PaymentService::class)->afterBuyProduct($data);
            }
            session()->flush();
            return $responsePayfort;
        }else{
            return $_POST;
        }
    }

    /**
     * Method: convertFortAmount
     *
     * @param $amount
     * @param $currencyCode
     *
     * @return float|int
     */
    public function convertFortAmount($amount, $currencyCode)
    {
        $new_amount = 0;
        $total = $amount;
        $decimalPoints    = $this->getCurrencyDecimalPoints($currencyCode);
        $new_amount = round($total, $decimalPoints) * (pow(10, $decimalPoints));
        return $new_amount;
    }

    /**
     * Method: getCurrencyDecimalPoints
     *
     * @param $currency
     *
     * @return int
     */
    public function getCurrencyDecimalPoints($currency)
    {
        $decimalPoint  = 2;
        $arrCurrencies = array(
            'JOD' => 3,
            'KWD' => 3,
            'OMR' => 3,
            'TND' => 3,
            'BHD' => 3,
            'LYD' => 3,
            'IQD' => 3,
        );
        if (isset($arrCurrencies[$currency])) {
            $decimalPoint = $arrCurrencies[$currency];
        }
        return $decimalPoint;
    }

    /**
     * Method: generateMerchantReference
     *
     * @return false|int
     */
    public function generateMerchantReference()
    {
        return strtotime('now');
    }

    /**
     * Method: calculateSignature
     *
     * @param $arrData
     * @param string $signType
     *
     * @return string
     */
    public function calculateSignature($arrData, $signType = 'request')
    {
        $shaString             = '';
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }

        if ($signType == 'request') {
            $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        }
        else {
            $shaString = $this->SHAResponsePhrase . $shaString . $this->SHAResponsePhrase;
        }
        $signature = hash($this->SHAType, $shaString);

        return $signature;
    }

    /**
     * Method: log
     *
     * @param $messages
     *
     * @return void
     */
    public function log($messages) {
        $messages = "========================================================\n\n".$messages."\n\n";
        $file = __DIR__.'/trace.log';
        if (filesize($file) > 907200) {
            $fp = fopen($file, "w+");
            ftruncate($fp, 0);
            fclose($fp);
        }

        $myfile = fopen($file, "a+");
        fwrite($myfile, $messages);
        fclose($myfile);
    }

    /**
     * Method: recurring
     *
     * @param $amount
     * @param $email
     * @param $tokenName
     * @param $userSubscriptionId
     *
     * @return void
     */
    public function recurring($amount, $email, $tokenName, $userSubscriptionId)
    {
        $postData      = array(
            'merchant_reference'  => $this->generateMerchantReference(),
            'access_code'         => $this->accessCode,
            'command'             => $this->command,
            'merchant_identifier' => $this->merchantIdentifier,
            'amount'              => $this->convertFortAmount($amount, $this->currency),
            'currency'            => strtoupper($this->currency),
            'customer_email'      => $email,
            'language'            => $this->language,
            'eci'                 => 'RECURRING',
            'token_name'          => $tokenName,
        );

        //calculate request signature
        $signature             = $this->calculateSignature($postData, 'request');
        $postData['signature'] = $signature;

        if ($this->sandboxMode) {
            $gatewayUrl = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';
        }
        else {
            $gatewayUrl = 'https://paymentservices.payfort.com/FortAPI/paymentApi';
        }
        $array_result = $this->callApi($postData, $gatewayUrl);
        if ($array_result['response_message'] == 'Success'){
            $renewStatus = true;
        } else {
            $renewStatus = false;
        }
        App::make(UserSubscriptionService::class)->renewUserSubscription($userSubscriptionId, $renewStatus);
    }

}
