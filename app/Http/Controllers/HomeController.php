<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Doctor;
use App\Models\Appointment;

class HomeController extends Controller
{
    public function redirect(Request $request) {
        //dd(Auth::user()->usertype);
        if(Auth::id()) {
            // Debugging statement
             // Check if usertype is retrieved correctly
    
            if(Auth::user()->usertype == '0') {

                $doctor = Doctor::all();
                return view('user.home', compact('doctor'));
            } else {
                return view('admin.home');
            }
        } else {
            // Redirect to login page or handle unauthenticated users
            return redirect()->route('login');
        }
    }

    public function index() {
        $doctor = Doctor::all();
        if(Auth::id()) {
            // Debugging statement
             // Check if usertype is retrieved correctly
    
            if(Auth::user()->usertype == '0') {
                return view('user.home', compact('doctor'));
            } else {
                return view('admin.home');
            }
        } else {
            // Redirect to login page or handle unauthenticated users
            return redirect()->back();
        }
        
    }

    public function appointment(Request $request) {
        
        $data = new appointment;
        $data->name=$request->name;
        $data->email=$request->email;
        $data->date=$request->date;
        $data->phone=$request->number;
        $data->message=$request->message;
        $data->doctor=$request->doctor;
        $data->status='In progress';

        if(Auth::id()) {
            $data->user_id=Auth::id();
        }

        $data->save();
       
        return redirect()->back()->with('message', 'Appointment booked successfully!');
    }

    public function myappointment() {
        if(Auth::id()) {
            if(Auth::user()->usertype == '0') {
            $userid=Auth::user()->id;
            $appoint=appointment::where('user_id',$userid)->get();
            return view('user.my_appointment', compact('appoint'));
            }
        }else {
            return redirect()->back();
        }
    }

    public function cancel_appoint($id) {
        $data=appointment::find($id);
        $data->delete();
        return redirect()->back();
    }

    
    
}

