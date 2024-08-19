<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $response=["status"=>400,"error",""];
        try{

            $credentials = $request->all();
            $data=$request->all();
            // echo json_decode($data);die();
            $response_found= User::FindUser($request->all());
            $user=$response_found['data']["user"] ?? null;
            if ($response_found["status"] == 200 && isset($user) && isset($user->token)) {
                //checkpassword
                $response=["status"=>200,"data"=>$user];
            }else{
                $response = User::UserLogin($credentials);
                if ($response["status"] == 200) {
                    $user_data = $response["data"];
                    $cookies = $response["cookies"] ?? '';
                    $user_data["cookies"] = $cookies;
                    $user_data["organisation"] = $credentials["organisation"];
                    $user_data["password"] = $credentials["password"];
                    $roles = $user_data["user"]["role"];
                    // echo json_encode(array_search("ROLE_ADMIN", $roles));die();
                    //indexOf role ROLE_ADMIN
                    //if (array_search("ROLE_ADMIN", $roles) !== false) {
                    $response_created=User::UpdateOrCreated($user_data);

                    if ($response_created["status"] == 200) {
                        $user=$response_created["user"];
                        $response=["status"=>200,"data"=>$user];
                    } else {
                        $response=["status"=>400,"error"=>$response_created["error"]];

                    }

                } else {
                    $response=["status"=>401,"error"=>'Invalid credentials'];
                }
            }
        }catch (Exception $ex){
            $response=["status"=>400,"error"=>$ex->getMessage()];
        }
        return response()->json($response);
    }
}
