<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\validator;



class StudentController extends Controller
{
    public function index()
    {
        return view('student.index');
    }

    public function store(Request $request)
    {
        
         $validator = Validator::make($request->all(),[
            'name' => 'required| max=255',
            'email' => 'required|email| max=255',
            'phone' => 'required| max=255',
            'course' => 'required| max=255',


        ]);
        if($validator ->fails())
        {
            return response()->json([
                'status'=> 400,
                'errors',
            ]);
        }
        else{
             $student = new Student;
             $student->name = $request->input('name');
             $student->email = $request->input('email');
             $student->phone = $request->input('phone');
             $student->course = $request->input('course');
            $student->save();
            return response()->json([
                'status'=> 200,
                'message'=>'Added Successfully',
            ]);

        }

            //without validation
            // $student = new Student;
            //      $student->name = $request->input('name');
            //  $student->email = $request->input('email');
            //  $student->phone = $request->input('phone');
            //  $student->course = $request->input('course');
            // $student->save();
            // return response()->json([
            //     'status'=> 200,
            //     'message'=>'Added Successfully',
            // ]);
            
    }
}
