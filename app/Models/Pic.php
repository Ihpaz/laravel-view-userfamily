<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pic extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama', 'email'
    ];

    public function detailProject()
    {
        return $this->hasMany(detailProject::class);
    }
}
