@php
    use App\Http\Controllers\EmployeeController;

    $filterlinks = EmployeeController::navigation();
    $presenId = EmployeeController::navigationId('/'.Request::path());

    $selectedLinks=['dashboard'=>'/manage/dashboard','myaccount'=>'/manage/my-account'];
    $icons = [
        "fa fa-calculator",
        "fa fa-inr",
        "fa fa-handshake-o",
        "fa fa-wrench",
        "fa fa-usb",
        "fa fa-ticket",
        "fa fa-bullhorn",
        "fa fa-tags",
        "fa fa-shield",
        "fa fa-gavel",
        "fa fa-user",
        "fa fa-search",
        "fa fa-group",
        "fa fa-credit-card",
        "fa fa-sign-out" 
    ];

    $sublinks_names = [];

    $sublink_ids = [];
@endphp

@php
    $logoPath = DB::table('logo')->first(); 
@endphp

<div class="row">
    <div class="page-wrapper toggled">
        <nav id="sidebar" class="sidebar-wrapper">
            <div class="sidebar-content">
                <a href="#" id="toggle-sidebar"><i class="fa fa-bars"></i></a>
                <div class="sidebar-brand">
                    <div class="text-center">
                        <img class="managepay-logo" src="{{asset('images/'.$logoPath->path)}}" alt=" Logo"  style=" width: 500px; height: 80px;
"/>
                    </div>
                </div>
                <div class="sidebar-menu">
                    @if(!empty($filterlinks))
                    <ul>
                        <li class="sidebar-dropdown {{ (Request::path() === 'manage/dashboard')?'active selected':''}}">
                            <a href="{{url('/')}}{{$selectedLinks['dashboard']}}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a>
                        </li>
                       
                        @foreach($filterlinks as $index => $link)
                        <li class="sidebar-dropdown {{ (Request::path() === $link['hyperlink'])?'active':''}}">
                            @if(!empty($filterlinks[$index]["sublinks"]))
                            <a href="javascript:void(0)"><i class="{{$filterlinks[$index]['icons']}}"></i><span></span><span>{{$filterlinks[$index]["link_name"]}}</span></a>
                                <div class="sidebar-submenu"   style="display:{{$presenId==$filterlinks[$index]['id']?'block':'none'}}" >
                                    <ul>
                                        @foreach($filterlinks[$index]["sublinks"] as $index => $sublink)
                                            @php 
                                                $sublink_array = explode("/",$sublink["hyperlink"]);
                                                $sublink_count = count($sublink_array);
                                                $sublinks_names[$sublink_array[$sublink_count-1]] = $sublink["link_name"];
                                                $sublink_ids[$sublink["id"]] = $sublink["hyperlinkid"];
                                            @endphp
                                            <li class="{{ ('/'.Request::path() === $sublink['hyperlink'])?'active selected':''}}">
                                                <a href="{{url('/')}}{{$sublink['hyperlink']}}">{{$sublink['link_name']}}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                              @if(!empty($link["hyperlinkid"]))
                               <?php $sublinks_names[$link["hyperlinkid"]] = $link["link_name"]; ?>
                              
                              @endif
                            <a href="{{url('/')}}{{$link['hyperlink']}}"><i class="{{$filterlinks[$index]['icons']}}"></i><span>{{$link["link_name"]}}</span></a>
                            @endif
                        </li>
                        @endforeach
                    <!--     <li class="sidebar-dropdown {{ (Request::path() === 'manage/my-account')?'active selected':''}}">
                            <a href="{{url('/')}}{{$selectedLinks['myaccount']}}"><i class="fa fa-user"></i> <span>My Account</span></a>
                        </li> -->
                        <li>
                            <form id="logout-form" action="{{ route('managepay.logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                            <a href="{{ route('managepay.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fa fa-sign-out"></i> <span>Log Out</span>
                            </a>
                        </li>
                    </ul>
                    @endif
                </div>

            </div>
        </nav>
    </div>
</div>
@php
session(['sublinkNames'=>$sublinks_names])
@endphp

