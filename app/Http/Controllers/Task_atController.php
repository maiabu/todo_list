<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Task;

class Task_atController extends Controller
{
    public function index(){
        $tasks =Task::get();

        return response()->json($tasks);
    }
    
        public function show(Task $task){
            return response()->json($task);
        }
    
}
