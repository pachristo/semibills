<?php

namespace App\Http\Controllers;

use App\Models\APITransaction;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Support;
use App\Models\Authwema;
// class  extends Model
use Illuminate\Support\Facades\Validator;
use App\Models\Beneficiary;
use App\Models\Card;

// use App\Models\APITransaction;
class APITransactionController extends Controller
{

    public $wallet_sub_key = '';
    public $api_key = '';
    public $paystack_secret = '';
    public $paystack_public = '';

    public function filteramount($string)
    {
        // Example string with letters

        // Remove all non-numeric characters except the negative sign
        $cleanedString = preg_replace('/[^0-9-]/', '', $string);

        // Convert cleaned string to numbe$this->fetchBalance()r and remove minus sign
        $number = abs((int) $cleanedString);

        // Output the result
        return $number; // Output: 50000
    }
    public function index()
    {
      
        \Log::debug(request()->all());
        $d = request()->all();
        // return 0;


        if (isset($d['type']) && $d['type'] == 'transfer') {
    
            $user = User::where('acct_no', $d['data']['creditAccountNumber'])->first();
            if ($user != null) {
                $balance = $user->wallet_ngn + ($d['data']['amount'] < 10000 ? $d['data']['amount'] : ($d['data']['amount'] - 50));
              
                $user->wallet_ngn = $balance;
                $user->save();




                $TRANS = APITransaction::create([
                    'trans_id' => $d['data']['paymentReference'],
                    'trans_type' => 'credit',
                    'trans_name' => 'bank',
                    'api_source' => 'safehaven',
                    'user_id' => $user->id,
                    'current_balance' => $balance,
                    'amount' => ($d['data']['amount']),
                    'data_json' => $d['data'],
                    'beneficiary_no' => $d['data']['creditAccountNumber'],
                    'beneficiary_name' => $d['data']['creditAccountName'],
                    // 'destinationInstitutionCode' => '090286',
                    'beneficiary_bank' => isset($this->banks[$d['data']['destinationInstitutionCode']]) ? $this->banks[$d['data']['destinationInstitutionCode']] : '',
                    'from_name' => $d['data']['debitAccountName'],
                    'from_no' => $d['data']['debitAccountNumber'],
                    'isReversed' => $d['data']['isReversed'] ? 'true' : 'false'
                ]);
                $this->notify($TRANS->trans_id, $user, $TRANS, 'Your Account has been credited with NGN' . number_format($d['data']['amount'], 2) . ' . From ' . $d['data']['debitAccountName']);
                $this->transEmail($d['data']['paymentReference'], $user, 'CREDIT TRANSACTION', 'credit', $d['data']['narration'], 'NGN ' . ($d['data']['amount']), $TRANS->created_at);
                // }
            }
        }


    }
    public function notify1($tokens, $data, $message, $subject)
    {

        // FCM server URL
        $url = 'https://fcm.googleapis.com/fcm/send';

        // Firebase server key
        $serverKey = env('FCM_SERVER_KEY');

        // Notification payload
        $notification = [
            'title' => $subject,
            'body' => $message,
        ];

        // Data payload (optional)
        $data = [

            'data' => $data,
        ];

        // Device token(s) to send notification to
        $tokens = $tokens;

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
        \Log::debug($response);

        // Handle the response
        if ($response === false) {

            // return response()->json(['error' => 'Failed to send notification']);
        }
        \App\Models\Notification::create([
            'user' => $data['data']->recipient,
            'text' => $message,
            'type' => 'not'
        ]);
        //    class Notification extends Model
//    {
//        use HasFactory;
        //    protected $fillable=['id', 'user_id', 'text', 'type', 'status', 'created_at', 'updated_at'];
// Notification::create([
//    'type'=>'order', 'title'=>$notification['title'], 'body'=>$notification['body'], 'status'=>'0', 'data_id'=>$orderr->order_id,  'user_id'=>$user->id
// ]);
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
        \Log::debug($response);

        // Handle the response
        if ($response === false) {

            // return response()->json(['error' => 'Failed to send notification']);
        }
        \App\Models\Notification::create([
            'user' => $user->id,
            'text' => $message,
            'type' => $data['data']->trans_name
        ]);
        //    class Notification extends Model
//    {
//        use HasFactory;
        //    protected $fillable=['id', 'user_id', 'text', 'type', 'status', 'created_at', 'updated_at'];
// Notification::create([
//    'type'=>'order', 'title'=>$notification['title'], 'body'=>$notification['body'], 'status'=>'0', 'data_id'=>$orderr->order_id,  'user_id'=>$user->id
// ]);
    }
    public function wemaauth()
    {
        if (request()->has('TransactionReference')) {
            $data = request()->all();
            \Log::debug($data['Data']);
            // Authwema::create([
            //  'transactionID'=>request()->transactionReference, 'securityINFO'=>request()->securityInfo,
            // ]);

            // return
            $data = [
                'TransactionReference' => request()->transactionReference,
                'authorized' => true,
            ];
            return json_encode($data);
        }
    }
    // pub
    public function fetchBalance()
    {
        $this->moveMoneyUser();
        //
        //   return auth()->user();

        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            'content-type' => 'application/json',
        ])->get(env('SAFEHAVEN_URL') . '/accounts' . '/' . auth()->user()->sub_acct_id);//.auth()->user()->sub_acct_id


 $balance_error=0;



        if ($response->successful()) {
            $data = $response->json();


            if (
                floatval($data['data']['accountBalance']) <= 0 &&
                auth()->user()->wallet_ngn <= 0
            ) {
                $balance_error = 0;
            }else{
                $balance_error = 1;
            }
            if (isset($data['data']) && isset($data['data']['accountBalance'])) {
                User::where('id', auth()->user()->id)->update(['wallet_ngn' => isset($data['data']) ? $data['data']['accountBalance'] : auth()->user()->wallet_ngn]);
                return ['statuscode' => $data['statusCode'], 'balance' => isset($data['data']) ? $data['data']['accountBalance'] : '','balance_error'=>$balance_error];
            }
            return ['statuscode' => '500', 'balance' => '0','balance_error'=>$balance_error];
            // Do something with the data
        } else {
            // Handle the error
            return ['statuscode' => '500', 'balance' => '0','balance_error'=>$balance_error];
        }
        // 666adaf6722a61002437d99e
    }

    public function fetchBalance2($id)
    {
        //
        //   return auth()->user();
        $users=user::where('acct_no','!=','')->get();
        foreach($users as $k=>$user){
        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            'content-type' => 'application/json',
        ])->get(env('SAFEHAVEN_URL') . '/accounts' . '/' . $user->sub_acct_id);//.auth()->user()->sub_acct_id





        // Optionall/ Handle the error
            // return ['statuscode' => '500', 'balance' => '0'];
        }
        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['data']) && isset($data['data']['accountBalance'])) {
                User::where('sub_acct_id',  $user->sub_acct_id)->update(['wallet_ngn' => $data['data']['accountBalance']]);
                // return ['statuscode' => $data['statusCode'], 'balance' => isset($data['data']) ? $data['data']['accountBalance'] : ''];
            }
      
        } else {
            // Handle the error
            // return ['statuscode' => '500', 'balance' => '0'];
        }
        // 666adaf6722a61002437d99e
    }

    public function createAccount()
    {

        $d = $this->createSafeHeaven();
        // return $d;
        if ($d) {

            return laraResponse('success', 'account  created  successfully')->success();
        } else {
            return laraResponse('error', 'unable to create account  ')->error();
        }
    }

    public function validateOTP()
    {
        $url =
            'https://apiplayground.alat.ng/wallet-creation/api/CustomerAccount/GenerateWalletAccountForPartnershipsV2/Otp';
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        # Request headers
        # Request headers
        $headers = [
            'x-api-key: ' . $this->api_key,
            'Content-Type: application/json',
            'Cache-Control: no-cache',
            'Ocp-Apim-Subscription-Key: ' . $this->wallet_sub_key,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        # Request body
        $request_body =
            '{
    "phoneNumber": "' .
            auth()->user()->acct_phone .
            '",
    "otp": "' .
            request()->token .
            '",
    "trackingId": "' .
            auth()->user()->wema_tracking_id .
            '"
}';
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request_body);

        $resp = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($resp);

        if ($data->statusCode == 'OK') {
            return laraResponse($data->message, $data)->success();
        } else {
            return laraResponse('error', [
                'msg' => 'something went wrong',
                'data' => $data,
            ])->error();
        }
    }

    public function getaccountDetails()
    {
        $url =
            'https://apiplayground.alat.ng/wallet-creation/api/CustomerAccount/GetPartnershipAccountDetails?phoneNumber=' .
            auth()->user()->acct_phone;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        # Request headers
        $headers = [
            'x-api-key: ' . $this->api_key,
            'Content-Type: application/json',
            'Cache-Control: no-cache',
            'Ocp-Apim-Subscription-Key: ' . $this->wallet_sub_key,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $resp = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($resp);
        // return laraResponse('success', $data)->success();
        if ($data->StatusCode == '0') {
            return laraResponse($data->Message, $data)->success();
        } else {
            return laraResponse('error', [
                'msg' => 'something went wrong',
                'data' => $data,
            ])->error();
        }
    }

    public function InterbankFetchAccountDetails()
    {
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        //
        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            'content-type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/transfers/name-enquiry', [
                    'bankCode' => request()->bankcode,
                    'accountNumber' => request()->account_number
                ]);


        // Handle the response
        if ($response->successful()) {
            $data = $response->json();
            if ($data['statusCode'] == 200)
                return laraResponse('success', ['data' => $data, 'setting' => $setting])->success();
            return laraResponse('error', $data)->error();
        } else {
            return laraResponse('error', [
                'msg' => 'something went wrong',
                // 'data' => $data,
            ])->error();
        }
    }

    public function moveMoneyUser()
    {
        // 090286
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        //
        $charges = \DB::table('charges')->where('user_id',auth()->user()->id)->where('status', 0)->paginate(10);
        if (isset($charges)) {
            $session = $this->authGenerate();


            foreach ($charges as $g => $v) {
                $response = \Http::withHeaders([
                    'ClientID' => env('SAFEHAVEN_AUTH_ID'),
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $session,
                    'content-type' => 'application/json',
                ])->post(env('SAFEHAVEN_URL') . '/transfers/name-enquiry', [
                            'bankCode' => '090286',
                            'accountNumber' => $v->credit_acct
                        ]);

                // return $response;
                // Handle the response
                if ($response->successful()) {
                    $data = $response->json();
                    $sessionid = '';
                    if ($data['statusCode'] == 200) {
                        // $sessionid
                        $sessionid = $data['data']['sessionId'];
                    }

                    // return $sessionid;


                    if ($sessionid != '') {


                        //   return auth()->user();
                   


                        $re = [
                            'saveBeneficiary' => false,
                            'nameEnquiryReference' => $sessionid,
                            'debitAccountNumber' => $v->debit_acct,
                            'beneficiaryBankCode' => '090286',
                            'amount' => floatval($v->amount),
                            'beneficiaryAccountNumber' => $v->credit_acct,
                            'narration' => 'Semibill credit transaction on #' . $v->trans_id,
                            'paymentReference' => '#trans_inter_bank' . $v->user_id . date('Ymdhis') . $sessionid


                        ];




                        $responsee = \Http::withHeaders([
                            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
                            'Accept' => 'application/json',
                            'Authorization' => 'Bearer ' . $session,
                            'content-type' => 'application/json',
                        ])->post(env('SAFEHAVEN_URL') . '/transfers', $re);
                        // return $responsee;

                        // Handle the response
                        if ($responsee->successful()) {
                            $data = $responsee->json();
                            if ($data['statusCode'] == 200) {
                                \DB::table('charges')->where('id', $v->id)->update(['status' => '1']);
                                // return $data;

                            }

                        }

                    }


                } else {

                }
            }
        }
    }

    public function getwalletbalance()
    {
        $url =
            'https://apiplayground.alat.ng/ws-acct-mgt/api/AccountMaintenance/CustomerAccount/GetAccountV2/accountNumber/' .
            request()->acct_number;
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        # Request headers
        $headers = [
            'x-api-key: ' . $this->api_key,
            'Content-Type: application/json',
            'Cache-Control: no-cache',
            'Ocp-Apim-Subscription-Key: ' . $this->wallet_sub_key,
        ];
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $resp = curl_exec($curl);
        curl_close($curl);
        $data = json_decode($resp);
        // return $data->result;et-bank-list
        return $data;
    }
    public function verifyAccount()
    {
        $auth = $this->authGenerate1();
        //    return  $auth['access_token'];
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        $response = \Http::withHeaders([
            'ClientID' => $auth['ibs_client_id'],
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $auth['access_token'],
            'content-type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/identity/v2', [
                    'type' => strtoupper(trim(request()->type)),
                    'async' => false,


                    'number' => request()->number,
                    'debitAccountNumber' => $setting->main_acct_no,
                ]);

        // Handle the response
        if ($response->successful()) {
            // Successful response
            // return 
            $d = $response->json();
            if (isset($d['statusCode']) && $d['statusCode'] == 200) {

                $charge = \App\Models\Admin\Charges::create([
                    'debit_acct' => auth()->user()->acct_no,
                    'credit_acct' => $setting->main_acct_no,
                    'user_id' => auth()->user()->id,
                    'amount' => 50,
                    'status' => 1,
                    'trans_id' => '',
                ]);
                $user = User::where('id', auth()->user()->id)->first();
                if ($user != null) {
                    $balance = $user->wallet_ngn - floatval(50);
                    // $d = request()-;
                    $user->wallet_ngn = $balance;
                    $user->save();
                }
                return laraResponse('success', ['data' => $d['data']])->success();

            } else {
                return laraResponse('error', [
                    'error' => 'Request failed',
                    'status' => $response->status(),
                    'response' => $response->json(),
                ])->error();

            }
        } else {
            // Handle error
            return laraResponse('error', [
                'error' => 'Request failed',
                'status' => $response->status(),
                'response' => $response->json(),
            ])->error();
        }
    }


    public function verifyotp()
    {
        $auth = $this->authGenerate1();
        //    return  $auth['access_token'];
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        $response = \Http::withHeaders([
            'ClientID' => $auth['ibs_client_id'],
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $auth['access_token'],
            'content-type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/identity/v2/validate', [
                    'type' => strtoupper(trim(request()->type)),
                    'identityId' => request()->id,
                    'otp' => request()->otp,
                ]);

        if ($response->successful()) {
            // Successful response
            // return 
            $d = $response->json();
            if (isset($d['statusCode']) && $d['statusCode'] == 200) {
                \Log::debug($d);
                if (strtolower(trim(request()->type)) == 'bvn')
                    User::where('id', auth()->user()->id)->update(['verification_type' => request()->type, 'verification_number' => $d['data']['providerResponse']['bvn'], 'verification_status' => 'active', 'sh_id_no' => request()->id, 'verification_otp' => request()->otp]);
                return laraResponse('success', ['data' => $d['data']])->success();

            } else {
                return laraResponse('error', [
                    'error' => 'Request failed',
                    'status' => $response->status(),
                    'response' => $response->json(),
                ])->error();

            }
        } else {
            // Handle error
            return laraResponse('error', [
                'error' => 'Request failed',
                'status' => $response->status(),
                'response' => $response->json(),
            ])->error();
        }
    }

    public function transfer()
    {
       
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);

        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (floatval($nb['balance_error']) == 0 ) {

            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();

        }
        if (floatval($nb['balance']) < floatval($this->filteramount(request()->amount) + $setting->trans_com)) {

            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();

        }



        $re = [
            'saveBeneficiary' => false,
            'nameEnquiryReference' => request()->sessionid,
            'debitAccountNumber' => auth()->user()->acct_no,
            'beneficiaryBankCode' => request()->bankcode,
            'amount' => floatval($this->filteramount(request()->amount)),
            'beneficiaryAccountNumber' => request()->account_number,
            'narration' => request()->narration,
            'paymentReference' => '#trans_inter_bank' . auth()->user()->id . date('Ymdhis') . request()->sessionid


        ];
        // return $re;

        $transid = '#trans_inter_bank' . auth()->user()->id . date('Ymdhis') . request()->sessionid;
        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            'content-type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/transfers', $re);


        // Handle the response
        if ($response->successful()) {
            $data = $response->json();
            if ($data['statusCode'] == 200)
                $user = User::where('id', auth()->user()->id)->first();
            if ($user != null) {
                $balance = $user->wallet_ngn - floatval($this->filteramount(request()->amount) + $setting->trans_com);
                // $d = request()-;
                $user->wallet_ngn = $balance;
                $user->save();


                $TRANS = APITransaction::create([
                    'trans_id' => $transid,
                    'trans_type' => 'debit',
                    'trans_name' => 'tranfer',
                    'api_source' => 'safehaven',
                    'user_id' => $user->id,
                    'current_balance' => $balance,
                    'amount' => floatval($this->filteramount(request()->amount)),
                    'data_json' => $data,
                    'beneficiary_bank' => isset($this->banks[request()->bankcode]) ? $this->banks[request()->bankcode] : '',
                    'beneficiary_no' => request()->account_number,
                    'beneficiary_name' => $data['data']['creditAccountName'],
                    // 'destinationInstitutionCode' => '090286',
                    'beneficiary_bank' => isset($this->banks[$data['data']['destinationInstitutionCode']]) ? $this->banks[$data['data']['destinationInstitutionCode']] : '',
                    'from_name' => $data['data']['debitAccountName'],
                    'from_no' => $data['data']['debitAccountNumber']

                ]);
                $this->notify($TRANS->trans_id, $user, $TRANS, 'Your Account has been Debited with  #' . number_format(($this->filteramount(request()->amount) + $setting->trans_com), 2) . ' ; Transfer to ' . request()->account_number);
                $this->transEmail($data['data']['paymentReference'], $user, 'DEBIT TRANSACTION', 'debit', $data['data']['narration'], 'NGN ' . number_format(($data['data']['amount']), 2), $TRANS->created_at);
                $setting = \App\Models\Setting::where('id', '!=', '')->first();
                // 'debit_acct', 'credit_acct', 'user_id', 'amount', 'status', 'created_at', 'updated_at','trans_id'

                $charge = \App\Models\Admin\Charges::create([
                    'debit_acct' => auth()->user()->acct_no,
                    'credit_acct' => $setting->main_acct_no,
                    'user_id' => auth()->user()->id,
                    'amount' => floatval($setting->trans_com) - 10,
                    'status' => 0,
                    'trans_id' => $TRANS->trans_id,
                ]);
            }
            return laraResponse('success', $data)->success();
            return laraResponse('error', $data)->error();
        } else {
            $data = $response->json();
            return laraResponse('error', [
                'msg' => 'something went wrong',
                'data' => $data,
            ])->error();
        }
        // {
        //     "securityInfo": "JTRYST932APE",
        //     "amount": 100,
        //     "destinationBankCode": "035",
        //     "destinationBankName": "Wema Bank",
        //     "destinationAccountNumber": "0289146390",
        //     "destinationAccountName": "PACHRISTO PEAK SEMIBILL",
        //     "sourceAccountNumber": "0285324431",
        //     "narration": "tip pachris",
        //     "transactionReference": "trans_3252352625",
        //     "useCustomNarration": true
        // }
    }

    public function getNIPCharges()
    {

    }
    /**
     * Show the form for creating a new resource.
     */
    public function fetchAccountDetails()
    {
        //
        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            'content-type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/transfers/name-enquiry', [
                    'bankCode' => 'ijoijo',
                    'accountNumber' => 'hkjhkkjh'
                ]);


        // Handle the response
        if ($response->successful()) {
            $data = $response->json();
            return laraResponse('success', $data)->success();
        } else {
            return laraResponse('error', [
                'msg' => 'something went wrong',
                // 'data' => $data,
            ])->error();
        }
    }

    public function listBanks()
    {

        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            // 'Content-Type' => 'application/json',
        ])->get(env('SAFEHAVEN_URL') . '/transfers/banks');



        // Handle the response
        if ($response->successful()) {
            // Request was successful
            $responseData = $response->json();
            // Process the response data
            $data = $responseData;
            return laraResponse('success', $data['data'])->success();
        } else {
            return laraResponse('error', [
                'msg' => 'something went wrong',
            ])->error();
        }
    }


    public function paystackAccountCreation()
    {

    }

    public function fetchPaystackAccount()
    {

    }

    public function resorveAccountNo()
    {

    }
    public function checkpaystackBalance()
    {

    }
    public function paystackBankList()
    {

    }

    public function addBeneficiary()
    {
        // 'acct_name', 'acct_no', 'bank', 'created_at', 'updated_at', 'user_id'




        $b = Beneficiary::updateOrCreate(
            ['acct_no' => request()->acct_no], // Condition to find the record based on SKU
            ['acct_name' => request()->acct_name, 'acct_no' => request()->acct_no, 'bank' => request()->bank, 'user_id' => auth()->user()->id,] // Data to update or insert
        );
        return laraResponse('success', $b)->success();

    }

    public function listBeneficiary()
    {
        // 'acct_name', 'acct_no', 'bank', 'created_at', 'updated_at', 'user_id'
        if (request()->has('type')) {
            $b = Beneficiary::where('user_id', auth()->user()->id)->where('bank', request()->type)->latest('created_at')->get();
            return laraResponse('success', $b)->success();

        } else {
            $b = Beneficiary::where('user_id', auth()->user()->id)->latest('created_at')->get();
            return laraResponse('success', $b)->success();

        }

    }

    public function deleteBeneficiary($id)
    {
        // 'acct_name', 'acct_no', 'bank', 'created_at', 'updated_at', 'user_id'
        $b = Beneficiary::where('id', $id)->delete();

        return laraResponse('success', ['msg' => 'data deleted Successfully'])->success();



    }




    public function transferinitiate()
    {



    }

    public function Sendsupport()
    {
        $support = Support::create([
            'user_id' => auth()->user()->id,
            'subject' => request()->subject,
            'type' => request()->type,
            'text' => request()->text,
            'status' => '0',
        ]);
        $this->sendEmail('', auth()->user(), request()->subject, request()->text);
        return laraResponse('success', $support)->success();
    }


    public function getNotify()
    {
        $not = \App\Models\Admin\Notify::where('status', 'unpublished')->get();
        foreach ($not as $rr => $v) {
            if ($v->target == 'all' || $v->target == 'fcm') {
                if ($v->recipient == 0) {
                    $tokens = \App\Models\User::latest('created_at')->where('device_token', '!=', null)->pluck('device_token')->toArray();
                    // \late
                    \Log::debug($tokens);
                    $this->notify1($tokens, $v, $v->text, $v->subject);
                } else {
                    $tokens = \App\Models\User::where('id', $v->recipient)->pluck('device_token')->toArray();
                    \Log::debug($tokens);
                    $this->notify1($tokens, $v, $v->text, $v->subject);
                }
                \App\Models\Admin\Notify::where('id', $v->id)->update([
                    'status' => 'published'
                ]);

            }
        }

    }


    public function getSetting()
    {
        $support = \App\Models\Setting::where('id', '!=', '')->first();
        //
        return laraResponse('success', $support)->success();
    }

    public function transEmail($id, $user, $subject, $type, $description, $amount, $date)
    {
        //   return $this->view('emails.welcome')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject("WELCOME TO VICTORSPREDICT.COM");

        $view = \View::make('emails.transaction', ['name' => $user->name, 'subject' => $subject, 'date' => $date, 'id' => $id, 'type' => $type, 'description' => $description, 'amount' => $amount])->render();
        // return $view;

        $emailData = [
            'from' => ['address' => 'admin@semibill.com', 'name' => 'SEMIBILL'],
            'to' => [
                [
                    'email_address' => [
                        'address' => 'info@semibill.com',
                        'name' => 'Semibill',
                    ],
                ],
            ],
            'cc' => [ // Adding CC recipient
                [
                    'email_address' => [
                        'address' => trim(strtolower($user->email)),
                        'name' => $user->name,
                    ],
                ],
            ],
            'subject' => $subject . ' | TRANSACTION - SEMIBILL.COM',
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



    public function sendEmail($to, $user, $subject, $text)
    {
        //   return $this->view('emails.welcome')->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))->subject("WELCOME TO VICTORSPREDICT.COM");

        $view = \View::make('emails.support', ['user' => $user, 'subject' => $subject, 'text' => $text])->render();
        // return $view;

        $emailData = [
            'from' => ['address' => 'admin@semibill.com'],
            'to' => [
                [
                    'email_address' => [
                        'address' => 'info@semibill.com',
                        'name' => 'Semibill',
                    ],
                ],
            ],
            'cc' => [ // Adding CC recipient
                [
                    'email_address' => [
                        'address' => trim(strtolower($user->email)),
                        'name' => $user->name,
                    ],
                ],
            ],
            'subject' => $subject . ' | SUPPORT-  SEMIBILL.COM',
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



    // safehaven 
    public function authGenerate()
    {
        // use Illuminate\Support\Facades\Http;

        $response = \Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                    'client_id' => env('SAFEHAVEN_AUTH_ID'),
                    'client_assertion' => env('SAFEHAVEN_TOKEN'),
                ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Retrieve the response data
            $responseData = $response->json();
            // Handle the response data
            // For example, print the access token
            return $responseData['access_token'];
        }
    }

    public function authGenerate1()
    {
        // use Illuminate\Support\Facades\Http;

        $response = \Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/oauth2/token', [
                    'grant_type' => 'client_credentials',
                    'client_assertion_type' => 'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
                    'client_id' => env('SAFEHAVEN_AUTH_ID'),
                    'client_assertion' => env('SAFEHAVEN_TOKEN'),
                ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Retrieve the response data
            $responseData = $response->json();
            // Handle the response data
            // For example, print the access token
            return $responseData;
        }
    }


    public function createSafeHeaven()
    {
        $auth = $this->authGenerate1();

        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        $response = \Http::withHeaders([
            'ClientID' => env('SAFEHAVEN_AUTH_ID'),
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->authGenerate(),
            'content-type' => 'application/json',
        ])->post(env('SAFEHAVEN_URL') . '/accounts/v2/subaccount', [
                    'phoneNumber' => request()->phone,
                    'emailAddress' => auth()->user()->email,
                    // 'identityType' => strtoupper(trim(auth()->user()->verification_type)),
                    'identityType' => 'BVN',
                    'autoSweep' => 'false',
                    'autoSweepDetails' => [
                        'schedule' => 'Instant',
                        'accountNumber' => $setting->main_acct_no
                    ],
                    'externalReference' => auth()->user()->username,
                    // 'otp' =>auth()->user()->verification_otp,
                    // 'identityId' => auth()->user()->sh_id_no,
                    // 'identityNumber' => auth()->user()->verification_number    ,

                    'otp' => request()->otp,
                    'identityId' => request()->no,
                    'identityNumber' => request()->bvn,

                ]);
        // 'verification_type', 'verification_number', 'verification_status','sh_id_no','verification_otp'
        // Handle the response
        if ($response->successful()) {
            // Request was successful
            $responseData = $response->json();
            // Process the response data
            \Log::debug($responseData);
            // return $responseData;
            if (!isset($responseData['data']))
                return false;
            $data = $responseData['data'];

            // Access data fields
            // $canDebit = $data['canDebit'];
            // $canCredit = $data['canCredit'];
            $id = $data['_id'];
            $client = $data['client'];
            $accountProduct = $data['accountProduct'];
            $accountNumber = $data['accountNumber'];
            $accountName = $data['accountName'];
            $charge = \App\Models\Admin\Charges::where('user_id', auth()->user()->id)->update([
                'debit_acct' => $data['accountNumber'],

                'status' => 0,

            ]);

            User::where('id', auth()->user()->id)->update([
                'acct_name' => $accountName,
                'acct_no' => $accountNumber,
                'sub_acct_id' => $id,
                'acct_status' => 'active',
                'verification_type' => 'BVN',
                'verification_number' => request()->bvn,
                'verification_status' => 'active',
                'sh_id_no' => request()->no,
                'verification_otp' => request()->otp
            ]);
            return true;
        } else {
            // Request failed
            return false;
            // Handle the error
        }
    }
    public function chargesSafe($user, $amount, $trans_id, $userto = null)
    {
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        // 'debit_acct', 'credit_acct', 'user_id', 'amount', 'status', 'created_at', 'updated_at','trans_id'
        if ($userto == null) {
            $charge = \App\Models\Admin\Charges::create([
                'debit_acct' => $user->acct_no,
                'credit_acct' => $setting->main_acct_no,
                'user_id' => $user->id,
                'amount' => floatval($amount),
                'status' => 0,
                'trans_id' => $trans_id
            ]);
        } else {
            $charge = \App\Models\Admin\Charges::create([
                'debit_acct' => $user->acct_no,
                'credit_acct' => $userto->acct_no,
                'user_id' => $user->id,
                'amount' => floatval($amount),
                'status' => 0,
                'trans_id' => $trans_id
            ]);
        }
        try {
            $this->moveMoney();


        } catch (\Exception $w) {
            \Log::debug($w);
        }


        return true;


    }

    public function listCards(){
      
        // $latestPost = \App\Models\Post::where('user_id', $userId)->latest('id')->first();
        $cards = \App\Models\Card::where('user_id', auth()->user()->id)->latest('id')->first();
        if($cards != null){
            return laraResponse('success', [
                'msg' => 'success',
                'card' => $cards,
            ])->success();
        }else{
            return laraResponse('success', [
                'msg' => 'No card request found',
                'card' => $cards,
            ])->success();
        }
    }
    public function reqCard()
    {

        $cards = \App\Models\Card::where('user_id', auth()->user()->id)->where('is_request','1')->where('is_verified','0')->first();
        if($cards != null){
            return laraResponse('success', [
                'msg' => 'Card request already exist',
                'card' => $cards,
            ])->success();
        }

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0 ) {

            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();

        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        // card_charge
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        if (floatval($nb['balance']) < floatval($this->filteramount($setting->card_charge))) {

            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $validate = Validator::make(request()->all(), [
            'firstname' => 'required|string|max:25',
            'lastname' => 'required|string|max:25',
           'middlename' => 'required|string|max:25',
           'address' => 'required|string|max:50',
           'city' => 'required|string|max:25',
           'postalcode'=>'required|max:10',
           'city'=>'required|string|max:25',
           'state' => 'required|string|max:25',
           'pin' => 'required|string|max:4',

        ]);
        if ($validate->fails()) {
            return laraResponse(
                'validation_error',
                $validate->messages()
            )->error();
        }
        $firstname = request()->firstname;
        $lastname = request()->lastname;
        $middlename = request()->middlename;
        $response = \Http::withHeaders([
            'Authorization' => 'Bearer ' . env('SUDO_AFRICA_TOKEN'),
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post('https://api.sudo.com/customers', [
                    'type' => 'individual',
                    'individual' => [
                        'identity' => [
                            'type' => 'BVN',
                            'number' => auth()->user()->verification_number
                        ],
                        'firstName' => $firstname,
                        'otherNames' => $middlename,
                        'lastName' => $lastname,
                        'dob' => request()->dob
                    ],
                    'company' => [
                        'identity' => [
                            'type' => 'BVN'
                        ],
                        'officer' => [
                            'identity' => [
                                'type' => 'BVN'
                            ]
                        ]
                    ],
                    'status' => 'active',
                    'billingAddress' => [
                        'line1' => request()->address,
                        'city' => request()->city,
                        'postalCode' => request()->postalcode,
                        'country' => 'Nigeria',
                        'state' => request()->state,
                        'line2' => request()->address2
                    ],
                    'emailAddress' => auth()->user()->email,
                    'phoneNumber' => auth()->user()->phone,
                    'name' => $firstname . ' ' . $middlename . ' ' . $lastname
                ]);
        //         'id', 'name', 'firstname', 'lastname', 'email', 'state', 'lga', 'phone', 'bank_name', 'bank_account_no', 'bank_account_name', 'device_token', 'email_verified_at', 'password', 'remember_token', 'created_at', 'updated_at', 'address', 'pass_token', 'email_verified', 'email_code', 'wallet_ngn', 'username', 'acct_name', 'acct_no', 'acct_status', 'acct_customer_id', 'acct_email', 'acct_phone', 'dod', 'nin', 'wema_tracking_id', 'pin', 'pin_token', 'ps_cus_code', 'ps_cus_id', 'biometric', 'referral_code', 'avatar', 'verification_type', 'verification_number', 'verification_status','sh_id_no','verification_otp'
        //    'id', 'user_id', 'customer_id', 'card_data', 'is_request', 'is_verified', 'pin', 'report', 'address', 'is_paid', 'created_at', 'updated_at', 'address1', 'city', 'lga', 'state', 'postalcode'
        \Log::debug($response);
        // return $response;
        if ($response->successful()) {
            // Handle successful response

            $data= $response->json();
            if(isset($data['statusCode'])&& $data['statusCode']==200){
                $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount($setting->card_charge);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $card=\App\Models\Card::create([
                'user_id'=>auth()->user()->id, 'customer_id'=>$data['data']['_id'], 'card_data'=>$data['data'], 'is_request'=>true, 'is_verified'=>false,   'address'=>request()->address, 'is_paid'=>true, 'created_at', 'updated_at', 'address1'=>request()->address2, 'city'=>request()->city, 'state'=>request()->state, 'postalcode'=>request()->postalcode
            ]);
            $this->chargesSafe(auth()->user(), $this->filteramount($setting->card_charge), 'card_'.$card->id);
        return laraResponse('success', ['msg' => 'data created Successfully'])->success();
            }else{
              
        return laraResponse('error', ['msg' => 'Opps! unable to create data, try again later '])->success();
            }
        } else {
            // Handle error
            return laraResponse('error', ['msg' => 'Opps! unable to create data, try again later '])->success();
        }
    }

    public $banks = [
        "",
        "000034" => "SIGNATURE BANK",
        "000036" => "OPTIMUS BANK",
        "000001" => "STERLING BANK",
        "000002" => "KEYSTONE BANK",
        "000003" => "FIRST CITY MONUMENT BANK",
        "000004" => "UNITED BANK FOR AFRICA",
        "000006" => "JAIZ BANK",
        "000007" => "FIDELITY BANK",
        "000008" => "POLARIS BANK",
        "000009" => "CITI BANK",
        "000010" => "ECOBANK",
        "000011" => "UNITY BANK",
        "000012" => "STANBIC IBTC BANK",
        "000013" => "GTBANK PLC",
        "000014" => "ACCESS BANK",
        "000015" => "ZENITH BANK",
        "000016" => "FIRST BANK OF NIGERIA",
        "000017" => "WEMA BANK",
        "000018" => "UNION BANK",
        "000019" => "ENTERPRISE BANK",
        "000021" => "STANDARD CHARTERED BANK",
        "000022" => "SUNTRUST BANK",
        "000023" => "PROVIDUS BANK",
        "060001" => "CORONATION MERCHANT BANK",
        "070001" => "NPF MICROFINANCE BANK",
        "070002" => "FORTIS MICROFINANCE BANK",
        "070008" => "PAGE MFBANK",
        "090001" => "ASO SAVINGS",
        "090003" => "JUBILEE LIFE",
        "090006" => "SAFETRUST",
        "090107" => "FIRST TRUST MORTGAGE BANK PLC",
        "090108" => "NEW PRUDENTIAL BANK",

        "090111" => "FINATRUST MICROFINANCE BANK",
        "090112" => "SEED CAPITAL MICROFINANCE BANK",
        "090115" => "TCF MICROFINANCE BANK",
        "090114" => "EMPIRE TRUST MICROFINANCE BANK",
        "090113" => "MICROVIS MICROFINANCE BANK ",
        "090116" => "AMML MICROFINANCE BANK ",
        "090117" => "BOCTRUST MICROFINANCE BANK LIMITED",
        "090120" => "WETLAND MICROFINANCE BANK",
        "090118" => "IBILE MICROFINANCE BANK",
        "090125" => "REGENT MICROFINANCE BANK",
        "090128" => "NDIORAH MICROFINANCE BANK",
        "090127" => "BC KASH MICROFINANCE BANK",
        "090121" => "HASAL MICROFINANCE BANK",
        "060002" => "FBNQUEST MERCHANT BANK",
        "090132" => "RICHWAY MICROFINANCE BANK",
        "090135" => "PERSONAL TRUST MICROFINANCE BANK",
        "090136" => "MICROCRED MICROFINANCE BANK",
        "090122" => "GOWANS MICROFINANCE BANK",
        "000024" => "RAND MERCHANT BANK",
        "090142" => "YES MICROFINANCE BANK",
        "090140" => "SAGAMU MICROFINANCE BANK",
        "090129" => "MONEY TRUST MICROFINANCE BANK",
        "070012" => "LAGOS BUILDING AND INVESTMENT COMPANY",
        "070009" => "GATEWAY MORTGAGE BANK",
        "070010" => "ABBEY MORTGAGE BANK",
        "070014" => "FIRST GENERATION MORTGAGE BANK",
        "070013" => "PLATINUM MORTGAGE BANK",
        "070016" => "INFINITY TRUST MORTGAGE BANK",
        "090119" => "OHAFIA MICROFINANCE BANK",
        "090124" => "XSLNCE MICROFINANCE BANK",
        "090130" => "CONSUMER MICROFINANCE BANK",
        "090131" => "ALLWORKERS MICROFINANCE BANK",
        "090134" => "ACCION MICROFINANCE BANK",
        "090139" => "VISA MICROFINANCE BANK",
        "090141" => "CHIKUM MICROFINANCE BANK",
        "090143" => "APEKS MICROFINANCE BANK",
        "090144" => "CIT MICROFINANCE BANK",
        "090145" => "FULLRANGE MICROFINANCE BANK",
        "090153" => "FFS MICROFINANCE BANK",
        "090160" => "ADDOSSER MICROFINANCE BANK",
        "090126" => "FIDFUND MICROFINANCE BANK",

        "090137" => "PECANTRUST MICROFINANCE BANK",
        "090148" => "BOWEN MICROFINANCE BANK",
        "090158" => "FUTO MICROFINANCE BANK",
        "070011" => "REFUGE MORTGAGE BANK",
        "070015" => "BRENT MORTGAGE BANK",
        "090138" => "ROYAL EXCHANGE MICROFINANCE BANK",
        "090147" => "HACKMAN MICROFINANCE BANK",
        "090146" => "TRIDENT MICROFINANCE BANK",
        "090157" => "INFINITY MICROFINANCE BANK",
        "090159" => "CREDIT AFRIQUE MICROFINANCE BANK",
        "090156" => "E-BARCS MICROFINANCE BANK",
        "090110" => "VFD MFB",

        "090097" => "EKONDO MICROFINANCE BANK",
        "090150" => "VIRTUE MICROFINANCE BANK",
        "090149" => "IRL MICROFINANCE BANK",

        "090151" => "MUTUAL TRUST MICROFINANCE BANK",
        "090161" => "OKPOGA MICROFINANCE BANK",
        "060003" => "NOVA MERCHANT BANK",
        "090154" => "CEMCS MICROFINANCE BANK",
        "090167" => "DAYLIGHT MICROFINANCE BANK",
        "070017" => "HAGGAI MORTGAGE BANK LIMITED",
        "090171" => "MAINSTREET MICROFINANCE BANK",
        "090178" => "GREENBANK MICROFINANCE BANK",
        "090179" => "FAST MICROFINANCE BANK",
        "090177" => "LAPO MICROFINANCE BANK",
        "000020" => "HERITAGE BANK",
        "090251" => "UNIVERSITY OF NIGERIA, NSUKKA MICROFINANCE BANK",
        "090196" => "PENNYWISE MICROFINANCE BANK ",
        "090197" => "ABU MICROFINANCE BANK ",
        "090194" => "NIRSAL NATIONAL MICROFINANCE BANK",
        "090176" => "BOSAK MICROFINANCE BANK",
        "090172" => "ASTRAPOLARIS MICROFINANCE BANK",
        "090261" => "QUICKFUND MICROFINANCE BANK",
        "090259" => "ALEKUN MICROFINANCE BANK",
        "090198" => "RENMONEY MICROFINANCE BANK ",
        "090262" => "STELLAS MICROFINANCE BANK ",
        "090205" => "NEW DAWN MICROFINANCE BANK",
        "090169" => "ALPHA KAPITAL MICROFINANCE BANK ",
        "090264" => "AUCHI MICROFINANCE BANK ",
        "090270" => "AB MICROFINANCE BANK ",
        "090263" => "NIGERIAN NAVY MICROFINANCE BANK ",
        "090258" => "IMO STATE MICROFINANCE BANK",
        "090276" => "TRUSTFUND MICROFINANCE BANK ",
        "090195" => "GROOMING MICROFINANCE BANK",
        "090260" => "ABOVE ONLY MICROFINANCE BANK ",
        "090272" => "OLABISI ONABANJO UNIVERSITY MICROFINANCE ",
        "090268" => "ADEYEMI COLLEGE STAFF MICROFINANCE BANK",
        "090280" => "MEGAPRAISE MICROFINANCE BANK",
        "000026" => "TAJ BANK",
        "090282" => "ARISE MICROFINANCE BANK",
        "090274" => "PRESTIGE MICROFINANCE BANK",
        "090278" => "GLORY MICROFINANCE BANK",
        "090188" => "BAINES CREDIT MICROFINANCE BANK",
        "000005" => "ACCESS(DIAMOND) BANK",
        "090289" => "PILLAR MICROFINANCE BANK",
        "090286" => "SAFE HAVEN MICROFINANCE BANK",
        "090292" => "AFEKHAFE MICROFINANCE BANK",
        "000027" => "GLOBUS BANK",
        "090285" => "FIRST OPTION MICROFINANCE BANK",
        "090296" => "POLYUNWANA MICROFINANCE BANK",
        "090295" => "OMIYE MICROFINANCE BANK",
        "090287" => "ASSETMATRIX MICROFINANCE BANK",
        "000025" => "TITAN TRUST BANK",
        "090271" => "LAVENDER MICROFINANCE BANK",
        "090290" => "FCT MICROFINANCE BANK",
        "090279" => "IKIRE MICROFINANCE BANK",
        "090303" => "PURPLEMONEY MICROFINANCE BANK",
        "ACCESS YELLO & BETA",
        "090123" => "TRUSTBANC J6 MICROFINANCE BANK LIMITED",
        "090305" => "SULSPAP MICROFINANCE BANK",
        "090166" => "ESO-E MICROFINANCE BANK",
        "090273" => "EMERALD MICROFINANCE BANK",
        "ACCESS MONEY",
        "090297" => "ALERT MICROFINANCE BANK",
        "090308" => "BRIGHTWAY MICROFINANCE BANK",
        "PALMPAY",
        "090325" => "SPARKLE",
        "090326" => "BALOGUN GAMBARI MICROFINANCE BANK",
        "090317" => "PATRICKGOLD MICROFINANCE BANK",
        "070019" => "MAYFRESH MORTGAGE BANK",
        "090327" => "TRUST MICROFINANCE BANK",
        "090133" => "AL-BARAKAH MICROFINANCE BANK",
        "090328" => "EYOWO",
        "090304" => "EVANGEL MICROFINANCE BANK ",
        "090332" => "EVERGREEN MICROFINANCE BANK",
        "090333" => "OCHE MICROFINANCE BANK",
        "090364" => "NUTURE MICROFINANCE BANK",

        "090329" => "NEPTUNE MICROFINANCE BANK",
        "090315" => "U & C MICROFINANCE BANK",
        "090331" => "UNAAB MICROFINANCE BANK",
        "090324" => "IKENNE MICROFINANCE BANK",
        "090321" => "MAYFAIR MICROFINANCE BANK",
        "090322" => "REPHIDIM MICROFINANCE BANK",
        "090299" => "KONTAGORA MICROFINANCE BANK",
        "090360" => "CASHCONNECT MICROFINANCE BANK",
        "090336" => "BIPC MICROFINANCE BANK",
        "090362" => "MOLUSI MICROFINANCE BANK",
        "090372" => "LEGEND MICROFINANCE BANK",
        "090369" => "SEEDVEST MICROFINANCE BANK",
        "090294" => "EAGLE FLIGHT MICROFINANCE BANK",
        "090373" => "THINK FINANCE MICROFINANCE BANK",

        "090374" => "COASTLINE MICROFINANCE BANK",
        "090281" => "MINT-FINEX MFB",
        "090363" => "HEADWAY MICROFINANCE BANK",
        "090377" => "ISALEOYO MICROFINANCE BANK",
        "090378" => "NEW GOLDEN PASTURES MICROFINANCE BANK",

        "090365" => "CORESTEP MICROFINANCE BANK",
        "090298" => "FEDPOLY NASARAWA MICROFINANCE BANK",
        "090366" => "FIRMUS MICROFINANCE BANK",
        "090383" => "MANNY MICROFINANCE BANK",
        "090391" => "DAVODANI MICROFINANCE BANK",
        "090389" => "EK-RELIABLE MICROFINANCE BANK",
        "090385" => "GTI MICROFINANCE BANK",
        "090252" => "YOBE MICROFINANCE BANK",
        "9 PAYMENT SOLUTIONS BANK",
        "OPAY",
        "090175" => "RUBIES MICROFINANCE BANK",
        "090392" => "MOZFIN MICROFINANCE BANK",
        "090386" => "INTERLAND MICROFINANCE BANK",
        "090400" => "FINCA MICROFINANCE BANK",
        "KONGAPAY",
        "090370" => "ILISAN MICROFINANCE BANK",
        "090399" => "NWANNEGADI MICROFINANCE BANK",
        "090186" => "GIREI MICROFINANACE BANK",
        "090396" => "OSCOTECH MICROFINANCE BANK",
        "090393" => "BRIDGEWAY MICROFINANACE BANK",
        "090380" => "KREDI MONEY MICROFINANCE BANK ",
        "090401" => "SHERPERD TRUST MICROFINANCE BANK",
        "NOWNOW DIGITAL SYSTEMS LIMITED",
        "090394" => "AMAC MICROFINANCE BANK",
        "070007" => "LIVINGTRUST MORTGAGE BANK PLC",
        "M36",
        "090283" => "NNEW WOMEN MICROFINANCE BANK ",
        "090408" => "GMB MICROFINANCE BANK",
        "090005" => "TRUSTBOND MORTGAGE BANK",
        "090152" => "NAGARTA MICROFINANCE BANK",
        "090155" => "ADVANS LA FAYETTE MICROFINANCE BANK",
        "090162" => "STANFORD MICROFINANCE BANK",
        "090164" => "FIRST ROYAL MICROFINANCE BANK",
        "090165" => "PETRA MICROFINANCE BANK",
        "090168" => "GASHUA MICROFINANCE BANK",
        "090173" => "RELIANCE MICROFINANCE BANK",
        "090174" => "MALACHY MICROFINANCE BANK",
        "090180" => "AMJU UNIQUE MICROFINANCE BANK",
        "090189" => "ESAN MICROFINANCE BANK",
        "090190" => "MUTUAL BENEFITS MICROFINANCE BANK",
        "090191" => "KCMB MICROFINANCE BANK",
        "090192" => "MIDLAND MICROFINANCE BANK",
        "090193" => "UNICAL MICROFINANCE BANK",
        "090265" => "LOVONUS MICROFINANCE BANK",
        "090266" => "UNIBEN MICROFINANCE BANK",
        "090269" => "GREENVILLE MICROFINANCE BANK",
        "090277" => "AL-HAYAT MICROFINANCE BANK",
        "090293" => "BRETHREN MICROFINANCE BANK",
        "090310" => "EDFIN MICROFINANCE BANK",
        "090318" => "FEDERAL UNIVERSITY DUTSE MICROFINANCE BANK",
        "090320" => "KADPOLY MICROFINANCE BANK",
        "090323" => "MAINLAND MICROFINANCE BANK",
        "090376" => "APPLE MICROFINANCE BANK",
        "090395" => "BORGU MICROFINANCE BANK",
        "090398" => "FEDERAL POLYTECHNIC NEKEDE MICROFINANCE BANK",
        "090404" => "OLOWOLAGBA MICROFINANCE BANK",
        "090406" => "BUSINESS SUPPORT MICROFINANCE BANK",
        "090202" => "ACCELEREX NETWORK LIMITED",
        "HOPEPSB",
        "090316" => "BAYERO UNIVERSITY MICROFINANCE BANK",
        "090410" => "MARITIME MICROFINANCE BANK",
        "090371" => "AGOSASA MICROFINANCE BANK",
        "ZENITH EASY WALLET",
        "070021" => "COOP MORTGAGE BANK",
        "CARBON",
        "090435" => "LINKS MICROFINANCE BANK",
        "090433" => "RIGO MICROFINANCE BANK",
        "090402" => "PEACE MICROFINANCE BANK",
        "090436" => "SPECTRUM MICROFINANCE BANK ",
        "060004" => "GREENWICH MERCHANT BANK",
        "000029" => "LOTUS BANK",
        "090426" => "TANGERINE MONEY",
        "000030" => "PARALLEX BANK",
        "090448" => "Moyofade MF Bank",
        "090449" => "SLS MF Bank",
        "090450" => "Kwasu MF Bank",
        "090451" => "ATBU Microfinance Bank",
        "090452" => "UNILAG Microfinance Bank",
        "090453" => "Uzondu MF Bank",
        "090454" => "Borstal Microfinance Bank",
        "090471" => "Oluchukwu Microfinance Bank",
        "090472" => "Caretaker Microfinance Bank",
        "090473" => "Assets Microfinance Bank",
        "090474" => "Verdant Microfinance Bank",
        "090475" => "Giant Stride Microfinance Bank",
        "090476" => "Anchorage Microfinance Bank",
        "090477" => "Light Microfinance Bank",
        "090478" => "Avuenegbe Microfinance Bank",
        "090479" => "First Heritage Microfinance Bank",
        "090480" => "KOLOMONI MICROFINANCE BANK",
        "090481" => "Prisco Microfinance Bank",
        "090483" => "Ada Microfinance Bank",
        "090484" => "Garki Microfinance Bank",
        "090485" => "SAFEGATE MICROFINANCE BANK",
        "090486" => "Fortress Microfinance Bank",
        "090487" => "Kingdom College Microfinance Bank",
        "090488" => "Ibu-Aje Microfinance",
        "090489" => "Alvana Microfinance Bank",
        "090455" => "MKOBO MICROFINANCE BANK LTD",
        "090456" => "Ospoly Microfinance Bank",
        "090459" => "Nice Microfinance Bank",
        "090460" => "Oluyole Microfinance Bank",
        "090461" => "Uniibadan Microfinance Bank",
        "090462" => "Monarch Microfinance Bank",
        "090463" => "Rehoboth Microfinance Bank",
        "090464" => "UNIMAID MICROFINANCE BANK",
        "090465" => "Maintrust Microfinance Bank",
        "090466" => "YCT MICROFINANCE BANK",
        "090467" => "Good Neighbours Microfinance Bank",
        "090468" => "Olofin Owena Microfinance Bank",
        "090469" => "Aniocha Microfinance Bank",
        "090446" => "SUPPORT MICROFINANCE BANK",
        "000028" => "CBN",
        "090482" => "FEDETH MICROFINANCE BANK",
        "090470" => "DOT MICROFINANCE BANK",
        "090504" => "ZIKORA MICROFINANCE BANK",
        "090506" => "SOLID ALLIANZE MICROFINANCE BANK",
        "000031" => "PREMIUM TRUST BANK",
        "SMARTCASH PAYMENT SERVICE BANK",
        "090405" => "MONIEPOINT MICROFINANCE BANK",
        "070024" => "HOMEBASE MORTGAGE BANK",
        "MOMO PAYMENT SERVICE BANK ",
        "090490" => "Chukwunenye Microfinance Bank",
        "090491" => "Nsuk Microfinance Bank",
        "090492" => "Oraukwu Microfinance Bank",
        "090493" => "Iperu Microfinance Bank",
        "090494" => "Boji Boji Microfinance Bank",
        "090495" => "GOODNEWS MICROFINANCE BANK",
        "090496" => "Radalpha Microfinance Bank",
        "090497" => "Palmcoast Microfinance Bank",
        "090498" => "Catland Microfinance Bank",
        "090499" => "Pristine Divitis Microfinance Bank",
        "050002" => "FEWCHORE FINANCE COMPANY LIMITED",
        "070006" => "COVENANT MICROFINANCE BANK",
        "090500" => "Gwong Microfinance Bank",
        "090501" => "Boromu Microfinance Bank",
        "090502" => "Shalom Microfinance Bank",
        "090503" => "Projects Microfinance Bank",
        "090505" => "Nigeria Prisons Microfinance Bank",
        "090507" => "Fims Microfinance Bank",
        "090508" => "Borno Renaissance Microfinance Bank",
        "090509" => "Capitalmetriq Swift Microfinance Bank",
        "090510" => "Umunnachi Microfinance Bank",
        "090511" => "Cloverleaf Microfinance Bank",
        "090512" => "Bubayero Microfinance Bank",
        "090513" => "Seap Microfinance Bank",
        "090514" => "Umuchinemere Procredit Microfinance Bank",
        "090515" => "Rima Growth Pathway Microfinance Bank ",
        "090516" => "Numo Microfinance Bank",
        "090517" => "Uhuru Microfinance Bank",
        "090518" => "Afemai Microfinance Bank",
        "090519" => "Ibom Fadama Microfinance Bank",
        "090520" => "IC Globalmicrofinance Bank",
        "090521" => "Foresight Microfinance Bank",
        "090523" => "Chase Microfinance Bank",
        "090524" => "Solidrock Microfinance Bank",
        "090525" => "Triple A Microfinance Bank",
        "090526" => "Crescent Microfinance Bank",
        "090527" => "Ojokoro Microfinance Bank",
        "090528" => "Mgbidi Microfinance Bank",
        "090529" => "Bankly Microfinance Bank",
        "090530" => "Confidence Microfinance Bank Ltd",
        "090531" => "Aku Microfinance Bank",
        "090532" => "Ibolo Micorfinance Bank Ltd",
        "090534" => "PolyIbadan Microfinance Bank",
        "090535" => "Nkpolu-Ust Microfinance",
        "090536" => "Ikoyi-Osun Microfinance Bank",
        "090537" => "Lobrem Microfinance Bank",
        "090538" => "Blue Investments Microfinance Bank",
        "090539" => "Enrich Microfinance Bank",
        "090540" => "Aztec Microfinance Bank",
        "090541" => "Excellent Microfinance Bank",
        "090542" => "Otuo Microfinance Bank Ltd",
        "090543" => "Iwoama Microfinance Bank",
        "090544" => "Aspire Microfinance Bank Ltd",
        "090545" => "Abulesoro Microfinance Bank Ltd",
        "090546" => "Ijebu-Ife Microfinance Bank Ltd",
        "090547" => "Rockshield Microfinance Bank",
        "090548" => "Ally Microfinance Bank",
        "090549" => "Kc Microfinance Bank",
        "090550" => "Green Energy Microfinance Bank Ltd",
        "090551" => "Fairmoney Microfinance Bank Ltd",
        "090552" => "Ekimogun Microfinance Bank",
        "090553" => "Consistent Trust Microfinance Bank Ltd",
        "090554" => "Kayvee Microfinance Bank",
        "090555" => "Bishopgate Microfinance Bank",
        "090556" => "Egwafin Microfinance Bank Ltd",
        "090557" => "Lifegate Microfinance Bank Ltd",
        "090558" => "Shongom Microfinance Bank Ltd",
        "090559" => "Shield Microfinance Bank Ltd",
        "090560" => "TANADI MFB (CRUST)",
        "090561" => "Akuchukwu Microfinance Bank Ltd",
        "090562" => "Cedar Microfinance Bank Ltd",
        "090563" => "Balera Microfinance Bank Ltd",
        "090564" => "Supreme Microfinance Bank Ltd",
        "090565" => "Oke-Aro Oredegbe Microfinance Bank Ltd",
        "090566" => "Okuku Microfinance Bank Ltd",
        "090567" => "Orokam Microfinance Bank Ltd",
        "090568" => "Broadview Microfinance Bank Ltd",
        "090569" => "Qube Microfinance Bank Ltd",
        "090570" => "Iyamoye Microfinance Bank Ltd",
        "090571" => "Ilaro Poly Microfinance Bank Ltd",
        "090572" => "Ewt Microfinance Bank",
        "090573" => "Snow Microfinance Bank",
        "090574" => "GOLDMAN MICROFINANCE BANK",
        "090575" => "Firstmidas Microfinance Bank Ltd",
        "090576" => "Octopus Microfinance Bank Ltd",
        "090578" => "Iwade Microfinance Bank Ltd",
        "090579" => "Gbede Microfinance Bank",
        "090580" => "Otech Microfinance Bank Ltd",
        "090581" => "BANC CORP MICROFINANCE BANK",
        "090583" => "STATESIDE MFB",
        "090584" => "Island MFB",
        "090586" => "GOMBE MICROFINANCE BANK LTD",
        "090587" => "Microbiz Microfinance Bank",
        "090588" => "Orisun MFB",
        "090589" => "Mercury MFB",
        "090590" => "WAYA MICROFINANCE BANK LTD",
        "090591" => "Gabsyn Microfinance Bank",
        "090592" => "KANO POLY MFB",
        "090593" => "TASUED MICROFINANCE BANK LTD",
        "090598" => "IBA MFB ",
        "090599" => "Greenacres MFB",
        "090600" => "AVE MARIA MICROFINANCE BANK LTD",
        "090602" => "KENECHUKWU MICROFINANCE BANK",
        "090603" => "Macrod MFB",
        "090606" => "KKU Microfinance Bank",
        "090608" => "Akpo Microfinance Bank",
        "090609" => "Ummah Microfinance Bank ",
        "090610" => "AMOYE MICROFINANCE BANK",
        "090611" => "Creditville Microfinance Bank",
        "090612" => "Medef Microfinance Bank",
        "090613" => "Total Trust Microfinance Bank",
        "090614" => "AELLA MFB",
        "090615" => "Beststar Microfinance Bank",
        "090616" => "RAYYAN Microfinance Bank",
        "090620" => "Iyin Ekiti MFB",
        "090621" => "GIDAUNIYAR ALHERI MICROFINANCE BANK",
        "090623" => "Mab Allianz MFB",
        "090649" => "CASHRITE MICROFINANCE BANK",
        "090657" => "PYRAMID MICROFINANCE BANK",
        "090659" => "MICHAEL OKPARA UNIAGRIC MICROFINANCE BANK",
        "090424" => "ABUCOOP MICROFINANCE BANK",
        "070025" => "AKWA SAVINGS & LOANS LIMITED",
        "000037" => "ALTERNATIVE BANK LIMITED",
        "090307" => "ARAMOKO MICROFINANCE BANK",
        "090181" => "BALOGUN FULANI MICROFINANCE BANK",
        "090425" => "BANEX MICROFINANCE BANK",
        "090413" => "BENYSTA MICROFINANCE BANK",
        "090431" => "BLUEWHALES MICROFINANCE BANK",
        "090444" => "BOI MF BANK",
        "090319" => "BONGHE MICROFINANCE BANK",
        "050006" => "BRANCH INTERNATIONAL FINANCIAL SERVICES",
        "090415" => "CALABAR MICROFINANCE BANK",
        "090445" => "CAPSTONE MF BANK",
        "CBN_TSA",
        "090397" => "CHANELLE BANK",
        "090440" => "CHERISH MICROFINANCE BANK",
        "090416" => "CHIBUEZE MICROFINANCE BANK",
        "090343" => "CITIZEN TRUST MICROFINANCE BANK LTD",
        "090254" => "COALCAMP MICROFINANCE BANK",
        "050001" => "COUNTY FINANCE LTD",
        "090429" => "CROSSRIVER MICROFINANCE BANK",
        "090414" => "CRUTECH MICROFINANCE BANK",
        "070023" => "DELTA TRUST MORTGAGE BANK",
        "050013" => "DIGNITY FINANCE",
        "090427" => "EBSU MICROFINANCE BANK",
        "000033" => "ENAIRA",
        "050012" => "ENCO FINANCE",
        "090330" => "FAME MICROFINANCE BANK",
        "050009" => "FAST CREDIT",
        "090409" => "FCMB MICROFINANCE BANK",
        "070026" => "FHA MORTGAGE BANK LTD",
        "090163" => "FIRST MULTIPLE MICROFINANCE BANK",
        "050010" => "FUNDQUEST FINANCIAL SERVICES LTD",
        "090438" => "FUTMINNA MICROFINANCE BANK",
        "090411" => "GIGINYA MICROFINANCE BANK",
        "090441" => "GIWA MICROFINANCE BANK",
        "090335" => "GRANT MF BANK",
        "090291" => "HALACREDIT MICROFINANCE BANK",
        "090418" => "HIGHLAND MICROFINANCE BANK",
        "050005" => "AAA FINANCE",
        "090439" => "IBETO MICROFINANCE BANK",
        "090350" => "ILLORIN MICROFINANCE BANK",
        "090430" => "ILORA MICROFINANCE BANK",
        "090417" => "IMOWO MICROFINANCE BANK",
        "090434" => "INSIGHT MICROFINANCE BANK",
        "090428" => "ISHIE MICROFINANCE BANK",
        "090353" => "ISUOFIA MICROFINANCE BANK",
        "090211" => "ITEX INTEGRATED SERVICES LIMITED",
        "090337" => "IYERU OKIN MICROFINANCE BANK LTD",
        "090421" => "IZON MICROFINANCE BANK",
        "090352" => "JESSEFIELD MICROFINANCE BANK",
        "090422" => "LANDGOLD MICROFINANCE BANK",
        "090420" => "LETSHEGO MFB",
        "090603 " => "MACROD MFB",
        "090423" => "MAUTECH MICROFINANCE BANK",
        "090432" => "MEMPHIS MICROFINANCE BANK",
        "090275" => "MERIDIAN MICROFINANCE BANK",
        "090349" => "NASARAWA MICROFINANCE BANK",
        "050004" => "NEWEDGE FINANCE LTD",
        "090676" => "NUGGETS MFB",
        "090437" => "OAKLAND MICROFINANCE BANK",
        "090345" => "OAU MICROFINANCE BANK LTD",
        "090390" => "PARKWAY MF BANK",
        "090004" => "PARRALEX MICROFINANCE BANK",
        "090379" => "PENIEL MICORFINANCE BANK LTD",
        "090412" => "PREEMINENT MICROFINANCE BANK",
        "090170" => "RAHAMA MICROFINANCE BANK",
        "090443" => "RIMA MICROFINANCE BANK",
        "050003" => "SAGEGREY FINANCE LIMITED",
        "050008" => "SIMPLE FINANCE LIMITED",
        "090182" => "STANDARD MICROFINANCE BANK",
        "KEGOW",
        "XPRESS WALLET",
        "070022" => "STB MORTGAGE BANK",
        "090340" => "STOCKCORP MICROFINANCE BANK",
        "090302" => "SUNBEAM MICROFINANCE BANK",
        "080002" => "TAJWALLET",
        "050007" => "TEKLA FINANCE LTD",
        "050014" => "TRINITY FINANCIAL SERVICES LIMITED",
        "090403" => "UDA MICROFINANCE BANK",
        "090341" => "UNILORIN MICROFINANCE BANK",
        "090338" => "UNIUYO MICROFINANCE BANK",
        "050020" => "VALE FINANCE LIMITED",
        "090419" => "WINVIEW BANK",
        "090631" => "WRA MICROFINANCE BANK",
        "090672" => "BELLABANK MICROFINANCE BANK",
        "090201" => "XPRESS PAYMENTS",
        "MONEY MASTER PSB",
        "090703" => "Bokkos MFB"
    ];


}
