@extends('admin.layout.admin')
@section('styles')
    <link href="{{asset('static/plugin/datatables/media/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
    <link href="{{ asset('static/plugin/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
    <link href="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.0/mapsjs-ui.css?dp-version=1533195059" />
@endsection

@section('content')
    <div class="row page-titles">
        <div class="col-md-12">
            <h4 class="text-white">地段分析</h4>
        </div>
        <div class="col-md-6">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/admin">首页</a></li>
                <li class="breadcrumb-item active">地段分析</li>
            </ol>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="m-t-10 m-b-10">（ 输入项目位置后，可以通过移动地图上的标签来标记准确位置，请记得调整位置后按保存 ）</div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <div class="controls">
                            <input type="text" class="form-control" id="address" name="address" placeholder="地址" required data-validation-required-message="必填" value="{{isset($location) ? $location->address : ''}}"> </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-warning" onclick="geocodeAndSearch();"> <i class="fa fa-map"></i> 搜索</button>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-block btn-success save-btn" onclick="saveAddress('{{isset($hash) ? $hash : ''}}');"> <i class="fa fa-save"></i> 保存</button>
                </div>
                <input type="hidden" id="property_hash"/>
                <input type="hidden" id="lat" value="{{isset($location) ? $location->lat : '0'}}">
                <input type="hidden" id="lng" value="{{isset($location) ? $location->lng : '0'}}">
            </div>
            <div id="map-box" style="width: 100%; height: 400px;"></div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="col-md-12">
                <div class="card">
                    <ul class="nav nav-tabs customtab m-b-20" role="tablist">
                        <li class="nav-item active"> <a class="nav-link " data-toggle="tab" href="#primaryTab" role="tab"> <h4 class="m-t-20">小学</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#highSchoolTab" role="tab"> <h4 class="m-t-20">中学</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#univercityTab" role="tab"> <h4 class="m-t-20">大学</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#restrauntTab" role="tab"><h4 class="m-t-20">餐饮</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#hospitalTab" role="tab"> <h4 class="m-t-20">医院</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#transportTab" role="tab"> <h4 class="m-t-20">公共交通</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#leisureTab" role="tab"> <h4 class="m-t-20">娱乐</h4>
                            </a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#shoppingTab" role="tab"> <h4 class="m-t-20">购物</h4>
                            </a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="primaryTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right">展示：2,000米半径内的小学</div>
                            </div>
                            <div class="table-responsive table-editable">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="primary-school">
                                    @isset($nearby)
                                        @foreach($nearby->primarySchool as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-primary.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'小学')"><i class="ti-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="highSchoolTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right">展示：3,000米半径内的中学</div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="high-school">
                                    @isset($nearby)
                                        @foreach($nearby->highSchool as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-high.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'中学')"><i class="ti-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="univercityTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="university">
                                    @isset($nearby)
                                        @foreach($nearby->university as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-university.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'大学')"><i class="ti-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="restrauntTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right">展示：1,000米半径内的餐饮</div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="restaurant">
                                    @isset($nearby)
                                        @foreach($nearby->restaurant as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-eatdrink.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'餐饮')"><i class="ti-trash"></i></button></td>

                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="hospitalTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right"></div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="hospital">
                                    @isset($nearby)
                                        @foreach($nearby->hospital as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-hospital.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'医院')"><i class="ti-trash"></i></button></td>

                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="transportTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right">展示：1,000米半径内的公共交通</div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="public-transport">
                                    @isset($nearby)
                                        @foreach($nearby->transport as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-transport.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'公共交通')"><i class="ti-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="leisureTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right">展示：2,000米半径内的娱乐</div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="leisure">
                                    @isset($nearby)
                                        @foreach($nearby->leisure as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-goingout.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'娱乐')"><i class="ti-trash"></i></button></td>

                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane " id="shoppingTab" role="tabpanel">
                            <div class="row m-b-15">
                                <div class="col-md-8">如果有修改，请务必保存。否则将会丢失翻译的记录。</div>
                                <div class="col-md-4 text-right">展示：5,000米半径内的购物</div>
                            </div>
                            <div class="table-responsive">
                                <table class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>分类</th>
                                        <th>自动抓取结果</th>
                                        <th>前端显示内容</th>
                                        <th>距离</th>
                                        <th>坐标</th>
                                        <th>操作</th>
                                    </tr>
                                    </thead>
                                    <tbody id="shopping">
                                    @isset($nearby)
                                        @foreach($nearby->shopping as $place)
                                            <tr>
                                                <td><img src="{{asset('static/images/location/icmark-shopping.png')}}" height="30px"></td>
                                                <td>{{$place->name}}</td>
                                                <td contenteditable="true">{{$place->chinese}}</td>
                                                <td contenteditable="true">{{$place->distance}}</td>
                                                <td>{{$place->location}}</td>
                                                <td><button class="btn btn-sm btn-danger m-l-20" onclick="deleteItem(this,'购物')"><i class="ti-trash"></i></button></td>
                                            </tr>
                                        @endforeach
                                    @endisset
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-mapevents.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.0/mapsjs-places.js"></script>

    <script src="{{ asset('static/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert/jquery.sweet-alert.custom.js') }}"></script>
    <script src="{{asset('static/plugin/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('static/plugin/bootstrap-select/bootstrap-select.min.js')}}"></script>
    <script src="{{ asset('static/js/pages/validation.js') }}"></script>
    <script src="{{ asset('static/admin/map.js') }}"></script>
    <script src="{{ asset('static/admin/location.js') }}"></script>
    <script src="{{ asset('static/plugin/sweetalert2/sweetalert2.js') }}"></script>

    <script type="text/javascript" >
        var nearby = '{{isset($nearby) ? json_encode($nearby) : ''}}';
    </script>
@endsection
