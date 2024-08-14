<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Charges extends Model
{
    use HasFactory;
    protected $table='charges';
    protected $fillable=[
        'debit_acct', 'credit_acct', 'user_id', 'amount', 'status', 'created_at', 'updated_at','trans_id','verify_acct'
    ];
}
