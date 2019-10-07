<div class="side-mini-panel">
    <ul class="mini-nav">
        <div class="togglediv"><a href="javascript:void(0)" id="togglebtn"><i class="ti-menu"></i></a></div>
        <!-- .Dashboard -->
        <li class="{{request()->path() == 'admin' || strpos(request()->path(), 'admin/base') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="icon-speedometer"></i></a>
            <div class="sidebarmenu">
                <!-- Left navbar-header -->
                <h3 class="menu-title">仪表板</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin' ? 'active' : ''}}"><a class="{{request()->path() == 'admin' ? 'active' : ''}}" href="/admin">仪表板</a></li>
                    <li class="menu {{(strpos(request()->path(),'admin/base/country')!==false || request()->path()=='admin/base/state' || request()->path()=='admin/base/city'||request()->path()=='admin/base/suburb') ?'active':'' }}">
                        <a href="javascript:void(0)">国家/省(州)/城市/小区<i class="fa fa-angle-left float-right"></i></a>
                        <ul class="sub-menu" style="display:{{(strpos(request()->path(),'admin/base/country')!==false || request()->path()=='admin/base/state' || request()->path()=='admin/base/city'||request()->path()=='admin/base/suburb') ?'block':'none' }}">
                            <li class="{{request()->path() == 'admin/base/country' ? 'active' : ''}}"><a class="{{strpos(request()->path() ,'admin/base/country')!==false ? 'active' : ''}}" href="/admin/base/country">国家</a></li>
                            <li class="{{request()->path() == 'admin/base/state' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/base/state' ? 'active' : ''}}" href="/admin/base/state">省(州)</a></li>
                            <li class="{{request()->path() == 'admin/base/city' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/base/city' ? 'active' : ''}}" href="/admin/base/city">城市</a></li>
                            <li class="{{request()->path() == 'admin/base/suburb' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/base/suburb' ? 'active' : ''}}" href="/admin/base/suburb">小区</a></li>
                        </ul>
                    </li>
                    <li class="{{strpos(request()->path(), 'admin/base/tax') !== false ? 'active' : ''}}"><a class="{{strpos(request()->path(), 'admin/base/tax') !== false ? 'active' : ''}}" href="/admin/base/tax">税率模板</a></li>
                </ul>
                <!-- Left navbar-header end -->
            </div>
        </li>
        <li class="{{strpos(request()->path(), 'admin/article') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="ti-book"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">文章管理</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin/article' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/article' ? 'active' : ''}}" href="/admin/article">文章列表</a></li>
                    <li class="{{request()->path() == 'admin/article/category' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/article/category' ? 'active' : ''}}" href="/admin/article/category">文章分类</a></li>
                    <hr>
                    <li class="{{request()->path() == 'admin/article/add' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/article/add' ? 'active' : ''}}" href="/admin/article/add">新建文章</a></li>
                </ul>
            </div>
        </li>
        <li class="{{strpos(request()->path(), 'admin/property') !== false || strpos(request()->path(), 'admin/property/unit') !== false || strpos(request()->path(), 'admin/property/pricelist') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="ti-home"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">房产管理</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin/property' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/property' ? 'active' : ''}}" href="/admin/property">物业列表</a></li>
                    <li class="{{request()->path() == 'admin/property/add' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/property/add' ? 'active' : ''}}" href="/admin/property/add">新建物业</a></li>
                    <hr>
                    <li class="{{request()->path() == 'admin/property/unit' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/property/unit' ? 'active' : ''}}" href="/admin/property/unit">户型列表</a></li>
                    <li class="{{request()->path() == 'admin/property/pricelist' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/property/pricelist' ? 'active' : ''}}" href="/admin/property/pricelist">价格单列表</a></li>
                </ul>
            </div>
        </li>
        <li class="{{strpos(request()->path(), 'admin/immi') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="icon-plane"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">移民管理</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin/immi' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/immi' ? 'active' : ''}}" href="/admin/immi">移民列表</a></li>
                    <li class="{{request()->path() == 'admin/immi/add' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/immi/add' ? 'active' : ''}}" href="/admin/immi/add">新建移民</a></li>
                </ul>
            </div>
        </li>
        <li class="{{strpos(request()->path(), 'admin/faq') !== false || strpos(request()->path(), 'admin/qnalist') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="icon-speech"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">FAQ管理</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin/faq' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/faq' ? 'active' : ''}}" href="/admin/faq">FAQ管理</a></li>
                    <li><hr/></li>
                    <li class="{{request()->path() == 'admin/qnalist' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/qnalist' ? 'active' : ''}}" href="/admin/qnalist">QnaList列表</a></li>
                    <li class="{{request()->path() == 'admin/qnalist/add' ? 'active' : ''}}"><a class="{{request()->path() == 'admin/qnalist/add' ? 'active' : ''}}" href="/admin/qnalist/add">新建QnaList</a></li>
                </ul>
            </div>
        </li>
        <li class="{{strpos(request()->path(), 'admin/location') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="ti-location-pin"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">地段分析管理</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin/location' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/location')!==false && strpos(request()->path() ,'admin/location/suburbprofile')===false ? 'active' : ''}}" href="/admin/location">
                             地段分析
                        </a>
                    </li>
                    <li class="{{request()->path() == 'admin/location/suburbprofile' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/location/suburbprofile')!==false ? 'active' : ''}}" href="/admin/location/suburbprofile">
                            小区分析
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="{{strpos(request()->path(), 'admin/crawler') !== false ? 'selected' : ''}}">
            <a href="javascript:void(0)"><i class="ti-cloud-down"></i></a>
            <div class="sidebarmenu">
                <h3 class="menu-title">爬虫管理</h3>
                <ul class="sidebar-menu">
                    <li class="{{request()->path() == 'admin/crawler/list' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/crawler/list')!==false ? 'active' : ''}}" href="/admin/crawler/list">
                            爬虫列表
                        </a>
                    </li>
                    <li class="{{request()->path() == 'admin/crawler/te' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/crawler/te')!==false ? 'active' : ''}}" href="/admin/crawler/te">
                            <img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('static/images/crawler/te.png')}}"> Trading Economy
                        </a>
                    </li>
                    <li class="{{request()->path() == 'admin/crawler/airbnb' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/crawler/airbnb')!==false ? 'active' : ''}}" href="/admin/crawler/airbnb">
                            <img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('static/images/crawler/airbnb.png')}}">
                            Aribnb
                        </a>
                    </li>
                    <li class="{{request()->path() == 'admin/crawler/realestate' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/crawler/realestate')!==false ? 'active' : ''}}" href="/admin/crawler/realestate">
                            <img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('static/images/crawler/suburbprofile.png')}}">
                            Realestate
                        </a>
                    </li>
                    <li class="{{request()->path() == 'admin/crawler/weixin' ? 'active' : ''}}">
                        <a class="{{strpos(request()->path() ,'admin/crawler/weixin')!==false ? 'active' : ''}}" href="/admin/crawler/weixin">
                            <img class="avatar-img m-r-10" width="30px" height="30px" src="{{asset('static/images/crawler/weixin.png')}}">
                            文章采集
                        </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
