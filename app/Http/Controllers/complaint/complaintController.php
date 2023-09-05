<?php

namespace App\Http\Controllers\complaint;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Complaint;
use Illuminate\Support\Str;

class complaintController extends Controller
{
    use GeneralTrait;
   public function addComplaint(Request $request){

    $validator = Validator::make($request->all(), [
        'body' => 'required|max:255'
    ]);

    if ($validator->fails()) {

        return $this->errorResponse($validator->errors(), 422);
    }
try{
   $user_id= Auth::id();
   Complaint::create([

    'user_id'=> $user_id,
    'uuid'=>Str::uuid()->toString(),
    'body' => $request->body

   ]);
   return response()->json([
   'The complaint has been added successfully'
   ]);
} catch (\Exception $ex) {

    return $this->errorResponse($ex->getMessage(), 500);
}
   }
}
