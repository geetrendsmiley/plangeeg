<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Dispute extends Model { use HasUuids; protected $fillable=['order_id','opened_by_id','reason','evidence','status','resolution_note','resolved_at']; protected function casts():array{return ['evidence'=>'array','resolved_at'=>'datetime'];} }
