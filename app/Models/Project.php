<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama','ketrangan'
    ];

    public function SubProject()
    {
        return $this->hasMany(SubProject::class);
    }
}
