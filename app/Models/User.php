<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
class User extends Authenticatable implements MustVerifyEmail {
    use \Illuminate\Database\Eloquent\Factories\HasFactory;
    use HasUuids, Notifiable;
    protected $fillable=['email','password','status','is_admin'];
    protected $hidden=['password','remember_token'];
    protected function casts(): array { return ['email_verified_at'=>'datetime','last_login_at'=>'datetime','password'=>'hashed','is_admin'=>'boolean']; }
    public function profile(){return $this->hasOne(Profile::class);}
    public function gigs(){return $this->hasMany(Gig::class,'seller_id');}
    public function buyerOrders(){return $this->hasMany(Order::class,'buyer_id');}
    public function sellerOrders(){return $this->hasMany(Order::class,'seller_id');}
    public function sentMessages(){return $this->hasMany(Message::class,'sender_id');}
}
