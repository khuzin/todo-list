<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Project extends Model
{
    use HasFactory;
    use AsSource;
    use Filterable;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
