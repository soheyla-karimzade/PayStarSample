<?php

namespace App\Http\Controllers;



use App\Services\Payment\PayStarPayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class PaymentController extends Controller
{

    protected  $PAYSTARGATWAYId;
    protected  $PAYSTARKEY;
    protected $PayStarService;
    public function __construct()
    {
        session_start();
        $this->PAYSTARGATWAYId = env('PAYSTARGATWAYId');
        $this->PAYSTARKEY = env('PAYSTARKEY');
    }


    public function Payment($id){
        $PayStarService = app()->makeWith(PayStarPayment::class,['GatewayId'=> $this->PAYSTARGATWAYId ,'key'=>$this->PAYSTARKEY,'productId'=>$id]);
        $PayStarService->Create($id);
        return redirect()->route('payment.api');

    }

    public function PaymentApi(){
        $redirect_url=$_SESSION['online_payment']['redirect_url'] ;
        $redirect_params=$_SESSION['online_payment']['redirect_params'] ;
        $redirect_url_method=$_SESSION['online_payment']['redirect_url_method'];
        return view('payment-api',['redirect_url'=> $redirect_url ,'redirect_params'=>$redirect_params,'redirect_url_method'=>$redirect_url_method]);
    }

    public function PaymentCallback(){
        $dataUpdate=[];
       $payment_id= $_SESSION['online_payment']['payment_id'];
        if($_POST['status']===1){
                $dataUpdate=  [
                'status' => $_POST['status'],
                'card_number' => $_POST['card_number'],
                'tracking_code' => $_POST['tracking_code'],
                'ref_num' => $_POST['ref_num'],
                'transaction_id' => $_POST['transaction_id'],

            ];
            if($_POST['card_number'] !==  auth()->user()->card_number)
                array_push($dataUpdate,['message'=>'card number not match with user card number']);
        }
        else{
            $dataUpdate=  [
                'status' => $_POST['status'],
                'ref_num' => $_POST['ref_num'],
                'transaction_id' => $_POST['transaction_id'],
            ];
        }
        $_SESSION['online_payment']['transaction_id'] =  $_POST['transaction_id'];

        $product_id=$_SESSION['online_payment']['product_id'];

        DB::table('payments')
            ->where('id', $payment_id)
            ->update($dataUpdate);

        $str=substr(auth()->user()->card_number, 6, 6);
        $strCardNumber= str_replace($str,'******',auth()->user()->card_number);

        $message=' your transaction_id is '. $_SESSION['online_payment']['transaction_id'];

        if($_POST['status']==1 && ($_POST['card_number'] !=  $strCardNumber)){
            Session::flash('message', 'your card number not match with entered card number '.$message);
            Session::flash('alert-class', 'alert-info');
            return redirect()->route('product',['id'=>$product_id]);
        }


        $PayStarService = app()->makeWith(PayStarPayment::class,['GatewayId'=> $this->PAYSTARGATWAYId ,'key'=>$this->PAYSTARKEY]);
        $verifyApi=$PayStarService->Verify($payment_id,$product_id);

        if($verifyApi['status']===1){
            $dataUpdate=  [
                'status' => $verifyApi['status'],
                'message' => $verifyApi['message'],
//                'ref_num' => $verifyApi['ref_num'],
//                'transaction_id' => $verifyApi['transaction_id'],
            ];
        }
        else{
            $dataUpdate=  [
                'status' => $verifyApi['status'],
                'message' => $verifyApi['message'],
            ];
        }
        DB::table('payments')
            ->where('id', $payment_id)
            ->update($dataUpdate);

        // $message= $_SESSION['online_payment']['message'] = $verifyApi['message'];
        $message=DB::table('payments')->where('id', $payment_id)->first()->message;
        $message.' your transaction_id is '. $_SESSION['online_payment']['transaction_id'];

        Session::flash('message', $message);
        Session::flash('alert-class', 'alert-info');
        return redirect()->route('product',['id'=>$product_id]);

    }
}