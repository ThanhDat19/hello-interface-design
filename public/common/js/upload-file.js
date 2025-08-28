let   filesList            = [];
let   callBackUpload       = null;
const elements_upload_file = {
    modal                  : $('#modalUploadFile'),
    drop_zone              : $("#dropZone"),
    show_img_zone          : $("#showImage"),
    class_icon_delete_image: $(".icon-delete-file"),
    btn_upload_file        : $('#btnUploadFile'),
};


function _renderUploadFile(refFileList, callBackFn = null) {
    filesList = refFileList;
    elements_upload_file.modal.modal('show');
    callBackUpload = callBackFn;
}
elements_upload_file.modal.on('shown.bs.modal', function (e) {
    $.each(filesList, function (i, file) {
        let reader = new FileReader();
        reader.onload = function (e) {
            elements_upload_file.show_img_zone.append(
                `
                <div class="img-item">
                    <img src="${e.target.result}" class="img-fluid">
                    <i class="bi bi-trash trash-icon icon-delete-file" onclick="removeFile(this, filesList, ${file.id})"></i>
                </div>
                `
            );
        };
        reader.readAsDataURL(file);
    });
});
elements_upload_file.modal.on('hidden.bs.modal', function (e) {
    elements_upload_file.show_img_zone.html('');
});

$(document).on("dragover drop", function (e) {
    e.preventDefault();
    e.stopPropagation();
});

elements_upload_file.drop_zone.on("dragover", function () {
    $(this).addClass("bg-info text-white");
}).on("dragleave", function () {
    $(this).removeClass("bg-info text-white");
}).on("drop", function (e) {
    $(this).removeClass("bg-info text-white");
    let files = e.originalEvent.dataTransfer.files;
    handleFiles(files);
});


$(document).on("paste", function (e) {
    let items = e.originalEvent.clipboardData.items;
    for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf("image") !== -1) {
            let file = items[i].getAsFile();
            handleFiles([file]);
        }
    }
});

function handleFiles(files) {
    $.each(files, function (i, file) {
        file.id = Date.now() + Math.random();
        filesList.push(file);
        let reader = new FileReader();
        reader.onload = function (e) {
            elements_upload_file.show_img_zone.append(
                `
                <div class="img-item">
                    <img src="${e.target.result}" class="img-fluid">
                    <i class="bi bi-trash trash-icon icon-delete-file" onclick="removeFile(this, filesList, '${file.id}')"></i>
                </div>
                `
            );
        };
        reader.readAsDataURL(file);
        

    });
}
function removeFile(e, filesListRemove = [], id) {
    let index = filesListRemove.findIndex((file) => file.id == id);
    if (index !== -1) {
        filesListRemove.splice(index, 1);
        $(e).closest(".img-item").remove();
    }
}
elements_upload_file.btn_upload_file.on('click', function (e) {
    elements_upload_file.modal.modal('hide');
    callBackUpload();
})
// $('#btnUploadFile').on('click', function (e) {
//     e.preventDefault()
//     let formData = new FormData();
    
//     filesList.forEach((item, index) => {
//         formData.append(`files[${index}]`, item);
//     });
//     $.ajax({
//         url        : 'http://127.0.0.1:8000/api/upload-file-demo',
//         method     : 'POST',
//         data       : formData,
//         processData: false,
//         contentType: false,
//         success    : function (result) {
            
//         }
//     })

// })