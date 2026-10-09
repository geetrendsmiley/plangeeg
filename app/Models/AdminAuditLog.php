<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class AdminAuditLog extends Model { use HasUuids; protected $fillable=['admin_id','action','target_type','target_id','before','after','ip_address','user_agent']; protected function casts():array{return ['before'=>'array','after'=>'array'];} }
