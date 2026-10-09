<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Profile extends Model { use HasUuids; public $incrementing=false; protected $primaryKey='user_id'; protected $fillable=['user_id','username','display_name','bio','school','skills','avatar_storage_key','email_verified','phone_verified','payout_verified','training_verified','identity_verified']; protected function casts():array{return ['skills'=>'array','email_verified'=>'boolean','phone_verified'=>'boolean','payout_verified'=>'boolean','training_verified'=>'boolean','identity_verified'=>'boolean'];} public function user(){return $this->belongsTo(User::class);} }
