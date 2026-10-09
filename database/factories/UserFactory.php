<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory; use Illuminate\Support\Str;
class UserFactory extends Factory { protected $model=\App\Models\User::class; public function definition():array{return ['id'=>(string)Str::uuid(),'email'=>fake()->unique()->safeEmail(),'password'=>'Password123!','status'=>'ACTIVE'];} }
