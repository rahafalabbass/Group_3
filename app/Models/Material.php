<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    public function collage(){
        return $this->belongsTo(Collage::class);
    }

    public function cycles(){
        return $this->hasMany(Cycle::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }
}
