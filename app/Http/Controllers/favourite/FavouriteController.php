<?php

namespace App\Http\Controllers\favourite;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Favorite;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FavouriteController extends Controller
{use GeneralTrait;
    public function add_question(Request $request){
        $validator = Validator::make($request->all(), [
            'uuid' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        $question_id=Question::where('uuid',$request->uuid)->first()->id;

        $user=Auth::id();
        Favorite::create([
               'question_id' => $question_id,
               'user_id'=>$user

        ]);
        return $this->successResponse([], 'the question has added successfully.');
    }
}
