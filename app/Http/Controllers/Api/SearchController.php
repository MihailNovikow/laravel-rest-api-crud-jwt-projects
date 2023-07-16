<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Foundation\helpers;
use App\Models\Project;
use App\Models\User;
use App\Http\Requests\SearchRequest;
use App\Http\Resources\SearchResource;
use DB;
use Illuminate\Support\Facades\Auth;
class SearchController extends ApiController
{
     protected $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function search(SearchRequest $request, $user_id)
    {
       $user = auth()->user()->id ??$user_id;
       $searchTerm = $request->name;

            if ($user) {
                    $model = Project::query()
                    ->where('name', 'LIKE', "%{$searchTerm}%")->where('user_id',  $user)->orderBy('created_at', 'desc')
                    ->get()
                    ->toArray();
                            if($model) {
      return response()->json(['data' => $model]);
    }  else {
            return $this->respondNotFound();
        }

            } else {
               return $this->respondUnauthorized();
            }
    }
}
