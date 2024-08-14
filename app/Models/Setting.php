<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table='setting';
    protected $fillable=['id', 'ref_com', 'phone', 'email', 'misc', 'created_at', 'updated_at','trans_com'];
}
