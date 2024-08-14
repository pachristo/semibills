<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Referral extends Model
{
    use HasFactory;
    protected $table="referral";
    protected $fillable=['id', 'user_id', 'referer', 'claimed', 'created_at', 'updated_at'];
    public function ref(){
        return $this->hasOne(User::class,'id','referer');

    }


    public function user(){
        return $this->hasOne(User::class,'id','user_id');

    }
    
    
}
