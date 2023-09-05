<?php

namespace App\Http\Controllers\users;
use App\Models\User;
use App\Models\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{

    public function showProfile(){
        $user = Auth::user();
        return response()->json($user);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->input('name');

        if ($request->hasFile('profile_picture')){

            $validator = Validator::make($request->all(), [
                'image' => 'image|max:5000', // Max size is 5 MB
            ]);
        if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 400);
            }
        }



        $user = User::findOrFail(Auth::id());

        $image = $this->uploadImage($request, $user, 'profile_picture');

        if ($image) {
            $user->image()->save(new Image(['url' => $image]));

            return $this->successResponse($user, 'Profile image updated successfully', 200);
        } else {
            return $this->errorResponse('Failed to upload image', 500);
        }
    }
}
