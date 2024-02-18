<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $keyType = 'string';

    protected $fillable = ['name'];

    public function funkos()
    {
        return $this->hasMany(Funko::class);
    }


    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }
}
