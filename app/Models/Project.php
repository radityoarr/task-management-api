<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasApiTokens, HasFactory;
    protected $fillable = ['name', 'description', 'start_date', 'end_date'];

    public function tasks():HasMany
    {
        return $this->hasMany(Task::class, 'project_id');
    }
}
