<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\User;
class Referral extends Model
{
    use HasFactory;
    protected $table="referral";
    protected $fillable=['id', 'user_id', 'referer', 'claimed', 'created_at', 'updated_at'];
    public function ref(){
        return $this->hasOne(User::class,'id','user_id');

    }
     public function user(){
        return $this->hasOne(User::class,'id','referer');
     }
}
