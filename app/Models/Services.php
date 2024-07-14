<?php

namespace App\Models;

use AnourValar\EloquentSerialize\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'parent_id'];

    public function parent()
    {
        return $this->belongsTo(Services::class, 'parent_id')->whereNull("parent_id");
    }

    public function children()
    {
        return $this->hasMany(Services::class, 'parent_id');
    }
}
