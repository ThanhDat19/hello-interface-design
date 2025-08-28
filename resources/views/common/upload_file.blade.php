
<div class="modal fade modal-xl" id="modalUploadFile" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Tải hình ảnh</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div>
                <p>Click vào vùng trống bên dưới để tải hình ảnh lên</p>
                <p><span class="tips-upload-file">Tips: </span>Bạn có thể Copy hình ảnh rồi Paste vào hoặc có kéo thả vào vùng trống bên dưới</p>
            </div>
            <div class="row m-3">
                <div id="dropZone" class="upload-container d-flex justify-content-center align-items-center col-md-7">
                    <form>
                        <div class="d-flex flex-column align-items-center">
                            <i class="bi bi-cloud-upload icon-upload-file"></i>
                            <p class="box-content-upload">Tải file lên</p>
                        </div>
                    </form>
                </div>
                <div id="showFileUpload" class="col-md-5">
                    <div id="showImage" class="row">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-primary" id="btnUploadFile">Tải file</button>
        </div>
        </div>
    </div>
</div>
