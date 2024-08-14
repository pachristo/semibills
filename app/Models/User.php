<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'firstname',
        'lastname',
        'email',
        'state',
        'lga',
        'phone',
        'bank_name',
        'bank_account_no',
        'bank_account_name',
        'device_token',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'address',
        'pass_token',
        'email_verified',
        'email_code',
        'wallet_ngn',
        'username',
        'acct_name',
        'acct_no',
        'acct_status',
        'acct_customer_id',
        'acct_email',
        'acct_phone',
        'dod',
        'nin',
        'wema_tracking_id',
        'pin',
        'has_pin',
        'pin_token',
        'ps_cus_code',
        'ps_cus_id',
        'biometric',
        'referral_code',
        'avatar',
        'verification_type',
        'verification_number',
        'verification_status',
        'sh_id_no',
        'verification_otp',
        'sub_acct_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pin',
        'verification_otp',
        'pin_token',
        'email_code',
        'device_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected $attributes = [
        'verification_status' => false,
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'verification_status' => 'boolean'
    ];
}
