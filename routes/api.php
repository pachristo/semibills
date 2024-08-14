<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\APIBills;
use App\Http\Controllers\APITransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::post('register', [ApiAuthController::class, 'register']);

Route::post('login', [ApiAuthController::class, 'login']);

// Route::get('user/{id}', [ApiAuthController::class, 'userById']);
// Route::get('get-user/{username}', [ApiAuthController::class, 'userByUsername']);
// 
Route::get('d-g', [APIBills::class, 'fetchBalance1']);
Route::get('d-balance/{id}', [APITransactionController::class, 'fetchBalance2']);


Route::post('wema-webhook', [APITransactionController::class, 'index']);

Route::post('wema-auth', [APITransactionController::class, 'wemaauth']);


Route::get('/load-notify', [APITransactionController::class, 'getNotify']);
// 
Route::get('get-settings', [APITransactionController::class, 'getSetting']);


Route::get('test-mozo', [APITransactionController::class, 'authGenerate']);

Route::get('create-new-wallet', [APITransactionController::class, 'createSafeHeaven']);




Route::post('forget-password-token', [ApiAuthController::class, 'resetpassword']);

// ftran
Route::post('/deposit', function () { });

Route::get('/delee', function () {
    // Endpoint URL
    // Get all user IDs from the users table
    $validUserIds = \App\Models\User::pluck('id')->toArray();

    // Delete from a_p_i_transactions where user_id does not exist in users table
    \DB::table('a_p_i_transactions')
        ->whereNotIn('user_id', $validUserIds)
        ->delete();
    //  \DB::table('a_p_i_transactions')
    //  ->whereRaw('CAST(amount AS DECIMAL(10,2)) < 0')
    //  ->delete();
    //  \DB::table('a_p_i_transactions')
    //  ->whereRaw('CAST(current_balance AS DECIMAL(10,2)) < 0')
    //  ->delete();
    \DB::table('a_p_i_transactions')
        ->where('amount', 'LIKE', '%-%')
        ->orWhere('current_balance', 'LIKE', '%-%')
        ->delete();
    // Delete from charges where user_id does not exist in users table
    \DB::table('charges')
        ->whereNotIn('user_id', $validUserIds)
        ->delete();
    \DB::table('charges')
        ->whereRaw('CAST(amount AS DECIMAL(10,2)) < 0')
        ->delete();
});
Route::get('/generate-username', [APIBills::class, 'userkey']);
Route::get('/move-money', [APIBills::class, 'moveMoney']);

Route::post('new-password', [ApiAuthController::class, 'updatePassword']);
Route::middleware('auth:api')->group(function () {

    Route::get('user/profile', [ApiAuthController::class, 'authUserProfile']);
    Route::post('user/delete-profile', [ApiAuthController::class, 'deleteUser']);


    // 
    Route::get('gb', [APITransactionController::class, 'fetchBalance']);
    Route::post('req-card', [APITransactionController::class, 'reqCard']);
    Route::get('list-card', [APITransactionController::class, 'listCards']);

    Route::get('/get-notify', function () {
        $notify = \App\Models\Notify::where('recipient', auth()->user()->id)->orWhere('recipient', '0')->latest('created_at')->get();

        return laraResponse('success', $notify)->success();
    });
    Route::post('update/token', [ApiAuthController::class, 'updateDeviceToken']);

    Route::post('/update/profile', [ApiAuthController::class, 'updateUser']);
    Route::post('confirm/email', [ApiAuthController::class, 'verifyEmail']);

    Route::get('/request-email-token', [ApiAuthController::class, 'verifyemail1']);

    // uploadAvatar
    Route::post('/update-avatar', [ApiAuthController::class, 'uploadAvatar']);

    Route::middleware(['throttle:watch_dog'])->group(function () {
        Route::get('/watch-5-seconds', function () {
            return "This route is protected by rate limiting. It can only be accessed 1 times per  5 second ";
        });

        Route::prefix('credit-switch')->group(function () {

            Route::post('/req-airtime', [APIBills::class, 'GetAirtimeVend']);

            Route::post('/buy-electricity', [APIBills::class, 'buyElectricity']);
            Route::post('/req-data', [APIBills::class, 'buyData']);
            Route::post('/show-max-recharge', [APIBills::class, 'rechargeshowmax']);

            Route::post('/buy-star-time', [APIBills::class, 'startimeBuy']);
            Route::post('/buy-jamb', [APIBills::class, 'vendJamb']);
            Route::post('buy-logical-pins', [APIBills::class, 'logicalPinsVend']);
            Route::post('/buy-dstv-gotv', [APIBills::class, 'dstvBuy']);

            Route::post('/fund-betting-acct', [APIBills::class, 'bettingFund']);
        });
        Route::post('/giftcard-order', [APIBills::class, 'orderGiftCard']);
        Route::post('paytack-initiate-interbank-transfer', [APITransactionController::class, 'transferinitiate']);
        Route::post('/gift-user', [APIBills::class, 'sendFunds']);
    });
    // gift user 

    // credit switch
    Route::prefix('credit-switch')->group(function () {
        Route::get('/get-merchant-balance', [APIBills::class, 'MerchantBalance']);


        Route::get('/get-data-plans/{type}', [APIBills::class, 'getDataPlans']);
        Route::get('/get-bet-list', [APIBills::class, 'listBetting']);
        Route::post('/validate-bet-account', [APIBills::class, 'validateBettingAcct']);


        Route::get('/get-show-max-packages', [APIBills::class, 'getShowmaxPackages']);




        Route::get('/get-star-time-packages', [APIBills::class, 'getStartimePackages']);


        Route::post('/verify-startimes', [APIBills::class, 'startimeVerify']);


        Route::post('/validate-dstv-gotv', [APIBills::class, 'validateDSTVGoTvCard']);
        Route::post('/list-dstv-gotv', [APIBills::class, 'listDstvGotv']);



        Route::post('fetch-pins', [APIBills::class, 'fetchPins']);



        Route::post('/validate-jamb', [APIBills::class, 'validateJamb']);

        // public function validateElectricity()
        // 


        Route::post('/validate-electricity', [APIBills::class, 'validateElectricity']);
        // buyElectricity


    });

    Route::get('/giftcard-bal', [APIBills::class, 'getGCBal']);
    Route::get('/giftcard-countries', [APIBills::class, 'getCountries']);
    Route::get('/giftcard-countrycode', [APIBills::class, 'giftcountryCode']);
    Route::get('/giftcard-get-product', [APIBills::class, 'getGiftcardProduct']);
    Route::get('/get-giftcard-by-product-id', [APIBills::class, 'getGiftcardProductById']);
    Route::get('/get-giftcard-by-country-id', [APIBills::class, 'getCreditCardByCountryCode']);

    Route::get('/get-giftcard-redeem-instructions', [APIBills::class, 'GiftcardRedeemInstr']);

    Route::post('/giftcard-fx-rate', [APIBills::class, 'getfxRateGiftcard']);




    Route::get('get-bank-list', [APITransactionController::class, 'listBanks']);


    Route::post('create_bank_wallet', [APITransactionController::class, 'createAccount']);

    Route::post('get-bank-details', [APITransactionController::class, 'fetchAccountDetails']);

    Route::post('get-inter-bank-details', [APITransactionController::class, 'InterbankFetchAccountDetails']);
    Route::get('get-debit-nip-charges', [APITransactionController::class, 'getNIPCharges']);
    Route::get('validate-otp', [APITransactionController::class, 'validateOTP']);
    Route::get('get-valide-acct-details', [APITransactionController::class, 'getaccountDetails']);
    Route::get('get-my-wallet-ballance', [APITransactionController::class, 'getwalletbalance']);


    Route::post('initiate-transfer', [APITransactionController::class, 'transfer']);




    // 

    // paystack 
    Route::get('paytack-create-account', [APITransactionController::class, 'paystackAccountCreation']);

    Route::get('paytack-list-banks', [APITransactionController::class, 'paystackBankList']);

    Route::get('paytack-fetch-personal-details', [APITransactionController::class, 'fetchPaystackAccount']);
    // 

    Route::post('paytack-fetch-interbank-details', [APITransactionController::class, 'resorveAccountNo']);
    // 
    Route::post('add-beneficiary', [APITransactionController::class, 'addBeneficiary']);
    Route::get('list-beneficiary', [APITransactionController::class, 'listBeneficiary']);
    Route::get('delete-beneficiary/{id}', [APITransactionController::class, 'deleteBeneficiary']);
    // 



    // transaction history
    Route::get('bills-transactions', [APIBills::class, 'transactions']);
    // support
    Route::post('support-post', [APITransactionController::class, 'Sendsupport']);

    // transaction pin
    Route::post('add-pin', [ApiAuthController::class, 'updatePin']);
    Route::post('reset-pin', [ApiAuthController::class, 'pinreset']);
    // referal
    Route::get('claim-ref', [ApiAuthController::class, 'cliamref']);
    Route::get('get-ref-list', [ApiAuthController::class, 'ref']);



    // verify Account Endpoint

    Route::post('/initialize-verify', [APITransactionController::class, 'verifyAccount']);

    Route::post('/verify-otp', [APITransactionController::class, 'verifyotp']);
});


// paystack 
Route::get('paytack-create-account', [APITransactionController::class, 'paystackAccountCreation']);

Route::get('paytack-list-banks', [APITransactionController::class, 'paystackBankList']);

Route::get('paytack-fetch-personal-details', [APITransactionController::class, 'fetchPaystackAccount']);
// 

Route::post('paytack-fetch-interbank-details', [APITransactionController::class, 'resorveAccountNo']);
// 
Route::post('paytack-add-transfer-beneficiary', [APITransactionController::class, 'addBeneficiary']);
Route::get('paytack-list-transfer-beneficiary', [APITransactionController::class, 'listBeneficiary']);
Route::get('paytack-delete-transfer-beneficiary/{id}', [APITransactionController::class, 'deleteBeneficiary']);
// 
