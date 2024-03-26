<?php

namespace App\Models\Iam;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends BaseModel
{
    use HasFactory;

    const ROLE_ADMIN = 1;

    const ROLE_VENDOR = 2;

    const ROLE_EMPLOYEE = 3;

    protected $fillable = ['name', 'description'];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * Casting data from sql to php format
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
