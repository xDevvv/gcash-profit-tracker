<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * Child models should override this property.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be cast.
     *
     * Child models should override this property.
     *
     * @var array<string, string>
     */
    protected $casts = [];
}
