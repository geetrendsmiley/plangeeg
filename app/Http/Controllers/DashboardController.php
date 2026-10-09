<?php
namespace App\Http\Controllers;
use App\Models\Gig; use App\Models\Order;
class DashboardController extends Controller { public function __invoke(){ $user=auth()->user(); return view('dashboard', ['myGigs'=>Gig::where('seller_id',$user->id)->latest()->get(), 'buying'=>Order::with('gig')->where('buyer_id',$user->id)->latest()->get(), 'selling'=>Order::with('gig')->where('seller_id',$user->id)->latest()->get()]); } }
