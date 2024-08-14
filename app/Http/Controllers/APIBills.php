<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\APITransaction;

class APIBills extends Controller
{
    //
    public $mode = false;

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
    public function MerchantBalance()
    {
        // return $this->getChecksumMertDetail();

        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');

        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->getChecksumMertDetail(),
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/mdetails", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }
    public function getCSBal()
    {
        // return $this->getChecksumMertDetail();

        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');

        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->getChecksumMertDetail(),
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/mdetails", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function getuserdetailsUsername($username)
    {
    }

    public function GetAirtimeVend()
    {


        

        $validate = Validator::make(request()->all(), [
            'phone' => 'required',
        ]);


        if ($validate->fails()) {
            return laraResponse(
                'Phone number required',
                $validate->messages()
            )->error();
        }

        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:4',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);

        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin', 'The provided pin does not match our records.'
                );
            }
        });

        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }



        $code = [
            'airtel' => 'A01E',
            '9mobile' => 'A02E',
            'globacom' => 'A03E',
            'mtn' => 'A04E',
        ];
        if (!key_exists(trim(strtolower(request()->type)), $code)) {
            return laraResponse('invalid_network_provider', [
                'msg' => 'Invalid network provider',
            ])->error();
        }

        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');

        // reference
        $id =
            'airtime_' .
            auth()->user()->id .
            '_' .
            date('dmY') .
            \Str::random(4);

        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'requestId' => $id,
            'serviceId' => $code[request()->type],
            'amount' => $this->filteramount(request()->amount),
            'recipient' => request()->phone,
            'date' => date('Y-m-d H:i:s'),
            'checksum' => $this->getChecksumAirtimeData(
                $code[request()->type],
                request()->phone,
                $this->filteramount(request()->amount),
                $id
            ),
        ];

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        // $user = User::find(auth()->user()->id);
        if (
            floatval($user->wallet_ngn) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        // return 0;
        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/mvend", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();
            if (!isset($responseData['statusCode']) || (isset($responseData['statusCode']) && $responseData['statusCode'] != '00')) {
                return lararesponse('error', $responseData)->error();
            }

            $current_balance = floatval(auth()->user()->wallet_ngn) - $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([ 'wallet_ngn' => $current_balance, ]);

            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => 'airtime',
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->phone,
                //  'beneficiary_name', 'beneficiary_bank', 'from_name', 'from_no'
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your  airtime  purchase  for   ' .
                    request()->phone .
                    ' was successful.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }
    // baseUrl/api/v1/mdetails
    public function getChecksumAirtimeData($id, $phone, $amount, $ref)
    {
        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $Id = $ref;

        $serviceId = $id;

        $Amount = $amount;

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');

        $recipient = $phone;

        $concatString =
            $loginId .
            '|' .
            $Id .
            '|' .
            $serviceId .
            '|' .
            $Amount .
            '|' .
            $privateKey .
            '|' .
            $recipient;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }
    public function getChecksumMertDetail()
    {
        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');

        $concatString = $loginId . '|' . $privateKey;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }

    public function sendFunds()
    {
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:4',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }
        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        // return request()->all();
        $userto = User::where('username', request()->username)->first();
        // return $user;
        $user_balance = round(
            floatval(auth()->user()->wallet_ngn) -
                floatval($this->filteramount(request()->amount)),
            2
        );
        User::where('id', auth()->user()->id)->update([
            'wallet_ngn' => $user_balance,
        ]);
        // $new_user = User::find(request()->id);
        $user_to_balance = round(
            floatval($userto->wallet_ngn) +
                floatval($this->filteramount(request()->amount)),
            2
        );
        // User::where('id', $userto->id)->update([
        //     'wallet_ngn' => $user_to_balance
        // ]);
        $responseData = [
            'sender' => auth()->user()->id,
            'reciever' => $userto->id,
            'amount' => $this->filteramount(request()->amount),
            'description' => request()->description,
        ];
        $trans_ref1 =
            '#trans_gift' .
            auth()->user()->id .
            strtotime(date('d-m-Y')) .
            \Str::random(14);
        $trans_ref2 =
            '#trans_gift' .
            $userto->id .
            strtotime(date('d-m-Y')) .
            \Str::random(14);
        $TRANS = APITransaction::create([
            'trans_id' => $trans_ref1,
            'trans_type' => 'debit',
            'trans_name' => 'transfer',
            'api_source' => 'semibill',
            'user_id' => auth()->user()->id,
            'current_balance' => $user_balance,
            'amount' => $this->filteramount(request()->amount),
            'data_json' => $responseData,
            'beneficiary_no' => '@' . request()->username,
            'beneficiary_name' => $userto->name,
            //  'beneficiary_bank',
            'from_name' => auth()->user()->name,
            'from_no' => auth()->user()->acct_no,
            // 'status',
        ]);
        $TRANS2 = APITransaction::create([
            'trans_id' => $trans_ref2,
            'trans_type' => 'credit',
            'trans_name' => 'transfer',
            'api_source' => 'semibill',
            'user_id' => $userto->id,
            'current_balance' => $user_to_balance,
            'amount' => $this->filteramount(request()->amount),
            'data_json' => $responseData,
            // 'status',
            'beneficiary_no' => '@' . request()->username,
            'beneficiary_name' => $userto->name,
            //  'beneficiary_bank',
            'from_name' => '@' . auth()->user()->username,
            'from_no' => auth()->user()->acct_no,
        ]);

        $this->notify(
            $TRANS->trans_id,
            auth()->user(),
            $TRANS,
            'Your account has been debited with NGN' .
                request()->amount .
                '.Funds Transfer to ' .
                $userto->username
        );

        $this->notify(
            $TRANS2->trans_id,
            $userto,
            $TRANS2,
            'Your account has been credited with NGN' .
                request()->amount .
                '.From  ' .
                auth()->user()->username .
                '.Desc:' .
                request()->description
        );

        $this->chargesSafe(
            auth()->user(),
            $this->filteramount(request()->amount),
            $TRANS->trans_id,
            $userto
        );

        // return laraResponse('success', [
        //     'msg' => 'success',
        //     // 'user' => $new_user,
        //     'user_from'=>$TRANS,
        //     'user_to'=>$TRANS2
        // ])->success();
        return laraResponse('success', $responseData)->success();
    }

    // DATA VENDD
    public function getDataPlans($type)
    {
        // Airtel	D01D
        // 9 Mobile	D02D
        // Globacom	D03D
        // Mtn	D04D
        // Smile	D05D
        // NTEL	D06D
        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:4',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }
        $code = [
            'airtel' => 'D01D',
            '9mobile' => 'D02D',
            'globacom' => 'D03D',
            'mtn' => 'D04D',
            'smile' => 'D05D',
            'ntel' => 'D06D',
        ];
        if (!key_exists(trim(strtolower($type)), $code)) {
            return laraResponse('invalid_network_provider', [
                'msg' => 'Invalid network provider',
            ])->error();
        }

        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),

            'serviceId' => $code[$type],
        ];

        \Log::debug($code[$type]);
        // baseUrl/api/v1/mdataplans
        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/mdataplans", $data, [
            'Content-Type' => 'application/json',
        ]);
        // return $response;
        // \Log::debug($response);
        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }

            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function buyData()
    {
        
        $validate = Validator::make(request()->all(), [
            'phone' => 'required',
        ]);

        if ($validate->fails()) {
            return laraResponse(
                'Phone number required',
                $validate->messages()
            )->error();
        }

        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }

        

        $user = User::find(auth()->user()->id);
        if (
            floatval($user->wallet_ngn) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        $code = [
            'airtel' => 'D01D',
            '9mobile' => 'D02D',
            'globacom' => 'D03D',
            'mtn' => 'D04D',
            'smile' => 'D05D',
            'ntel' => 'D06D',
        ];
        if (!key_exists(trim(strtolower(request()->type)), $code)) {
            return laraResponse('invalid_network_provider', [
                'msg' => 'Invalid network provider',
            ])->error();
        }

        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');

        // reference
        $id =
            'data_' . auth()->user()->id . '_' . date('dmY') . \Str::random(4);

        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'requestId' => $id,
            'serviceId' => $code[request()->type],
            'amount' => $this->filteramount(request()->amount),
            'recipient' => request()->phone,
            'productId' => request()->plan,
            'date' => date('Y-m-d H:i:s'),
            'checksum' => $this->getChecksumAirtimeData(
                $code[request()->type],
                request()->phone,
                $this->filteramount(request()->amount),
                $id
            ),
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/dvend", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();
            \Log::debug($responseData);
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => 'data',
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->phone,
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your mobile data subcription for ' .
                    request()->phone .
                    ' was successful.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );

            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function listBetting()
    {
        // {{baseUrl}}betting/providers?loginId={{loginId}}&key={{publicKey}}
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
        ];

        $response = Http::get("$baseUrl/betting/providers", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function validateBettingAcct()
    {
        // {{baseUrl}}betting/validate

        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),

            'customerId' => request()->id,
            'provider' => request()->provider,
        ];
        if (strtolower(request()->provider) == 'sportybet') {
            $respons = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GIFT_BILLS_API_KEY'),
                'MerchantId' => env('GIFT_BILL_MERCHANT_ID'),
                'Content-Type' => 'application/json',
            ])->post(env('GIFT_BILLS_URL') . '/betting/validate', [
                'provider' => 'SPORTYBET',
                'customerId' => request()->id,
            ]);
            if ($respons->successful()) {
                $responseData = $respons->json();
                return laraResponse('success', $responseData)->success();
            }
        } else {
            // Make the POST request with application/json content type
            $response = Http::post("$baseUrl/betting/validate", $data, [
                'Content-Type' => 'application/json',
            ]);

            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                // Access the response body as an array or JSON object

                $responseData = $response->json();
                // return $responseData;
                if (
                    !isset($responseData['statusCode']) ||
                    (isset($responseData['statusCode']) &&
                        $responseData['statusCode'] != '00')
                ) {
                    return lararesponse('error', $responseData)->error();
                }

                // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
                //    'data_json', 'status'
                return laraResponse('success', $responseData)->success();
            } else {
                // Handle the error
                $errorData = $response->json();
                return lararesponse('error', $errorData)->error();
            }
        }
    }

    public function bettingFund()
    {
        // "serviceId" : "B01T",
        // "customerId":"34382",
        // "amount": 200,
        // "name" : "OLUFEMI ISAAC BABATUNDE",
        // "provider" : "BangBet"
        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:6',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric|max:4',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'betting_' .
            auth()->user()->id .
            '_' .
            date('dmY') .
            \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'requestId' => $id,
            'serviceId' => request()->serviceId,
            'customerId' => request()->customerId,
            'amount' => $this->filteramount(request()->amount),
            'name' => request()->name,
            'provider' => request()->provider,
        ];

        // https://www.nellobytesystems.com/APIBettingV1.aspUserID=CK123&APIKey=456&BettingCompany=sportybet&CustomerID=57025731&Amount=1000&CallBackURL=http://www.your-website.com
        if (strtolower(request()->provider) == 'sportybet') {
            $jsonData = [
                'amount' => $this->filteramount(request()->amount),
                'customerId' => request()->customerId,
                'provider' => 'SPORTYBET',

                'reference' => $id,
            ];
            $respons = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('GIFT_BILLS_API_KEY'),
                'MerchantId' => env('GIFT_BILL_MERCHANT_ID'),
                'Encryption' => hash_hmac(
                    'sha512',
                    json_encode($jsonData),
                    env('GIFT_BILLS_ENCRYPTED_KEY')
                ),
                'Content-Type' => 'application/json',
            ])->post(env('GIFT_BILLS_URL') . '/betting/topup', $jsonData);

            // Get the response body
            // $responseData = $response->body();

            // Handle the response as needed
            // return $respons;
            if ($respons->successful()) {
                $responseData = $respons->json();
                // return $responseData;
                if ($responseData['success']) {
                    $current_balance =
                        floatval(auth()->user()->wallet_ngn) -
                        $this->filteramount(request()->amount);
                    User::where('id', auth()->user()->id)->update([
                        'wallet_ngn' => $current_balance,
                    ]);
                    $TRANS = APITransaction::create([
                        'trans_id' => $id,
                        'trans_type' => 'debit',
                        'trans_name' => 'betting',
                        'api_source' => 'giftbills',
                        'user_id' => auth()->user()->id,
                        'current_balance' => $current_balance,
                        'amount' => $this->filteramount(request()->amount),
                        'data_json' => $responseData,
                        // 'status',
                        'beneficiary_no' => request()->customerId,
                    ]);
                    $this->notify(
                        $TRANS->trans_id,
                        auth()->user(),
                        $TRANS,
                        'Your sport bet funding for ' .
                            request()->customerId .
                            ' was successful.'
                    );
                    $this->chargesSafe(
                        auth()->user(),
                        $this->filteramount(request()->amount),
                        $TRANS->trans_id
                    );
                    return laraResponse('success', $responseData)->success();
                }
                // {"orderid":"789","statuscode":"100","status":"ORDER_RECEIVED","meterno":"1234567890","metertoken":"000123"}
            } else {
                // Handle the error
                $errorData = $respons->json();
                return lararesponse('error', $errorData)->error();
            }
        } else {
            // Make the POST request with application/json content type
            $response = Http::post("$baseUrl/betting/pay", $data, [
                'Content-Type' => 'application/json',
            ]);
            // Amount validation
            $validate = Validator::make(request()->all(), [
                'amount' => 'required|numeric|min:4',
            ]);
            if ($validate->fails()) {
                return laraResponse(
                    'Amount Field required',
                    $validate->messages()
                )->error();
            }
            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                // Access the response body as an array or JSON object

                $responseData = $response->json();
                // return $responseData;
                if (
                    !isset($responseData['statusCode']) ||
                    (isset($responseData['statusCode']) &&
                        $responseData['statusCode'] != '00')
                ) {
                    return lararesponse('error', $responseData)->error();
                }
                $current_balance =
                    floatval(auth()->user()->wallet_ngn) -
                    $this->filteramount(request()->amount);
                User::where('id', auth()->user()->id)->update([
                    'wallet_ngn' => $current_balance,
                ]);
                $TRANS = APITransaction::create([
                    'trans_id' => $id,
                    'trans_type' => 'debit',
                    'trans_name' => 'betting',
                    'api_source' => 'credit-switch',
                    'user_id' => auth()->user()->id,
                    'current_balance' => $current_balance,
                    'amount' => $this->filteramount(request()->amount),
                    'data_json' => $responseData,
                    // 'status',
                    'beneficiary_no' => request()->customerId,
                    // 'beneficiary_name'=>$userto->name,
                    //  'beneficiary_bank',
                    //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
                ]);
                $this->notify(
                    $TRANS->trans_id,
                    auth()->user(),
                    $TRANS,
                    'Your sport bet funding for ' .
                        request()->customerId .
                        ' was successful.'
                );
                $this->chargesSafe(
                    auth()->user(),
                    $this->filteramount(request()->amount),
                    $TRANS->trans_id
                );
                // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
                //    'data_json', 'status'
                return laraResponse('success', $responseData)->success();
            } else {
                // Handle the error
                $errorData = $response->json();
                return lararesponse('error', $errorData)->error();
            }
        }
    }

    public function getShowmaxPackages()
    {
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
        ];
        // baseUrl/api/v1/mdataplans
        // Make the POST request with application/json content type
        $response = Http::get("$baseUrl/showmax/packages", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function fetchBalance1()
    {
        //
        //         $response = \Http::withHeaders([
        //             'ClientID' => env('SAFEHAVEN_AUTH_ID'),
        //             'Accept' => 'application/json',
        //             'Authorization' => 'Bearer ' . $this->authGenerate(),
        //             'content-type' => 'application/json',
        //         ])->get(env('SAFEHAVEN_URL') . '/accounts'.'?page=0&limit=600&isSubAccount=true');//.auth()->user()->sub_acct_id

        //   // Optionally, you can handle the response here
        //   // e.g., checking the status code or processing the data
        //   if ($response->successful()) {
        //     $data = $response->json();

        //   foreach($data['data'] as $k=>$v){
        //     if($v['accountNumber']=='8029581674'){

        //         User::where('acct_no',$v['accountNumber'])->update(['wallet_ngn'=>$v['accountBalance']]);
        //     }else{
        //           User::where('acct_no',$v['accountNumber'])->update(['sub_acct_id'=>$v['_id']]);
        //     }

        //   }
        //   // auth()

        //   return ['statuscode'=>'500','balance'=>'00'];
        //     // Do something with the data
        //   } else {
        //     // Handle the error
        //     return ['statuscode'=>'500','balance'=>'0'];
        //   }
    }

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
        ])->get(
            env('SAFEHAVEN_URL') .
                '/accounts' .
                '/' .
                auth()->user()->sub_acct_id
        ); //.auth()->user()->sub_acct_id

        $balance_error = 0;

        // Optionally, you can handle the response here
        // e.g., checking the status code or processing the data
        if ($response->successful()) {
            $data = $response->json();

            // foreach($data['data'] as $k=>$v){
            //     User::where('verification_number',$v['bvn'])->update(['sub_acct_id'=>$v['subAccountDetails']['_id']]);
            // }
            // auth()
            if (
                isset($data['data']) &&
                isset($data['data']['accountBalance'])
            ) {
                if (
                    floatval($data['data']['accountBalance']) <= 0 &&
                    auth()->user()->wallet_ngn <= 0
                ) {
                    $balance_error = 0;
                }else{
                    $balance_error = 1;
                }
                User::where('id', auth()->user()->id)->update([
                    'wallet_ngn' => isset($data['data'])
                        ? $data['data']['accountBalance']
                        : auth()->user()->wallet_ngn,
                ]);
                return [
                    'statuscode' => $data['statusCode'],
                    'balance' => isset($data['data'])
                        ? $data['data']['accountBalance']
                        : '',
                    'balance_error' => $balance_error,
                ];
            }
            return [
                'statuscode' => '500',
                'balance' => '0',
                'balance_error' => $balance_error,
            ];
            // Do something with the data
        } else {
            // Handle the error
            return [
                'statuscode' => '500',
                'balance' => '0',
                'balance_error' => $balance_error,
            ];
        }
    }

    public function rechargeshowmax()
    {
        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:6',
        ]);

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        // $user = User::find(auth()->user()->id);
        if (
            floatval($user->wallet_ngn) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'showmax_' .
            auth()->user()->id .
            '_' .
            date('dmY') .
            \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        // "serviceId" : "SOMX",
        // "customerNo":"09058639550",
        // "amount": 100,
        // "requestId" : "{{random12digit}}",
        // "subscriptionType" : "mobile_only",
        // "invoicePeriod" : "1",
        // "packageName" : "Showmax Mobile"
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'requestId' => $id,
            'serviceId' => 'SOMX',
            'customerNo' => request()->customerNo,
            'amount' => $this->filteramount(request()->amount),
            'packageName' => request()->packageName,
            'invoicePeriod' => request()->invoicePeriod,
            'subscriptionType' => request()->subscriptionType,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/showmax/pay", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => 'showmax',
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->customerNo,
                // 'beneficiary_name'=>$userto->name,
                //  'beneficiary_bank',
                //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your Cable TV (Show-max) Subcription for ' .
                    request()->customerNo .
                    ' was successful.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );
            // "serviceId" : "SOMX",
            // "customerNo":"09058639550",
            // "amount": 100,
            // "requestId" : "{{random12digit}}",
            // "subscriptionType" : "mobile_only",
            // "invoicePeriod" : "1",
            // "packageName" : "Showmax Mobile"
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function getStartimePackages()
    {
        // baseUrl/api/v1/startimes/fetchProductList
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
        ];
        // baseUrl/api/v1/mdataplans
        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/startimes/fetchProductList", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function startTimeChecksum($code, $amount)
    {
        // ConcatString = loginId + ”|” + privateKey + ”|” + smartCardCode + “|” + fee;
        // Checksum = Base64(Bcyrpt(ConcatString));

        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $Amount = $amount;

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');

        $concatString =
            $loginId . '|' . $privateKey . '|' . $code . '|' . $amount;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }

    public function startimeVerify()
    {
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // checksum	String	M	Checksum computed for the request. See “Security: Checksum” section for hash computation steps
        // smartCardCode	String	M	Smart card code.
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->startTimeChecksum(request()->code, ''),
            'smartCardCode' => request()->code,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/starvalidate1", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }

            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }
    public function startimeBuy()
    {
        // loginId	Numeric	M	Merchant id provided during integration
        // key	String	M	Merchants (public) key
        // checksum	String	M	Checksum computed for the request. See “Security: Checksum” section for hash computation steps
        // smartCardCode	String	M	Smart card code.
        // fee	Numeric	M	Amount to recharge smart card
        // transactionRef	Numeric	M	Unique transaction Id for the request. Maxlength (36characters)
        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:6',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }
        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'startime_' .
            auth()->user()->id .
            '_' .
            date('dmY') .
            \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body

        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->startTimeChecksum(
                request()->code,
                request()->amount
            ),
            'smartCardCode' => request()->code,

            'fee' => $this->filteramount(request()->amount),
            'transactionRef' => $id,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/starvend1", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => 'startime',
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->code,
                // 'beneficiary_name'=>$userto->name,
                //  'beneficiary_bank',
                //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your Cable TV (startime) Subcription  for ' .
                    request()->code .
                    ' was successful.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    // DSTV AND GOTV
    public function checksumDSTV_G0TV($customerNo, $ref, $amount)
    {
        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $Amount = $amount;

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');

        $concatString =
            $loginId .
            '|' .
            $privateKey .
            '|' .
            $customerNo .
            '|' .
            $ref .
            '|' .
            $amount;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }

    public function validateDSTVGoTvCard()
    {
        // {"loginId":"1234","key":"f7a2b427de…","checksum":"JDJhJDE…","customerNo":"10553886499","serviceId":"dstv"}
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // checksum	String	M	Checksum computed for the request. See “Security: Checksum” section for hash computation steps
        // smartCardCode	String	M	Smart card code.
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->checksumDSTV_G0TV(request()->code, '', ''),
            'customerNo' => request()->code,
            'serviceId' => request()->type,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/cabletv/multichoice/validate", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }

            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function listDstvGotv()
    {
        // baseUrl//api/v1/cabletv/multichoice/fetchproducts

        // baseUrl/api/v1/startimes/fetchProductList
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'serviceId' => request()->type,
        ];
        // baseUrl/api/v1/mdataplans
        // Make the POST request with application/json content type
        $response = Http::post(
            "$baseUrl/cabletv/multichoice/fetchproducts",
            $data,
            [
                'Content-Type' => 'application/json',
            ]
        );

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function dstvBuy()
    {
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:4',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'dstv_' . auth()->user()->id . '_' . date('dmY') . \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body

        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->checksumDSTV_G0TV(
                request()->code,
                $id,
                request()->amount
            ),
            'serviceId' => request()->type,
            'customerNo' => request()->code,
            'customerName' => request()->name,
            'amount' => $this->filteramount(request()->amount),
            'transactionRef' => $id,
            'productsCodes' => [],
            'invoicePeriod' => request()->invoicePeriod,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/cabletv/multichoice/vend", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => request()->type,
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->code,
                // 'beneficiary_name'=>$userto->name,
                //  'beneficiary_bank',
                //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your Cable TV (' .
                    request()->type .
                    ') Subcription  for ' .
                    request()->code .
                    ' was successful.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function fetchPins()
    {
        // baseUrl//api/v1/cabletv/multichoice/fetchproducts

        // baseUrl/api/v1/startimes/fetchProductList
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'serviceId' => request()->type,
        ];
        // baseUrl/api/v1/mdataplans
        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/get_avail_pin_packages", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function logicalPinsVend()
    {
        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'dstv_' . auth()->user()->id . '_' . date('dmY') . \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body

        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->checksum_Logicalpins(
                request()->type,
                $id,
                request()->amount
            ),
            'serviceId' => request()->type,
            'recipient' => request()->phone,

            'amount' => $this->filteramount(request()->amount),
            'requestId' => $id,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/vend_pins", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => 'logical',
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->phone,
                // 'beneficiary_name'=>$userto->name,
                //  'beneficiary_bank',
                //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your e-pin purchase for ' .
                    request()->phone .
                    ' was succesfull.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function checksum_Logicalpins($serviceId, $ref, $amount)
    {
        //         ConcatString = loginId + ”|” + serviceId + ”|” + privateKey + “|” + requestId + “|” + amount;
        // Checksum = Base64(Bcyrpt(ConcatString));

        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');

        $concatString =
            $loginId .
            '|' .
            $serviceId .
            '|' .
            $privateKey .
            '|' .
            $ref .
            '|' .
            $amount;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }
    public function checksum_Jambpins($serviceId, $ref, $amount, $phone)
    {
        //         ConcatString = loginId + ”|” + serviceId + ”|” + privateKey + “|” + requestId + “|” + amount;
        // Checksum = Base64(Bcyrpt(ConcatString));

        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');
        // loginId, serviceId, privateKey, requestId, requestAmount

        $concatString =
            $loginId .
            '|' .
            $serviceId .
            '|' .
            $privateKey .
            '|' .
            $ref .
            '|' .
            $amount;
        // '|' .
        // $phone;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }
    public function validateJamb()
    {
        // baseUrl//api/v1/cabletv/multichoice/fetchproducts

        // baseUrl/api/v1/startimes/fetchProductList
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'ConfirmCode' => request()->code,
        ];
        // baseUrl/api/v1/mdataplans
        // Make the POST request with application/json content type
        $response = Http::get("$baseUrl/verify_jamb_candidate", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object
            $responseData = $response->json();

            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
            //    'data_json', 'status'
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function vendJamb()
    {
        // "loginId": "{{loginId}}",
        // "key": "{{publicKey}}",
        // "requestId": "{{requestId}}",
        // "serviceId": "P07N",
        // "amount": 4,
        // "recipient": "08012345678",
        // "checksum": "{{checkSum}}",
        // "email": "xyz@gmail.com",
        // "confirmCode": "1375779512",
        // "productType": "jambutme"
        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:6',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }

        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }

        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'jambb_' . auth()->user()->id . '_' . date('dmY') . \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body

        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->checksum_Jambpins(
                request()->type,
                $id,
                $this->filteramount(request()->amount),
                request()->phone
            ),
            'confirmCode' => request()->code,
            'serviceId' => request()->type,
            'recipient' => request()->phone,

            'amount' => $this->filteramount(request()->amount),

            'email' => request()->email,

            'productType' => request()->productType,
            'requestId' => $id,
        ];

        // Make the POST request with application/json content type
        $response = Http::post("$baseUrl/vend_pins", $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            // return $responseData;
            if (
                !isset($responseData['statusCode']) ||
                (isset($responseData['statusCode']) &&
                    $responseData['statusCode'] != '00')
            ) {
                return lararesponse('error', $responseData)->error();
            }
            $current_balance =
                floatval(auth()->user()->wallet_ngn) -
                $this->filteramount(request()->amount);
            User::where('id', auth()->user()->id)->update([
                'wallet_ngn' => $current_balance,
            ]);
            $TRANS = APITransaction::create([
                'trans_id' => $id,
                'trans_type' => 'debit',
                'trans_name' => 'jamb',
                'api_source' => 'credit-switch',
                'user_id' => auth()->user()->id,
                'current_balance' => $current_balance,
                'amount' => $this->filteramount(request()->amount),
                'data_json' => $responseData,
                // 'status',
                'beneficiary_no' => request()->phone,
                // 'beneficiary_name'=>$userto->name,
                //  'beneficiary_bank',
                //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
            ]);
            $this->notify(
                $TRANS->trans_id,
                auth()->user(),
                $TRANS,
                'Your e-pin for ' . request()->phone . ' was succesfull.'
            );
            $this->chargesSafe(
                auth()->user(),
                $this->filteramount(request()->amount),
                $TRANS->trans_id
            );
            return laraResponse('success', $responseData)->success();
        } else {
            // Handle the error
            $errorData = $response->json();
            return lararesponse('error', $errorData)->error();
        }
    }

    public function checksum_Electricity($serviceId, $ref, $code, $amount)
    {
        //     ConcatString = loginId + ”|” + serviceId + ”|” + privateKey + ”|” + customerAccountId + ”|” + requestId + ”|” + amount;
        // Checksum = Base64(Bcyrpt(ConcatString));

        $loginId = env('CREDIT_SWITCH_LOGIN_ID');

        $privateKey = env('CREDIT_SWITCH_PRIVATE_KEY');
        // loginId, requestId, serviceId, requestAmount, privateKey and recipient
        $concatString =
            $loginId .
            '|' .
            $serviceId .
            '|' .
            $privateKey .
            '|' .
            $code .
            '|' .
            $ref .
            '|' .
            $amount;

        $checksum = base64_encode(
            password_hash($concatString, PASSWORD_DEFAULT)
        ); //PASSWORD_BCRYPT

        return $checksum;
    }

    public function validateElectricity()
    {
        $id = '';
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body
        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'serviceId' => request()->type,
            'customerAccountId' => request()->code,
            'checksum' => $this->checksum_Electricity(
                request()->type,
                $id,
                request()->code,
                ''
            ),
        ];
        if (request()->type == 'BEDC') {
            $usl =
                'https://www.nellobytesystems.com/APIVerifyElectricityV1.asp';
            $dat = [
                'UserID' => env('CLUBKONNECT_USERID'),
                'APIKey' => env('CLUBKONNECT_KEY'),
                'ElectricCompany' => '10',
                'MeterNo' => request()->code,
            ];
            // UserID=CK123&APIKey=456&ElectricCompany=01&meterno=1234567890
            $respons = Http::get($usl, $dat, [
                'Content-Type' => 'application/json',
            ]);
            $responseDat = $respons->json();
            if ($responseDat) {
                return laraResponse('success', $responseDat)->success();
            } else {
                // Handle the error
                $errorData = $respons->json();
                return lararesponse('error', $errorData)->error();
            }
        } else {
            // baseUrl/api/v1/mdataplans
            // Make the POST request with application/json content type
            $response = Http::post("$baseUrl/evalidate", $data, [
                'Content-Type' => 'application/json',
            ]);

            // CLUBKONNECT_USERID=CK101005316
            // CLUBKONNECT_KEY=N5B1AR1G6U2803QA7KTLR10I0M3D55GYY12X274435KPVGO20I99LB5P83G54BJP

            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                $id =
                    'electricity_' .
                    auth()->user()->id .
                    '_' .
                    date('dmY') .
                    \Str::random(4);
                // Access the response body as an array or JSON object
                $responseData = $response->json();

                if (
                    !isset($responseData['statusCode']) ||
                    (isset($responseData['statusCode']) &&
                        $responseData['statusCode'] != '00')
                ) {
                    return lararesponse('error', $responseData)->error();
                }
                // 'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at',
                //    'data_json', 'status'
                return laraResponse('success', $responseData)->success();
            } else {
                // Handle the error
                $errorData = $response->json();
                return lararesponse('error', $errorData)->error();
            }
        }
    }

    public function buyElectricity()
    {
        //         customerAccountId	Numeric	M	Customers unique identifier on distributors platform e.g Account Number or Meter Number
        // amount	Numeric	M	Amount to top-up customers account/meter with
        // customerName	String	M	Name of Customer
        // requestId	Numeric	M	Merchants unique id/reference for the transaction
        // customerAddress	String	M	Address of the Customer
        // key	String	M	Merchants (public) key
        // checksum	String	M	Checksum computed for the request. See “Security: Checksum” section for hash computation steps

        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:1',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }
        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }
        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $id =
            'electricity_' .
            auth()->user()->id .
            '_' .
            date('dmY') .
            \Str::random(4);
        // Define the base URL
        $baseUrl = env('CREDIT_SWITCH_BASE_URL');
        // Prepare the data to be sent in the request body

        $data = [
            'loginId' => env('CREDIT_SWITCH_LOGIN_ID'),
            'key' => env('CREDIT_SWITCH_PUBLIC_KEY'),
            'checksum' => $this->checksum_Electricity(
                request()->type,
                $id,
                request()->code,
                request()->amount
            ),
            'customerAccountId' => request()->code,
            'serviceId' => request()->type,
            'customerName' => request()->name,

            'amount' => $this->filteramount(request()->amount),

            'customerAddress' => request()->address,

            'requestId' => $id,
        ];

        if (request()->type == 'BEDC') {
            $usl = 'https://www.nellobytesystems.com/APIElectricityV1.asp';
            $dat = [
                'UserID' => env('CLUBKONNECT_USERID'),
                'APIKey' => env('CLUBKONNECT_KEY'),
                'ElectricCompany' => '10',
                'MeterNo' => request()->code,
                'Amount' => $this->filteramount(request()->amount),
                'PhoneNo' => request()->phone,
            ];
            $respons = Http::get("$usl", $dat);

            if ($respons->successful()) {
                $responseData = $respons->json();
                if ($responseData['status'] == 'ORDER_RECIEVED') {
                    $current_balance =
                        floatval(auth()->user()->wallet_ngn) -
                        $this->filteramount(request()->amount);
                    User::where('id', auth()->user()->id)->update([
                        'wallet_ngn' => $current_balance,
                    ]);
                    $TRANS = APITransaction::create([
                        'trans_id' => $id,
                        'trans_type' => 'debit',
                        'trans_name' => 'electricity',
                        'api_source' => 'clubkonnect',
                        'user_id' => auth()->user()->id,
                        'current_balance' => $current_balance,
                        'amount' => $this->filteramount(request()->amount),
                        'data_json' => $responseData,
                        // 'status',
                        'beneficiary_no' => request()->code,
                        'beneficiary_name' => request()->name,
                        //  'beneficiary_bank',
                        //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
                    ]);
                    $this->notify(
                        $TRANS->trans_id,
                        auth()->user(),
                        $TRANS,
                        'Your electricity bill for ' .
                            request()->code .
                            ' was succesfull.'
                    );
                    $this->chargesSafe(
                        auth()->user(),
                        $this->filteramount(request()->amount),
                        $TRANS->trans_id
                    );
                    return laraResponse('success', $responseData)->success();
                }
                // {"orderid":"789","statuscode":"100","status":"ORDER_RECEIVED","meterno":"1234567890","metertoken":"000123"}
            } else {
                // Handle the error
                $errorData = $respons->json();
                return lararesponse('error', $errorData)->error();
            }
        } else {
            // Make the POST request with application/json content type
            $response = Http::post("$baseUrl/evend", $data, [
                'Content-Type' => 'application/json',
            ]);

            // Check if the request was successful (status code 2xx)
            if ($response->successful()) {
                // Access the response body as an array or JSON object

                $responseData = $response->json();
                // return $responseData;090286090286
                if (
                    !isset($responseData['statusCode']) ||
                    (isset($responseData['statusCode']) &&
                        $responseData['statusCode'] != '00')
                ) {
                    return lararesponse('error', $responseData)->error();
                }
                $current_balance =
                    floatval(auth()->user()->wallet_ngn) -
                    $this->filteramount(request()->amount);
                User::where('id', auth()->user()->id)->update([
                    'wallet_ngn' => $current_balance,
                ]);
                $TRANS = APITransaction::create([
                    'trans_id' => $id,
                    'trans_type' => 'debit',
                    'trans_name' => 'electricity',
                    'api_source' => 'credit-switch',
                    'user_id' => auth()->user()->id,
                    'current_balance' => $current_balance,
                    'amount' => $this->filteramount(request()->amount),
                    'data_json' => $responseData,
                    'beneficiary_no' => request()->code,
                    'beneficiary_name' => request()->name,
                    //  'beneficiary_bank',status
                    //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
                ]);
                $this->notify(
                    $TRANS->trans_id,
                    auth()->user(),
                    $TRANS,
                    'Your electricity bill for ' .
                        request()->code .
                        ' was succesfull.'
                );
                $this->chargesSafe(
                    auth()->user(),
                    $this->filteramount(request()->amount),
                    $TRANS->trans_id
                );
                return laraResponse('success', $responseData)->success();
            } else {
                // Handle the error
                $errorData = $response->json();
                return lararesponse('error', $errorData)->error();
            }
        }
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
            'client_assertion_type' =>
                'urn:ietf:params:oauth:client-assertion-type:jwt-bearer',
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

    public function moveMoney()
    {
        // 090286
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        //
        $charges = \DB::table('charges')
            ->where('status', 0)
            ->paginate(10);
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
                    'accountNumber' => $v->credit_acct,
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
                        $re = [
                            'saveBeneficiary' => false,
                            'nameEnquiryReference' => $sessionid,
                            'debitAccountNumber' => $v->debit_acct,
                            'beneficiaryBankCode' => '090286',
                            'amount' => floatval($v->amount),
                            'beneficiaryAccountNumber' => $v->credit_acct,
                            'narration' =>
                                'Semibill credit transaction on #' . $v->trans_id,
                            'paymentReference' =>
                                '#trans_inter_bank' .
                                $v->user_id .
                                date('Ymdhis') .
                                $sessionid,
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
                                \DB::table('charges')
                                    ->where('id', $v->id)
                                    ->update(['status' => '1']);
                                // return $data;
                            }
                        }
                    }
                } else {
                }
            }
        }
    }

    public function moveMoneyUser()
    {
        // 090286
        $setting = \App\Models\Setting::where('id', '!=', '')->first();
        //
        $charges = \DB::table('charges')
            ->where('user_id', auth()->user()->id)
            ->where('status', 0)
            ->paginate(10);
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
                    'accountNumber' => $v->credit_acct,
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
                            'narration' =>
                                'Semibill credit transaction on #' . $v->trans_id,
                            'paymentReference' =>
                                '#trans_inter_bank' .
                                $v->user_id .
                                date('Ymdhis') .
                                $sessionid,
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
                                \DB::table('charges')
                                    ->where('id', $v->id)
                                    ->update(['status' => '1']);
                                // return $data;
                            }
                        }
                    }
                } else {
                }
            }
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
                'trans_id' => $trans_id,
            ]);
        } else {
            $charge = \App\Models\Admin\Charges::create([
                'debit_acct' => $user->acct_no,
                'credit_acct' => $userto->acct_no,
                'user_id' => $user->id,
                'amount' => floatval($amount),
                'status' => 0,
                'trans_id' => $trans_id,
            ]);
        }
        try {
            $this->moveMoney();
        } catch (\Exception $w) {
            \Log::debug($w);
        }

        return true;
    }

    // giftcard endpoint\

    public $gc_client_id = '';
    public $gc_client_secret = '';
    public $gc_audience = 'https://giftcards.reloadly.com';

    public function getAccessTokenGiftcard()
    {
        $curl = curl_init();
        $data = [
            'client_id' => $this->gc_client_id,
            'client_secret' => $this->gc_client_secret,
            'grant_type' => 'client_credentials',
            'audience' => $this->gc_audience,
        ];
        // Make the POST request with application/json content type
        $response = Http::post('https://auth.reloadly.com/oauth/token', $data, [
            'Content-Type' => 'application/json',
        ]);

        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON object

            $responseData = $response->json();
            return $responseData['access_token'];
        }

        return 0;
    }
    public function getGCBal()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->gc_audience . '/accounts/balance',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return 0;
        } else {
            return json_decode($response, true)['balance'];
        }
    }

    public function getCountries()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "$this->gc_audience/countries",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }
    public function giftcountryCode()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "$this->gc_audience/countries/" . request()->code,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }

    public function getGiftcardProduct()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL =>
                "$this->gc_audience/products?size=" .
                request()->size .
                '&page=' .
                request()->page .
                '&productName=' .
                request()->name .
                '&countryCode=' .
                request()->countrycode .
                '&includeRange=' .
                request()->range .
                '&includeFixed=' .
                request()->fixed .
                '',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }

    public function getGiftcardProductById()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "$this->gc_audience/products/" . request()->id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }

    public function getCreditCardByCountryCode()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL =>
                "$this->gc_audience/countries/" . request()->id . '/products',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }
    public function GiftcardRedeemInstr()
    {
        if ($this->getAccessTokenGiftcard() == 0) {
            return lararesponse('error', [
                'msg' => 'gift card token error',
            ])->error();
        }

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "$this->gc_audience/redeem-instructions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }
    public function getfxRateGiftcard()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL =>
                'https://giftcards.reloadly.com/fx-rate?currencyCode=USD&amount=' .
                $this->filteramount(request()->amount),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Accept: application/com.reloadly.giftcards-v1+json',
                'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
        } else {
            // if($this->getGCBal()==0)return lararesponse('error', ['msg'=>'empty merhcant card token error'])->error();
            return lararesponse('success', json_decode($response))->success();
        }
    }
    public function userkey()
    {
        // User::where('email','!=','')->update(['username'=>'']);
        $emails = User::pluck('email');

        foreach ($emails as $email) {
            // Extract the username part by removing anything after "@"
            $username = explode('@', $email)[0];

            // Convert the username to lowercase
            $username = strtolower($username);

            // Ensure the username is not more than 9 characters
            $username = substr($username, 0, 14);

            // Replace non-alphanumeric characters with empty strings
            $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);

            // Check if the generated username is unique
            $unique_username = $username;
            $counter = 1;
            while (User::where('username', $unique_username)->exists()) {
                $unique_username = $username . $counter++;
            }

            // Save the unique username to the Users table
            User::where('email', $email)->update([
                // 'email' => $email,
                'username' => $unique_username,
            ]);
        }
    }
    public function orderGiftCard()
    {
        // Amount validation
        $validate = Validator::make(request()->all(), [
            'amount' => 'required|numeric|min:6',
        ]);
        if ($validate->fails()) {
            return laraResponse(
                'Amount Field required',
                $validate->messages()
            )->error();
        }
        $validate = Validator::make(request()->all(), [
            'pin' => 'required|numeric',
        ]);
        $validate->after(function ($validator) {
            if (request()->pin != auth()->user()->pin) {
                $validator->errors()->add(
                    'pin',
                    'The provided pin does not match our records.'
                );
            }
        });
        if ($validate->fails()) {
            return laraResponse(
                'Incorrect transaction pin',
                $validate->messages()
            )->error();
        }
        $url = 'https://giftcards.reloadly.com/orders';
        $nb = $this->fetchBalance();
        $user = User::find(auth()->user()->id);
        if (floatval($nb['balance_error']) == 0) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }
        if ($nb['statuscode'] != 200) {
            return laraResponse('system_error', [
                'msg' => 'system error. Try again later ',
            ])->error();
        }
        if (
            floatval($nb['balance']) <
            floatval($this->filteramount(request()->amount))
        ) {
            return laraResponse('insufficient_funds', [
                'msg' => 'Insufficient Funds',
            ])->error();
        }

        $payload = [
            'productId' => request()->id,
            'quantity' => request()->qty,
            'unitPrice' => request()->unit,
            'customIdentifier' =>
                \Str::slug(auth()->user()->name, '_') .
                \Str::random(9) .
                auth()->user()->id,
            'senderName' => 'SEMIBILL TECH',
            'recipientEmail' => auth()->user()->email,
            'recipientPhoneDetails' => [
                'countryCode' => 'NG',
                'phoneNumber' => auth()->user()->phone,
            ],
            'preOrder' => false,
        ];
        // return true;
        try {
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://giftcards.reloadly.com/orders',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($payload),
                CURLOPT_HTTPHEADER => [
                    'Accept: application/com.reloadly.giftcards-v1+json',
                    'Authorization: Bearer ' . $this->getAccessTokenGiftcard(),
                    'Content-Type: application/json',
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                \Log::debug([['error' => 'Request failed', 'details' => $err]]);
                return lararesponse('error', [
                    'msg' => 'gift card connection error',
                ])->error();
            } else {
                $current_balance =
                    floatval(auth()->user()->wallet_ngn) -
                    $this->filteramount(request()->amount);

                $result = json_decode($response);
                \Log::debug([['details' => $result]]);
                $TRANS = APITransaction::create([
                    'trans_id' => 'Gitcard_' . $result->transactionId,
                    'trans_type' => 'debit',
                    'trans_name' => 'giftcard',
                    'api_source' => 'reloadly',
                    'user_id' => auth()->user()->id,
                    'current_balance' => $current_balance,
                    'amount' => $this->filteramount(request()->amount),
                    'data_json' => $result,
                    // 'status',
                    'beneficiary_no' => auth()->user()->email,
                    'beneficiary_name' => auth()->user()->name,
                    //  'beneficiary_bank',
                    //   'from_name'=>auth()->user()->name, 'from_no'=>auth()->user()->acct_no
                ]);
                User::where('id', auth()->user()->id)->update([
                    'wallet_ngn' => $current_balance,
                ]);

                $this->notify(
                    $TRANS->trans_id,
                    auth()->user(),
                    $TRANS,
                    'Your giftcard card purchase was succesfull.'
                );
                $this->chargesSafe(
                    auth()->user(),
                    $this->filteramount(request()->amount),
                    $TRANS->trans_id
                );
                return lararesponse(
                    'success',
                    json_decode($response)
                )->success();
            }
        } catch (\Exception $e) {
            \Log::debug(['error' => 'Request Error: ' . $e->getMessage()]);
            return lararesponse('error', [
                'msg' => 'gift card connection error',
            ])->error();
            // return response()->json(, 500);
        }
    }

    public function transactions()
    {
        $trans = APITransaction::latest('created_at')
            ->where('user_id', auth()->user()->id)
            ->get();

        return lararesponse('success', $trans)->success();
    }

    public function fxrate()
    {
    }

    public function flightsearch()
    {
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
            'type' => $data['data']->trans_name,
        ]);
        //    class Notification extends Model
        //    {
        //        use HasFactory;
        //    protected $fillable=['id', 'user_id', 'text', 'type', 'status', 'created_at', 'updated_at'];
        // Notification::create([
        //    'type'=>'order', 'title'=>$notification['title'], 'body'=>$notification['body'], 'status'=>'0', 'data_id'=>$orderr->order_id,  'user_id'=>$user->id
        // ]);
    }

    public $banks = [
        '',
        '000034' => 'SIGNATURE BANK',
        '000036' => 'OPTIMUS BANK',
        '000001' => 'STERLING BANK',
        '000002' => 'KEYSTONE BANK',
        '000003' => 'FIRST CITY MONUMENT BANK',
        '000004' => 'UNITED BANK FOR AFRICA',
        '000006' => 'JAIZ BANK',
        '000007' => 'FIDELITY BANK',
        '000008' => 'POLARIS BANK',
        '000009' => 'CITI BANK',
        '000010' => 'ECOBANK',
        '000011' => 'UNITY BANK',
        '000012' => 'STANBIC IBTC BANK',
        '000013' => 'GTBANK PLC',
        '000014' => 'ACCESS BANK',
        '000015' => 'ZENITH BANK',
        '000016' => 'FIRST BANK OF NIGERIA',
        '000017' => 'WEMA BANK',
        '000018' => 'UNION BANK',
        '000019' => 'ENTERPRISE BANK',
        '000021' => 'STANDARD CHARTERED BANK',
        '000022' => 'SUNTRUST BANK',
        '000023' => 'PROVIDUS BANK',
        '060001' => 'CORONATION MERCHANT BANK',
        '070001' => 'NPF MICROFINANCE BANK',
        '070002' => 'FORTIS MICROFINANCE BANK',
        '070008' => 'PAGE MFBANK',
        '090001' => 'ASO SAVINGS',
        '090003' => 'JUBILEE LIFE',
        '090006' => 'SAFETRUST',
        '090107' => 'FIRST TRUST MORTGAGE BANK PLC',
        '090108' => 'NEW PRUDENTIAL BANK',

        '090111' => 'FINATRUST MICROFINANCE BANK',
        '090112' => 'SEED CAPITAL MICROFINANCE BANK',
        '090115' => 'TCF MICROFINANCE BANK',
        '090114' => 'EMPIRE TRUST MICROFINANCE BANK',
        '090113' => 'MICROVIS MICROFINANCE BANK ',
        '090116' => 'AMML MICROFINANCE BANK ',
        '090117' => 'BOCTRUST MICROFINANCE BANK LIMITED',
        '090120' => 'WETLAND MICROFINANCE BANK',
        '090118' => 'IBILE MICROFINANCE BANK',
        '090125' => 'REGENT MICROFINANCE BANK',
        '090128' => 'NDIORAH MICROFINANCE BANK',
        '090127' => 'BC KASH MICROFINANCE BANK',
        '090121' => 'HASAL MICROFINANCE BANK',
        '060002' => 'FBNQUEST MERCHANT BANK',
        '090132' => 'RICHWAY MICROFINANCE BANK',
        '090135' => 'PERSONAL TRUST MICROFINANCE BANK',
        '090136' => 'MICROCRED MICROFINANCE BANK',
        '090122' => 'GOWANS MICROFINANCE BANK',
        '000024' => 'RAND MERCHANT BANK',
        '090142' => 'YES MICROFINANCE BANK',
        '090140' => 'SAGAMU MICROFINANCE BANK',
        '090129' => 'MONEY TRUST MICROFINANCE BANK',
        '070012' => 'LAGOS BUILDING AND INVESTMENT COMPANY',
        '070009' => 'GATEWAY MORTGAGE BANK',
        '070010' => 'ABBEY MORTGAGE BANK',
        '070014' => 'FIRST GENERATION MORTGAGE BANK',
        '070013' => 'PLATINUM MORTGAGE BANK',
        '070016' => 'INFINITY TRUST MORTGAGE BANK',
        '090119' => 'OHAFIA MICROFINANCE BANK',
        '090124' => 'XSLNCE MICROFINANCE BANK',
        '090130' => 'CONSUMER MICROFINANCE BANK',
        '090131' => 'ALLWORKERS MICROFINANCE BANK',
        '090134' => 'ACCION MICROFINANCE BANK',
        '090139' => 'VISA MICROFINANCE BANK',
        '090141' => 'CHIKUM MICROFINANCE BANK',
        '090143' => 'APEKS MICROFINANCE BANK',
        '090144' => 'CIT MICROFINANCE BANK',
        '090145' => 'FULLRANGE MICROFINANCE BANK',
        '090153' => 'FFS MICROFINANCE BANK',
        '090160' => 'ADDOSSER MICROFINANCE BANK',
        '090126' => 'FIDFUND MICROFINANCE BANK',

        '090137' => 'PECANTRUST MICROFINANCE BANK',
        '090148' => 'BOWEN MICROFINANCE BANK',
        '090158' => 'FUTO MICROFINANCE BANK',
        '070011' => 'REFUGE MORTGAGE BANK',
        '070015' => 'BRENT MORTGAGE BANK',
        '090138' => 'ROYAL EXCHANGE MICROFINANCE BANK',
        '090147' => 'HACKMAN MICROFINANCE BANK',
        '090146' => 'TRIDENT MICROFINANCE BANK',
        '090157' => 'INFINITY MICROFINANCE BANK',
        '090159' => 'CREDIT AFRIQUE MICROFINANCE BANK',
        '090156' => 'E-BARCS MICROFINANCE BANK',
        '090110' => 'VFD MFB',

        '090097' => 'EKONDO MICROFINANCE BANK',
        '090150' => 'VIRTUE MICROFINANCE BANK',
        '090149' => 'IRL MICROFINANCE BANK',

        '090151' => 'MUTUAL TRUST MICROFINANCE BANK',
        '090161' => 'OKPOGA MICROFINANCE BANK',
        '060003' => 'NOVA MERCHANT BANK',
        '090154' => 'CEMCS MICROFINANCE BANK',
        '090167' => 'DAYLIGHT MICROFINANCE BANK',
        '070017' => 'HAGGAI MORTGAGE BANK LIMITED',
        '090171' => 'MAINSTREET MICROFINANCE BANK',
        '090178' => 'GREENBANK MICROFINANCE BANK',
        '090179' => 'FAST MICROFINANCE BANK',
        '090177' => 'LAPO MICROFINANCE BANK',
        '000020' => 'HERITAGE BANK',
        '090251' => 'UNIVERSITY OF NIGERIA, NSUKKA MICROFINANCE BANK',
        '090196' => 'PENNYWISE MICROFINANCE BANK ',
        '090197' => 'ABU MICROFINANCE BANK ',
        '090194' => 'NIRSAL NATIONAL MICROFINANCE BANK',
        '090176' => 'BOSAK MICROFINANCE BANK',
        '090172' => 'ASTRAPOLARIS MICROFINANCE BANK',
        '090261' => 'QUICKFUND MICROFINANCE BANK',
        '090259' => 'ALEKUN MICROFINANCE BANK',
        '090198' => 'RENMONEY MICROFINANCE BANK ',
        '090262' => 'STELLAS MICROFINANCE BANK ',
        '090205' => 'NEW DAWN MICROFINANCE BANK',
        '090169' => 'ALPHA KAPITAL MICROFINANCE BANK ',
        '090264' => 'AUCHI MICROFINANCE BANK ',
        '090270' => 'AB MICROFINANCE BANK ',
        '090263' => 'NIGERIAN NAVY MICROFINANCE BANK ',
        '090258' => 'IMO STATE MICROFINANCE BANK',
        '090276' => 'TRUSTFUND MICROFINANCE BANK ',
        '090195' => 'GROOMING MICROFINANCE BANK',
        '090260' => 'ABOVE ONLY MICROFINANCE BANK ',
        '090272' => 'OLABISI ONABANJO UNIVERSITY MICROFINANCE ',
        '090268' => 'ADEYEMI COLLEGE STAFF MICROFINANCE BANK',
        '090280' => 'MEGAPRAISE MICROFINANCE BANK',
        '000026' => 'TAJ BANK',
        '090282' => 'ARISE MICROFINANCE BANK',
        '090274' => 'PRESTIGE MICROFINANCE BANK',
        '090278' => 'GLORY MICROFINANCE BANK',
        '090188' => 'BAINES CREDIT MICROFINANCE BANK',
        '000005' => 'ACCESS(DIAMOND) BANK',
        '090289' => 'PILLAR MICROFINANCE BANK',
        '090286' => 'SAFE HAVEN MICROFINANCE BANK',
        '090292' => 'AFEKHAFE MICROFINANCE BANK',
        '000027' => 'GLOBUS BANK',
        '090285' => 'FIRST OPTION MICROFINANCE BANK',
        '090296' => 'POLYUNWANA MICROFINANCE BANK',
        '090295' => 'OMIYE MICROFINANCE BANK',
        '090287' => 'ASSETMATRIX MICROFINANCE BANK',
        '000025' => 'TITAN TRUST BANK',
        '090271' => 'LAVENDER MICROFINANCE BANK',
        '090290' => 'FCT MICROFINANCE BANK',
        '090279' => 'IKIRE MICROFINANCE BANK',
        '090303' => 'PURPLEMONEY MICROFINANCE BANK',
        'ACCESS YELLO & BETA',
        '090123' => 'TRUSTBANC J6 MICROFINANCE BANK LIMITED',
        '090305' => 'SULSPAP MICROFINANCE BANK',
        '090166' => 'ESO-E MICROFINANCE BANK',
        '090273' => 'EMERALD MICROFINANCE BANK',
        'ACCESS MONEY',
        '090297' => 'ALERT MICROFINANCE BANK',
        '090308' => 'BRIGHTWAY MICROFINANCE BANK',
        'PALMPAY',
        '090325' => 'SPARKLE',
        '090326' => 'BALOGUN GAMBARI MICROFINANCE BANK',
        '090317' => 'PATRICKGOLD MICROFINANCE BANK',
        '070019' => 'MAYFRESH MORTGAGE BANK',
        '090327' => 'TRUST MICROFINANCE BANK',
        '090133' => 'AL-BARAKAH MICROFINANCE BANK',
        '090328' => 'EYOWO',
        '090304' => 'EVANGEL MICROFINANCE BANK ',
        '090332' => 'EVERGREEN MICROFINANCE BANK',
        '090333' => 'OCHE MICROFINANCE BANK',
        '090364' => 'NUTURE MICROFINANCE BANK',

        '090329' => 'NEPTUNE MICROFINANCE BANK',
        '090315' => 'U & C MICROFINANCE BANK',
        '090331' => 'UNAAB MICROFINANCE BANK',
        '090324' => 'IKENNE MICROFINANCE BANK',
        '090321' => 'MAYFAIR MICROFINANCE BANK',
        '090322' => 'REPHIDIM MICROFINANCE BANK',
        '090299' => 'KONTAGORA MICROFINANCE BANK',
        '090360' => 'CASHCONNECT MICROFINANCE BANK',
        '090336' => 'BIPC MICROFINANCE BANK',
        '090362' => 'MOLUSI MICROFINANCE BANK',
        '090372' => 'LEGEND MICROFINANCE BANK',
        '090369' => 'SEEDVEST MICROFINANCE BANK',
        '090294' => 'EAGLE FLIGHT MICROFINANCE BANK',
        '090373' => 'THINK FINANCE MICROFINANCE BANK',

        '090374' => 'COASTLINE MICROFINANCE BANK',
        '090281' => 'MINT-FINEX MFB',
        '090363' => 'HEADWAY MICROFINANCE BANK',
        '090377' => 'ISALEOYO MICROFINANCE BANK',
        '090378' => 'NEW GOLDEN PASTURES MICROFINANCE BANK',

        '090365' => 'CORESTEP MICROFINANCE BANK',
        '090298' => 'FEDPOLY NASARAWA MICROFINANCE BANK',
        '090366' => 'FIRMUS MICROFINANCE BANK',
        '090383' => 'MANNY MICROFINANCE BANK',
        '090391' => 'DAVODANI MICROFINANCE BANK',
        '090389' => 'EK-RELIABLE MICROFINANCE BANK',
        '090385' => 'GTI MICROFINANCE BANK',
        '090252' => 'YOBE MICROFINANCE BANK',
        '9 PAYMENT SOLUTIONS BANK',
        'OPAY',
        '090175' => 'RUBIES MICROFINANCE BANK',
        '090392' => 'MOZFIN MICROFINANCE BANK',
        '090386' => 'INTERLAND MICROFINANCE BANK',
        '090400' => 'FINCA MICROFINANCE BANK',
        'KONGAPAY',
        '090370' => 'ILISAN MICROFINANCE BANK',
        '090399' => 'NWANNEGADI MICROFINANCE BANK',
        '090186' => 'GIREI MICROFINANACE BANK',
        '090396' => 'OSCOTECH MICROFINANCE BANK',
        '090393' => 'BRIDGEWAY MICROFINANACE BANK',
        '090380' => 'KREDI MONEY MICROFINANCE BANK ',
        '090401' => 'SHERPERD TRUST MICROFINANCE BANK',
        'NOWNOW DIGITAL SYSTEMS LIMITED',
        '090394' => 'AMAC MICROFINANCE BANK',
        '070007' => 'LIVINGTRUST MORTGAGE BANK PLC',
        'M36',
        '090283' => 'NNEW WOMEN MICROFINANCE BANK ',
        '090408' => 'GMB MICROFINANCE BANK',
        '090005' => 'TRUSTBOND MORTGAGE BANK',
        '090152' => 'NAGARTA MICROFINANCE BANK',
        '090155' => 'ADVANS LA FAYETTE MICROFINANCE BANK',
        '090162' => 'STANFORD MICROFINANCE BANK',
        '090164' => 'FIRST ROYAL MICROFINANCE BANK',
        '090165' => 'PETRA MICROFINANCE BANK',
        '090168' => 'GASHUA MICROFINANCE BANK',
        '090173' => 'RELIANCE MICROFINANCE BANK',
        '090174' => 'MALACHY MICROFINANCE BANK',
        '090180' => 'AMJU UNIQUE MICROFINANCE BANK',
        '090189' => 'ESAN MICROFINANCE BANK',
        '090190' => 'MUTUAL BENEFITS MICROFINANCE BANK',
        '090191' => 'KCMB MICROFINANCE BANK',
        '090192' => 'MIDLAND MICROFINANCE BANK',
        '090193' => 'UNICAL MICROFINANCE BANK',
        '090265' => 'LOVONUS MICROFINANCE BANK',
        '090266' => 'UNIBEN MICROFINANCE BANK',
        '090269' => 'GREENVILLE MICROFINANCE BANK',
        '090277' => 'AL-HAYAT MICROFINANCE BANK',
        '090293' => 'BRETHREN MICROFINANCE BANK',
        '090310' => 'EDFIN MICROFINANCE BANK',
        '090318' => 'FEDERAL UNIVERSITY DUTSE MICROFINANCE BANK',
        '090320' => 'KADPOLY MICROFINANCE BANK',
        '090323' => 'MAINLAND MICROFINANCE BANK',
        '090376' => 'APPLE MICROFINANCE BANK',
        '090395' => 'BORGU MICROFINANCE BANK',
        '090398' => 'FEDERAL POLYTECHNIC NEKEDE MICROFINANCE BANK',
        '090404' => 'OLOWOLAGBA MICROFINANCE BANK',
        '090406' => 'BUSINESS SUPPORT MICROFINANCE BANK',
        '090202' => 'ACCELEREX NETWORK LIMITED',
        'HOPEPSB',
        '090316' => 'BAYERO UNIVERSITY MICROFINANCE BANK',
        '090410' => 'MARITIME MICROFINANCE BANK',
        '090371' => 'AGOSASA MICROFINANCE BANK',
        'ZENITH EASY WALLET',
        '070021' => 'COOP MORTGAGE BANK',
        'CARBON',
        '090435' => 'LINKS MICROFINANCE BANK',
        '090433' => 'RIGO MICROFINANCE BANK',
        '090402' => 'PEACE MICROFINANCE BANK',
        '090436' => 'SPECTRUM MICROFINANCE BANK ',
        '060004' => 'GREENWICH MERCHANT BANK',
        '000029' => 'LOTUS BANK',
        '090426' => 'TANGERINE MONEY',
        '000030' => 'PARALLEX BANK',
        '090448' => 'Moyofade MF Bank',
        '090449' => 'SLS MF Bank',
        '090450' => 'Kwasu MF Bank',
        '090451' => 'ATBU Microfinance Bank',
        '090452' => 'UNILAG Microfinance Bank',
        '090453' => 'Uzondu MF Bank',
        '090454' => 'Borstal Microfinance Bank',
        '090471' => 'Oluchukwu Microfinance Bank',
        '090472' => 'Caretaker Microfinance Bank',
        '090473' => 'Assets Microfinance Bank',
        '090474' => 'Verdant Microfinance Bank',
        '090475' => 'Giant Stride Microfinance Bank',
        '090476' => 'Anchorage Microfinance Bank',
        '090477' => 'Light Microfinance Bank',
        '090478' => 'Avuenegbe Microfinance Bank',
        '090479' => 'First Heritage Microfinance Bank',
        '090480' => 'KOLOMONI MICROFINANCE BANK',
        '090481' => 'Prisco Microfinance Bank',
        '090483' => 'Ada Microfinance Bank',
        '090484' => 'Garki Microfinance Bank',
        '090485' => 'SAFEGATE MICROFINANCE BANK',
        '090486' => 'Fortress Microfinance Bank',
        '090487' => 'Kingdom College Microfinance Bank',
        '090488' => 'Ibu-Aje Microfinance',
        '090489' => 'Alvana Microfinance Bank',
        '090455' => 'MKOBO MICROFINANCE BANK LTD',
        '090456' => 'Ospoly Microfinance Bank',
        '090459' => 'Nice Microfinance Bank',
        '090460' => 'Oluyole Microfinance Bank',
        '090461' => 'Uniibadan Microfinance Bank',
        '090462' => 'Monarch Microfinance Bank',
        '090463' => 'Rehoboth Microfinance Bank',
        '090464' => 'UNIMAID MICROFINANCE BANK',
        '090465' => 'Maintrust Microfinance Bank',
        '090466' => 'YCT MICROFINANCE BANK',
        '090467' => 'Good Neighbours Microfinance Bank',
        '090468' => 'Olofin Owena Microfinance Bank',
        '090469' => 'Aniocha Microfinance Bank',
        '090446' => 'SUPPORT MICROFINANCE BANK',
        '000028' => 'CBN',
        '090482' => 'FEDETH MICROFINANCE BANK',
        '090470' => 'DOT MICROFINANCE BANK',
        '090504' => 'ZIKORA MICROFINANCE BANK',
        '090506' => 'SOLID ALLIANZE MICROFINANCE BANK',
        '000031' => 'PREMIUM TRUST BANK',
        'SMARTCASH PAYMENT SERVICE BANK',
        '090405' => 'MONIEPOINT MICROFINANCE BANK',
        '070024' => 'HOMEBASE MORTGAGE BANK',
        'MOMO PAYMENT SERVICE BANK ',
        '090490' => 'Chukwunenye Microfinance Bank',
        '090491' => 'Nsuk Microfinance Bank',
        '090492' => 'Oraukwu Microfinance Bank',
        '090493' => 'Iperu Microfinance Bank',
        '090494' => 'Boji Boji Microfinance Bank',
        '090495' => 'GOODNEWS MICROFINANCE BANK',
        '090496' => 'Radalpha Microfinance Bank',
        '090497' => 'Palmcoast Microfinance Bank',
        '090498' => 'Catland Microfinance Bank',
        '090499' => 'Pristine Divitis Microfinance Bank',
        '050002' => 'FEWCHORE FINANCE COMPANY LIMITED',
        '070006' => 'COVENANT MICROFINANCE BANK',
        '090500' => 'Gwong Microfinance Bank',
        '090501' => 'Boromu Microfinance Bank',
        '090502' => 'Shalom Microfinance Bank',
        '090503' => 'Projects Microfinance Bank',
        '090505' => 'Nigeria Prisons Microfinance Bank',
        '090507' => 'Fims Microfinance Bank',
        '090508' => 'Borno Renaissance Microfinance Bank',
        '090509' => 'Capitalmetriq Swift Microfinance Bank',
        '090510' => 'Umunnachi Microfinance Bank',
        '090511' => 'Cloverleaf Microfinance Bank',
        '090512' => 'Bubayero Microfinance Bank',
        '090513' => 'Seap Microfinance Bank',
        '090514' => 'Umuchinemere Procredit Microfinance Bank',
        '090515' => 'Rima Growth Pathway Microfinance Bank ',
        '090516' => 'Numo Microfinance Bank',
        '090517' => 'Uhuru Microfinance Bank',
        '090518' => 'Afemai Microfinance Bank',
        '090519' => 'Ibom Fadama Microfinance Bank',
        '090520' => 'IC Globalmicrofinance Bank',
        '090521' => 'Foresight Microfinance Bank',
        '090523' => 'Chase Microfinance Bank',
        '090524' => 'Solidrock Microfinance Bank',
        '090525' => 'Triple A Microfinance Bank',
        '090526' => 'Crescent Microfinance Bank',
        '090527' => 'Ojokoro Microfinance Bank',
        '090528' => 'Mgbidi Microfinance Bank',
        '090529' => 'Bankly Microfinance Bank',
        '090530' => 'Confidence Microfinance Bank Ltd',
        '090531' => 'Aku Microfinance Bank',
        '090532' => 'Ibolo Micorfinance Bank Ltd',
        '090534' => 'PolyIbadan Microfinance Bank',
        '090535' => 'Nkpolu-Ust Microfinance',
        '090536' => 'Ikoyi-Osun Microfinance Bank',
        '090537' => 'Lobrem Microfinance Bank',
        '090538' => 'Blue Investments Microfinance Bank',
        '090539' => 'Enrich Microfinance Bank',
        '090540' => 'Aztec Microfinance Bank',
        '090541' => 'Excellent Microfinance Bank',
        '090542' => 'Otuo Microfinance Bank Ltd',
        '090543' => 'Iwoama Microfinance Bank',
        '090544' => 'Aspire Microfinance Bank Ltd',
        '090545' => 'Abulesoro Microfinance Bank Ltd',
        '090546' => 'Ijebu-Ife Microfinance Bank Ltd',
        '090547' => 'Rockshield Microfinance Bank',
        '090548' => 'Ally Microfinance Bank',
        '090549' => 'Kc Microfinance Bank',
        '090550' => 'Green Energy Microfinance Bank Ltd',
        '090551' => 'Fairmoney Microfinance Bank Ltd',
        '090552' => 'Ekimogun Microfinance Bank',
        '090553' => 'Consistent Trust Microfinance Bank Ltd',
        '090554' => 'Kayvee Microfinance Bank',
        '090555' => 'Bishopgate Microfinance Bank',
        '090556' => 'Egwafin Microfinance Bank Ltd',
        '090557' => 'Lifegate Microfinance Bank Ltd',
        '090558' => 'Shongom Microfinance Bank Ltd',
        '090559' => 'Shield Microfinance Bank Ltd',
        '090560' => 'TANADI MFB (CRUST)',
        '090561' => 'Akuchukwu Microfinance Bank Ltd',
        '090562' => 'Cedar Microfinance Bank Ltd',
        '090563' => 'Balera Microfinance Bank Ltd',
        '090564' => 'Supreme Microfinance Bank Ltd',
        '090565' => 'Oke-Aro Oredegbe Microfinance Bank Ltd',
        '090566' => 'Okuku Microfinance Bank Ltd',
        '090567' => 'Orokam Microfinance Bank Ltd',
        '090568' => 'Broadview Microfinance Bank Ltd',
        '090569' => 'Qube Microfinance Bank Ltd',
        '090570' => 'Iyamoye Microfinance Bank Ltd',
        '090571' => 'Ilaro Poly Microfinance Bank Ltd',
        '090572' => 'Ewt Microfinance Bank',
        '090573' => 'Snow Microfinance Bank',
        '090574' => 'GOLDMAN MICROFINANCE BANK',
        '090575' => 'Firstmidas Microfinance Bank Ltd',
        '090576' => 'Octopus Microfinance Bank Ltd',
        '090578' => 'Iwade Microfinance Bank Ltd',
        '090579' => 'Gbede Microfinance Bank',
        '090580' => 'Otech Microfinance Bank Ltd',
        '090581' => 'BANC CORP MICROFINANCE BANK',
        '090583' => 'STATESIDE MFB',
        '090584' => 'Island MFB',
        '090586' => 'GOMBE MICROFINANCE BANK LTD',
        '090587' => 'Microbiz Microfinance Bank',
        '090588' => 'Orisun MFB',
        '090589' => 'Mercury MFB',
        '090590' => 'WAYA MICROFINANCE BANK LTD',
        '090591' => 'Gabsyn Microfinance Bank',
        '090592' => 'KANO POLY MFB',
        '090593' => 'TASUED MICROFINANCE BANK LTD',
        '090598' => 'IBA MFB ',
        '090599' => 'Greenacres MFB',
        '090600' => 'AVE MARIA MICROFINANCE BANK LTD',
        '090602' => 'KENECHUKWU MICROFINANCE BANK',
        '090603' => 'Macrod MFB',
        '090606' => 'KKU Microfinance Bank',
        '090608' => 'Akpo Microfinance Bank',
        '090609' => 'Ummah Microfinance Bank ',
        '090610' => 'AMOYE MICROFINANCE BANK',
        '090611' => 'Creditville Microfinance Bank',
        '090612' => 'Medef Microfinance Bank',
        '090613' => 'Total Trust Microfinance Bank',
        '090614' => 'AELLA MFB',
        '090615' => 'Beststar Microfinance Bank',
        '090616' => 'RAYYAN Microfinance Bank',
        '090620' => 'Iyin Ekiti MFB',
        '090621' => 'GIDAUNIYAR ALHERI MICROFINANCE BANK',
        '090623' => 'Mab Allianz MFB',
        '090649' => 'CASHRITE MICROFINANCE BANK',
        '090657' => 'PYRAMID MICROFINANCE BANK',
        '090659' => 'MICHAEL OKPARA UNIAGRIC MICROFINANCE BANK',
        '090424' => 'ABUCOOP MICROFINANCE BANK',
        '070025' => 'AKWA SAVINGS & LOANS LIMITED',
        '000037' => 'ALTERNATIVE BANK LIMITED',
        '090307' => 'ARAMOKO MICROFINANCE BANK',
        '090181' => 'BALOGUN FULANI MICROFINANCE BANK',
        '090425' => 'BANEX MICROFINANCE BANK',
        '090413' => 'BENYSTA MICROFINANCE BANK',
        '090431' => 'BLUEWHALES MICROFINANCE BANK',
        '090444' => 'BOI MF BANK',
        '090319' => 'BONGHE MICROFINANCE BANK',
        '050006' => 'BRANCH INTERNATIONAL FINANCIAL SERVICES',
        '090415' => 'CALABAR MICROFINANCE BANK',
        '090445' => 'CAPSTONE MF BANK',
        'CBN_TSA',
        '090397' => 'CHANELLE BANK',
        '090440' => 'CHERISH MICROFINANCE BANK',
        '090416' => 'CHIBUEZE MICROFINANCE BANK',
        '090343' => 'CITIZEN TRUST MICROFINANCE BANK LTD',
        '090254' => 'COALCAMP MICROFINANCE BANK',
        '050001' => 'COUNTY FINANCE LTD',
        '090429' => 'CROSSRIVER MICROFINANCE BANK',
        '090414' => 'CRUTECH MICROFINANCE BANK',
        '070023' => 'DELTA TRUST MORTGAGE BANK',
        '050013' => 'DIGNITY FINANCE',
        '090427' => 'EBSU MICROFINANCE BANK',
        '000033' => 'ENAIRA',
        '050012' => 'ENCO FINANCE',
        '090330' => 'FAME MICROFINANCE BANK',
        '050009' => 'FAST CREDIT',
        '090409' => 'FCMB MICROFINANCE BANK',
        '070026' => 'FHA MORTGAGE BANK LTD',
        '090163' => 'FIRST MULTIPLE MICROFINANCE BANK',
        '050010' => 'FUNDQUEST FINANCIAL SERVICES LTD',
        '090438' => 'FUTMINNA MICROFINANCE BANK',
        '090411' => 'GIGINYA MICROFINANCE BANK',
        '090441' => 'GIWA MICROFINANCE BANK',
        '090335' => 'GRANT MF BANK',
        '090291' => 'HALACREDIT MICROFINANCE BANK',
        '090418' => 'HIGHLAND MICROFINANCE BANK',
        '050005' => 'AAA FINANCE',
        '090439' => 'IBETO MICROFINANCE BANK',
        '090350' => 'ILLORIN MICROFINANCE BANK',
        '090430' => 'ILORA MICROFINANCE BANK',
        '090417' => 'IMOWO MICROFINANCE BANK',
        '090434' => 'INSIGHT MICROFINANCE BANK',
        '090428' => 'ISHIE MICROFINANCE BANK',
        '090353' => 'ISUOFIA MICROFINANCE BANK',
        '090211' => 'ITEX INTEGRATED SERVICES LIMITED',
        '090337' => 'IYERU OKIN MICROFINANCE BANK LTD',
        '090421' => 'IZON MICROFINANCE BANK',
        '090352' => 'JESSEFIELD MICROFINANCE BANK',
        '090422' => 'LANDGOLD MICROFINANCE BANK',
        '090420' => 'LETSHEGO MFB',
        '090603 ' => 'MACROD MFB',
        '090423' => 'MAUTECH MICROFINANCE BANK',
        '090432' => 'MEMPHIS MICROFINANCE BANK',
        '090275' => 'MERIDIAN MICROFINANCE BANK',
        '090349' => 'NASARAWA MICROFINANCE BANK',
        '050004' => 'NEWEDGE FINANCE LTD',
        '090676' => 'NUGGETS MFB',
        '090437' => 'OAKLAND MICROFINANCE BANK',
        '090345' => 'OAU MICROFINANCE BANK LTD',
        '090390' => 'PARKWAY MF BANK',
        '090004' => 'PARRALEX MICROFINANCE BANK',
        '090379' => 'PENIEL MICORFINANCE BANK LTD',
        '090412' => 'PREEMINENT MICROFINANCE BANK',
        '090170' => 'RAHAMA MICROFINANCE BANK',
        '090443' => 'RIMA MICROFINANCE BANK',
        '050003' => 'SAGEGREY FINANCE LIMITED',
        '050008' => 'SIMPLE FINANCE LIMITED',
        '090182' => 'STANDARD MICROFINANCE BANK',
        'KEGOW',
        'XPRESS WALLET',
        '070022' => 'STB MORTGAGE BANK',
        '090340' => 'STOCKCORP MICROFINANCE BANK',
        '090302' => 'SUNBEAM MICROFINANCE BANK',
        '080002' => 'TAJWALLET',
        '050007' => 'TEKLA FINANCE LTD',
        '050014' => 'TRINITY FINANCIAL SERVICES LIMITED',
        '090403' => 'UDA MICROFINANCE BANK',
        '090341' => 'UNILORIN MICROFINANCE BANK',
        '090338' => 'UNIUYO MICROFINANCE BANK',
        '050020' => 'VALE FINANCE LIMITED',
        '090419' => 'WINVIEW BANK',
        '090631' => 'WRA MICROFINANCE BANK',
        '090672' => 'BELLABANK MICROFINANCE BANK',
        '090201' => 'XPRESS PAYMENTS',
        'MONEY MASTER PSB',
        '090703' => 'Bokkos MFB',
    ];
}
