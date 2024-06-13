<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Students;
use Illuminate\Support\Facades\Validator;

class studentController extends Controller
{
    #function to get all students
    public function index()
    {
        $students = Students::all();

        // if($students->isEmpty()){
        //     $data = [
        //         'message' => 'No students found',
        //         'status' => 404
        //     ];
        //     return response()->json($data, 404);
        // };

        $data =[
           'students' => $students,
           'status' => 200
        ];    

        return response()->json($data, 200);
    }
    #function to obtain one student
    public function indexOne($id)
    {
        $student = Students::find($id);
        
        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'student' => $student,
            'status' => 200
        ];
        return response()->json($data, 200);

    }

    #function to create a student
    public function  store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'email' => 'required|email|unique:student',
            'phone' => 'required|max:15',
            'language' => 'required',
            'classRoom' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
        $student = Students::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'language' => $request->language,
            'classRoom' => $request->classRoom
        ]);
        if(!$student){
            $data= [
                'message' => 'Student not created',
                'status' => 500
            ];
            return response()->json($data, 500);
        }
        $data = [
            'student' => $student,
            'status'  => 201
        ];
        return response()->json($data, 201);
    }


    #function to update a student
    public function updateOne(Request $request, $id)
    {
        $student = Students::find($id);
        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
                ];
                return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:30',
            'email' => 'required|email',
            'phone' => 'required|max:15',
            'language' => 'required',
            'classRoom' => 'required'
        ]);
        if($validator->fails()){
            $data = [
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->language = $request->language;
        $student->classRoom = $request->classRoom;

        $student->save();

        $data = [
            'message' => 'Student updated',
            'student'=>$student,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    #function to update a part of one student
    public function updateOnePart(Request $request, $id){
        $student = Students::find($id);
        if(!$student){
            $data = [
                'message' => 'Student not found',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'max:30',
            'email' => 'email|unique:student',
            'phone' => 'digits:15',
            'language' => 'min:2',
            'classRoom' => 'max:10'
        ]);

        // verificar si el validador falla
        if($validator->fails()){
            $data = [
                'message' => 'Validation error',
                'errors'  => $validator->errors(),
                'status'  => 400
            ];
            return response()->json($data, 400);
        }
        if($request->has("name")){
            $student->name = $request->name;
        }
        if($request->has('email')){
            $student->email = $request->email;
        }
        if($request->has('phone')){
            $student->phone = $request->phone;
        }
        if($request->has('language')){
            $student->language = $request->language;
        }
        if($request->has('classRoom')){
            $student->classRoom = $request->classRoom;
        }

        $student->save();

        $data = [
            'message' => 'Student updated successfully',
            'status' => 200
        ];

        return response()->json($data, 200);
    } 


    #function for delete students 
    public function deleteOne($id)
      {
          $students = Students::find($id);
  
          if(!$students){
              $data = [
                  'message' => 'Student not found',
                  'status' => 404
              ];
              return response()->json($data, 404);
          }
  
          $students->delete();
          $data = [
              'message' => 'Student deleted',
              'status' => 200
          ];
          return response()->json($data, 200);
    }

};
