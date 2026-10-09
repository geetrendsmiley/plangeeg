<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Message extends Model { use HasUuids; protected $fillable=['conversation_id','sender_id','body','read_at']; protected function casts():array{return ['read_at'=>'datetime'];} }
