<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Place extends Model {
    
    protected $table = 'places';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'slug',
        'city',
        'state',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}