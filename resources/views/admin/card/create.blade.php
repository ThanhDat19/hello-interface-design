@extends('admin.layout.blank')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Thêm mới thẻ</h4>
            </div>
            <div class="card-body">
                <div class="form-validation">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="row">
                                <div class="blog-img">
                                    <img src="{{asset('common/image/empty_img.png')}}" alt="" class="blk-img" id="card_image">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <button type="button" class="btn btn-primary" id="btnUploadFileCard">Tải ảnh lên</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-xl-8">
                            <form id="cardForm">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label class="col-lg-4 col-form-label" for="card_name">Tên thẻ<span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="card_name" name="card_name" placeholder="Nhập tên thẻ">
                                                        <div class="invalid-feedback" id="error_card_name"></div>
                                            
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label class="col-lg-4 col-form-label" for="card_type_id">Loại thẻ</label>
                                                        <select class="form-control select2_cardType" id="card_type_id" name="card_type_id" placeholder="" data-allow-clear="false">
                                                        </select>
                                                        <div class="invalid-feedback" id="error_card_type_id"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="row">
                                                    <div class="mb-3">
                                                        <label class="col-form-label" for="description">Mô tả</label>
                                                        <textarea name="description" class="form-control" id="description" name="description" rows="6"></textarea>
                                                        <div class="invalid-feedback" id="error_description"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="attack_stat">Attack</label>
                                                <input type="number" class="form-control number" name="attack_stat" id="attack_stat" name="attack_stat" placeholder="">
                                                <div class="invalid-feedback" id="error_attack_stat"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="magic_stat">Magic</label>
                                                <input type="number" class="form-control number" id="magic_stat" name="magic_stat" placeholder="">
                                                <div class="invalid-feedback" id="error_magic_stat"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="defense_stat">Defense</label>
                                                <input type="number" class="form-control number" id="defense_stat" name="defense_stat" placeholder="">
                                                <div class="invalid-feedback" id="error_defense_stat"></div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="support_stat">Support</label>
                                                <input type="number" class="form-control number" id="support_stat" name="support_stat" placeholder="">
                                                <div class="invalid-feedback" id="error_support_stat"></div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label class="col-form-label" for="dodge_stat">Dodge</label>
                                                <input type="number" class="form-control number" id="dodge_stat" name="dodge_stat" placeholder="">
                                                <div class="invalid-feedback" id="error_dodge_stat"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <button type="button" class="btn btn-primary" id="btnCreate">Thêm mới</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('common.upload_file')
@endsection
@section('scripts')
<script src="{{asset('common/js/upload-file.js')}}"></script>
<script src="{{assetAdmin('js/pages/card/create.js')}}"></script>
@endsection