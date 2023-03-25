<?php

namespace App\Http\Controllers\Api;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all();

        if($students->count() > 0){
            return response()->json([
                'status' => 200,
                'students' => $students
            ],200);
        }else {
            return response()->json([
                'status' => 404,
                'message' => 'No Records Found'
            ],404);
        }

    }

    public function addStudent(Request $request){
        $validate = Validator::make($request->all(), [
            'firstname' => 'required|string|max:191',
            'lastname'  => 'required|string|max:191',
            'email'  => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validate->messages()
            ],422);
        }else{
            $student = Student::create(
                [
                    'firstname' => $request->firstname,
                    'lastname'  => $request->lastname,
                    'email'  => $request->email,
                    'phone' => $request->phone,
                ]
            );

            if($student) {
                return response()->json([
                    'status' => 200,
                    'message' => "Student Added Successfully"
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong"
                ],500);
            }
        }
    }

    function getStudentbyId($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "Student with privided id Does not exist"
            ],404);

        }
    }

    function editStudent($id){

        $student = Student::find($id);
        if($student){
            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => "Student with privided id Does not exist"
            ],404);

        }
    }

    public function updateStudent(Request $request, int $id){
        $validate = Validator::make($request->all(), [
            'firstname' => 'required|string|max:191',
            'lastname'  => 'required|string|max:191',
            'email'  => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validate->messages()
            ],422);
        }else{
            $student = Student::find($id);

            if($student) {

                $student->update(
                    [
                        'firstname' => $request->firstname,
                        'lastname'  => $request->lastname,
                        'email'  => $request->email,
                        'phone' => $request->phone,
                    ]
                );

                return response()->json([
                    'status' => 200,
                    'message' => "Student Updated Successfully"
                ],200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => "Student with privided id Does not exist"
                ],404);
            }
        }
    }

    public function deleteStudent($id)
    {

        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status' => 200,
                'message' => "Student Deleted Successfully"
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "Student with privided id Does not exist"
            ],404);
        }
    }
}
