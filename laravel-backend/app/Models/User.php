<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Autres attributs et méthodes
    protected $guarded = [];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->makeAllAttributesFillable();
    }

    protected function makeAllAttributesFillable()
    {
        $this->fillable = $this->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($this->getTable());
    }
    public function recapitulatifs()
    {
        return $this->hasMany(Recapitulatif::class);
    }
    public static function FindUser($data)
    {
        $response = array("status" => 400, "error" => "");
        try {
            $user = User::where("email", $data['email'])->where("organisation", $data["organisation"])->first();
            if (!isset($user)) {
                $response = array("status" => 400, "error" => "NOTFOUND");
            } else {
                $response = array("status" => 200, "data" => array("user" => $user, "token" => $user->token));
            }
        } catch (Exception $ex) {
            $response = array("status" => 400, "error" => $ex->getMessage());

        }
        return $response;
    }

    public static function getAcessToken($id)
    {
        $response = array("status" => 400, "error" => "");
        try {
            $user = User::where("id", $id)->first();

            if (isset($user)) {
                if (!isset($user->token) || !isset($user->cookies)) {
                    $user = User::RefreshAcessToken($user->id);
                }
                $response = array("status" => 200, "data" => $user->token);
            } else {
                $response = array("status" => 400, "error" => "UserNotFound");

            }
        } catch (Exception $ex) {
            $response = array("status" => 400, "error" => $ex->getMessage());

        }
        return $response;
    }

    public static function RefreshAcessToken($id)
    {
        $response = array("status" => 400, "error" => "");
        try {
            $user = User::where("id", $id)->first();

            if (isset($user)) {
                $credentials = [
                    "email" => $user->email,
                    "password" => $user->password_valomnia,
                    "organisation" => $user->organisation,
                ];

                $response = User::UserLogin($credentials);

                if ($response["status"] == 200) {
                    $user_data = $response["data"];
                    $cookies = $response["cookies"] ?? '';
                    $user_data["cookies"] = $cookies;
                    $user_data["organisation"] = $credentials["organisation"];
                    return User::UpdateOrCreated($user_data);
                } else {
                    $response = array("status" => 400, "error" => "UserInvalid");
                }
            } else {
                $response = array("status" => 400, "error" => "UserNotFound");

            }
        } catch (Exception $ex) {
            $response = array("status" => 400, "error" => $ex->getMessage());

        }
        return $response;
    }

    public static function UserLogin($data)
    {
        $response = array("status" => 400, "error" => "");
        try {
            $api_call = new ApiCall(false);
            $url_api = str_replace("organisation", $data["organisation"], env('URL_API','https://organisation.valomnia.com'));
            $data_request = [
                "j_username" => $data["email"],
                "j_password" => $data["password"],
                "ajax" => "true"
            ];
            $api_response = $api_call->GetResponse($url_api . '/j_spring_security_check', 'GET', $data_request, true);
            //echo $api_response;die();
            if (strpos($api_response, "302") !== false && strpos($api_response, "login/ajaxSuccess") !== false) {
                preg_match('/^Set-Cookie:\s*JSESSIONID=([^;]+)/mi', $api_response, $matches);
                $jsessionid = $matches[1] ?? null;

                if ($jsessionid) {
                    //echo "jsessionid : ".$jsessionid;
                    $api_response = json_decode($api_call->GetResponse($url_api . "/login/ajaxSuccess", 'GET', [], false, "JSESSIONID=$jsessionid"), TRUE);
                    $response = array(
                        "status" => 200,
                        "data" => $api_response,
                        "cookies" => $jsessionid
                    );
                } else {
                    $response = array("status" => 400, "error" => "LoginFailed !");
                }
            } else {
                $response = array("status" => 400, "error" => "LoginFailed !");
            }

        } catch (Exception $ex) {
            $response = array("status" => 400, "error" => $ex->getMessage());

        }
        return $response;
    }

    public static function UpdateOrCreated($data)
    {
        $response = array("status" => 400, "error" => "");
        try {
            $token = $data["token"];
            $organisation_name = $data["organisation"];
            $user_data = $data["user"];

            $user = User::where("email", $user_data['email'])->where("organisation", $organisation_name)->first();

            //organisation_name !!!!
            $roles = implode(",", $user_data["role"]);
            if (!isset($user)) {

                $user = User::create([
                    'organisation' => $organisation_name,
                    'email' => $user_data['email'],
                    'name' => $user_data['firstName'] . " " . $user_data['lastName'],
                    //'statue' => $user_data['statue'],
                    //'email_verified_at' => $user_data['email_verified_at'],
                    'token' => $token,
                    'password_valomnia' => $data['password'],
                    'cookies' => $data['cookies'],
                    'role' => implode(",", $user_data['role']),
                    // 'created_at' =>$user_data['created_at'],
                    // 'updated_at' =>$user_data['updated_at'],
                    'password' =>$data['password'],
                    //ajoutéé les données !
                ]);
                //create new user

            } else {


                $user->organisation = $organisation_name;
                $user->email = $user_data['email'];
                $user->name =  $user_data['firstName'] . " " . $user_data['lastName'];
                $user->token = $token;
                $user->role=implode(",", $user_data['role']);
                $user->cookies= $data['cookies'];
                $user->save();

                //update user data

            }
            $response = array("status" => 200, "data" => array("user" => $user, "token" => $token,"cookies"=>$data['cookies']));
        } catch (Exception $ex) {
            $response = array("status" => 400, "error" => $ex->getMessage());

        }
        return $response;
    }
}


