<?php

namespace App\Http\Controllers\material;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Collage;
use Illuminate\Support\Facades\Validator;
use App\Models\Material;
use Illuminate\Http\Request;


class materialController extends Controller
{
    use GeneralTrait;
    public function show(Request $request){
    $validator = Validator::make($request->all(), [
        'uuid' => 'required|max:5'
    ]);

    if ($validator->fails()) {

        return $this->errorResponse($validator->errors(), 422);
    }

    {
        try {
       $collage_id = Collage::where('uuid', $request->uuid)->pluck('id');


       $data= Material::where('collage_id', $collage_id)->pluck('uuid','name');

            return $this->successResponse($data,$message='All Material');
        } catch (\Exception $ex) {
            return $this->errorResponse($ex->getMessage(), 500);
        }
    }}
}
