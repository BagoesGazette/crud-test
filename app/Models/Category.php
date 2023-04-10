<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_publish'
    ];

    public function scopeSearchable($query, $search){
        if($search) $query->where('name', 'LIKE', '%'. $search.'%');
    }

    
}
