<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Transaction extends Model { use HasUuids; protected $fillable=['order_id','provider','provider_reference','type','amount_kobo','currency','status','commission_kobo','processor_fee_kobo','metadata']; protected function casts():array{return ['amount_kobo'=>'integer','commission_kobo'=>'integer','processor_fee_kobo'=>'integer','metadata'=>'array'];} }
