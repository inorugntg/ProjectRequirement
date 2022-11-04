<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class CustomAuthController extends Controller
{
    
    public function index()
    {
        return view('auth.register');
    }  
      
    public function register()
    {
        $register = register->alldata();
        return response()->json([
            'register'=>$register,
        ]);
    }

    public function uploads(Request $request){
        $datainput=['nama'=>$request->nama, 'date'=>$request->date, 'email'=>$request->email, 'phone'=>$request->phone, 'job'=>$request->job,'skill'=>$request->skill];
        $this->register->uploads($datainput);
    }
 
    public function customregister(Request $request)
    {
        // @dd($request->all());
        $request->validate([
            
            'id'   => 'required|numeric',
            'nama' => 'required',
            'date' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'required|numeric',
            'jobs' => 'required',
            'skills' => 'required'

        ]);
   
        $credentials = $request->only('email', 'password' );
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('Signed in');
        }
  
        return redirect("register")->withSuccess('Login details are not valid');
    }

    
}