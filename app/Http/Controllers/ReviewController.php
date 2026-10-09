<?php
namespace App\Http\Controllers;
use App\Models\Order; use App\Models\Review; use Illuminate\Http\Request;
class ReviewController extends Controller { public function store(Request $r,Order $order){abort_unless($order->status==='RELEASED',422);abort_unless(in_array(auth()->id(),[$order->buyer_id,$order->seller_id]),403);$reviewee=auth()->id()===$order->buyer_id?$order->seller_id:$order->buyer_id;$data=$r->validate(['rating'=>'required|integer|min:1|max:5','comment'=>'nullable|string|max:2000']);Review::create(['order_id'=>$order->id,'reviewer_id'=>auth()->id(),'reviewee_id'=>$reviewee,'rating'=>$data['rating'],'comment'=>$data['comment']??null]);return back()->with('success','Review submitted.');} }
