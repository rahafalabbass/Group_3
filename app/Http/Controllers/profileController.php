<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Traits\GeneralTrait;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
class profileController extends Controller
{
use GeneralTrait;
    public function update_profile(Request $request)
    {$validator = Validator::make($request->all(), [
        'name' => 'required',
        'number' => 'required',


    ]);


    if ($validator->fails()) {
        return $this->errorResponse($validator->errors(), 422);
    }

        if($request->hasfile('url'))
        {
            $info=Auth::user();
            $image_name = $info->url;
            $image_path = public_path('users/'.$image_name);
            if(File::exists($image_path)) {
              File::delete($image_path);
            }

            $file=$request->file('url');
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('users/',$filename);

        }

            try{
                // $user = User::find(Auth::id())->update($request->all());
                $user =Auth::user();
                if($user->name != $request->name){
                $nameExists = DB::table('users')
                ->where('name',$request->name)
                ->exists();
                if($nameExists){
                    return $this->errorResponse('the name is already exists', 422);

                }
                else{
                    $user->name=$request->name;
                }}

                if($user->number != $request->number){
                    $nameExists = DB::table('users')
                    ->where('number',$request->number)
                    ->exists();
                   
                    if($nameExists){
                        return $this->errorResponse('the number is already exists', 422);

                    }
                    else{
                        $user->number=$request->number;
                    }}
                    $user->url = $filename;
                    $user ->save();

                $data['name'] = $user->name;
                $data['specialization'] =$user->collage->name;
                $data['collage'] = $user->collage->type;
                $data['url'] = str_replace('"', '',asset('users/'. $user->url));

                return $this->successResponse($data, 'The changes have updated successfully.');
            }catch (\Exception $ex){
                return $this->errorResponse($ex->getMessage(), 500);
            }

        return response()->json(['response'=>['code'=>'200','message'=>'تم تعديل البيانات بنجاح',]]);
    }
}



            //   $info=Auth::user();

            //     $path = $request->fileName->saveAs('public/images');
            //     $name = $request->fileName->getClientOriginalName();
            //     $user = User::findOrFail(Auth::id())->update(['name'=>$info->name,
            //     'number'=>$info->number,
            //     'collage_id'=>$info->collage_id,
            //     'code'=>$info->code,
            //                     'url' => $path
            //                 ]);
