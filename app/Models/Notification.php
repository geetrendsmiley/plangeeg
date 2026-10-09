<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Notification extends Model { use HasUuids; protected $fillable=['user_id','type','title','body','read_at']; protected function casts():array{return ['read_at'=>'datetime'];} }
