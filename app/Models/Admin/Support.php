<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\User;
class Support extends Model
{
    use HasFactory;
    protected $fillable =['id', 'user_id', 'subject', 'type', 'text', 'status', 'created_at', 'updated_at'];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
