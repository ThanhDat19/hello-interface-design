
// was-validated: add class để show validate
// có lỗi validate thì gắn vào 
// <div class="invalid-feedback">
//    Please enter a num.
// </div>

const element_create = {
    image          : $('#card_image'),
    btn_upload_file: $('#btnUploadFileCard'),
    card_name      : $('#card_name'),
    card_type_id   : $('#card_type_id'),
    description    : $('#description'),
    attack_stat    : $('#attack_stat'),
    magic_stat     : $('#magic_stat'),
    defense_stat   : $('#defense_stat'),
    support_stat   : $('#support_stat'),
    dodge_stat     : $('#dodge_stat'),
    btn_create     : $('#btnCreate'),
    class_error    : $('.invalid-feedback'),
    form           : $('#cardForm'),
}
let fileCard = [];

element_create.card_type_id.select2({
    width     : "100%",
    allowClear: false,
});

function callBackUploadCard () {
    if (fileCard.length > 0) {
        let firstFile = fileCard[0];
        let reader = new FileReader();
        reader.onload = function (e) {
            element_create.image.attr('src', e.target.result);
        };
        reader.readAsDataURL(firstFile);
    } else {
        element_create.image.attr('src', IMAGE_EMPTY_URL);
    }
}

async function getDataCardType () {
    return new Promise((resolve) => {
        $.ajax({
            url: window.routes.get_data_card_type,
            method: "GET",
            success: function(result) {
                if (result.success) {
                    resolve({
                        success: true,
                        data   : result.data,
                    });
                }
                
            },
            fail: function () {
                resolve({
                    success: false,
                    data   : null
                });
            }
        })
    })
}
function createData () {
    element_create.class_error.text('');
    element_create.form.removeClass('was-validated');
    element_create.form.find('.form-control').removeClass('is-invalid');
    element_create.btn_create.prop('disabled', true);
    let data = new FormData(element_create.form[0]);
    $.each(fileCard, function(key,value) {
        data.append(`files[${key}]`, value);
    });
    $.ajax({
        url        : window.routes.post_create_card,
        method     : 'POST',
        data       : data,
        processData: false,
        contentType: false,
        success    : function (result) {
            element_create.btn_create.prop('disabled', false);

            if (result.code == 400) {
                Swal.fire({
                    title: SWAL.TITLE_ERROR,
                    text: SWAL.TEXT_VALIDATE_ERROR,
                    type: "error",
                    timer: 3000,
                });
                $.each(result.errors, function(key, value) {
                    $(`#error_${key}`).text(value[0]);
                    $(`#${key}`).addClass('is-invalid');
                })
            } else if (result.code == 500) {
                Swal.fire({
                    title: SWAL.TITLE_ERROR,
                    text: SWAL.TEXT_ERROR_SERVER,
                    type: "error",
                    timer: 3000,
                });
            } else if (result.code == 200) {
                Swal.fire({
                    title: SWAL.TITLE_SUCCESS,
                    text: SWAL.TEXT_CREATE_SUCCESS,
                    type: "success",
                    timer: 3000,
                }).then(() =>{
                     window.location.href = window.routes.page_card_index;
                });
               
            } else {
                Swal.fire({
                    title: SWAL.TITLE_ERROR,
                    text: result.messages,
                    type: "error",
                    timer: 3000,
                });
            }
        }
    }) 

}
async function loadDataCreate () {
    let response = await getDataCardType();
    if (response.success) {
        cardTypes = response.data;
        console.log(cardTypes);
        $.each(cardTypes, function(key, value) {
            element_create.card_type_id.append($('<option></option>').attr('value', value.card_type_id).text(value.card_type_name));
        })
    }
    
}
element_create.btn_upload_file.click(function (e) {
    _renderUploadFile(fileCard, callBackUploadCard);
})
element_create.btn_create.click(function (e) {
    e.preventDefault();
    createData();
})
$(document).ready(async function() {
    loadDataCreate();
})