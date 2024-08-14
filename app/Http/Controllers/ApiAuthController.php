<?php

namespace App\Http\Controllers;


use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Referral;
use App\Models\Setting;

class ApiAuthController extends Controller
{

    public function deleteUser()
    {
        
        $user = auth()->user();
        $user->delete();
        return laraResponse('User Deleted successfully', [
            'message' => 'User Deleted successfully',
        ])->success();
    }


    public function login(Request $request)
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (auth()->attempt($data)) {
            $token = auth()
                ->user()
                ->createToken('LaravelAuthApp')->accessToken;

            return laraResponse('User Verified', [
                'token' => $token,
                'user' => auth()->user(),
            ])->success();
        } else {
            return laraResponse('Invalid Details', [
                'Invalid Details',
            ])->error();
        }
    }

    public function ref()
    {
        $set = Setting::find(1);
        $list = Referral::with(['user', 'ref'])->where('claimed', '0')->where('referer', auth()->user()->id)->get();
        return laraResponse('success', [
            'ref' => $list,
            'count' => count($list),
            'price_per_ref' => $set->ref_com,
            'total_earning' => $set->ref_com * count($list)

        ])->success();
    }

    public function cliamref()
    {
        $set = Setting::find(1);
        $ref_claim = Referral::where('claimed', '0')->where('referer', auth()->user()->id)->get();
        // User::where('id', auth()->user()->id)->update([
        //     'wallet_ngn' => (auth()->user()->wallet_ngn + (count($ref_claim) * $set->ref_com))
        // ]);
        // Referral::where('claimed', '0')->where('user_id', auth()->user()->id)->update([
        //     'claimed' => '1'
        // ]);

        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        // 'debit_acct', 'credit_acct', 'user_id', 'amount', 'status', 'created_at', 'updated_at','trans_id'

        $charge = \App\Models\Admin\Charges::create([
            'debit_acct' => auth()->user()->acct_no,
            'credit_acct' => $setting->main_acct_no,
            'user_id' => auth()->user()->id,
            'amount' => floatval(count($ref_claim) * $set->ref_com),
            'status' => 2,
            'trans_id' => 'ref',
        ]);
        return laraResponse('success', [
            'msg' => 'You successfully claimed your Referal Bonus '

        ])->success();
    }
    public function updatePin()
    {

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric|min:4',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'Pin Field required',
                $validate->messages()
            )->error();
        }

        User::where('id', auth()->user()->id)->update([
            'pin' => request()->pin,
            'has_pin' => true,
            'pin_token' => ''

        ]);
        $code = 'email';
        if (request()->has('ref'))
            $code = request()->ref;
        $this->Referalgenerator(auth()->user(), $code);
        //   return  $this->Referalgenerator('email');
        return laraResponse('Pin Created Successfully', [
            'msg' => 'success'

        ])->success();
    }
    public function pinreset()
    {
        $token = rand(1111, 9999);

        User::where('id', auth()->user()->id)->update([
            'pin_token' => $token,

        ]);
        $this->sendEmailP(auth()->user()->email, auth()->user(), $token);
        return laraResponse('We have sent you a token on  your email', [
            'token' => $token

        ])->success();

    }
    public function updateBiometric()
    {
        User::where('id', auth()->user()->id)->update([
            'biometric' => request()->biodata,
            'pin_token' => ''

        ]);
        return laraResponse('Pin Created Successfully', [
            'msg' => 'success'

        ])->success();
    }
    public function register(Request $request)
    {
        $avatar = '';
        // name validation
        $validate = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'Name Field required',
                $validate->messages()
            )->error();
        }

        // email validation
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Email Field required',
                $validate->messages()
            )->error();
        }



        $validate = Validator::make($request->all(), [
            // 'phone' => 'required',
            'phone' => 'required|unique:users,phone',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Phone Field required',
                $validate->messages()
            )->error();
        }

        // password  validation
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'password lenght error',
                $validate->messages()
            )->error();
        }
        $validate = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'password match error',
                $validate->messages()
            )->error();
        }
        $tokenr = rand(11111, 99999);


        $email = strtolower($request->email);
        // Extract the username part by removing anything after "@"
        $username = explode('@', $email)[0];

        // Convert the username to lowercase
        $username = strtolower($username);

        // Replace non-alphanumeric characters with empty strings
        $username = preg_replace("/[^a-zA-Z0-9]/", "", $username);
        // Retrieve emails from the Users table
        $emails = User::where('username', 'like', $username . '%')->pluck('username');
        $unique_username = $username;

        foreach ($emails as $vu) {




            // Check if the generated username is unique
            // $unique_username = $username;
            $counter = 1;
            while (User::where('username', $vu)->exists()) {
                $unique_username = $username . $counter++;
            }
        }
        // create user
        $user = User::create([
            'name' => ucfirst(strtolower($request->name)),
            'phone' => ucfirst(strtolower($request->phone)),
            'email' => strtolower($request->email),
            'password' => bcrypt($request->password),
            'email_code' => $tokenr,
            'username' => $unique_username
        ]);

        $token = $user->createToken('LaravelAuthApp')->accessToken;
        try {
            $this->sendEmailc($user->email, $user, $tokenr);
        } catch (\Exception $th) {
            //throw $th;
        }
        $code = 'email';
        if (request()->has('ref')) {
            $code = request()->ref;
            $user_ref = User::where('referral_code', $code)->first();
            if ($user_ref != null) {
                $this->notify('', $user_ref, [], $user->name . '  Just registered under your referral code');
            }
        }
        $this->Referalgenerator($user, $code);

        return laraResponse('Account Created Successfully', [
            'token' => $token,
            'user' => $user,
        ])->success();
    }
    public function verifyemail1(){
        $user = User::where('id', auth()->user()->id)->first();
        // if (request()->code == $user->email_code) {
            $tokenr = rand(11111, 99999);

            User::where('id', auth()->user()->id)->update(['email_code' => $tokenr]);
            try {
                $this->sendEmailc($user->email, $user, $tokenr);
            } catch (\Exception $th) {
                //throw $th;
                return laraResponse('email error', [
                    'msg' => 'unable to send email',
                ])->error();
            }
            return laraResponse('success', [
                'email_token' => $tokenr,

                'msg' => 'Token Sent successfully',
            ])->success();
        // }
       
    }

    public function sendEmail($to, $user)
    {
        //   return $this->view('emails.welcome')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject("WELCOME TO VICTORSPREDICT.COM");

        $view = \View::make('emails.wc', ['user' => $user])->render();
        // return $view;
        $emailData = [
            'from' => ['address' => 'info@semibill.com','name'=>'SEMIBILL'],
            'to' => [
                [
                    'email_address' => [
                        'address' => trim(strtolower($to)),
                        'name' => 'Semibill',
                    ],
                ],
            ],
            'subject' => 'WELCOME TO SEMIBILL.COM',
            'htmlbody' => $view,
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.zeptomail.com/v1.1/email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($emailData),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Zoho-enczapikey ",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }
    }
    public function authUserProfile()
    {
     
        // if ($id != auth()->user()->id) {
        //     return laraResponse('error', ['msg' => 'Unauthorized'])->error();
        // }

        $user = auth()->user();

        if ($user != null) {
            return laraResponse('success', $user)->success();
        }
        return laraResponse('error', ['msg' => 'Data not Found'])->error();
    }
    public function userByUsername($username)
    {
        $user = User::select('id', 'name', 'email', 'phone', 'created_at', 'updated_at', 'address', 
            'email_verified', 'wallet_ngn', 'username', 'acct_name', 
            'acct_no', 'acct_status')->where('username', $username)->first();
        if ($user != null) {
            return laraResponse('success', $user)->success();
        }
        return laraResponse('error', ['msg' => 'Data not Found'])->error();
    }


    public function fundAccount()
    {

    }
    public function uploadAvatar(Request $request)
    {
        // Validate the request
        $validate = Validator::make($request->all(), [
            'avatar' => 'required|image|max:6000', // Adjust the validation rules as needed
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'Image validation error',
                $validate->messages()
            )->error();
        }

        // Get the user
        $user = auth()->user(); // Assuming you're using authentication

        // Store the uploaded image
        $avatar = $request->file('avatar');
        $avatarPath = $avatar->store('avatars', 'public'); // Store the image in the 'avatars' directory under the 'public' disk

        // Update the user's avatar column
        $user->avatar = url('/storage') . '/' . $avatarPath;
        $user->save();
        $neww = User::find(auth()->user()->id);
        return laraResponse('success', [
            'message' => 'Data updated successfully',
            'user' => $neww
        ])->success();
    }
    public function updateUser()
    {


        $avatar = '';
        // name validation
        $validate = Validator::make(request()->all(), [
            'name' => 'required|min:3',
        ]);

        if ($validate->fails()) {
            return laraResponse('Name Field required', [
                'Name Field required',
            ])->error();
        }

        // name validation
        $validate = Validator::make(request()->all(), [
            'email' =>
                'required|email|unique:users,email,' .
                auth()->user()->id .
                ',id',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'Email already exist or required',
                $validate->messages()
            )->error();
        }

        $validate = Validator::make(request()->all(), [
            'phone' => 'required',
            // 'state' => 'required',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'All Fields required',
                $validate->messages()
            )->error();
        }

        $tokenr = rand(11111, 99999);

        // User::where('id', auth()->user()->id)->update(['email_code' => $tokenr]);
        // try {
        
        User::where('id', auth()->user()->id)->update([
            'name' => ucwords(request()->name),
            'email' => strtolower(request()->email),
            'phone' => strtolower(request()->phone),
            'email_code' => $tokenr,
'email_verified' =>strtolower(request()->email)==auth()->user()->email ?1 :0,
            'address' => request()->address,
        ]);
        $user=User::find(auth()->user()->id);
        if(strtolower(request()->email)!=auth()->user()->email) $this->sendEmailc(request()->email, $user, $tokenr);
        return laraResponse('success', [
            'message' => 'Data updated successfully',
            'user'=>$user
        ])->success();
    }

    public function updatePassword(Request $request)
    {

        $validate = Validator::make(request()->all(), [
            'password' => 'required|min:8|confirmed',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'password error  ',
                $validate->messages()
            )->error();
        }
        $user = User::where('email', trim(strtolower(request()->email)))->first();

        User::where('email', $user->email)->update([
            'password' => \Hash::make($request->input('password')),
        ]);
        \Auth::loginUsingId($user->id);

        $user->tokens()->delete();

        $token = auth()
            ->user()
            ->createToken('LaravelAuthApp')->accessToken;

        return laraResponse('success', [
            'token' => $token,
            'user' => auth()->user()->only([
                'id', 'name', 'email', 'phone', 'created_at', 'updated_at', 'address', 
                'email_verified', 'wallet_ngn', 'username', 'acct_name', 
                'acct_no', 'acct_status'
            ]),
        ])->success();
    }
    public function resetpassword()
    {
        $validate = Validator::make(request()->all(), [
            'email' => 'required|email',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'email  required',
                $validate->messages()
            )->error();
        }

        $user = User::where(
            'email',
            trim(strtolower(request()->email))
        )->first();
        if ($user == null) {
            return laraResponse('email  does not exist', [
                'msg' => 'User record not found',
            ])->error();
        }
        $token = rand(11111, 99999);
        User::where('email', $user->email)->update(['pass_token' => $token]);
        // try {
        $this->sendEmailr($user->email, $user, $token);

        return laraResponse('success', [
            'user' => $user != null ? $user : [],
            'token' => $token,
            'msg' => 'Kindly check your email for token',
        ])->success();
    }
    public function updateDeviceToken()
    {
        User::where('id', auth()->user()->id)->update([
            'device_token' => request()->token,
        ]);
        $user = User::where('id', auth()->user()->id)->first();
        return laraResponse('success', [
            'user' => $user != null ? $user : [],
        ])->success();
    }

    public function verifyEmail()
    {
        $user = User::where('id', auth()->user()->id)->first();
        if (request()->code == $user->email_code) {
            User::where('id', auth()->user()->id)->update(['email_verified' => 1]);
            try {
                $this->sendEmail($user->email, $user);
            } catch (\Exception $th) {
                //throw $th;
            }
            return laraResponse('success', [
                'user' => $user != null ? $user : [],

                'msg' => 'Token Matched successfully',
            ])->success();
        }
        return laraResponse('Code does not match', [
            'msg' => 'code does not match',
        ])->error();

    }
    public function sendEmailr($to, $user, $token)
    {
        //   return $this->view('emails.welcome')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject("WELCOME TO VICTORSPREDICT.COM");

        $view = \View::make('emails.reset', ['token' => $token, 'user' => $user])->render();
        // return $view;
        $emailData = [
            'from' => ['address' => 'info@semibill.com','name'=>'SEMIBILL'],
            'to' => [
                [
                    'email_address' => [
                        'address' => trim(strtolower($to)),
                        'name' => 'SEMIBILL',
                    ],
                ],
            ],
            'subject' => 'NEW PASSWORD REQUEST - SEMIBILL.COM',
            'htmlbody' => $view,
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.zeptomail.com/v1.1/email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($emailData),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Zoho-enczapikey ",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }
    }

    public function sendEmailP($to, $user, $token)
    {
        //   return $this->view('emails.welcome')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject("WELCOME TO VICTORSPREDICT.COM");

        $view = \View::make('emails.pin', ['token' => $token, 'user' => $user])->render();
        // return $view;
        $emailData = [
            'from' => ['address' => 'info@semibill.com','name'=>'SEMIBILL'],
            'to' => [
                [
                    'email_address' => [
                        'address' => trim(strtolower($to)),
                        'name' => 'SEMIBILL',
                    ],
                ],
            ],
            'subject' => 'NEW PIN REQUEST - SEMIBILL.COM',
            'htmlbody' => $view,
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.zeptomail.com/v1.1/email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($emailData),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Zoho-enczapikey ",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }
    }

    public function sendEmailc($to, $user, $token)
    {
        //   return $this->view('emails.welcome')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject("WELCOME TO VICTORSPREDICT.COM");

        $view = \View::make('emails.confirm', ['token' => $token, 'user' => $user])->render();
        // return $view;
        $emailData = [
            'from' => ['address' => 'info@semibill.com','name'=>'SEMIBILL'],
            'to' => [
                [
                    'email_address' => [
                        'address' => trim(strtolower($to)),
                        'name' => 'SEMIBILL',
                    ],
                ],
            ],
            'subject' => 'CONFIRM EMAIL - SEMIBILL.COM',
            'htmlbody' => $view,
        ];
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.zeptomail.com/v1.1/email',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($emailData),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Zoho-enczapikey ",
                "cache-control: no-cache",
                "content-type: application/json",
            ),
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);
        // if ($err) {
        //     echo "cURL Error #:" . $err;
        // } else {
        //     echo $response;
        // }
    }
    public function fcm($d)
    {
        // FCM server key
        $serverKey = env('FCM_SERVER_KEY');

        // FCM endpoint
        $fcmEndpoint = 'https://fcm.googleapis.com/fcm/send';

        // Device token (registration ID)
        $deviceToken = $d['token'];

        // Your notification payload
        $notification = [
            'title' => $d['title'],
            'body' => $d['body'],
            'icon' => asset('logo.png'), // URL to the icon
        ];

        // Construct the HTTP headers
        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];

        // Construct the notification payload
        $data = [
            'to' => $deviceToken,
            'notification' => $notification,
        ];

        // Convert the data to JSON
        $jsonData = json_encode($data);

        // Initialize cURL session
        $ch = curl_init($fcmEndpoint);

        // Set cURL options
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            echo 'FCM cURL Error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Output the response
        echo $response;
    }

    public function notify($trans_id, $user, $data, $message)
    {

        // FCM server URL
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Firebase server key
        $serverKey = env('FCM_SERVER_KEY');

        // Notification payload
        $notification = [
            'title' => 'Hi, ' . $user->name,
            'body' => $message,
        ];

        // Data payload (optional)
        $data = [
            'user' => $user,
            'data' => $data,
        ];

        // Device token(s) to send notification to
        $tokens = [$user->device_token];

        // Construct the HTTP headers
        $headers = [
            'Authorization: key=' . $serverKey,
            'Content-Type: application/json',
        ];

        // Construct the payload
        $payload = [
            'notification' => $notification,
            'data' => $data,
            'registration_ids' => $tokens,
        ];

        // Initialize cURL
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        // Execute the request
        $response = curl_exec($ch);

        // Close cURL session
        curl_close($ch);
        // \Log::debug($response);

        // Handle the response
        if ($response === false) {

            // return response()->json(['error' => 'Failed to send notification']);
        }
        \App\Models\Notification::create([
            'user' => $user->id,
            'text' => $message,
            'type' => 'referral'
        ]);
        //    class Notification extends Model
        //    {
        //        use HasFactory;
        //    protected $fillable=['id', 'user_id', 'text', 'type', 'status', 'created_at', 'updated_at'];
        // Notification::create([
        //    'type'=>'order', 'title'=>$notification['title'], 'body'=>$notification['body'], 'status'=>'0', 'data_id'=>$orderr->order_id,  'user_id'=>$user->id
        // ]);
    }

    public function Referalgenerator($US, $ref)
    {
        $user = User::where('referral_code', null)->orWhere('referral_code', '')->get();
        if (count($user) > 0) {
            foreach ($user as $k => $e) {
                $code = $e->id . \Str::random(4);
                User::where('id', $e->id)->update(['referral_code' => $code]);
            }
        }
        if ($ref != 'email') {
            $u = User::where('referral_code', $ref)->first();
            \App\Models\Referral::updateOrCreate(
                ['referer' => $u->id, 'user_id' => $US->id], // Search criteria
                ['referer' => $u->id, 'user_id' => $US->id, 'claimed' => '0'] // Values to update or insert
            );
        }



    }
}
