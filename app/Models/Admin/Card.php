<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Card extends Model
{
    use HasFactory;
    protected $table='card';
    protected $fillable=[
       'id', 'user_id', 'customer_id', 'card_data', 'is_request', 'is_verified', 'pin', 'report', 'address', 'is_paid', 'created_at', 'updated_at', 'address1', 'city', 'lga', 'state', 'postalcode'
    ];
    protected $casts=[
        'is_request'=>'boolean', 'is_verified'=>'boolean', 'is_paid'=>'boolean'
    ];
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
