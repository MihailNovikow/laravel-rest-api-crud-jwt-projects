<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\ApiController;

class TaskController extends ApiController
{
    public function index()
    {
        $tasks = Task::all();
        if($tasks) {
         return $this->respondSuccess($tasks);
        } else {
           return $this->respondNotFound();
        }

    }
 public function singleProjectTasks(Request $request)
    {
        $user_id = auth('api')->user()->id ?? $request->user_id;
        $tasks = Task::where('project_id', $request->project_id)->where('user_id', $user_id
        )->firstOrFail();
        if($tasks) {
 return $this->respondSuccess($tasks);
        } else {
            return $this->respondNotFound();
        }
    }
    public function store(TaskRequest $request, $user_id)
    {
        $userId = auth('api')->user()->id ?? User::findOrFail('id',$user_id);
        $task['user_id'] = $userId;
        $task = Task::create($request->validated());
        return $this->respondSuccess($task);
    }

    public function show($id)
    {
        $task = Task::find($id);
        if($task) {
            return $this->respondSuccess($task);
         }
         else {
           return $this->respondNotFound();
        }
    }

    public function update(TaskRequest $request, $task_id)
    {
         $task = Task::find('id', $task_id);
 if($task) {
           $task->name = $request->name;
        $task->description = $request->description;
        $user_id = auth('api')->user()->id ?? $request->user_id;
        $task->user_id = $user_id;
        $task->save();
       return $this->respondSuccess($task);
        }
       else {
           return $this->respondNotFound();
        }
    }

      public function destroy($id)
    {
        $task = Task::find($id);
        if($task) {
        $task->delete();
       return $this->respondSuccess($task);
        }
       else {
           return $this->respondNotFound();
        }
    }
}
