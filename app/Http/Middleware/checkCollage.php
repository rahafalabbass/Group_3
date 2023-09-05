<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Collage;
use Illuminate\Support\Facades\Auth;
class checkCollage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         $collageId = Collage::where('uuid', $request->uuid)->pluck('id');

        $user = Auth::user();

        if($collageId[0] == $user->collage_id){

            return $next($request);

        }
        else{
            return response()->json(
             ['message'=>   'you are unregister in this specialization']);
        }
    }
}
