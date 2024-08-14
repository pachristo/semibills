<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Authwema extends Model
{
    use HasFactory;
    protected $table='auth_wema';
    protected $fillablbe=[
        'id', 'transactionID', 'securityINFO', 'created_at', 'updated_at'
    ];
}
