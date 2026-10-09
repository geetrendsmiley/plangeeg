<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Review extends Model { use HasUuids; protected $fillable=['order_id','reviewer_id','reviewee_id','rating','comment']; }
