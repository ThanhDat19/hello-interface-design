<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="{{assetUser('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('common/css/common.css')}}">
    <title>Đăng nhập</title>
</head>
<body>
    <main>
        <div>
            <form action="" id="loginForm">
                <div>
                    <span class="errors" id="error_wrong_login"></span>
                </div>
                <div>
                    <label for="email">Email</label>
                    <span class="errors" id="error_email"></span>
                    <input type="text" name="email" placeholder="User name" id="email">
                </div>
                <div>
                    <label for="password">Password</label>
                    <span class="errors" id="error_password"></span>
                    <input type="password" name="password" placeholder="Password" id="password">
                </div>
                <div>
                    <button type="submit" id="sendLogin">Login</button>
                </div>
            </form>
        </div>
    </main>
</body>
<script>
    API_URL = "{{env('API_URL')}}";
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script> --}}
<script src="{{assetUser('assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{asset('common/js/common.js')}}"></script>
<script src="{{asset('auth/pages/login.js')}}"></script>

</html>