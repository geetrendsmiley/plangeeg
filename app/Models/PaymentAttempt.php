<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class PaymentAttempt extends Model { use HasUuids; protected $fillable=['order_id','provider','reference','status','amount_kobo']; protected function casts():array{return ['amount_kobo'=>'integer'];} }
