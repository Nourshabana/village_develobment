<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Resources\TeacherResource;
use App\Models\School;
use App\Models\Teacher;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    use HttpResponses;

    public function __construct()
    {
        $this->middleware(['role:admin',]);
    }


    public function store(StoreTeacherRequest $request){
        $request->validated($request->all());
        $teacheruser=new User();
        $teacher=new Teacher();
        $filename=$this->uploadimage($request,'teachers');
        $schools=School::where('name','like','%'.$request->schoolname.'%')->first();
        $teacheruser->name=$request->name;
        $teacheruser->email=$request->email;
        if($request->has('phone')){$teacheruser->phone=$request->phone;}
        $teacheruser->password=Hash::make($request->password);
        $teacheruser->assignRole('teacher');
        $teacheruser->save();
        $teacher->user_id=$teacheruser->id;
        $teacher->name=$request->name;
        $teacher->subject=$request->subject;
        $teacher->school_id=$schools->id;
        $teacher->stage=$request->stage;
        if ($filename){$teacher->photo=$filename;}
        $teacher->save();
        return new TeacherResource($teacher);

    }

    public function index()
    {
        
        return TeacherResource::collection(Teacher::all());
        //
    }
    public function show(Teacher $teacher)
    {
        return TeacherResource::collection(Teacher::where('id',$teacher->id)->get());
        //
    }

    public function update(Request $request,Teacher $teacher )
    {
        $user=User::where('id',$teacher->user_id)->first();
        $validator = Validator::make($request->all(), [
            'phone' => [
                'sometimes',
                Rule::unique('users')->ignore($user->id),
            ],
            'schoolname'=>['sometimes','string',],
            'stage'=>['sometimes','string'],
            'photo'=>['sometimes','max:2000','mimes:png,jpg']
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        
        if ($request->has('stage')){$teacher->stage=$request->stage;}else{$teacher->stage=$teacher->stage;}
        if ($request->has('schoolname')){
        $schools=School::where('name','like','%'.$request->schoolname.'%')->first();
        $teacher->school_id=$schools->id;}
        else{$teacher->school_id=$teacher->school_id;}
        if ($request->has('phone')){$user->phone=$request->phone;}else{$user->phone=$user->phone;}
        $filename=$this->updateimage($request,'teacher',$teacher);
        $user->save();
        $teacher->photo=$filename;
        $teacher->save();
        return new TeacherResource($teacher);
    }
    public function destroy( Teacher $teacher)
    {
        $user=User::where('id',$teacher->user_id)->first();
        $user->removeRole('teacher');
        if($teacher->photo!='user.png'){
        if($this->deleteimage($teacher)){$teacher->delete();}}else{$teacher->delete();}
        $user->delete();
        return $this->succes('','your record was deleted succesfully');
        //
    }

}
