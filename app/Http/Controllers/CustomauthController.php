<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Response;
use Notification;
use App\Notifications\NewRegiterEmail;
use Illuminate\Foundation\Auth\RegistersUsers;
use DataTables;




class CustomauthController extends Controller
{

	public function index() {

		return view('customAuth.login');
	}

	public function customLogin(Request $request) {

		$request->validate([

			'email' => "required",
			'password' => "required"
		]);

		$credentials = $request->only('email', 'password');

		if(Auth::attempt($credentials)) {

			return redirect()->intended('dashboard')->withSuccess('Signed in');		
			//	intended When you are done verifying or charging the user or whatever you need to do to grant access to the protected page you simply use this code
		}


		return redirect("login")->withSuccess('login credentials are not valids');
	}

	public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


	public function registration()
	
	{
		return view('customAuth.registration');
	}

	public function customRegistration(Request $request)
	{
		$request->validate([

			'name' => 'required',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:3'
		]);

		$data = $request->all();

		// dd($data);
		
		$check = $this->create($data);

		Auth::loginUsingId($check->id);

		return response()->json();
		
		// return Redirect::to('/party');
		// return redirect()->intended('dashboard')->withSuccess('Signed in');	
	}

	public function create(array $data)
	{
		$password = Hash::make($data['password']);
			// $password = $data['password'];	
			$user = User::create([
				'name' => $data['name'],
				'email' => $data['email'],
				'password' => $password,
            	'role' => isset($data['role']) ? $data['role'] : 'user'

			]);

			// $email = $data['email'];
			// Notification::route('mail', $email)->notify(new NewRegiterEmail($password));

			$pass = $data['password'];

			$user->notify(new NewRegiterEmail($pass));

			return $user;
	}


	public function dashboard()
	{
		if(Auth::check()) {

			// return redirect()->url('/party');
			return Redirect::to('/party');

		}


		return redirect("login")->withSuccess("you are not allowed to access");
	}

	public function signOut()
	{
		Session::flush();
		Auth::logout();


		return Redirect('login');
	}


	public function update_admin_country(Request $request)
		{

			$country = $request->country;

			$user = User::where('id', auth()->user()->id)->update(['country' => $country]);

			return response()->json();
		}

		public function update_admin_state(Request $request)
		
		{

			$state = $request->state;

			$user = User::where('id', auth()->user()->id)->update(['state' => $state]);

			return response()->json();
		}



    
}
