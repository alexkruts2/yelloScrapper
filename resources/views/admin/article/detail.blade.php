@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('static/plugin/dropify/dist/css/dropify.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <link href="{{asset('static/plugin/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('static/plugin/summernote/dist/summernote-bs4.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">{{isset($article) ? '文章详情' : '新建文章'}}</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                @if(isset($article))
                <li class="breadcrumb-item"><a href="/admin/article">文章列表</a></li>
                <li class="breadcrumb-item active">文章详情</li>
                @else
                <li class="breadcrumb-item active">新建文章</li>
                @endif
            </ol>
        </div>
    </div>
    <form id="article-form" novalidate>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success" onclick="saveArticle()"><i class="ti-save"></i> 保存</button>
                            <button type="button" class="btn btn-info" onclick="showPreviewModal()"><i class="ti-check"></i> 预览</button>
                            @if(!isset($article))
                            <button type="button" class="btn btn-warning" onclick="showImportModal()"><i class="ti-download"></i> 导入</button>
                            @endif
                        </div>
                        @if(isset($article))
                        <div class="col-md-6 text-right m-t-10">
                            <input type="checkbox" {{isset($article) && $article->is_published ? 'checked' : ''}} class="js-switch" name="is_published" data-color="#009c75" data-size="small" onchange="publish()" />
                            <label class="m-r-20">发布</label>
                            <input type="checkbox" {{isset($article) && $article->is_top ? 'checked' : ''}} class="js-switch" name="is_top" data-color="#f62d51" data-size="small" onchange="setTop()"/>
                            <label class="m-r-20">置顶</label>
                            <input type="checkbox" {{isset($article) && !$article->is_whitelabelled ? '' : 'checked'}} class="js-switch" name="is_whitelabelled" data-color="#ffbc34" data-size="small" onchange="setWhiteLabel()"/>
                            <label>品牌信息声明</label>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-body">
                        <div class="form-group row m-b-40">
                            <label> 文章首要缩略图 </label>
                            <input type="file" id="head_pic" name="head_pic" class="dropify" data-height="180" data-default-file="{{isset($article) && !is_null($article) && !is_null(\App\Image::findByName($article->head_pic)) ? \App\Image::findByName($article->head_pic)->base_url . '/' . $article->head_pic : ''}}"/>
                        </div>
                        <hr>
                        <div class="form-group m-t-30">
                            <label> 文章标题 : <span class="text-danger">*</span> </label>
                            <div class="controls">
                                <input type="text" class="form-control" id="name" name="name" required data-validation-required-message="必填" value="{{isset($article) ? $article->name : ''}}"> </div>
                        </div>
                        <div class="form-group m-b-40">
                            <label> 短描述（Meta Description） : <span class="text-danger">*</span> </label><br>
                            <small>此短描述在前端，仅在分享卡片中出现。主要用于SEO目的。</small>
                            <div class="controls m-t-10">
                                <input type="text" class="form-control" id="lite_des" name="lite_des" required data-validation-required-message="必填" value="{{isset($article) ? $article->lite_des : ''}}"> </div>
                        </div>
                        <hr>
                        <div class="form-group row m-t-30">
                            <div class="col-md-4">
                                <label> 文章分类</label>
                                <div class="controls">
                                    <select name="category_id" id="category_id" required data-validation-required-message="必填" class="form-control">
                                        @foreach(\App\ArticleCategory::all() as $category)
                                            <option value="{{$category->id}}" {{isset($article) && $article->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <label> 标签（每个标签最长5个字）</label>
                                <div class="controls">
                                    <input id="tags" name="tags" type="text" class="form-control" value="{{ isset($article) ? $article->tags : '' }}" data-role="tagsinput" placeholder="输入标签..." />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> 来源链接（请复制原文的URL链接）</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="source_url" name="source_url" value="{{isset($article) ? $article->source_url : ''}}"> </div>
                        </div>
                        <div class="form-group row m-b-40">
                            <div class="col-md-6">
                                <label> 作者 : <span class="text-danger">*</span> </label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="author" name="author" required data-validation-required-message="必填" value="{{isset($article) ? $article->author : ''}}"> </div>
                            </div>
                            <div class="col-md-6">
                                <label> 版权类型</label>
                                <div class="controls">
                                    <select name="copyright_type" id="copyright_type" class="form-control" onchange="changeCopyrightType()">
                                        <option value="1" {{isset($article) && $article->copyright_type == '1' ? 'selected' : ''}}>网络采集</option>
                                        <option value="2" {{isset($article) && $article->copyright_type == '2' ? 'selected' : ''}}>微信采集</option>
                                        <option value="3" {{isset($article) && $article->copyright_type == '3' ? 'selected' : ''}}>原创</option>
                                        <option value="4" {{isset($article) && $article->copyright_type == '4' ? 'selected' : ''}}>授权发布</option>
                                        <option value="5" {{isset($article) && $article->copyright_type == '5' ? 'selected' : ''}}>未知</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group row m-t-30">
                            <div class="col-md-6">
                                <label> 国家 : </label>
                                <div class="controls">
                                    <select name="country_id" id="country_id" class="form-control" onchange="changeCountry()">
                                        @foreach(\App\Country::all() as $country)
                                            <option value="{{$country->id}}" {{isset($article) && $article->country_id == $country->id ? 'selected' : ''}}>{{$country->name_cn}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> 州/省/地区 : </label>
                                <div class="controls">
                                    <select name="state_id" id="state_id" class="form-control" onchange="changeState()">
                                        <option value="0">--请选择州/省/地区--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> 城市 : </label>
                            <div class="controls">
                                <select name="city_id" id="city_id" class="form-control">
                                    <option value="0">--请选择城市--</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <label>公众号设置 <a class="get-code" data-toggle="collapse" href="#official" aria-expanded="true"><i class="fa fa-code"></i></a></label>
                        <div class="collapse" id="official" aria-expanded="true">
                            <div class="form-group m-t-30 official">
                                <label> 头像 </label>
                                <input type="file" id="official_avatar" name="official_avatar" class="dropify" data-height="180" data-default-file="{{isset($article) && !is_null($article->official_avatar) ? \App\Image::findByName($article->official_avatar)->base_url . '/' . $article->official_avatar : ''}}"/>
                            </div>
                            <div class="form-group official">
                                <label> 名称</label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="official_name" name="official_name" value="{{isset($article) ? $article->official_name : ''}}"> </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="hash" name="hash" value="{{isset($article) ? $article->hash : ''}}">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <label> 文章正文内容</label>
                    <textarea name="content" id="content" rows="10" cols="80">{{isset($article) ? $article->content : ''}}</textarea>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <label> 文章长描述</label><br>
                    <small>请复制文章正文内容的一部分，作为长描述的内容。主要应用在文章分享时的“封闭→注册→获客”场景。</small>
                    <div class="controls m-t-10">
                        <textarea class="form-control" id="full_des" name="full_des">{{isset($article) ? $article->full_des : ''}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <div id="preview-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">文章预览</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="article-preview" style="padding: 0 20px 0 40px;">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
    <div id="import-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">导入文章</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="import-form" novalidate>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> 文章地址 : <span class="text-danger">*</span> </label>
                            <div class="controls">
                                <input type="text" class="form-control" id="import_url" name="import_url" required data-validation-required-message="必填" value="" placeholder="请输入文章地址。。。">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">取消</button>
                        <button type="submit" class="btn btn-danger waves-effect waves-light">导入</button>
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
    <script src="{{asset('static/plugin/dropify/dist/js/dropify.min.js')}}"></script>
    <script src="{{asset('static/plugin/switchery/dist/switchery.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('static/plugin/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('static/js/pages/validation.js') }}"></script>
    <script src="{{ asset('static/admin/article.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                default: ''
            }
        });
        changeCountry();

        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
        $('#full_des').summernote({
            height: 300, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
        $('#content').summernote({
            height: 600, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
    </script>
@endsection
