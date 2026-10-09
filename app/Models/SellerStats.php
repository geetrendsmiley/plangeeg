<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class SellerStats extends Model { protected $primaryKey='user_id'; public $incrementing=false; protected $fillable=['user_id','avg_rating','completed_orders','avg_response_hours','repeat_buyers','score']; }
