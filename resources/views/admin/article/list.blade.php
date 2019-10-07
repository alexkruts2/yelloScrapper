@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('static/plugin/bootstrap-datepicker/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('static/plugin/bootstrap-daterangepicker/daterangepicker.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">文章列表</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                <li class="breadcrumb-item active">文章列表</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-2">
                            <label>分类</label>
                            <div class="controls">
                                <select class="form-control" id="category">
                                    <option value="0">全部</option>
                                    @foreach(\App\ArticleCategory::all() as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>地区</label>
                            <div class="controls">
                                <select class="form-control" id="country">
                                    <option value="0">全部</option>
                                    @foreach(\App\Country::all() as $country)
                                        <option value="{{$country->id}}">{{$country->name_cn}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>版权类型</label>
                            <div class="controls">
                                <select name="copyright_type" id="copyright_type" class="form-control">
                                    <option value="0">全部</option>
                                    <option value="1" {{isset($article) && $article->copyright_type == '1' ? 'selected' : ''}}>网络采集</option>
                                    <option value="2" {{isset($article) && $article->copyright_type == '2' ? 'selected' : ''}}>微信采集</option>
                                    <option value="3" {{isset($article) && $article->copyright_type == '3' ? 'selected' : ''}}>原创</option>
                                    <option value="4" {{isset($article) && $article->copyright_type == '4' ? 'selected' : ''}}>授权发布</option>
                                    <option value="5" {{isset($article) && $article->copyright_type == '5' ? 'selected' : ''}}>未知</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label>时间</label>
                            <div class="input-daterange input-group" id="date-range">
                                <input type="text" class="form-control" id="from"/>
                                <div class="input-group-append">
                                    <span class="input-group-text bg-info b-0 text-white">到</span>
                                </div>
                                <input type="text" class="form-control" id="to"/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label>操作</label>
                            <button class="btn btn-info" onclick="searchArticle()"><i class="ti-search"></i> 搜索</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblarticle" class="display nowrap table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">录入时间</th>
                                <th class="text-center">发布时间</th>
                                <th class="text-center">标题</th>
                                <th class="text-center">分类</th>
                                <th class="text-center">地区</th>
                                <th class="text-center">作者</th>
                                <th class="text-center">版权状态</th>
                                <th class="text-center">状态</th>
                                <th class="text-center">查看次数</th>
                                <th class="text-center">分享次数</th>
                                <th class="text-center">操作</th>
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
    <script src="{{ asset('static/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert/jquery.sweet-alert.custom.js') }}"></script>
    <script src="{{asset('static/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{ asset('static/js/pages/validation.js') }}"></script>
    <script src="{{ asset('static/admin/article.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $('#date-range').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            toggleActive: true
        });
    </script>
@endsection
