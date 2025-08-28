const element_login = {
    form          : $("#loginForm"),
    email         : $("#email"),
    password      : $("#password"),
    send_login    : $("#sendLogin"),
    url_login     : (API_URL + "/login"),
    url_save_token: "/save-token",
}

element_login.send_login.on('click', function(e) {
    e.preventDefault();
    let data = {
        email   : element_login.email.val(),
        password: element_login.password.val(),
    };
    $(".errors").text('');
    $.ajax({
        url   : element_login.url_login,
        data  : data,
        method: "POST",
        success: async function (response) {
            if (response.code == 200) {
                var token = response.data.login_token;
                var user  = response.data.user;
                sessionStorage.setItem('api_token', response.data.login_token);
                sessionStorage.setItem('user_auth', JSON.stringify(response.data.user));
                dataResponse = await  _saveToken(token, JSON.stringify(user));
                if (dataResponse.success) {
                    if (user.role == 1) {
                        window.location.href = "/manager";
                    } else {
                        window.location.href = "/";
                    }
                }
            } else if (response.code == 400 || response.code == 500) {
                Swal.fire({
                    icon: "error",
                    title: SWAL.TITLE_ERROR,
                    text: response.messages,
                });
                if (response.errors) {
                    $.each(response.errors,function(index,value){
                        element_login.form.find(`#error_${index}`).text(value[0]);
                    })
                }
            }
            
        }
    })
})
async function _saveToken(token, user) {
    return new Promise(async (resolve, reject) => {
        $.ajax({
            url   : element_login.url_save_token,
            data  : {
                token: token,
                user: user},
            method: "GET",
            success: function (response){
                if (response.ok) {
                    resolve({
                        success: true,
                    });
                }
            },
            error: function (response) {
                resolve({
                    success: false,
                });
            }
        });
    })
    
}

