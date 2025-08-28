<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $tokenRecent = session('api_token');
        
        if (!$tokenRecent) {
            return redirect('/login');
        }
        // Riêng source mới xài (Mỗi lần reload lại page thì check xem còn login hay không, cách này chưa tối ưu do gọi đi gọi lại nhiều lần)
        // $response = Http::withToken($token)->get(env('API_URL') . '/check-login');
        // Do dùng chung source nên xài check kiểu này (Làm trước nhỡ sau này tách domain thì khỏi làm lại =)))))
        try {
            $payload = JWTAuth::setToken($tokenRecent)->authenticate();
            return $next($request);
        } catch (TokenExpiredException $e) {
           
        } catch (TokenInvalidException $e) {
           
        } catch (\Exception $e) {
           
        }
        return redirect('/login');
    }
}
