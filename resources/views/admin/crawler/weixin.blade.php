@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('static/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">爬虫</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                <li class="breadcrumb-item active">爬虫微信文章</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
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
                                <th class="text-center">标题<br><small class="text-grey">Article Title</small></th>
                                <th class="text-center">作者<br><small class="text-grey">Article Author</small></th>
                                <th class="text-center">微信公众号名称<br><small class="text-grey">Weixin Nickname</small></th>
                                <th class="text-center">是否原创<br><small class="text-grey">Original</small></th>
                                <th class="text-center">公众号头像<br><small class="text-grey">Weixin Avatar</small></th>
                                <th class="text-center">发布时间<br><small class="text-grey">Publish Time</small></th>
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
                        <div class="row form-group col-12">
                            <label>App ID</label>
                            <input type="text" class="form-control" name="app_id"  id="app_id" value="" placeholder="请输入App ID ... ">
                        </div>
                        <div class="row form-group col-12">
                            <label>Webhook URL</label>
                            <input type="text" class="form-control" name="weixin_webhook_url"  id="weixin_webhook_url" value="" placeholder="请输入Webhook URL ... ">
                        </div>
                        <div class="form-group row col-12">
                            <div class="tags-default">
                                <input type="text" value="Amsterdam,Washington,Sydney" data-role="tagsinput"  name="users" id="users" placeholder="add tags" />
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
    <script src="{{asset('static/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('static/js/pages/validation.js') }}"></script>
    <script src="{{ asset('static/admin/crawler_common.js') }}"></script>
    <script src="{{ asset('static/admin/weixin.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>

@endsection
