<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama','project_id'
    ];
    public function detailProject()
    {
        return $this->hasMany(detailProject::class);
    }
}
