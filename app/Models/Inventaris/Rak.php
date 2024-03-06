<?php

namespace App\Http\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model Rak
 *
 * @author defrindr
 */
class Rak extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];
}
