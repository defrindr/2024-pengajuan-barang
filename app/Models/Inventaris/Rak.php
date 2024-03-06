<?php

namespace App\Models\Inventaris;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
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

    protected $table = 'rak';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $builder->where(function ($builder) use ($keyword) {
            $builder->where('name', 'like', "%$keyword%");
        });
    }
}
