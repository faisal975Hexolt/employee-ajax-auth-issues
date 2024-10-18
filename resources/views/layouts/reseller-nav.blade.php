<style>
    @import url("https://fonts.googleapis.com/css?family=Open+Sans:300,400,700");
    @import url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css");

    body {
        color: #5d5f63;
        height: 100vh;
        width: 100vw;
        font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
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
        height: 100%;
        width: 220px;
        background: #293949;
        position: fixed;
        top: 0;
        left: 0;
        transition: all 0.3s ease-in-out;
        z-index: 1040;
    }

    .sidebare #leftside-navigation ul,
    .sidebare #leftside-navigation ul ul {
        margin: 0;
        padding: 0;
    }

    .sidebare #leftside-navigation ul li {
        list-style-type: none;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }

    .sidebare #leftside-navigation ul li.active>a {
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

    .sidebare #leftside-navigation ul ul {
        display: none;
    }

    .sidebare #leftside-navigation ul ul li {
        background: #23313f;
        margin: 0;
        border-bottom: none;
    }

    .sidebare #leftside-navigation ul ul li a {
        font-size: 13px;
        padding: 13px 0 13px 25px;
        color: #c5c9d2;
    }

    .text-lime {
        color: #B2FF59 !important;
    }

    .text-grey {
        color: #B0BEC5 !important;
    }

    .arrow {
        float: right;
        margin-right: 20px;
    }

    .activeul {
        display: block !important;
    }
</style>
@php
    $mainLinks = [
        'payin' => [
            'icon' => 'fa-exchange',
            'color' => 'lightgreen',
            'label' => 'Payin',
            'submenus' => [
                ['link' => 'reseller/dashboard', 'label' => 'Dashboard'],
                ['link' => 'reseller/payin/transaction_list', 'label' => 'Transaction List'],
                ['link' => 'reseller/payin/transaction_report', 'label' => 'Transaction Report'],
                ['link' => 'reseller/payin/transactions_count', 'label' => 'Transaction Count'],
                ['link' => 'reseller/payin/transactions_count_summary', 'label' => 'Transaction Summary'],
            ],
        ],
        'payout' => [
            'icon' => 'fa-exchange',
            'color' => 'lightgreen',
            'label' => 'Payout',
            'submenus' => [
                ['link' => 'reseller/payout/dashboard', 'label' => 'Dashboard'],
                ['link' => 'reseller/payout/transactions', 'label' => 'Transactions'],
                ['link' => 'reseller/payout/payout_report', 'label' => 'Payout Report'],
            ],
        ],
        // 'myAccount' => [
        //     'icon' => 'fa-user',
        //     'color' => 'white',
        //     'label' => 'Acc & Setting',
        //     'submenus' => [
        //         ['link' => 'reseller/myAccount', 'label' => 'My Account']
        //     ],
        // ],
    ];
    $currentPath = Request::path();

    $logoPath = DB::table('logo')->first();

@endphp

<aside class="sidebare">
    <div id="leftside-navigation">
        <ul>
            <li>
                <div class="text-center">

                        <img src="{{ asset('images/' . $logoPath->path) }}" width="100" height="52" alt="yourpg">
                </div>
            </li>
            @foreach ($mainLinks as $key => $menu)
                @if (isset($menu['submenus']))
                    @php
                        $submenuActive = false;
                        foreach ($menu['submenus'] as $submenu) {
                            if ($submenu['link'] == $currentPath) {
                                $submenuActive = true;
                                break;
                            }
                        }
                    @endphp
                    <li class="sub-menu ">
                        <a href="javascript:void(0);">
                            <i class="fa {{ $menu['icon'] }}" style="color:{{ $menu['color'] }}"></i>
                            <span>{{ $menu['label'] }}</span>
                            <i class="arrow fa fa-angle-right pull-right"></i>
                        </a>
                        <ul class="{{ $submenu['link'] == $currentPath ? 'activeul' : '' }}">
                            @foreach ($menu['submenus'] as $submenu)
                                <li class="{{ $submenu['link'] == $currentPath ? 'active' : '' }}">
                                    <a href="{{ url('/') }}/{{ $submenu['link'] }}">{{ $submenu['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="{{ $menu['link'] == $currentPath ? 'active' : '' }}">
                        <a href="{{ url('/') }}/{{ $menu['link'] }}">
                            <i class="fa {{ $menu['icon'] }}" style="color:{{ $menu['color'] }}"></i>
                            <span>{{ $menu['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

            <li>
                <form id="logout-form" action="{{ route('reseller.logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
                <a href="{{ route('reseller.logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out fa-lg" style="color:#b6b6b6"></i>
                    <span>Log Out</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script>
    $("#leftside-navigation .sub-menu > a").click(function(e) {
        $("#leftside-navigation ul ul").slideUp();
        if (!$(this).next().is(":visible")) {
            $(this).next().slideDown();
        }
        e.stopPropagation();
    });
</script>
