<?php

namespace App\Models\Inventaris;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * Auto-generated Model Inventaris
 *
 * @author defrindr
 */
class Inventaris extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'inventaris';

    protected $fillable = ['qrcode', 'name', 'category_id', 'rak_id', 'stok_sekarang', 'stok_total'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function scopeSearch(Builder $builder, string $keyword): void
    {
        $kategoriTable = Kategori::getTableName();
        $rakTable = Rak::getTableName();
        $selfTable = self::getTableName();
        $builder
            ->leftJoin($kategoriTable, "{$kategoriTable}.id", "{$selfTable}.category_id")
            ->leftJoin($rakTable, "{$rakTable}.id", "{$selfTable}.rak_id")
            ->where(function ($builder) use ($keyword, $kategoriTable, $rakTable, $selfTable) {
                $builder->where("{$selfTable}.name", 'like', "%$keyword%")
                    ->orWhere("{$kategoriTable}.name", 'like', "%$keyword%")
                    ->orWhere("{$rakTable}.name", 'like', "%$keyword%");
            })->select($selfTable.'.*');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->qrcode = Str::random(50);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function rak(): BelongsTo
    {
        return $this->belongsTo(Rak::class);
    }
}
