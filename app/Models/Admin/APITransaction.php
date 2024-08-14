<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\User;
class APITransaction extends Model
{
    use HasFactory;
    protected $fillable=[
        'id', 'trans_id', 'trans_type', 'trans_name', 'api_source', 'user_id', 'current_balance', 'amount', 'created_at', 'updated_at', 'data_json', 'status', 'beneficiary_no', 'beneficiary_name', 'beneficiary_bank', 'from_name', 'from_no'
    ];

    public function user(){

        return $this->hasOne(User::class,'id','user_id');
    }

    protected $casts=[
        'data_json'=>'array'
    ];
}
