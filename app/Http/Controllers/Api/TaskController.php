<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Http\Resources\Taskresource;

class TaskController extends Controller
{

    public function store(Request $request){
        $user=$request->user();
        if(!$user){
            return response()->json([
                'status'=> false,
                'message'=>[
                    'ar'=>'يجب تسجل الدخول',
                    'en'=>'Unauthenticated'
                ]
                ]);
        }

        $validate=$request->validate([
            'title'=>['required','string','max:2000'],
            'status'=>['required','string','in:pending,completed'],
            'user_id'=>['required','integer','exists:users,id']
        ]);
        
        $task =Task::create($validate);

        return response()->json([
              'status' => true,
            'message' => [
                'ar' => 'تم بنجاح',
                'en' => 'succssefully'
            ],
            'data'=>[
                'id'=>$task->id,
                'title'=>$task->title,
                'status'=>$task->status,
                'user_id'=>$task->user_id,
                'user'=>$task->user?->name
            ],
             'data'=> new TaskResource($task)
            ]);
    }

    public function destroy(Request $request,$id){
        $user=$request->user();

        if(!$user){
        return response()->json([
        'status'=> false,
        'message'=>[
          'ar'=>'يجب تسجل الدخول',
         'en'=>'Unauthenticated'
       ]
        ]);
    }
        $task =Task::find($id);

        if(!$task){
        return response()->json([
        'status' => false,
         'message' => [
         'ar' => 'غير موجود',
         'en' => 'not found'
         ]
     ]);
        }

        $task->delete();

        return response()->json([
        'status' => true,
        'message' => [
        'ar' => 'تم الحذف بنجاح',
        'en' => 'deleted successfuly'
        ]
        ]);
        }

        public function update(Request $request,$id){
            $user=$request->user();

            if(!$user){
            return response()->json([
                'status'=> false,
                'message'=>[
                    'ar'=>'يجب تسجل الدخول',
                    'en'=>'Unauthenticated'
                ]
                ]);
        }

        $task=Task::findOrFail($id);
         return response()->json([
        'status' => true,
        'message' => [
        'ar' => 'تم الحذف بنجاح',
        'en' => 'deleted successfully'
        ]
        ]);

        $validate=$request->validate([
            'title'=>['required','string','max:2000'],
            'status'=>['required','string','in:pending,completed'],
            'user_id'=>['required','integer','exists:users,id']
        ]);

        $task->update($validate);
         return response()->json([
        'status' => true,
        'message' => [
        'ar' =>'تم بنجاح',
        'en' => 'update successsfully'
        ]
        ]);
        }
    }

