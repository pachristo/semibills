<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $table='beneficiaries';
    use HasFactory;
    protected $fillable=['id', 'acct_name', 'acct_no', 'bank', 'created_at', 'updated_at', 'user_id','recipient_code'];
}
