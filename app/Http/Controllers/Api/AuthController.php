<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Code;
use App\Models\Collage;
use Illuminate\Support\Str;





class AuthController extends Controller
{
    use GeneralTrait;

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required ',
            'number' => 'required',
            'uuid' => 'required'

        ]);


        if ($validator->fails()) {

            return $this->errorResponse($validator->errors(), 422);
        }
        try {
          $check_name=  User::where('name',$request['name'])->first();
          if ($check_name) {
            return $this->errorResponse('The name already exists', 400);
        }
          $check_number=  User::where('number',$request['number'])->first();
          if ($check_number) {
            return $this->errorResponse('The number already exists', 400);
        }
            $collage_id = Collage::where('uuid', $request['uuid'])->first()->id;
                  $code = (string)random_int(100000, 999999);


            $user = User::create([
                'name' => $request->name,
                'number' => $request->number,
                'collage_id' => $collage_id,
                'code' => $code

            ]);
            return $this->successResponse([], 'Registered Successfully.');
        } catch (\Exception $ex) {

            return $this->errorResponse($ex->getMessage(), 500);
        }
    }


    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:12',
            'code' => 'required|max:6'
        ]);


        if ($validator->fails()) {

            return $this->errorResponse($validator->errors(), 422);
        }

        try {

            //  return $this->successResponse([],'User has logged in successfully.');
            $info1 = User::where('name', $request['name'])->first();
            if(is_null($info1))  {
                return $this->errorResponse('The name  uncorrect', 400);
            }
            $info2 = User::where('code', $request['code'])->first();
            if(!$info2){
                return $this->errorResponse('The code  uncorrect', 400);
            }

            if($info1 != $info2){
                return $this->errorResponse('The name or code uncorrect', 400);
            }
          $collage=$info1->collage;


            $data['name'] = $info1->name;
            $data['specialization'] =$collage->name;
            $data['collage'] = $collage->type;
            $data['url'] = str_replace('"', '',asset('users/'. $info1->url));
            $data['token'] = $info1->createToken('MyApp')->plainTextToken;

            return $this->successResponse($data, 'User has logged in successfully.');
        } catch (\Exception $ex) {
            return $this > $this->errorResponse('The name or code uncorrect', 400);
        }
    }


    public function logout(Request $request)
    {
        auth('sanctum')->user()->tokens()->delete();

        return $this->successResponse([], 'User has logged out successfully.');
    }
}




// $user = DB::table('users')   example one
//                 ->latest()
//                 ->first();


//  $user = User::orderBy('id', 'DESC')->first(); example two


// $user = User::get()->latest();            example three
