<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $token = JWTAuth::parseToken()->authenticate();
            if ($token) {
                $user_id     = $token->user_id;
                $token_login = JWTAuth::getToken();
                $userLogin   = User::where('access_token', $token_login)->first();
                if (!empty($userLogin)) {
                    if (auth('api')->user()->user_id != $userLogin->user_id) {
                        return response()->json([
                            'status'      => 'error',
                            'messages'     => 'Sai thông tin đăng nhập',
                            'status_code' => '-5',
                        ]);
                    }
                } else {
                    $user = User::find($user_id);
                    if (!$user->access_token) {
                        return response()->json([
                            'status'      => 'error',
                            'messages'     => 'Phiên đăng nhập hết hạn',
                            'status_code' => '-4',
                        ]);
                    } else {
                        return response()->json([
                            'status'      => 'error',
                            'messages'     => 'Có thiết bị khác đang sử dụng tài khoản này',
                            'status_code' => '-6',
                        ]);
                    }
                }
            } else {
                return response()->json([
                    'status'      => 'error',
                    'messages'     => 'Phiên đăng nhập hết hạn',
                    'status_code' => '-4',
                ]);
            }
        } catch (Exception $e) {
             if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'status' => 'error',
                    'messages' => 'Token không hợp lệ',
                    'status_code' => '-1',
                ]);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'status' => 'error',
                    'messages' => 'Token đã hết hạn',
                    'status_code' => '-2',
                ]);
            } else{
                return response()->json([
                    'status' => 'error',
                    'messages' => 'Token không được tìm thấy',
                    'status_code' => '-3',
                ]);
            }
        }
        return $next($request);
    }
}
