const SWAL = {
    TITLE_SUCCESS      : 'Thành công',
    TEXT_CREATE_SUCCESS: 'Thêm dữ liệu thành công',
    TEXT_UPDATE_SUCCESS: 'Cập nhật dữ liệu thành công',
    TITLE_ERROR        : 'Lỗi',
    TEXT_VALIDATE_ERROR: 'Dữ liệu không hợp lệ',
    TEXT_ERROR_SERVER  : 'Lỗi! Vui lòng liên hệ Admin',
}
const IMAGE_EMPTY_URL = "/common/image/empty_img.png";
$.ajaxSetup({
    headers: {
        'Authorization': 'Bearer ' + sessionStorage.getItem('api_token'),
    },
    beforeSend: function() {
        
    },
    complete: function(result) {
        console.log("Setup oke");
        var data = result.responseJSON;
        if (['-1', '-2', '-3', '-4', '-5', '-6'].includes(data.status_code)) {
            window.location.href ="/login";
        }
    }
});
$(document).on('xhr.dt', function(e, settings, json, xhr) {
    console.log("Global DataTables xhr:", json);

    if (json && ['-1','-2','-3','-4','-5','-6'].includes(json.status_code)) {
        window.location.href = "/login";
    }
});
function formatedDate (date = '', format = "DD/MM/YYYY") {
    if (date =='' || !date) {
        return '';
    }
    return moment(date).format(format);
}