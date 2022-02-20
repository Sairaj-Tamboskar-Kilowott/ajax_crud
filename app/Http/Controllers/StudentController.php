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

    // public function store(Request $request)
    // {
    //     //sending data with validation
    //      $validator = Validator::make($request->all(),[
    //         'name' => 'required|max=191',
    //         'email' => 'required|email| max=191',
    //         'phone' => 'required|max=191',
    //         'course' => 'required|max=191',


    //     ]);
    //     if($validator ->fails())
    //     {
    //         return response()->json([
    //             'status'=> 400,
    //             'errors'=>$validator->messages()
    //         ]);
    //     }
    //     else{
    //          $student = new Student;
    //          $student->name = $request->input('name');
    //          $student->email = $request->input('email');
    //          $student->phone = $request->input('phone');
    //          $student->course = $request->input('course');
    //         $student->save();
    //         return response()->json([
    //             'status'=> 200,
    //             'message'=>'Added Successfully',
    //         ]);

    //     }
    // }

    //             //without validation
    //         // $student = new Student;
    //         // $student->name = $request->input('name');
    //         // $student->email = $request->input('email');
    //         // $student->phone = $request->input('phone');
    //         // $student->course = $request->input('course');
    //         // $student->save();
    //         // return response()->json([
    //         //     'status'=> 200,
    //         //     'message'=>'Added Successfully',
    //         // ]);
            
    // }

        //using different validation method
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => ['required', 'integer'],
            'course' => 'required',
            
        ]);
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
            return redirect()->route('student.index');
    }



    public function fetchstudent()
        {
            $students = Student::all();
            return response()->json([
                'students'=> $students,
            ]);
        }
    

        

    //Edit funtion
    public function edit($id)
    {
        $student = Student::find($id);
        if($student)
        {
            return response()->json([
                'status'=> 200,
                'student'=>$student,
                
            ]);
        }
        else{
            return response()->json([
                'status'=> 404,
                'message'=>'student not found',
                
            ]);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'phone' => ['required', 'integer'],
            'course' => 'required',
            
        ]);
        // $student = new Student;
            $student =  Student::find($id);
            if($student)
        {
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            $student->update();
            

            return response()->json([
                'status'=> 200,
                'message'=>'Student updated Successfully',
                
            ]);
            // return redirect()->route('student.index');
        }
        else{
            return response()->json([
                'status'=> 404,
                'message'=>'student not found',
                
            ]);
        }
            
    
    }

    //using Validator type validation
    // $validator = Validator::make($request->all(),[
    //             'name' => 'required|max=191',
    //             'email' => 'required|email| max=191',
    //             'phone' => 'required|max=191',
    //             'course' => 'required|max=191',
    
    
    //         ]);
    //         if($validator ->fails())
    //         {
    //             return response()->json([
    //                 'status'=> 400,
    //                 'errors'=>$validator->messages(),
    //             ]);
    //         }
    //         else{
    //             $student =  Student::find($id);
    //             if($student)
    //             {
    //             $student->name = $request->input('name');
    //             $student->email = $request->input('email');
    //             $student->phone = $request->input('phone');
    //             $student->course = $request->input('course');
    //             $student->update();
            

    //             return response()->json([
    //              'status'=> 200,
    //              'message'=>'Student updated Successfully',
                
    //              ]);
    //         // return redirect()->route('student.index');
    //         }
    //         else
    //         { 
    //             return response()->json([
    //             'status'=> 404,
    //             'message'=>'student not found',
                
    //         ]);
    //     }
    // }
// }
        

        public function destroy($id){
            $student = Student::find($id);
            $student->delete();

            return response()->json([
            'status'=> 200,
            'message'=>'student data deleted',
        ]);
        }
    
}