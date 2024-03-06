<?php

namespace App\Http\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Auto-generated Model Kategori
 *
 * @author defrindr
 */
class Kategori extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name'];
}
