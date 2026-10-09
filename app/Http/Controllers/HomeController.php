<?php
namespace App\Http\Controllers;
use App\Models\Gig;
class HomeController extends Controller { public function __invoke(){ $gigs=Gig::with(['seller.profile','category'])->where('status','ACTIVE')->latest('published_at')->paginate(12); return view('home',compact('gigs')); } }
