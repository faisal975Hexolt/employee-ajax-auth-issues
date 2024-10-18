<style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,700");
    @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css");

    body {
        color: #5d5f63;

        height: 100vh;
        width: 100vw;
        font-family: Source Sans Pro, Helvetica Neue, Helvetica, Arial, sans-serif;
        padding: 0;
        margin: 0;
        text-rendering: optimizeLegibility;
        -webkit-font-smoothing: antialiased;
    }

    .sidebare-toggle {
        margin-left: -240px;
    }

    .sidebare {
        overflow-y: scroll;
        height: 800px;
        max-height: 1000px;
        width: 220px;
        background: #293949;
        position: fixed;
        margin-top: -50px;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -o-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
        transition: all 0.3s ease-in-out;
        z-index: 1040;
    }

    .sidebare #leftside-navigation ul,
    .sidebare #leftside-navigation ul ul {
        margin: -2px 0 0;
        padding: 0;
    }

    .sidebare #leftside-navigation ul li {
        list-style-type: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebare #leftside-navigation ul li.active a {
        color: #1abc9c;
    }

    .sidebare #leftside-navigation ul li.active ul {
        display: block;
    }

    .sidebare #leftside-navigation ul li a {
        color: #aeb2b7;
        text-decoration: none;
        display: block;
        padding: 18px 0 18px 25px;
        font-size: 12px;
        outline: 0;
        -webkit-transition: all 200ms ease-in;
        -moz-transition: all 200ms ease-in;
        -o-transition: all 200ms ease-in;
        -ms-transition: all 200ms ease-in;
        transition: all 200ms ease-in;
    }

    .sidebare #leftside-navigation ul li a:hover {
        color: #1abc9c;
    }

    .active {
        color: #636b6f;
    }

    .sidebare #leftside-navigation ul li a span {
        display: inline-block;
    }

    .sidebare #leftside-navigation ul li a i {
        width: 20px;
    }

    .sidebare #leftside-navigation ul li a i .fa-angle-left,
    .sidebare #leftside-navigation ul li a i .fa-angle-right {
        padding-top: 3px;
    }

    .sidebare #leftside-navigation ul ul {
        display: none;
    }

    .sidebare #leftside-navigation ul ul li {
        background: #23313f;
        margin-bottom: 0;
        margin-left: 0;
        margin-right: 0;
        border-bottom: none;
    }

    .sidebare #leftside-navigation ul ul li a {
        font-size: 13px;
        padding-top: 13px;
        padding-bottom: 13px;
        color: #c5c9d2;
    }

    .text-lime {
        color: #B2FF59 !important;
    }

    .text-grey {
        color: #B0BEC5 !important;
    }
</style>

<div class="row">

    @php

        $merchantMenus = \App\MerchantMenus::where('status', 1)->orderBy('menu_no', 'asc')->get();

        $mcount = [];
    @endphp

    @php
        $logoPath = DB::table('logo')->first();
    @endphp

    <aside class="sidebare">
        <div id="leftside-navigation" class="nano">
            <ul class="nano-content">
                <li>
                    <div class="text-center" style="">
                        <img class="Logo" src="{{ asset('images/' . $logoPath->path) }}" width="100" height="52px"
                            alt="logo" />
                    </div>
                </li>




                @if ($merchantMenus)
                    @foreach ($merchantMenus as $menu)
                        @if (getMerchantServiceStatus($menu))
                            @if ($menu->insert_link)
                                <li class="{{ in_array(Request::path(), [$menu->menu_link]) ? 'active' : '' }}">
                                    <a href="{{ url('/') }}/{{ $menu->menu_link }}"><i
                                            class="{{ $menu->menu_icon }}"
                                            style="color:{{ $menu->menu_color }}"></i><span>{{ $menu->menu_name }}</span></a>
                                </li>
                            @else
                                <li class="sub-menu">
                                    <a href="javascript:void(0);"><i class="{{ $menu->menu_icon }}"
                                            style="color:{{ $menu->menu_color }}"></i><span>{{ $menu->menu_name }}</span><i
                                            class="arrow fa fa-angle-right pull-right"></i></a>
                                    @php

                                        $subMenus = \App\MerchantSubmenus::where('submenu_under', $menu->menu_id)
                                            ->where('status', 1)
                                            ->orderBy('submenu_no', 'asc')
                                            ->get();
                                        $mcount[] = ['id' => $menu->menu_id, 'is_always_open' => $menu->is_always_open];
                                    @endphp

                                    @if ($subMenus)
                                        <ul id="subMenu{{ $menu->menu_id }}">
                                            @foreach ($subMenus as $submenu)
                                                @if (App\Classes\MerchantValidate::validateMenu() || $submenu->merchant_validation_check == 0)
                                                    <li class="{{ in_array(Request::path(), [$submenu->submenu_link]) ? 'active' : '' }}  "
                                                        id="sidesubmenu"><a
                                                            href="{{ url('/') }}/{{ $submenu->submenu_link }}">{{ $submenu->submenu_name }}</a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endif
                    @endforeach
                @endif





            </ul>
        </div>
    </aside>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $("#leftside-navigation .sub-menu > a").click(function(e) {
        $("#leftside-navigation ul ul").slideUp(),
            $(this).next().is(":visible") || $(this).next().slideDown(),
            e.stopPropagation();
    });
</script>


<script>
    var mcount = (<?php echo json_encode($mcount); ?>)
    console.log(mcount);
    $.each(mcount, function(index, value) {
        if ($('#subMenu' + value.id).children().hasClass('active')) {
            $('#subMenu' + value.id).css("display", "block");


        } else {

        }

    });
</script>
