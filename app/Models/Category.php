<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model; use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Category extends Model { use HasUuids; protected $fillable=['name','slug']; public function gigs(){return $this->hasMany(Gig::class);} }
