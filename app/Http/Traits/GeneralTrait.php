<?php
namespace App\Http\Traits;
trait GeneralTrait{

    protected function successResponse($data, $message = null, $code = 200)
    {
        return response()->json([
            'status'=> 'Success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message = null, $code)
    {
        return response()->json([
            'status'=>'Error',
            'message' => $message,
            'data' => null
        ],$code);
    }

    protected function success($data,$answers, $message = null, $code = 200)
    {
        return response()->json([

            'message' => $message,
              'الاسئلة'=>[[
        'السؤال' => $data['body'],
        // 'الخيارات' => [ $answers['الخيارات']

        // ]
                                    ]]
        ], $code);
    }




}
