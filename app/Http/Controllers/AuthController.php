<?php
namespace App\Http\Controllers;
use App\Models\Profile; use App\Models\User; use Illuminate\Http\Request; use Illuminate\Support\Facades\Auth; use Illuminate\Validation\Rules\Password;
class AuthController extends Controller {
 public function showLogin(){return view('auth.login');}
 public function login(Request $r){$data=$r->validate(['email'=>'required|email','password'=>'required|string']); if(!Auth::attempt($data,$r->boolean('remember'))){return back()->withErrors(['email'=>'Invalid email or password.'])->onlyInput('email');} $r->session()->regenerate(); $r->user()->update(['last_login_at'=>now()]); return redirect()->intended('/dashboard');}
 public function showRegister(){return view('auth.register');}
 public function register(Request $r){$data=$r->validate(['email'=>'required|email|unique:users,email','password'=>['required','confirmed',Password::min(8)],'username'=>'required|alpha_dash|min:3|max:40|unique:profiles,username','display_name'=>'nullable|string|max:100','school'=>'nullable|string|max:160']); $user=User::create(['email'=>$data['email'],'password'=>$data['password'],'status'=>'ACTIVE']); Profile::create(['user_id'=>$user->id,'username'=>$data['username'],'display_name'=>$data['display_name']??null,'school'=>$data['school']??null]); Auth::login($user); $r->session()->regenerate(); return redirect('/dashboard')->with('success','Welcome to GeeGig.');}
 public function logout(Request $r){Auth::logout();$r->session()->invalidate();$r->session()->regenerateToken();return redirect('/');}
}
