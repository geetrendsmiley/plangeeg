<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Gig extends Model { use HasUuids; protected $fillable=['seller_id','category_id','title','slug','description','price_kobo','status','is_demo','image_storage_key','published_at']; protected function casts():array{return ['price_kobo'=>'integer','is_demo'=>'boolean','published_at'=>'datetime'];} public function seller(){return $this->belongsTo(User::class,'seller_id');} public function category(){return $this->belongsTo(Category::class);} public function orders(){return $this->hasMany(Order::class);} public function getPriceNairaAttribute(){return number_format($this->price_kobo/100,2);}}
