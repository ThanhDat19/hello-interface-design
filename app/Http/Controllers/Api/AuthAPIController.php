<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;

class AuthAPIController extends Controller
{
   
    public function login(Request $request) {
        $data = [
            'email'    => $request->email,
            'password' => $request->password,
        ];
        $validator = $this->_validateLogin($data);
        
        if ($validator['status'] == false) {
            return response()->json([
                'status'   => 'error',
                'code'     => 400,
                'messages' => 'Dữ liệu không hợp lệ',
                'errors'   => $validator['errors'],
            ]);
        }


        try {
            $login_token = auth('api')->attempt($data);
            if (!$login_token) {
                return response()->json([
                    'status'  => 'error',
                    'code'    => 400,
                    'messages' => 'Dữ liệu không hợp lệ.',
                    'errors'  => [
                        'wrong_login' => ['Tên đăng nhập hoặc mật khẩu không chính xác.']
                    ]
                ]);
            }
            $user = User::where('email', $data['email'])->select('fullname', 'nickname', 'email', 'phone', 'role')->first();
            
            User::where('email', $user->email)->update([
                'access_token' => $login_token
            ]);
            return response()->json([
                'status'  => 'success',
                'code'    => 200,
                'messages' => 'Đăng nhập thành công',
                'data'    => [
                    'login_token' => $login_token,
                    'user'        => $user, 
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'   => 'error',
                'code'     => 500,
                'messages' => 'Lỗi, vui lòng liên hệ kỹ thuật']);
        }
    }
    private function _validateLogin($data = []) {
        
        $rules = [
            'email'    => 'bail|required',
            'password' => 'bail|required|min:6|max:20',
        ];

        $messages = [
            '*.required'   => ':attribute không được để trống',
            'password.min' => ':attribute không được nhỏ hơn :min ký tự',
            'password.max' => ':attribute không được lớn hơn :max ký tự',
        ];

        $attributes = [
            'email'    => 'Email',
            'password' => 'Mật khẩu',
        ];

        $validator = Validator::make($data, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return ['status' => false, 'errors' => $validator->errors()->toArray()];
        }

        return ['status' => true, 'errors' => []];
    }
    public function logout(Request $request) {
        
        try {
            $token = JWTAuth::parseToken()->authenticate();
            if ($token) {
                $user    = auth('api')->user();
                $user_id = $user->user_id;
                User::where('user_id', $user_id)->update([
                    'access_token' => null
                ]);
                return response()->json([
                    'status'  => 'success',
                    'code'    => 200,
                    'messages' => 'Đăng xuất thành công.'
                ]);
                // $user = json_decode(auth)
            }
            return response()->json([
                'status'  => 'error',
                'code'    => 500,
                'messages' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => 'error',
                'code'    => 500,
                'messages' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
            ]);
        }
    }
    public function checkLogin(Request $request) {
        try {
            $token       = JWTAuth::parseToken()->authenticate();
            $tokenRecent = $request->bearerToken();
            if ($token->access_token == $tokenRecent) {
                return response()->json([
                    'status'   => 'success',
                    'messages' => 'Token hợp lệ',
                ]);
            }
        }catch (\Throwable $th) {
            return response()->json([
                'status'  => 'error',
                'code'    => 500,
                'messages' => 'Có lỗi xảy ra. Vui lòng thử lại sau.'
            ]);
        }
    }
}
