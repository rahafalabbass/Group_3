<?php

namespace App\Http\Controllers\collage;

use App\Http\Controllers\Controller;
use App\Models\Collage;
use Illuminate\Http\Request;
use App\Http\Resources\CollageResource;
use Illuminate\Support\Collection;
use App\Http\Traits\GeneralTrait;
use App\Models\Cycle;
use App\Models\Material;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class collageController extends Controller
{
    use GeneralTrait;
    public function allmajor()
    {


        $collages = Collage::all();

        return  CollageResource::Collection($collages);
    }


        public function majorfor(Request $request){

            $validator = Validator::make($request->all(), [
                'type' => 'required|boolean'
            ]);


            if ($validator->fails()) {

                return $this->errorResponse($validator->errors(), 422);
            }
            try{
                $collages=Collage::where('type',$request['type'])->get();
                return  CollageResource::Collection($collages);

            }catch (\Exception $ex) {

                return $this->errorResponse($ex->getMessage(), 500);
            }

        }
}
