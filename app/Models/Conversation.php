<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Conversation extends Model { use HasUuids; protected $fillable=['buyer_id','seller_id','gig_id']; public function messages(){return $this->hasMany(Message::class);} public function gig(){return $this->belongsTo(Gig::class);} }
