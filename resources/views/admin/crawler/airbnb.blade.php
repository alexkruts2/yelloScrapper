@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">爬虫</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                <li class="breadcrumb-item active">爬虫 Airbnb</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <select class="selectpicker form-control" data-style="btn-info" id="state">
                                <option value="-1">全部</option>
                                @foreach(\App\State::whereHas('country',function($query){$query->where('name_en','Australia');})->orderBy('name_cn', 'asc')->get() as $state)
                                    <option value="{{$state->id}}">{{$state->name_cn}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-9 text-right">
                            <button class="btn btn-info" id="setting"><i class="ti-pencil-alt"></i> 设置</button>
                            <button class="btn btn-cyan" id="shenjian_ctrl_button"><i class="ti-control-play"></i>&nbsp;启动</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="table" class="display nowrap table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">房ID<br><small class="text-grey">Room ID</small></th>
                                <th class="text-center">标题<br><small class="text-grey">Title</small></th>
                                <th class="text-center">形态<br><small class="text-grey">Property Type</small></th>
                                <th class="text-center">客人数<br><small class="text-grey">Max Guest</small></th>
                                <th class="text-center">床房<br><small class="text-grey">Bed Room</small></th>
                                <th class="text-center">浴室<br><small class="text-grey">Bath Room</small></th>
                                <th class="text-center">纬度<br><small class="text-grey">Latitude</small></th>
                                <th class="text-center">经度<br><small class="text-grey">Longitude</small></th>
                                <th class="text-center">小区<br><small class="text-grey">Suburb</small></th>
                                <th class="text-center">价格<br><small class="text-grey">Price</small></th>
                                <th class="text-center">货币<br><small class="text-grey">Currency</small></th>
                                <th class="text-center">评价数<br><small class="text-grey">Review Count</small></th>

                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div id="setting-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="setting-form" method="post" novalidate>
                    <div class="modal-header">
                        <h4 class="modal-title">设置</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>Webhook URL</label>
                                <input type="text" class="form-control" name="webhook_url"  id="webhook_url" value="" placeholder="请输入Webhook URL ... ">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-12">
                                <label>源码</label>
                                <textarea class="form-control" name="source_code" id="source_code" rows="5"  placeholder="请输入源码 ... "></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                        <button type="submit" class="btn btn-success"><i class="ti-save"></i> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="{{ asset('static/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert/jquery.sweet-alert.custom.js') }}"></script>
    <script src="{{asset('static/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('static/js/pages/validation.js') }}"></script>
    <script src="{{ asset('static/admin/crawler_common.js') }}"></script>
    <script src="{{ asset('static/admin/airbnb.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>

@endsection