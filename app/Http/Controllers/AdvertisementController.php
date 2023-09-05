<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;

class AdvertisementController extends Controller
{
    public function show(){
        $images=Advertisement::all();
        return  ImageResource::Collection($images);
    }
}
