<?php
namespace App\Http\Controllers;
use App\Models\Category; use App\Models\Gig; use Illuminate\Http\Request; use Illuminate\Support\Str;
class GigController extends Controller {
 public function index(Request $r){$q=Gig::with(['seller.profile','category'])->where('status','ACTIVE'); if($r->filled('q')){$term=$r->string('q');$q->where(fn($x)=>$x->where('title','like',"%{$term}%")->orWhere('description','like',"%{$term}%"));} if($r->filled('category')){$q->whereHas('category',fn($x)=>$x->where('slug',$r->category));} return view('gigs.index',['gigs'=>$q->latest('published_at')->paginate(15)->withQueryString(),'categories'=>Category::orderBy('name')->get()]);}
 public function show(Gig $gig){abort_unless($gig->status==='ACTIVE',404);$gig->load(['seller.profile','category']);return view('gigs.show',compact('gig'));}
 public function create(){abort_unless(auth()->check(),403);return view('gigs.create',['categories'=>Category::orderBy('name')->get()]);}
 public function store(Request $r){$data=$r->validate(['title'=>'required|string|max:100','description'=>'required|string|max:2000','price_naira'=>'required|numeric|min:500|max:100000000','category_id'=>'required|exists:categories,id']);$gig=Gig::create(['seller_id'=>auth()->id(),'category_id'=>$data['category_id'],'title'=>$data['title'],'slug'=>Str::slug($data['title']).'-'.Str::lower(Str::random(6)),'description'=>$data['description'],'price_kobo'=>(int)round($data['price_naira']*100),'status'=>'PENDING']);return redirect()->route('gigs.show',$gig)->with('success','Gig submitted for admin approval.');}
}
