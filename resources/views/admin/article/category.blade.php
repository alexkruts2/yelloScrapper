@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">文章分类</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                <li class="breadcrumb-item active">文章分类</li>
            </ol>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-primary" onclick="showCategoryModal(true)"><i class="ti-plus"></i> 新增</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="tblcategory" class="display nowrap table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th class="text-center">分类名称</th>
                                <th class="text-center">文章数</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(\App\ArticleCategory::all() as $category)
                            <tr>
                                <td class="text-center">{{$category->name}}</td>
                                <td class="text-center">{{$category->articles()->count()}}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-info" onclick="showCategoryModal(false, {{$category->id}}, this)"><i class="ti-pencil-alt"></i></button>
                                    <button class="btn btn-sm btn-danger" onclick="deleteCategory({{$category->id}}, this)"><i class="ti-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="category-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">文章分类</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="category-form" novalidate>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> 分类名称 : <span class="text-danger">*</span> </label>
                            <div class="controls">
                                <input type="text" class="form-control" id="category_name" name="name" required data-validation-required-message="必填" value="" placeholder="请输入分类名...">
                            </div>
                        </div>

                        <input id="category_id" name="category_id" type="hidden" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger"><i class="ti-save"></i> 保存</button>
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
    <script src="{{ asset('static/admin/article.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>
@endsection