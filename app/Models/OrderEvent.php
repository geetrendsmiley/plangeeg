<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class OrderEvent extends Model { use HasUuids; public $timestamps=false; protected $fillable=['order_id','from_state','to_state','actor_id','reason','metadata','created_at']; protected function casts():array{return ['metadata'=>'array','created_at'=>'datetime'];} public function order(){return $this->belongsTo(Order::class);} }
