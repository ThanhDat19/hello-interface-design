<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function login(Request $request) {
        $tokenRecent = session('api_token');
        // Riêng source mới xài (Mỗi lần reload lại page thì check xem còn login hay không, cách này chưa tối ưu do gọi đi gọi lại nhiều lần)
        // $response = Http::withToken($tokenRecent)->get(env('API_URL') . '/check-login');
        // Do dùng chung source nên dùng cái này (Làm trước nhỡ sau này tách domain thì khỏi làm lại =)))))
        $user = session('user');

        try {
            $payload = JWTAuth::setToken($tokenRecent)->authenticate();
            return redirect('/');
        } catch (TokenExpiredException $e) {
           
        } catch (TokenInvalidException $e) {
           
        } catch (\Exception $e) {
           
        }
        return view('auth.login');
    }
    public function saveToken(Request $request) {
        session(['api_token' => $request->token]);
        session(['user' => $request->user]);
        return response()->json(['ok' => true]);
    }
}
