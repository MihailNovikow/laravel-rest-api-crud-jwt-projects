<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'project_id',
        'status',
    ];
     public function Project()
    {
    	return $this->belongsTo('App\Models\Project', 'project_id', 'id');
    }
    public function User()
    {
    	return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

}
