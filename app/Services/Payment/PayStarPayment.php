<?php

namespace App\Services\Payment;


use App\Services\Payment\PaymentInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PayStarPayment implements  PaymentInterface
{
    protected $GatewayId;
    protected $key;
    protected $productId;

    public function __construct( $GatewayId,  $key, $productId='')
    {
        $this->GatewayId= $GatewayId;
        $this->key= $key;
        $this->productId= $productId;
    }
    public function Create($productId)
    {
        $amount=DB::table('products')->where('id',$productId)->first()->price;
//        amount#order_id#callback
         $dataSign=(int)$amount.'#'.$productId.'#http://localhost:8000/payment-callback';
        $sign=hash_hmac('SHA512',  $dataSign,  $this->key, false );

        $data = [
            "amount" => (int)$amount,
            "order_id" => $productId,
            "callback" => "http://localhost:8000/payment-callback",
            "sign" => $sign ,
        ];
        $data_string = json_encode($data);
        $userId = auth()->user()->id;

        $result = $this->CallAPI('https://core.paystar.ir/api/pardakht/create', $data_string);
        $response = json_decode($result, JSON_OBJECT_AS_ARRAY);

        if ("1" == $response["status"]) {
            $Token = $response['data']['token'];
            $RefNum = $response['data']['ref_num'];
            $PaymentAmount = $response['data']['payment_amount'];
            $OrderId = $response['data']['order_id'];
            $status=$response["status"];
            $message=$response["message"];

           $paymentId= DB::table('payments')->insertGetId([
                [
                    'ref_num'=>$RefNum,
                    'token' =>  $Token ,
                    'amount'=>$PaymentAmount,
                    'product_id'=>$OrderId,
                    'status'=>$status,
                    'message'=>$message,
                    'data'=>json_encode($response['data']),
                    'user_id'=>$userId
                ],
            ]);

            $_SESSION['online_payment']['redirect_url'] = 'https://core.paystar.ir/api/pardakht/payment';
            $_SESSION['online_payment']['redirect_params'] = $Token;
            $_SESSION['online_payment']['redirect_url_method'] = 'POST';
            $_SESSION['online_payment']['product_id'] = $productId;
            $_SESSION['online_payment']['payment_id'] = $paymentId;
            $_SESSION['online_payment']['message'] = $message;
        }

    }

    public function Verify($payment_id,$product_id)
    {

        $product=DB::table('products')->where('id',$product_id)->first();
        $payments=DB::table('payments')->where('id',$payment_id)->first();

        $data = [
            "amount" => (int)$product->price,
            "ref_num" => $payments->ref_num,
        ];
        $data_string = json_encode($data);

        $result = $this->CallAPI('https://core.paystar.ir/api/pardakht/verify', $data_string);
        $response = json_decode($result, JSON_OBJECT_AS_ARRAY);
        return $response;
    }



    //Send Data
    private function CallAPI($url, $data = false)
    {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization:Bearer '.$this->GatewayId,
        ]);

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }
}