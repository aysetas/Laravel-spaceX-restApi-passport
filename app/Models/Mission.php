<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'flight',
        'capsule_id'
    ];

    public function capsule()
    {
        return $this->belongsTo(Capsule::class,'capsule_id','id');
    }
}
