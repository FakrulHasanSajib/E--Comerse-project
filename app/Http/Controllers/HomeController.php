<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\user;
use App\Models\product;
class HomeController extends Controller
{
    public function redirect()
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            // Get the user type
            $usertype = Auth::user()->usertype;

            // Check user type and redirect accordingly
            if ($usertype == '1') {
                return view('admin.home');
            } else {
                $data = product::paginate(3);
                return view('user.home',compact('data'));
            }
        } else {
            // If the user is not authenticated, redirect to login page
            return redirect()->route('login');
        }
    }

    public function index()
    {
        if(Auth::id())
        {
            return redirect('redirect');
        }
        else{
            $data = product::paginate(3);
            return view('user.home',compact('data'));
        }
       
    }
}

