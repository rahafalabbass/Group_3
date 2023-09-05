<?php

namespace App\Http\Controllers\questions;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cycle;
use App\Http\Resources\CycleResource;
use App\Http\Traits\GeneralTrait;
use App\Models\Material;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use App\Http\Resources\CollageResource;
use App\Http\Resources\infoResource;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\QuestionCollection;
use App\Models\Collage;
use Hamcrest\Core\IsTypeOf;
use SebastianBergmann\Type\Type;
use App\Http\Resources\bankResource;
use App\Http\Resources\correctResource;
use PhpParser\Node\Stmt\Return_;

use function PHPUnit\Framework\stringContains;

class QuestionController extends Controller
{
    use GeneralTrait;



    public function all_cycles(Request $request)
    {
            $validator = Validator::make($request->all(), [
                'uuid' => 'required|max:4',
                'is-master' =>'required|boolean'
            ]);
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 422);
            }

            try {
                $material = Material::where('uuid', $request['uuid'])->first();
                if (!$material) {
                    return $this->errorResponse('Undefined uuid', 422);
                }
                $material_id=$material->id;
                $cycles_nums = Material::findOrFail($material_id)->questions->where('is-master', $request['is-master'])->whereNotNull('year')->pluck('year');

                return $this->successResponse($cycles_nums, 'All Cycles .');
            } catch (\Exception $ex) {
                return $this > $this->errorResponse('The name or code uncorrect', 400);
            }
        }



    public function all_cycle_questions(Request $request){


                $validator = Validator::make($request->all(), [
            'uuid' => 'required|max:4',
            'is-master' => 'required|boolean',
            'year' => 'required|max:4'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 422);
        }

        try {
            $material = Material::where('uuid', $request['uuid'])->first();
            if (!$material) {
                return $this->errorResponse('Undefined uuid', 422);
            }
            $material_id=$material->id;
               $cycles_nums = Material::findOrFail($material_id)->questions->where('is-master', $request['is-master'])->where('year',$request['year'])->take(50);
               return  QuestionResource::Collection($cycles_nums);
        } catch (\Exception $ex) {
            return $this > $this->errorResponse('The name or code uncorrect', 400);
        }
    }

    public function book_questions(Request $request){


        $validator = Validator::make($request->all(), [
        'uuid' => 'required|max:4',
        'is-master' => 'required|boolean',
    ]);
    if ($validator->fails()) {
    return $this->errorResponse($validator->errors(), 422);
    }

    try {
    $material = Material::where('uuid', $request['uuid'])->first();
    if (!$material) {
        return $this->errorResponse('Undefined uuid', 422);
    }
    $material_id=$material->id;
       $book_question = Material::findOrFail($material_id)->questions->where('is-master', $request['is-master'])->whereNull('year')->take(50);
       return  QuestionResource::Collection($book_question);
    } catch (\Exception $ex) {
    return $this > $this->errorResponse('The name or code uncorrect', 400);
        }

}
public function collage_cycles(Request $request)
 {

try{
   $collage_id = Auth::user()->collage->id;
      $ss= Collage::find($collage_id)->materials()->pluck('id')->toArray();
      $dd=   Material::whereIn('id',$ss)->get();
      return  infoResource::Collection($dd);

}catch (\Exception $ex) {
    return $this->errorResponse($ex->getMessage(), 500);
}

}

public function bank_questions(Request $request){
    try{
        $validator = Validator::make($request->all(), [
            'is_master' => 'required|boolean',
        ]);
        if ($validator->fails()) {
        return $this->errorResponse($validator->errors(), 422);
        }
        $collage_id = Auth::user()->collage->id;
           $materials= Collage::find($collage_id)->materials()->get();
          // $material_info=   Material::whereIn('id',$material_ids)->get();
           return  bankResource::Collection($materials);

     }catch (\Exception $ex) {
         return $this->errorResponse($ex->getMessage(), 500);
     }
}

public function Question_corrector(Request $request){

        $data = $request->toArray();
        $counter=0;
        $true=0;
        $false=0;
        $result=[];
        foreach ( $data as $key => $value) {

            $question= Question::where('uuid',$key)->first();
            $answers= Question::find($question->id)->answers;
            $correctAnswer= $answers->where('is_correct',1)->first();
               if($correctAnswer->uuid == $value){
                $counter+= $question->degree;
                $true++;
                continue;
               }
               $false++;

            //    $uncorrect[$question->body]= CycleResource::collection($$answers);
            $result[]=[
                'uuid_question' =>$question->uuid,
                'question text' =>$question->body,
                'answers'=>CycleResource::collection($answers),
                'incorrect answer'=> $value
            ];

        }
        $data_req[]=[
            'عدد الاسئلة الصحيحة'=>$true,
            'عدد الاسئلة الغلط'=>$false,
            'علامتك هي'=>$counter,
            'data'=>$result,
        ];


       return $this->successResponse($data_req, 'the result .');



}



}


