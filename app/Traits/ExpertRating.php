<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



trait ExpertRating {
    public function getExpertTests(){
        $endpoint='/webservices/';
        $data=[
            'request'=>[
                'authentication'=>[
                    "partnerid"=> env('EXPERT_RATING_PARTNER_ID'),
                    "password"=> env('EXPERT_RATING_PASSWORD')
                ],
                "method"=> [
                    "name"=> "GetTestList"
                ]
            ]
        ];
        $response=$this->postCurl($endpoint,json_encode($data));
        return $response;
    }

    public function createTestLink($test_id,$todz_id,$test_booking_id){
        $endpoint='/webservices/generateticket.aspx';
            $debug = "0";
            $dev = "1";
            $reuse= "0";
            $secure_mode = "0";
            $browser_proctoring = "1";
            $max_retries = "1";
            $webcam_proctoring = "1";
            $webcam_mandatory = "1";
            $extra1="extra1";
            $extra2="extra2";
        $data = [   
        'partnerid'=>env('EXPERT_RATING_PARTNER_ID'),
        'password'=>env('EXPERT_RATING_PASSWORD'),
        'user_id'=>$todz_id,
        'test_id'=>$test_id,
        'test_booking_id'=>$test_booking_id,
        'return_URL'=>env('EXPERT_RATING_RETURN_URL'),
        'debug'=>$debug,
        'dev'=>$dev,
        'reuse'=>$reuse,
        'secure_mode'=>$secure_mode,
        'browser_proctoring'=>$browser_proctoring,
        'max_retries'=>$max_retries,
        'webcam_proctoring'=>$webcam_proctoring,
        'webcam_mandatory'=>$webcam_mandatory,
        'extra1'=>$extra1,
        'extra2'=>$extra2
        ];
        //dd( $data );
        $response=$this->postCurl($endpoint,$data);
     return  $response;
    }


    private function postCurl($endpoint,$data){
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, env('EXPERT_RATING_API_URL').''.$endpoint);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
                $headers = array();
                $headers[] = 'Accept: */*';
           //   $headers[] = 'Content-Type: application/json';
                 curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $result = curl_exec($ch);
                if (curl_errno($ch)) {
                    echo 'Error:' . curl_error($ch);
                }
                curl_close($ch);
                return json_decode($result); 
    }

    private function getCurl($endpoint,$token=null):object{
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, env('EXPERT_RATING_API_URL').''.$endpoint);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            $headers = array();
            $headers[] = 'Accept: */*';
            $headers[] = 'Content-Type: application/json';
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $result = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            }
            curl_close($ch);
            return json_decode($result); 
}
}
