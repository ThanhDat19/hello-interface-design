@extends('admin.layout.blank')
@section('css')
<link rel="stylesheet" href="{{assetAdmin('css/pages/card.css')}}">
@endsection
@section('content')

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive active-projects style-1">
                <div class="tbl-caption">
                    <h4 class="heading mb-0">Thẻ</h4>
                    <div>
                        {{-- <a class="btn btn-primary btn-sm" data-bs-toggle="offcanvas" href="{{route('manager.card.create')}}" role="button" aria-controls="offcanvasExample" id="btnCreate">+ Thêm mới thẻ</a> --}}
                        <a class="btn btn-primary btn-sm" href="{{route('manager.card.create')}}" role="button" id="btnCreate">+ Thêm mới thẻ</a>
                    </div>
                </div>
                    <table id="card-table" class="table">
                        <thead>
                            <tr>
                                <th class="col-table col-table-main-01">Card ID</th>
                                <th class="col-table col-table-main-02">Tên thẻ</th>
                                <th class="col-table col-table-main-03">Loại thẻ</th>
                                <th class="col-table col-table-main-04">Mô tả</th>
                                <th class="col-table col-table-main-05">
                                    <div>Người tạo</div>
                                    <div>/ Người sửa</div>
                                </th>
                                <th class="col-table col-table-main-06">
                                    <div>Ngày tạo</div>
                                    <div>/ Ngày sửa</div>
                                </th>
                                <th class="col-table col-table-main-07">
                                    Chức năng
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script src="{{assetAdmin('js/pages/card/index.js')}}"></script>
@endsection