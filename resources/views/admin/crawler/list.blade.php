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
            <h4 class="text-white">爬虫列表</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                <li class="breadcrumb-item active">爬虫列表</li>
            </ol>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body row">
                    <div class="table-responsive">
                        <table id="table" class="display nowrap table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">爬虫名</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('static/images/crawler/te.png')}}">Trading Economy</td>
                                    <td class="text-center">
                                        <button class="btn btn-info setting" data-crawler="te"><i class="ti-pencil-alt"></i> 设置</button>&nbsp;
                                        <button class="btn btn-cyan shenjian_ctrl_button"  data-crawler='te' id="btn_te"><i class='ti-control-play'></i>&nbsp;启动</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('/static/images/crawler/suburbprofile.png')}}">Suburb Profile
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-center">
                                        <button class="btn btn-info setting"  data-crawler="suburbprofile"><i class="ti-pencil-alt"></i> 设置</button>&nbsp;
                                        <button class="btn btn-cyan shenjian_ctrl_button"  data-crawler='suburbprofile' id="btn_suburbprofile"><i class='ti-control-play'></i>&nbsp;启动</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('/static/images/crawler/airbnb.png')}}">Airbnb
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-center">
                                        <button class="btn btn-info setting"  data-crawler="airbnb"><i class="ti-pencil-alt"></i> 设置</button>&nbsp;
                                        <button class="btn btn-cyan shenjian_ctrl_button"  data-crawler='airbnb' id="btn_airbnb"><i class='ti-control-play'></i>&nbsp;启动</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('/static/images/crawler/suburbprofile.png')}}">Realestate
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-center">
                                        <button class="btn btn-info setting"  data-crawler="realestate"><i class="ti-pencil-alt"></i> 设置</button>&nbsp;
                                        <button class="btn btn-cyan shenjian_ctrl_button"  data-crawler='realestate' id="btn_realestate"><i class='ti-control-play'></i>&nbsp;启动</button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-center"><img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('/static/images/crawler/weixin.png')}}">文章采集
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                    <td class="text-center">
                                        <button class="btn btn-info setting"  data-crawler="weixin"><i class="ti-pencil-alt"></i> 设置</button>&nbsp;
                                        <button class="btn btn-cyan shenjian_ctrl_button" data-crawler='weixin' id="btn_weixin"><i class='ti-control-play'></i>&nbsp;启动</button>
                                    </td>
                                </tr>
                            </tbody>
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
    <div id="weixin-setting-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="weixin-setting-form" method="post" novalidate>
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
    <script src="{{ asset('static/admin/crawler_list.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>

@endsection