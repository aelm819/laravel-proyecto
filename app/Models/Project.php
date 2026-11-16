<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'deadline',
        'status',
        'user_id',
    ];


    public function users(){
    return $this->belongsToMany(User::class)
                ->withPivot('role', 'contribution_hours')
                ->withTimestamps();
    }

}
