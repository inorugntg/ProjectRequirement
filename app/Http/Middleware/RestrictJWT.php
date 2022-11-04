<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\HelperPublic;
use App\Models\UserLog;

class RestrictJWT
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($payload = JWTAuth::parseToken()->getPayload()) {
            if ($payload->get('ipa') != md5($request->ip())) {
                $responseMessage = 'Origin IP tidak valid. Silahkan login kembali';
                $response = HelperPublic::helpResponse(403, [], $responseMessage, null);
                // UserLog::saveLog($response);
                return response()->json($response, 403);
            }

            if ($payload->get('ura') != md5($request->userAgent())) {
                $responseMessage = 'Origin user agent tidak valid. Silahkan login kembali';
                $response = HelperPublic::helpResponse(403, [], $responseMessage, null);
                // UserLog::saveLog($response);
                return response()->json($response, 403);
            }

            if ($payload->get('hst') != md5(gethostname())) {
                $responseMessage = 'Origin hostname tidak valid. Silahkan login kembali';
                $response = HelperPublic::helpResponse(403, [], $responseMessage, null);
                // UserLog::saveLog($response);
                return response()->json($response, 403);
            }
        } else {
            $responseMessage = 'Token anda tidak valid. Silahkan login kembali';
            $response = HelperPublic::helpResponse(403, [], $responseMessage, null);
            // UserLog::saveLog($response);
            return response()->json($response, 403);
        }

        return $next($request);
    }
}
