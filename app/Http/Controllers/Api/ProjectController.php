<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Models\User;
use App\Http\Controllers\Api\ApiController;

class ProjectController extends ApiController
{

    public function index()
    {
        $projects = Project::all();
        if($projects) {
         return $this->respondSuccess($projects);
        } else {
           return $this->respondNotFound();
        }

    }

    public function store(ProjectRequest $request)
    {
        $user = auth('api')->user() ?? User::findOrFail($request->user_id);
        $project['user_id'] = $user->id;
        $project = Project::create($request->validated());

        return $this->respondSuccess($project);
    }

    public function show($id)
    {
        $project = Project::find($id);
        if($project) {
            return $this->respondSuccess($project);
         }
         else {
           return $this->respondNotFound();
        }
    }

    public function update(ProjectRequest $request, $id)
    {
        $project = Project::find($id);
        if($project) {
           $project->name = $request->name;
        $project->description = $request->description;
        $user_id = auth('api')->user()->id ?? $request->user_id;
        $project->user_id = $user_id;
        $project->save();
       return $this->respondSuccess($project);
        }
       else {
           return $this->respondNotFound();
        }
    }

      public function destroy($id)
    {
        $project = Project::find($id);
        if($project) {
        $project->delete();
       return $this->respondSuccess($project);
        }
       else {
           return $this->respondNotFound();
        }
    }
}
