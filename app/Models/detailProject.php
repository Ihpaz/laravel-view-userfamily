<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detailProject extends Model
{
    use HasFactory;


    protected $fillable = [
        'nama','StartDate','EndDate','pic_id','status','subproject_id'
    ];
}
