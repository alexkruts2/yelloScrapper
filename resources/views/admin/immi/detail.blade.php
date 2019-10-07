@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link href="{{asset('static/plugin/dropify/dist/css/dropify.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <link href="{{asset('static/plugin/switchery/dist/switchery.min.css')}}" rel="stylesheet" />
    <link href="{{ asset('static/plugin/summernote/dist/summernote-bs4.css') }}" rel="stylesheet">
    <link href="{{asset('static/plugin/prism/prism.css')}}" rel="stylesheet">
    <link href="{{asset('static/plugin/owl.carousel/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('static/plugin/owl.carousel/owl.theme.default.css')}}" rel="stylesheet">
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">{{isset($immigrant) ? '移民详情' : '新建移民'}}</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                @if(isset($immigrant))
                <li class="breadcrumb-item"><a href="/admin/immi">移民列表</a></li>
                <li class="breadcrumb-item active">移民详情</li>
                @else
                <li class="breadcrumb-item active">新建移民</li>
                @endif
            </ol>
        </div>
    </div>
    <form id="immi-form" novalidate>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-md-8">
                            <button type="button" class="btn btn-success" onclick="saveImmigrant()"><i class="ti-save"></i> 保存</button>
{{--                            <button type="button" class="btn btn-info" onclick="showPreviewModal()"><i class="ti-check"></i> 预览</button>--}}
                        </div>
                        @if(isset($immigrant))
                            <div class="col-md-4 row">
                                <div class="col-md-4 text-right m-t-10">
                                    <input type="checkbox" {{isset($immigrant) && $immigrant->is_hot ? 'checked' : ''}} class="js-switch" name="is_hot" data-color="red" data-size="small" onchange="setHot()" />
                                    <label class="m-r-20">热门</label>
                                </div>
                                <div class="col-md-4 text-right m-t-10">
                                    <input type="checkbox" {{isset($immigrant) && $immigrant->is_recommended ? 'checked' : ''}} class="js-switch" name="is_recommended" data-color="orange" data-size="small" onchange="setRecommended()" />
                                    <label class="m-r-20">推荐</label>
                                </div>
                                <div class="col-md-4 text-right m-t-10">
                                    <input type="checkbox" {{isset($immigrant) && $immigrant->is_published ? 'checked' : ''}} class="js-switch" name="is_published" data-color="#009c75" data-size="small" onchange="publish()" />
                                    <label class="m-r-20">发布</label>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-body">
                        <div class="form-group">
                            <h4 class="m-b-20" > 名称 </h4>
                            <div class="form-group">
                                <label> 中文名 : <span class="text-danger">*</span> </label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="name_cn" name="name_cn" required data-validation-required-message="必填" value="{{isset($immigrant) ? $immigrant->name_cn : ''}}"> </div>
                            </div>
                            <div class="form-group">
                                <label> 英文名 : <span class="text-danger">*</span> </label>
                                <div class="controls">
                                    <input type="text" class="form-control" id="name_en" name="name_en" required data-validation-required-message="必填" value="{{isset($immigrant) ? $immigrant->name_en : ''}}"> </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <h4 class="m-t-20 m-b-20" >  基本条件 </h4>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label> 国家 : <span class="text-danger">*</span> </label>
                                    <div class="controls">
                                        <select name="country_id" id="country_id" class="form-control" onchange="changeCountry()">
                                            @foreach(\App\Country::all() as $country)
                                                <option value="{{$country->id}}" {{isset($immigrant) && $immigrant->country_id == $country->id ? 'selected' : ''}}>{{$country->name_cn}}</option>
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

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label> 下签/办理周期 : </label>
                                    <div class="controls">
                                        <select name="duration" id="duration" class="form-control" >
                                            <option value="3" {{isset($immigrant) && $immigrant->duration == 3 ? 'selected' : ''}}>3个月以内</option>
                                            <option value="6" {{isset($immigrant) && $immigrant->duration == 6 ? 'selected' : ''}}>6个月以内</option>
                                            <option value="12" {{isset($immigrant) && $immigrant->duration == 12 ? 'selected' : ''}}>12个月以内</option>
                                            <option value="13" {{isset($immigrant) && $immigrant->duration == 13 ? 'selected' : ''}}>12个月以上</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label> 类型 : </label>
                                    <div class="controls">
                                        <select name="type" id="type" class="form-control" >
                                            <option value="投资移民" {{isset($immigrant) && $immigrant->type == '投资移民' ? 'selected' : ''}}>投资移民</option>
                                            <option value="独立技术移民" {{isset($immigrant) && $immigrant->type == '独立技术移民' ? 'selected' : ''}}>独立技术移民</option>
                                            <option value="雇主担保移民" {{isset($immigrant) && $immigrant->type == '雇主担保移民' ? 'selected' : ''}}>雇主担保移民</option>
                                            <option value="买房移民" {{isset($immigrant) && $immigrant->type == '买房移民' ? 'selected' : ''}}>买房移民</option>
                                            <option value="退休移民" {{isset($immigrant) && $immigrant->type == '退休移民' ? 'selected' : ''}}>退休移民</option>
                                            <option value="护照项目" {{isset($immigrant) && $immigrant->type == '护照项目' ? 'selected' : ''}}>护照项目</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <h4 class="m-t-20 m-b-20" > 描述 </h4>
                            <div class="form-group">
                                <label> 标签 : <span class="text-danger">*</span> </label>
                                <input id="tags" name="tags" type="text" class="form-control" value="{{ isset($immigrant) ? $immigrant->tags : '' }}" data-role="tagsinput" placeholder="输入标签..." />

                                {{-- <textarea class="form-control" id="tags" name="tags">{{isset($immigrant) ? $immigrant->tags : ''}}</textarea>--}}
                            </div>
                            <div class="form-group">
                                <label> 前端主描述：</label>
                                <textarea class="form-control" id="main_description" name="main_description" rows="8">{{isset($immigrant) ? $immigrant->main_description : ''}}</textarea>
                            </div>
                            <div class="form-group">
                                <label> 前端短描述：</label>
                                <textarea class="form-control" id="secondary_description" name="secondary_description" rows="8">{{isset($immigrant) ? $immigrant->secondary_description : ''}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label> 官方移民局信息链接：</label>
                            <div class="controls">
                                <input type="text" class="form-control" id="immi_link" name="immi_link" value="{{isset($immigrant) ? $immigrant->immi_link : ''}}"> </div>
                        </div>
                    </div>
                    <input type="hidden" id="hash" name="hash" value="{{isset($immigrant) ? $immigrant->hash : ''}}">
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <ul class="nav nav-tabs customtab" role="tablist">
                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#tab1" role="tab"><span class="hidden-sm-up"><i class="ti-gallery"></i></span> <span class="hidden-xs-down">媒体信息</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab2" role="tab"><span class="hidden-sm-up"><i class="ti-agenda"></i></span> <span class="hidden-xs-down">附加服务</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab3" role="tab"><span class="hidden-sm-up"><i class="ti-panel"></i></span> <span class="hidden-xs-down">项目优势</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab4" role="tab"><span class="hidden-sm-up"><i class="ti-receipt"></i></span> <span class="hidden-xs-down">申请信息</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab5" role="tab"><span class="hidden-sm-up"><i class="ti-money"></i></span> <span class="hidden-xs-down">费用清单</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab6" role="tab"><span class="hidden-sm-up"><i class="ti-comment-alt"></i></span> <span class="hidden-xs-down">硬性要求</span></a> </li>
                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#tab7" role="tab"><span class="hidden-sm-up"><i class="ti-notepad"></i></span> <span class="hidden-xs-down">培训材料</span></a> </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1" role="tabpanel">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label >图片：</label>
                                        <div id="immi_images" class="owl-carousel owl-theme">
                                            @if(isset($immigrant) && !is_null($immigrant->images) && $immigrant->images != "")
                                                @foreach(json_decode($immigrant->images) as $image)
                                                    <div class="item">
                                                        <img src="{{config('asset.cos_img_url') . '/' . $image->url}}" height="150">
                                                        <div class="row" style="position:absolute; right:20px; bottom:10px">
                                                            <button type="button" class="btn btn-sm btn-cyan" onclick="setImagePrimary(this,'{{$image->url}}')"><i class="{{$image->is_primary == 1 ? ' ti-thumb-down' : 'ti-thumb-up' }}"></i></button>
                                                            <button type="button" class="btn btn-sm btn-danger m-l-10" onclick="deleteImage('{{$image->url}}')"><i class="ti-trash"></i></button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <input type="text" id="imageJson" value="{{isset($immigrant) && !is_null($immigrant->images) ? $immigrant->images : ''}}" hidden/>
                                    </div>
                                    <div class="col-md-12 m-t-10 row p-l-10 m-l-0">
                                        <input type="file" id="images" name="images[]" class="btn btn-sm btn-info" multiple>
                                        <button type="button" onclick="addImages()" class="btn  btn-success m-l-10"><i class="ti-upload"></i> 上传</button>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label > 视频：</label>
                                        <video id="video-player" controls style="width: 100%;height:300px;">
                                            <source src="{{isset($immigrant) && !is_null($immigrant->video) ? asset_url($immigrant->video, 'video') : ''}}" type="video/mp4">
                                        </video>
                                    </div>
                                    <div class="row col-md-12">
                                        <input type="file" id="video" name="video" class="btn btn-sm btn-info  m-l-10" accept="video/mp4">
                                        <button type="button" onclick="addVideo()" class="btn btn-success m-l-10"><i class="ti-upload"></i> 上传</button>
                                        @if(isset($immigrant) && !is_null($immigrant->video))
                                            <button id="deleteVideoBtn" type="button" class="btn btn-danger m-l-10" onclick="deleteVideo()"><i class="ti-trash"></i> 删除</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab2" role="tabpanel">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div style="display: flex;align-items: center;">
                                            <div>
                                                <h5 >FAQ列表：</h5>
                                            </div>

                                        </div>
                                        <div class="controls   ">
                                            <table id="tbl_faq" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                                <thead>
                                                <tr>
                                                    <th>Faq名称</th>
                                                    <th>Hash</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($immigrant) && !is_null($immigrant->faq_ids) && $immigrant->faq_ids != "")
                                                    @foreach(json_decode($immigrant->faq_ids) as $faq_id)
                                                        <tr>
                                                            <td>
                                                                {{!is_null(\App\Faq::where("id",$faq_id)->first()) ? \App\Faq::where("id",$faq_id)->first()->name : ''}}
                                                            </td>
                                                            <td>
                                                                {{!is_null(\App\Faq::where("id",$faq_id)->first()) ? \App\Faq::where("id",$faq_id)->first()->hash : ''}}
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteFaq('{{!is_null(\App\Faq::where("id",$faq_id)->first()) ? \App\Faq::where("id",$faq_id)->first()->hash : ''}}',this)"><i class="ti-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                            <button  type="button" class="btn btn-rounded btn-info"  onclick="showFaqModal(0, false)"  ><i class="ti-plus"></i> 添加FAQ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab3" role="tabpanel">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group m-l-10">
                                    <h5 > 项目优势 : </h5>
                                    <div class="row col-md-12 ">
                                        <div class="table-responsive">
                                            <table id="tbl_adv" class="display nowrap table  table-hover table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">排序</th>
                                                    <th class="text-center">优势名称</th>
                                                    <th class="text-center">描述</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                            <button class="btn btn-rounded btn-info" type="button" onclick="showAdvModal()"><i class="ti-plus"></i> 添加优势</button>
                                        </div>
                                        <input type="hidden" class="form-control" id="adv" name="adv" value="{{isset($immigrant) ? $immigrant->adv : ''}}"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab4" role="tabpanel">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group m-l-10">
                                    <h5 > 申请步骤 : </h5>
                                    <div class="row col-md-12 ">
                                        <div class="table-responsive">
                                            <table id="tbl_process" class="display nowrap table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">排序</th>
                                                    <th class="text-center">步骤名称</th>
                                                    <th class="text-center">描述</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                            <button class="btn btn-rounded btn-info" type="button" onclick="createProcess();return false;"><i class="ti-plus"></i> 添加步骤</button>
                                        </div>
                                        <input type="text" class="form-control" id="process" name="process" value="{{isset($immigrant) ? $immigrant->process : ''}}" hidden/>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-body">
                                <div class="form-group m-t-40 m-l-10">
                                    <h5 > 申请条件 : </h5>
                                    <div class="row col-md-12 ">

                                        <div class="table-responsive">
                                            <table id="tbl_requirements" class="display nowrap table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">排序</th>
                                                    <th class="text-center">条件名称</th>
                                                    <th class="text-center">描述</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                            <button class="btn btn-rounded btn-info" type="button" onclick="showRequirementsModal()"><i class="ti-plus"></i> 添加条件</button>
                                        </div>
                                        <input type="hidden" class="form-control" id="requirements" name="requirements" value="{{isset($immigrant) ? $immigrant->requirements : ''}}"/>
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="form-body">
                                <div class="row m-t-40">
                                    <div class="form-group col-md-12  p-l-20 p-r-20">
                                        <h5 > 材料要求清单 : </h5>
                                        <div class="row col-md-12 ">
                                            <div class="table-responsive">
                                                <table id="tbl_doc" class="display nowrap table table-striped table-bordered">
                                                    <thead>
                                                    <tr>
                                                        <th class="text-center">材料名称</th>
                                                        <th class="text-center">材料描述</th>
                                                        <th class="text-center">样本材料下载</th>
                                                        <th class="text-center">操作</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                                <button class="btn btn-rounded btn-info" type="button" onclick="createDoc();return false;"><i class="ti-plus"></i> 添加材料</button>
                                            </div>
                                            <input type="text" class="form-control" id="document" name="document" value="{{isset($immigrant) ? $immigrant->document : ''}}" hidden/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab5" role="tabpanel">
                        <div class="card-body">
                            <div class="form-group m-l-10">
                                <h5 > 费用清单 : </h5>
                                <div class="row col-md-12 ">

                                    <div class="table-responsive">
                                        <table id="tbl_fee" class="display nowrap table table-striped table-bordered">
                                            <thead>
                                            <tr>
                                                <th class="text-center">费用名称</th>
                                                <th class="text-center">费用金额</th>
                                                <th class="text-center">收费机构</th>
                                                <th class="text-center">描述</th>
                                                <th class="text-center">操作</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                        <button class="btn btn-rounded btn-info" type="button" onclick="createFee();return false;"><i class="ti-plus"></i> 添加费用</button>
                                    </div>
                                    <input type="text" class="form-control" id="fee" name="fee" value="{{isset($immigrant) ? $immigrant->fee : ''}}" hidden/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab6" role="tabpanel">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group" >
                                    <h5 > 居住要求 : </h5>
                                    <small class="card-subtitle">前端可以针对是否有移民监，对移民项目进行筛选，此处若选择需要去当地居住，则视为有移民监。</small>
                                    <div class="controls row m-t-20" >
                                        <div class="col-md-6 d-flex flex-row  align-items-center ">
                                            <label class="m-r-10" style="margin-top:3px;">  是否需要在当地居住  </label><input type="checkbox"  class="js-switch" data-color="#009efb" id="is_onshore" name="is_onshore" data-size="small" {{isset($immigrant) ? ($immigrant->is_onshore == 1 ? 'checked' : '') : 'checked'}} />
                                        </div>
                                        <div class="col-md-6">
                                            <label> 移民监策略 : </label><input type="text" class="form-control" id="onshore_period" name="onshore_period" required value="{{isset($immigrant) ? $immigrant->onshore_period : ''}}" placeholder="比如：每5年住满2年">
                                        </div>
                                    </div>
                                    <div class="controls row  m-t-20" >
                                        <div class="col-md-12">
                                            <label> 居住要求描述 : </label>  <textarea type="text" class="form-control" id="onshore_des" name="onshore_des" rows="8">{{isset($immigrant) ? $immigrant->onshore_des : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group " >
                                    <h5 > 雇佣要求 : </h5>
                                    <div class="controls row m-t-20" >
                                        <div class="col-md-6 d-flex flex-row align-items-center ">
                                            <label class="m-r-10" style="margin-top:3px;"> 是否需要雇人  </label><input type="checkbox"  class="js-switch form-check-input" data-color="#009efb" id="is_employment_req" name="is_employment_req" data-size="small" {{isset($immigrant) ? ($immigrant->is_employment_req == 1 ? 'checked' : '') : 'checked'}}/>
                                        </div>
                                        <div class="col-md-6">
                                            <label> 雇员人数 : </label><input type="number" class="form-control" id="employment_amount" name="employment_amount" required value="{{isset($immigrant) ? $immigrant->employment_amount : ''}}">
                                        </div>
                                    </div>
                                    <div class="controls row m-t-20" >
                                        <div class="col-md-12">
                                            <label> 雇佣要求描述 : </label>  <textarea class="form-control" id="employment_des" name="employment_des" value="" rows="8">{{isset($immigrant) ? $immigrant->employment_des : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr/>
                                <div class="form-group ">
                                    <h5 > 语言要求 : </h5>
                                    <div class="controls row m-t-30" >
                                        <div class="col-md-6">
                                            <label> 要求的语言 : </label><input type="text" class="form-control" id="language_req" name="language_req" required value="{{isset($immigrant) ? $immigrant->language_req : ''}}">
                                        </div>
                                        <div class="col-md-6">
                                            <label> 语言要求等级 : </label><input type="text" class="form-control" id="language_level" name="language_level" required value="{{isset($immigrant) ? $immigrant->language_level : ''}}">
                                        </div>

                                    </div>
                                    <div class="controls m-t-20">
                                        <label> 语言要求描述 : </label>  <textarea class="form-control" id="language_des" name="language_des" rows="8">{{isset($immigrant) ? $immigrant->language_des : ''}}</textarea>
                                    </div>
                                </div>
                                <hr>

                                <div class="form-group">
                                    <h5 > 资产要求 : </h5>
                                    <div class="controls row m-t-20" >
                                        <div class="col-md-6 d-flex flex-row align-items-center">
                                            <label class="m-r-10" style="margin-top:3px;">  是否在当地需要拥有资产  </label><input type="checkbox"  class="js-switch" data-color="#009efb" id="is_asset_req" name="is_asset_req" data-size="small" {{isset($immigrant) ? ($immigrant->is_asset_req == 1 ? 'checked' : '') : 'checked'}}/>
                                        </div>
                                        <div class="col-md-6">
                                            <label> 资产金额 : </label>
                                            <div class="input-group mb-3">
                                                <input type="number" class="form-control" id="asset_amount" name="asset_amount" required value="{{isset($immigrant) ? $immigrant->asset_amount : ''}}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text symbol">{{isset($immigrant) ? $immigrant->country->symbol : ''}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="controls row m-t-20" >
                                        <div class="col-md-12">
                                            <label> 资产要求描述 : </label>  <textarea class="form-control" id="employment_des" name="employment_des" value="" rows="8">{{isset($immigrant) ? $immigrant->employment_des : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <hr>


                                <div class="row  ">
                                    <div class="form-group col-md-12  ">
                                        <h5 > 资金要求 : </h5>
                                        <div class="controls d-flex flex-row m-t-20" >
                                            <div class="col-md-6 row m-t-20">
                                                <div class="row m-l-0 p-l-0 ">
                                                    <label class="m-t-6 m-r-10"> 是否需要投资  </label> <input type="checkbox"  class="js-switch" data-color="#009efb" id="is_invest_req" name="is_invest_req" data-size="small"  {{isset($immigrant) ? ($immigrant->is_invest_req == 1 ? 'checked' : '') : 'checked'}} />
                                                </div>
                                                <div class="row  p-l-40">
                                                    <label class="m-t-6 m-r-10"> 是否需要资金来源证明  </label> <input type="checkbox"  class="js-switch" data-color="#009efb" id="is_capital_proof" name="is_capital_proof" data-size="small" {{isset($immigrant) ? ($immigrant->is_capital_proof == 1 ? 'checked' : '') : 'checked'}} />
                                                </div>
                                            </div>
                                            <div class="col-md-6 m-l-20 p-l-0 p-r-0">
                                                <label> 投资金额 : </label>
                                                <div class="input-group mb-3">
                                                    <input type="number" class="form-control" id="invest_amount" name="invest_amount"  value="{{isset($immigrant) ? $immigrant->invest_amount : ''}}"/>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text symbol">{{isset($immigrant) ? $immigrant->country->symbol : ''}}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="controls row m-t-10">
                                            <div class="col-md-12">
                                                <label> 投资要求描述 : </label><textarea type="text" class="form-control" id="invest_des" name="invest_des" rows="8">{{isset($immigrant) ? $immigrant->invest_des : ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab7" role="tabpanel">
                        <div class="card-body">
                            <div class="form-body">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <label  > 项目负责人</label><br>
                                        <small class="card-subtitle">分销状态下，本项目的默认联系人（仅可填入HASH ID）</small>
                                        <input type="text" class="m-t-10 form-control" id="internal_manager_id" name="internal_manager_id" value="{{isset($immigrant->internal_manager_id) && !is_null($immigrant->internal_manager_id)  && $immigrant->internal_manager_id != 0 ? $immigrant->internal_manager->hash : ''}}">
                                    </div>
                                    <div class="col-md-6">
                                        <label  > 培训人</label><br>
                                        <small class="card-subtitle">分销状态下，培训视频前端展示的培训人名称，请手动输入。</small>
                                        <input type="text" class=" m-t-10 form-control" id="trainer" name="trainer" value="{{isset($immigrant) && !is_null($immigrant->trainer) ? $immigrant->trainer : ''}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="card-title" >培训视频</label>
                                            <video id="training-video-player" controls style="width: 100%;height:300px;">
                                                <source src="{{isset($immigrant) && !is_null($immigrant->training_video) ? asset_url($immigrant->training_video, 'video') : ''}}" type="video/mp4">
                                            </video>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input type="file" id="training_video" name="training_video" class="btn btn-sm btn-info" accept="video/mp4">
                                            <button type="button" onclick="addTrainingVideo()" class="btn btn-success m-l-10"><i class="ti-upload"></i> 上传</button>
                                            @if(isset($immigrant) && !is_null($immigrant->training_video))
                                                <button type="button" id="btn_del_training_video"  class="btn btn-danger  m-l-10" onclick="deleteTrainingVideo()"><i class="ti-trash"></i> 删除</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="form-group m-t-20">
                                    <label > 培训文章 : </label>
                                    <div class="row col-md-12 ">

                                        <div class="table-responsive">
                                            <table id="tbl_training" class="display nowrap table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">文章Hash</th>
                                                    <th class="text-center">标题</th>
                                                    <th class="text-center">文章分类</th>
                                                    <th class="text-center">操作</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(isset($immigrant) && !is_null($immigrant->training_articles) && $immigrant->training_articles != "")
                                                    @foreach(json_decode($immigrant->training_articles) as $article_id)
                                                        <tr>
                                                            <td>
                                                                {{!is_null(\App\Article::where("id",$article_id)->first()) ? \App\Article::where("id",$article_id)->first()->hash : ''}}
                                                            </td>
                                                            <td>
                                                                <a href="/admin/article/{{!is_null(\App\Article::where("id",$article_id)->first()) ?  \App\Article::where("id",$article_id)->first()->hash : ''}}">{{ !is_null(\App\Article::where("id",$article_id)->first()) ? \App\Article::where("id",$article_id)->first()->name : ''}}</a>
                                                            </td>
                                                            <td>
                                                                {{!is_null(\App\Article::where("id",$article_id)->first()) ? (!is_null(\App\Article::where("id",$article_id)->first()->category) ? \App\Article::where("id",$article_id)->first()->category->name : '') : ''}}
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger" onclick="deleteArticle('{{!is_null(\App\Article::where("id",$article_id)->first()) ? \App\Article::where("id",$article_id)->first()->hash : ''}}',this)"><i class="ti-trash"></i></button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row col-md-12 m-t-20 m-b-20 justify-content-center" >
                                            <button class="btn btn-rounded btn-info" type="button" onclick="createArticle();return false;"><i class="ti-plus"></i> 添加文章</button>
                                        </div>
                                        <input type="text" class="form-control" id="training_articles" name="training_articles" value="{{isset($immigrant) ? $immigrant->training_articles : ''}}" hidden/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    <div id="faq-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">FAQ管理</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form id="package-form" novalidate>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> FAQ Hash : <span class="text-danger">*</span> </label>
                            <input type="text" class="form-control" id="faq_hash" name="faq_hash" required data-validation-required-message="必填" value="" placeholder="请输入价格单Hash。。。">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                        <button type="button" class="btn btn-success" onclick="addFaq()"><i class="ti-save"></i> 保存</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="adv-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">项目优势</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> 优势名称 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="adv_title" name="adv_title" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 排序 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="number" class="form-control" id="adv_rank" name="adv_rank" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 描述 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <textarea type="text" class="form-control" id="adv_des" name="adv_des" required data-validation-required-message="必填" rows="8"></textarea> </div>
                    </div>
                    <input type="number" class="form-control" id="adv_is_update" name="adv_is_update" hidden>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="addAdv();"><i class="ti-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

    <div id="requirements-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">申请条件</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> 条件名称 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="requirements_title" name="requirements_title" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 排序 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="number" class="form-control" id="requirements_rank" name="requirements_rank" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 描述 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <textarea type="text" class="form-control" id="requirements_des" name="requirements_des" required data-validation-required-message="必填" rows="8"></textarea> </div>
                    </div>
                    <input type="number" class="form-control" id="requirement_is_update" name="requirement_is_update" hidden>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="addRequirements();"><i class="ti-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

    <div id="process-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">申请步骤</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> 步骤名称 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="process_title" name="process_title" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 排序 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="process_rank" name="process_rank" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 描述 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <textarea type="text" class="form-control" id="process_des" name="process_des" required data-validation-required-message="必填" rows="8"></textarea> </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="addProcess();"><i class="ti-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

    <div id="fee-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">费用清单</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> 费用名称 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="fee_title" name="fee_title" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 费用金额 : <span class="text-danger">*</span> </label>
                        <div class="input-group mb-3">
                            <input type="number" class="form-control" id="fee_amount" name="fee_amount" required data-validation-required-message="必填" >
                            <div class="input-group-append">
                                <span class="input-group-text symbol">{{isset($immigrant) ? $immigrant->country->symbol : ''}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label> 收费机构 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="fee_body" name="fee_body" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 描述 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <textarea class="form-control" id="fee_des" name="fee_des" required data-validation-required-message="必填" rows="8"></textarea> </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="addFee();"><i class="ti-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

    <div id="article-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">培训文章详情</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> 文章Hash : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="article_hash" name="article_hash" required data-validation-required-message="必填" > </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="addArticle();"><i class="ti-save"></i> 添加</button>
                </div>
            </div>
        </div>
    </div>

    <div id="doc-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">材料详情</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label> 材料名称 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <input type="text" class="form-control" id="doc_name" name="doc_name" required data-validation-required-message="必填" > </div>
                    </div>
                    <div class="form-group">
                        <label> 材料描述 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <textarea class="form-control" id="doc_des" name="doc_des" required data-validation-required-message="必填" rows="8"></textarea> </div>
                    </div>
                    <div class="form-group">
                        <label> 样本材料稳当 : <span class="text-danger">*</span> </label>
                        <div class="controls">
                            <form id="docForm">
                                <input type="file" id="doc_file" name="doc_file" class="btn btn-sm btn-info"/>
                            </form>

                        </div>
                        <input hidden type="text" id="doc_download" name="doc_download" class="btn btn-sm btn-info"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                    <button type="button" class="btn btn-success" onclick="addDoc();"><i class="ti-save"></i> 添加</button>
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
    <script src="{{asset('static/plugin/dropify/dist/js/dropify.min.js')}}"></script>
    <script src="{{asset('static/plugin/switchery/dist/switchery.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('static/plugin/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script src="{{asset('static/plugin/prism/prism.js')}}"></script>
    <script src="{{asset('static/plugin/owl.carousel/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('static/js/pages/validation.js') }}"></script>
    <script src="{{ asset('static/admin/immigrant.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>
    <script>
        $('.dropify').dropify({
            messages: {
                default: ''
            }
        });
        $('.js-switch').each(function () {
            new Switchery($(this)[0], $(this).data());
        });
        $('#content').summernote({
            height: 900, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: false // set focus to editable area after initializing summernote
        });
    </script>
@endsection
