<?php
namespace App\Models;

class ApiCall {
    protected $con;
    protected $url;
    protected $header;
    protected $complex_ID;

    function __construct($need_token=false,$user_id=null)
    {
       // $this->url=env('URL_API');
        if(!$need_token){
            $this->header=array();
        }else{
            if(isset($user_id)){
                $response=User::getAcessToken(intval($user_id));
                if($response['status']==200){
                    $token=  $response["data"] ?? "";

                    if(isset($token) && ($token !="")){
                        $this->header=array('Authorization: Bearer '.$token);
                    }

                    else{
                        $this->header=array();
                    }

                }
            }

        }

    }

    public  function GetResponse($type_info, $request_type, $data,$CURLOPT_HEADER=false,$cookies=null)
    {
        $this->con = curl_init();
        $api_url=$type_info;
        if ($request_type == 'GET') {
            if(count($data) > 0){
                $i=0;
                foreach ($data as $index=>$param){
                    if($i ==0){$api_url.="?".$index."=".$param;}
                    else{$api_url.="&".$index."=".$param;}
                    $i++;
                }
            }
        }
        curl_setopt($this->con, CURLOPT_URL, $api_url);
        curl_setopt($this->con, CURLOPT_SSL_VERIFYPEER, true); // Enable SSL certificate verification
        curl_setopt($this->con, CURLOPT_SSL_VERIFYHOST, 2);    // Check that the common name exists and matches the host name
        curl_setopt($this->con, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($this->con, CURLOPT_HEADER, $CURLOPT_HEADER);
        curl_setopt($this->con, CURLOPT_FOLLOWLOCATION, true);
        // Set the cookie
        if(isset($cookies)){

            curl_setopt($this->con, CURLOPT_COOKIE, $cookies);
        }
       //echo json_encode($this->header);die();

        curl_setopt($this->con, CURLOPT_HTTPHEADER, $this->header);
        if ($request_type != 'POST') {
            curl_setopt($this->con, CURLOPT_CUSTOMREQUEST, $request_type);
        } else {
            curl_setopt($this->con, CURLOPT_POST, 1);
        }
        if ($request_type == 'PUT') {
            curl_setopt($this->con, CURLOPT_POSTFIELDS, http_build_query($data));
        } else {
            curl_setopt($this->con, CURLOPT_POSTFIELDS, $data);
        }

        curl_setopt($this->con, CURLOPT_RETURNTRANSFER, 1);
        $response=curl_exec($this->con);
        if($response === false) {
            $error = curl_error($this->con);
            curl_close($this->con);
            //echo "CURL Error: $error \n";
            return $error;
        } else {
            curl_close($this->con);
            if (strpos($api_url, "j_spring_security_check") !== false) {
                $header_size = curl_getinfo($this->con, CURLINFO_HEADER_SIZE);
                $header = substr($response, 0, $header_size);
                $body = substr($response, $header_size);
                return $header;
            }else{
                return $response;
            }




        }

    }



    public  function GetAccessToken()
    {

    }
}
