<?php
use Illuminate\Support\Facades\Schedule;
Schedule::call(function(){\App\Models\Order::where('status','DELIVERED')->where('delivered_at','<',now()->subHours(config('geegig.auto_release_hours')))->each(function($order){$order->update(['status'=>'AUTO_RELEASED','completed_at'=>now()]);});})->hourly();
