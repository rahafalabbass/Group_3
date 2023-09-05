<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Models\Collage;
use App\Models\Material;


class Cycle extends Model
{
    use HasFactory;

    public function material(){
        return $this->belongsTo(Material::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    // public function collage(){
    //     return $this->hasOneThrough(Collage::class, Material::class);
    // }
}
