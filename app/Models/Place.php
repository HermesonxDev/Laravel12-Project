<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Place extends Model {
    
    use HasFactory;
    
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