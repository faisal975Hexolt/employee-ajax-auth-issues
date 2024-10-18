@php
    use App\Http\Controllers\ResellerController;

    $per_page = ResellerController::page_limit();
@endphp
@extends('layouts.resellercontent')
@section('resellercontent')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .card {
            background-color: #fff;
            border-radius: 10px;
            border: #f78ca0 1px solid;
            padding: 10px 5px 10px 5px;
        }

        body {
            /*background-color: #efefef;*/
            background-color: #fff;
            font-family: Arial, sans-serif, 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans';
            font-size: 15px;
            line-height: 1.6;
            color: #636b6f
        }

        textarea {
            resize: none;
        }

        .box {
            max-width: 100%;
            border: 1px solid #c3c3c3;
            /*  height: 300px;*/
            padding: 10px;
            margin: 10px;
        }

        .app-card.border-left-decoration {
            border-left: 3px solid #15a362;
        }

        .app-card {
            position: relative;
            background: #fff;
            border-radius: .25rem;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }

        .shadow-sm {
            box-shadow: 0 0.125rem 0.25rem rgb(0 0 0 / 8%) !important;
        }

        .alert-dismissible {
            padding-right: 3rem;
        }

        .p-lg-4 {
            padding: 1.5rem !important;
        }

        .mb-3 {
            margin: 0px;
        }

        .app-card-stat .stats-figure {
            font-size: 2rem;
            color: #252930;
        }

        .alert {
            position: relative;
            padding: 1rem 1rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
            border-radius: .25rem;
        }

        .app-card-stat {
            text-align: center;
            border: 1px solid #c3c3c3;
        }

        .app-card {
            position: relative;
            background: #f5f6fe;
            border-radius: .25rem;
            border: 1px solid #c3c3c3;
        }

        .app-card .app-card-header {
            border-bottom: 1px solid #c3c3c3;
        }

        .align-items-center {
            -webkit-align-items: center !important;
            align-items: center !important;
        }

        .justify-content-between {
            -webkit-justify-content: space-between !important;
            justify-content: space-between !important;
        }

        .app-card .app-card-link-mask {
            position: absolute;
            width: 100%;
            height: 100%;
            display: block;
            left: 0;
            top: 0;
        }

        .col-auto {
            -webkit-flex: 0 0 auto;
            flex: 0 0 auto;
            width: auto;
        }

        .app-card .app-card-title {
            font-size: 15px;
            margin: 20px 30px;
            float: left;
        }

        .app-card .card-header-action {
            font-size: 15px;
            margin: 20px 30px;
            float: right;
        }

        .app-card .chart-container p {
            text-align: center;
            padding: 100px;
        }

        .mandatory {
            color: red;
            font-size: large;
        }

        .zero-width {
            width: 0%;
        }

        .full-width {
            width: 100%;
        }

        .managepay-logo {
            max-width: 100px;
            background-color: #fff;
            border-radius: 2px solid #fff;
        }

        .managepay-porder-logo {
            width: 50%;
        }

        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
        }

        .padding-20 {
            padding: 20px;
        }

        .padding-10 {
            padding: 10px;
        }

        /*side bar css*/

        /*side bar css*/
        .sidebar-wrapper,
        .sidebar-wrapper .sidebar-dropdown>a:after,
        .sidebar-wrapper ul li a i,
        .page-wrapper .page-content {
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -o-transition: all 0.3s;
            -ms-transition: all 0.3s;
            transition: all 0.3s;
        }

        @keyframes swing {
            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(10deg);
            }

            30% {
                transform: rotate(0deg);
            }

            40% {
                transform: rotate(-10deg);
            }

            50% {
                transform: rotate(0deg);
            }

            60% {
                transform: rotate(5deg);
            }

            70% {
                transform: rotate(0deg);
            }

            80% {
                transform: rotate(-5deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /*----------------sidebar-wrapper----------------*/
        .sidebar-wrapper,
        .sidebar-wrapper .sidebar-dropdown>a:after,
        .sidebar-wrapper ul li a i,
        .page-wrapper .page-content {
            -webkit-transition: all 0.3s;
            -moz-transition: all 0.3s;
            -o-transition: all 0.3s;
            -ms-transition: all 0.3s;
            transition: all 0.3s;
            z-index: 10001;
        }

        @keyframes swing {
            0% {
                transform: rotate(0deg);
            }

            10% {
                transform: rotate(10deg);
            }

            30% {
                transform: rotate(0deg);
            }

            40% {
                transform: rotate(-10deg);
            }

            50% {
                transform: rotate(0deg);
            }

            60% {
                transform: rotate(5deg);
            }

            70% {
                transform: rotate(0deg);
            }

            80% {
                transform: rotate(-5deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        /*----------------page-wrapper----------------*/
        .page-wrapper {
            height: 100vh;
        }

        /*----------------toggeled sidebar----------------*/
        .page-wrapper.toggled .sidebar-wrapper {
            left: 0px;
        }

        @media screen and (min-width: 768px) {
            .page-wrapper.toggled .page-content {
                padding-left: 300px;
            }
        }

        @media screen and (min-width:1280px) {
            .navbar-left {
                float: left !important;
                margin-left: 100px;
            }
        }

        @media screen and (min-width:1440px) {
            .navbar-left {
                float: left !important;
                margin-left: 30px;
            }
        }



        .page-wrapper.toggled #toggle-sidebar {
            position: absolute;
            color: #cacaca;
        }

        /*----------------sidebar-wrapper----------------*/
        .sidebar-wrapper {
            width: 260px;
            background: #5d1c84;
            height: 100%;
            max-height: 100%;
            position: fixed;
            top: 0;
            left: -300px;
        }

        .sidebar-wrapper ul li:hover a i,
        .sidebar-wrapper .sidebar-dropdown .sidebar-submenu li a:hover:before,
        .sidebar-wrapper .sidebar-search input.search-menu:focus+span,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active a i {
            color: #fb5edf;
        }

        .sidebar-wrapper ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .sidebar-wrapper a {
            text-decoration: none;
        }

        /*----------------sidebar-content----------------*/
        .sidebar-content {
            max-height: calc(100% - 30px);
            height: calc(100% - 30px);
            overflow-y: auto;
            position: relative;
            background-color: #5d1c84;
        }

        .sidebar-content.desktop {
            overflow-y: hidden;
        }

        /*--------------------sidebar-brand----------------------*/
        .sidebar-wrapper .sidebar-brand {
            padding: 2px 4px;
            text-align: center;
            background-color: #ffffff;
        }

        .sidebar-wrapper .sidebar-brand>a {
            color: #fff;
            text-transform: uppercase;
            font-weight: bold;
        }

        /*--------------------sidebar-header----------------------*/
        .sidebar-wrapper .sidebar-header {
            padding: 20px;
            overflow: hidden;
            border-top: 1px solid #2b2b2b;
        }

        .sidebar-wrapper .sidebar-header .user-pic {
            float: left;
            width: 60px;
            padding: 2px;
            border: 1px solid #585858;
            border-radius: 8px;
            margin-right: 15px;
        }

        .sidebar-wrapper .sidebar-header .user-info {
            float: left;
            color: #b3b8c1;
        }

        .sidebar-wrapper .sidebar-header .user-info span {
            display: block;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-role {
            font-size: 12px;
            color: #7c818a;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-status * {
            display: inline-block;
            color: #7c818a;
            font-size: 12px;
        }

        .sidebar-wrapper .sidebar-header .user-info .user-status i {
            font-size: 8px;
            color: #21e80b;
        }

        /*-----------------------sidebar-search------------------------*/

        .sidebar-wrapper .sidebar-search {
            border-top: 1px solid #2b2b2b;
        }

        .sidebar-wrapper .sidebar-search>div {
            padding: 10px 20px;
        }

        .sidebar-wrapper .sidebar-search input.search-menu,
        .sidebar-wrapper .sidebar-search .input-group-addon {
            background: #2b2b2b;
            box-shadow: none;
            color: #7c818a;
            border-color: #2b2b2b;
            transition: color 0.5s;
        }

        /*----------------------sidebar-menu-------------------------*/
        .sidebar-wrapper .sidebar-menu {
            border-top: 1px solid #2b2b2b;
            /* padding-bottom: 10px; */
            background-color: #5d1c84 !important;
        }

        .sidebar-wrapper .sidebar-menu .header-menu span {
            font-weight: bold;
            font-size: 14px;
            color: #4e5767;
            padding: 15px 20px 5px 20px;
            display: inline-block;
        }

        .sidebar-wrapper .sidebar-menu ul li a {
            display: inline-block;
            width: 100%;
            color: #7c818a;
            text-decoration: none;
            transition: color 0.3s;
            position: relative;
            /*padding: 8px 30px 8px 20px;*/
            padding: 8px 25px 8px 10px;
        }

        .sidebar-wrapper .sidebar-menu ul li:hover>a,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active>a {
            color: #b3b8c1;
        }


        .sidebar-wrapper .sidebar-menu ul li a i {
            margin-right: 10px;
            font-size: 14px;
            background: #5d1c84;
            width: 30px;
            height: 30px;
            line-height: 30px;
            text-align: center;
            border-radius: 4px;
        }

        .sidebar-wrapper .sidebar-menu ul li a:hover>i::before {
            display: inline-block;
            animation: swing ease-in-out 0.5s 1 alternate;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown div {
            background: #2b2b2b;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown>a:after {
            /* content: "\f105";
                  font-family: FontAwesome;*/
            font-weight: 400;
            font-style: normal;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            background: 0 0;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            position: absolute;
            right: 15px;
            top: 14px;
        }

        /* .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu ul {
                  padding: 5px 0;
                } */

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li {

            font-size: 13px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a:before {
            content: "\f054";
            font-family: FontAwesome;
            font-weight: 400;
            font-style: normal;
            display: inline-block;
            text-align: center;
            text-decoration: none;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            margin-right: 10px;
            font-size: 10px;
        }

        .sidebar-wrapper .sidebar-menu ul li a span.label,
        .sidebar-wrapper .sidebar-menu ul li a span.badge {
            float: right;
            margin-top: 8px;
            margin-left: 5px;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .badge,
        .sidebar-wrapper .sidebar-menu .sidebar-dropdown .sidebar-submenu li a .label {
            float: right;
            margin-top: 0px;
        }

        .sidebar-wrapper .sidebar-menu .badge {
            background: #384558;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-submenu {
            display: none;
        }

        .sidebar-wrapper .sidebar-menu .sidebar-dropdown.active>a:after {
            transform: rotate(90deg);
            right: 17px;
        }

        /*--------------------------side-footer------------------------------*/

        .sidebar-footer {
            position: absolute;
            width: 100%;
            bottom: 0;
            display: flex;
            background: #2b2b2b;
        }

        .sidebar-footer>a {
            flex-grow: 1;
            text-align: center;

            height: 30px;
            line-height: 30px;
            color: #7c818a;
            position: relative;
        }

        .sidebar-footer>a:hover {
            color: #b3b8c1;
        }

        .sidebar-footer>a .notification {
            position: absolute;
            top: 0;
        }

        /*--------------------------page-content-----------------------------*/
        .page-wrapper .page-content {
            display: inline-block;
            width: 100%;
            padding-left: 0px;
        }

        .page-wrapper .page-content>div {
            padding: 20px 40px;
        }

        .page-wrapper .page-content {
            overflow-x: hidden;
        }

        /*---------------------toggle-sidebar button-------------------------*/
        #toggle-sidebar {
            position: fixed;
            top: 13px;
            left: 25px;
            color: #fff;
            font-size: 18px;
        }

        /*----------------  Scroll bar style   --------------- */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
            color: #9c9c9c;
        }

        ::-webkit-scrollbar-button {
            width: 0px;
            height: 0px;
        }

        ::-webkit-scrollbar-thumb {
            background: #657692;
            border: 0px none #ffffff;
            border-radius: 50px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #657692;
        }

        ::-webkit-scrollbar-thumb:active {
            background: #657692;
        }

        ::-webkit-scrollbar-track {
            background: #0c1119;
            border: 0px none #ffffff;
            border-radius: 71px;
        }

        ::-webkit-scrollbar-track:hover {
            background: #0c1119;
        }

        ::-webkit-scrollbar-track:active {
            background: #0c1119;
        }

        ::-webkit-scrollbar-corner {
            background: transparent;
        }

        /*for navigation fixed */
        body {
            padding-top: 70px;
        }

        /*for navigation fixed */

        /*for showing cursor */
        .show-pointer {
            cursor: pointer;
        }

        /*for showing cursor */

        .src form input {
            display: block;
            border: 2px solid #178dbb;
        }

        .src input {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 37.5px;
            line-height: 30px;
            outline: 0;
            border: 0;
            display: none;
            font-size: 1em;
            border-radius: 20px;
            padding: 0 20px;
        }

        .daterangepicker .drp-calendar {
            display: none;
            max-width: 310px !important;
        }

        .src form {
            width: 250px !important;
            cursor: pointer;
        }

        .src form {
            position: relative;
            left: 90%;
            bottom: 82px;
            transform: translate(-50%, -50%);
            transition: all 1s;
            width: 50px;
            background: white;
            box-sizing: border-box;
            border-radius: 15px;
        }

        .srct form {
            width: 405px !important;
            cursor: pointer;
        }

        .srct form {

            left: 85%;

        }

        .src .fa {
            box-sizing: border-box;
            padding: 10px;
            width: 42.5px;
            height: 37.5px;
            position: absolute;
            top: 0;
            right: 0;
            border-radius: 50%;
            color: white;
            background: #178dbb;
            text-align: center;
            font-size: 1.2em;
            transition: all 1s;
        }

        .page-footer {
            padding-left: 5px;
            width: 100%;
            background-color: #5d1c84;
            position: fixed;
            bottom: 0;
            left: 0;
            height: auto;
            left: 0px;
            z-index: 9;
        }

        table {
            width: 100%;
        }

        /* td {
                  max-width: 0;
                  overflow: hidden;
                  text-overflow: ellipsis;
                  white-space: nowrap;
                } */
        td.columnA {
            width: 30%;
        }

        td.columnB {
            width: 70%;
        }

        div>.vertical-align-center {
            padding: 12px;
        }

        .vertical-align-center {
            vertical-align: middle !important;
        }

        .mr-5 {
            margin-left: 5px;
        }

        .mr-10 {
            margin-left: 10px;
        }

        .mr-20 {
            margin-left: 20px;
        }

        .edit-customer-address-btn {
            border-radius: 14px;
        }

        /*=======================For Check Box Custom Style====================*/
        .checkbox label:after,
        .radio label:after {
            content: '';
            display: table;
            clear: both;
        }

        .checkbox .cr,
        .radio .cr {
            position: relative;
            display: inline-block;
            border: 1px solid #a9a9a9;
            border-radius: .25em;
            width: 1.3em;
            height: 1.3em;
            float: left;
            margin-right: .5em;
        }

        .radio .cr {
            border-radius: 50%;
        }

        .checkbox .cr .cr-icon,
        .radio .cr .cr-icon {
            position: absolute;
            font-size: .8em;
            line-height: 0;
            top: 50%;
            left: 20%;
        }

        .radio .cr .cr-icon {
            margin-left: 0.04em;
        }

        .checkbox label input[type="checkbox"],
        .radio label input[type="radio"] {
            display: none;
        }

        .checkbox label input[type="checkbox"]+.cr>.cr-icon,
        .radio label input[type="radio"]+.cr>.cr-icon {
            transform: scale(3) rotateZ(-20deg);
            opacity: 0;
            transition: all .3s ease-in;
        }

        .checkbox label input[type="checkbox"]:checked+.cr>.cr-icon,
        .radio label input[type="radio"]:checked+.cr>.cr-icon {
            transform: scale(1) rotateZ(0deg);
            opacity: 1;
        }

        .checkbox label input[type="checkbox"]:disabled+.cr,
        .radio label input[type="radio"]:disabled+.cr {
            opacity: .5;
        }

        /*Loading Gif On Screen Style*/
        #divLoading {
            display: none;
        }

        #divLoading.show {
            display: block;
            position: fixed;
            z-index: 99999;
            background-image: url('../images/loading.gif');
            background-color: #000;
            opacity: 0.7;
            background-repeat: no-repeat;
            background-position: center;
            left: 0;
            bottom: 0;
            right: 0;
            top: 0;
        }

        #loadinggif.show {
            left: 50%;
            top: 50%;
            position: absolute;
            z-index: 101;
            width: 32px;
            height: 32px;
            margin-left: -16px;
            margin-top: -16px;
        }

        /*Chat Box Style*/

        .case-details {
            margin-top: 50px;
        }

        .people-list {
            float: left;
        }

        .people-list .search {
            padding: 20px;
        }

        .people-list input {
            border-radius: 3px;
            border: none;
            padding: 14px;
            color: white;
            background: #6a6c75;
            width: 90%;
            font-size: 14px;
        }

        .people-list .fa-search {
            position: relative;
            left: -25px;
        }

        .people-list ul {
            padding: 20px;
            height: auto;
        }

        .people-list ul li {
            padding-bottom: 20px;
            list-style-type: none;
        }

        .people-list img {
            float: left;
        }

        .people-list .about {
            float: left;
            margin-top: 8px;
        }

        .people-list .about {
            padding-left: 8px;
        }

        .people-list .status {
            color: #92959e;
        }

        .chat {
            width: 490px;
            float: left;
            background: #f2f5f8;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            color: #434651;
        }

        .chat .chat-header {
            padding: 20px;
            border-bottom: 2px solid white;
        }

        .chat .chat-header img {
            float: left;
        }

        .chat .chat-header .chat-about {
            float: left;
            padding-left: 10px;
            margin-top: 6px;
        }

        .chat .chat-header .chat-with {
            font-weight: bold;
            font-size: 16px;
        }

        .chat .chat-header .chat-num-messages {
            color: #92959e;
        }

        .chat .chat-header .fa-star {
            float: right;
            color: #d8dadf;
            font-size: 20px;
            margin-top: 12px;
        }

        /* .chat .chat-history {
                  padding: 30px 30px 20px;
                  border-bottom: 2px solid white;
                  overflow-y: scroll;
                  height: 575px;
                } */
        .chat .chat-history {
            padding: 30px 30px 20px;
            border-bottom: 2px solid white;
            overflow-y: scroll;
            height: 575px;
            position: fixed;
            bottom: 6px;
            top: 0px;
            width: 56%
        }

        .chat .chat-history .message-data {
            margin-bottom: 15px;
        }

        .chat .chat-history .message-data-time {
            color: #a8aab1;
            padding-left: 6px;
        }

        .chat .chat-history .message {
            color: white;
            padding: 18px 10px;
            line-height: 26px;
            font-size: 16px;
            border-radius: 7px;
            margin-bottom: 30px;
            width: 100%;
            position: relative;
        }

        .chat .chat-history .message:after {
            bottom: 100%;
            left: 7%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-bottom-color: #86bb71;
            border-width: 10px;
            margin-left: -10px;
        }

        .chat .chat-history .my-message {
            background: #171b2f;
            font-family: 'Open Sans', sans-serif;
        }

        .chat .chat-history .other-message {
            background: #178ddb;
            font-family: 'Open Sans', sans-serif;
        }

        .chat .chat-history .other-message:after {
            border-bottom-color: #94c2ed;
            left: 93%;
        }

        .chat-history>ul>li {
            position: relative;
            top: 40px;
        }

        .chat .chat-message {
            position: fixed;
            padding: 30px 0px 30px 25px;
            bottom: 5px;
            right: 0px;
            width: 54%;
        }

        .chat .chat-message textarea {
            width: 100%;
            border: none;
            padding: 10px 20px;
            font: 14px/22px "Lato", Arial, sans-serif;
            margin-bottom: 10px;
            border-radius: 5px;
            resize: none;
            border: 1px solid #171b2f;
        }

        .chat .chat-message .fa-file-o,
        .chat .chat-message .fa-file-image-o {
            font-size: 16px;
            color: gray;
            cursor: pointer;
        }

        .chat .chat-message button {
            float: right;
            color: #061f5f;
            font-size: 16px;
            text-transform: uppercase;
            border: 1px solid #171b2f;
            cursor: pointer;
            background: #f2f5f8;
            width: 110px;

        }

        .chat .chat-message button:hover {
            background-color: #061f5f;
            color: #fff;
        }

        .online,
        .offline,
        .me {
            margin-right: 3px;
            font-size: 10px;
        }

        .online {
            color: #86bb71;
        }

        .offline {
            color: #e38968;
        }

        .me {
            color: #94c2ed;
        }

        .align-left {
            text-align: left;
        }

        .align-right {
            text-align: right;
        }

        .float-right {
            float: right;
        }

        .clearfix:after {
            visibility: hidden;
            display: block;
            font-size: 0;
            content: " ";
            clear: both;
            height: 0;
        }

        .chat-message>textarea {
            margin-left: 30px;
        }

        .chat-send-button {
            background-color: #171b2f;
            color: rgb(255, 255, 255);
            margin-top: 0%;
            position: absolute;
            padding: 16px;
            top: 20%;
            bottom: 27%;
            right: 10%;
        }

        /**Form Wizard Style css starts here*/
        /* Style the form */
        #regForm {
            background-color: #ffffff;
        }

        /* Style the input fields */
        input {
            padding: 10px;
            width: 100%;
            font-size: 17px;
            font-family: Raleway;
            border: 1px solid #aaaaaa;
        }

        /* Mark input boxes that gets an error on validation: */
        input.invalid {
            background-color: #ffdddd;
        }

        /* Hide all steps by default: */
        .tab {
            display: none;
        }

        /* Make circles that indicate the steps of the form: */
        .step {
            height: 15px;
            width: 15px;
            margin: 0 2px;
            background-color: #bbbbbb;
            border: none;
            border-radius: 50%;
            display: inline-block;
            opacity: 0.5;
        }

        /* Mark the active step: */
        .step.active {
            opacity: 1;
        }

        /* Mark the steps that are finished and valid: */
        .step.finish {
            background-color: #4CAF50;
        }

        /**Form Wizard Style css ends here*/

        @media (max-width: 414px) {
            .chat-history {
                width: 100% !important;
                height: 530px !important;
                padding-left: 0;
                position: relative;
                left: -10px;
                scroll-behavior: auto;
            }

            .chat .chat-message {
                position: fixed;
                bottom: 0px;
                right: 0px;
                padding-left: 10px;
                padding-right: 10px;
                width: 100%;
            }

            .chat .chat-message textarea {
                width: 78% !important;
                border: none;
                font: 14px/22px "Lato", Arial, sans-serif;
                margin-bottom: 35px;
                border-radius: 5px;
                resize: none;
                margin-left: 0px;
            }

            .chat .chat-message button {
                float: right;
                color: #061f5f;
                font-size: 16px;
                text-transform: uppercase;
                border: 1px solid #171b2f;
                cursor: pointer;
                background: #f2f5f8;
                width: 20%;
                text-align: center;
            }

            #btn-1 {
                position: relative;
                margin-right: 0%;
                right: 0px;
            }
        }

        @media (min-width: 768px) {
            .chat-history {
                height: 600px !important;
            }
        }



        @media screen and (min-width: 414px) and (max-width: 576px) {
            .chat-history {
                height: 375px !important;
            }
        }

        @media (min-width: 768px) {
            .chat-history {
                height: 600px !important;


            }
        }

        @media screen and (min-width: 414px) and (max-width: 414px) {

            .people-list {
                width: 100%;
                float: left;
            }

            .people-list ul {
                padding: 20px;
                height: 500px;
            }

            .chat-history {
                width: 100%;
                height: 600px !important;
            }

            .chat .chat-message {
                position: fixed;
                bottom: 0px;
                right: 0px;
                width: 100%;
            }

            .chat .chat-message textarea {
                width: 78% !important;
                border: none;
                font: 14px/22px "Lato", Arial, sans-serif;
                margin-bottom: 40px;
                border-radius: 5px;
                resize: none;
            }

            .chat .chat-message button {
                float: right;
                color: #061f5f;
                font-size: 10px;
                text-transform: uppercase;
                border: 1px solid #171b2f;
                cursor: pointer;
                background: #f2f5f8;
                width: 20%;
                text-align: center;
            }

            #btn-1 {
                position: relative;
                top: 10px;
                margin-right: 0%;
            }
        }

        @media screen and (min-width: 360px) and (max-width: 360px) {

            .people-list {
                width: 100%;
                float: left;
            }

            .people-list ul {
                padding: 20px;
                height: 500px;
            }

            .chat-history {
                width: 100%;
                height: 500px !important;
            }

            .chat .chat-message {
                position: fixed;
                bottom: 0px;
                right: 0px;
                width: 100%;
            }

            .chat .chat-message textarea {
                width: 80% !important;
                border: none;
                font: 14px/22px "Lato", Arial, sans-serif;
                margin-bottom: 40px;
                border-radius: 5px;
                resize: none;
            }

            .chat .chat-message button {
                float: right;
                color: #061f5f;
                font-size: 10px;
                text-transform: uppercase;
                border: 1px solid #171b2f;
                cursor: pointer;
                background: #f2f5f8;
                width: 20%;
                text-align: center;
            }

            #btn-1 {
                position: relative;
                top: 10px;
                margin-right: 0%;
            }
        }

        .set-modal>div.form-group {
            margin-left: -95px;
            margin-right: -15px;
        }


        .form-horizontal .form-fit {
            margin-left: -15px;
            margin-right: 100px !important;
        }

        .input-file-area {
            max-height: 300px;
            overflow-x: hidden;
            overflow-y: scroll;
        }

        fieldset.scheduler-border {
            border: 1px groove #ddd !important;
            padding: 0 1.4em 1.4em 1.4em !important;
            margin: 0 0 1.5em 0 !important;
            -webkit-box-shadow: 0px 0px 0px 0px #000;
            box-shadow: 0px 0px 0px 0px #000;
        }

        legend.scheduler-border {
            font-size: 1.2em !important;
            font-weight: bold !important;
            text-align: left !important;
            width: auto;
            padding: 0 10px;
            border-bottom: none;
        }


        #payment-mode-graph,
        #transaction-status-graph,
        #device-graph {
            width: 100%;
            height: 450px;
        }

        .hide_content {
            display: none;
        }




        .loader {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: url("../images/loader.gif") 50% 50% no-repeat rgb(249, 249, 249);
            opacity: .8;
        }


        .dataTables_processing {
            background-color: rgb(182 174 174 / 70%);
            border: 1px solid transparent;
            border-radius: 4px;
            box-shadow: 0 1px 1px rgb(0 0 0 / 5%);
            margin-bottom: 14px;
        }


        .cust_date_range {
            font-size: 15px !important;
        }




        .sidebar-wrapper .sidebar-menu ul li.selected a {
            background-color: #f31782;
            color: #fff;
        }
    </style>
    <div class="row">
        <div class="col-sm-12 padding-20">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" id="transaction-tabs">
                        <li class="active"><a data-toggle="tab" class="show-cursor" data-target="#dashboard}}">Dashboard</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">



                        <div class="row g-4 mb-4">
                            <div class="col-6 col-lg-6">
                                <input type="text" name="datetimes" id="datetimes"
                                    style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%" />
                            </div>

                            <div class="col-6 col-lg-6">
                                <select name="" class="form-control" id="merchantid">
                                    <option value="all">All</option>
                                    @foreach ($merchantList as $merchant)
                                        <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row g-4 mb-4">

                            <div class="col-6 col-lg-3">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(120deg, #0073b7 0%, #637e8e 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Total
                                            GTV </h4>
                                        <div class="stats-figure" id="gtv" style="color:white;font-weight:900;">
                                            ₹ 0 </div>

                                    </div>

                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(-20deg, #fc6076 0%, #ff9a44 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">
                                            Successful Transactions</h4>
                                        <div class="stats-figure" id="successfulTransaction"
                                            style="color:white;font-weight:900;"> 0
                                        </div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>

                            <div class="col-6 col-lg-3 ">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: linear-gradient(to right, #43e97b 0%, #38f9d7 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">Amount
                                            Refunded</h4>
                                        <div class="stats-figure" id="refund" style="color:white;font-weight:900;">₹0.00
                                        </div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 ">
                                <div class="app-card app-card-stat shadow-sm h-100"
                                    style="background-image: radial-gradient(circle 248px at center, #16d9e3 0%, #30c7ec 47%, #46aef7 100%);">
                                    <div class="app-card-body p-3 p-lg-4">
                                        <h4 class="stats-type mb-1" style="color:white;font-weight:900;height:40px;">
                                            ChargeBack Amount</h4>
                                        <div class="stats-figure" id="chargeback" style="color:white;font-weight:900;">₹0.00
                                        </div>
                                    </div>
                                    <a class="app-card-link-mask" href="#"></a>
                                </div>
                            </div>




                        </div>


                        <div class="row g-4 mb-4 " style="margin-top: 10px;">

                            <div class="col-12 col-lg-12">
                                <div class="card ">
                                    <div class="card-body" id="transactionGraph" style="height:450px; ">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row g-4 mb-4" style="margin-top: 10px;">

                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h3 class="box-title" id="paymentModeTitle">Payments Mode Distribution</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="card-body">
                                        <div id="payment-mode-graph"></div>
                                        <div class="text-center text-muted" id="payment-mode-graph-empty"> No data for
                                            selected date
                                            range
                                        </div>
                                    </div>
                                </div><!-- /.box -->
                            </div>

                            <div class="col-md-6">
                                <div class="card ">
                                    <div class="card-header">
                                        <h3 class="box-title" id="paymentModeTitle">Status Wise Transactions</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="card-body">
                                        <div id="transaction-status-graph"></div>
                                        <div class="text-center text-muted" id="transaction-status-graph-empty"> No data
                                            for
                                            selected date
                                            range
                                        </div>
                                    </div>
                                </div><!-- /.box -->
                            </div>

                            <div class="col-md-6" style="margin-top: 10px;">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title" id="deviceTitle">Device Distribution </h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="card-body">
                                        <div id="device-graph"></div>
                                        <div class="text-center text-muted" id="device-graph-empty"> No data for selected
                                            date range
                                        </div>
                                    </div>
                                </div><!-- /.box -->
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.2/dist/boxicons.js"></script>

    <script src="//cdn.amcharts.com/lib/4/core.js"></script>
    <script src="//cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="//cdn.amcharts.com/lib/4/themes/kelly.js"></script>




    <script type="text/javascript">
        $(function() {

            var start = moment().startOf('day');
            var end = moment().endOf('day');

            function cb(start, end) {
                $('input[name="datetimes"] span').html(start.format('MMMM D, YYYY HH:mm:ss') + ' - ' + end.format(
                    'MMMM D, YYYY HH:mm:ss'));

                merchantId = $('#merchantid').val();



                callingapis(start, end, merchantId);
                callinggraphapi(start, end, merchantId);
            }

            $('input[name="datetimes"]').daterangepicker({
                dateLimit: {
                    days: 1
                },
                startDate: start,
                endDate: end,
                locale: {
                    format: 'DD/MM/YYYY HH:mm:ss'
                },
                timePicker: true,
                timePicker24Hour: false,
                timePickerSeconds: true,
                minDate: moment().subtract(365, 'days'),
                maxDate: moment(),
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days')
                        .endOf('day')
                    ],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'Last 30 Days': [moment().subtract(29, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf(
                        'day')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month').startOf('day'), moment()
                        .subtract(1, 'month').endOf('month').endOf('day')
                    ],
                    'Last 2 Month': [moment().subtract(2, 'month').startOf('month').startOf('day'), moment()
                        .subtract(1, 'month').endOf('month').endOf('day')
                    ]
                }
            }, cb);

            cb(start, end);

            $('#merchantid').on('change', function(event) {
                console.log('working');
                var merchantId = $(this).val();
                var startDate = moment($('#datetimes').data('daterangepicker').startDate);
                var endDate = moment($('#datetimes').data('daterangepicker').endDate);
                console.log(merchantId, startDate, endDate);

                callingapis(startDate, endDate, merchantId);
                callinggraphapi(startDate, endDate, merchantId);
            });

            function callingapis(start, end, merchantid) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    dataType: "json",
                    data: {
                        'start': start.format('YYYY-MM-DD HH:mm:ss'),
                        'end': end.format('YYYY-MM-DD HH:mm:ss'),
                        'merchantId': merchantid

                    },
                    url: '{{ url('/') }}/reseller/dashboardTransactionStats',
                    xhrFields: {
                        withCredentials: true
                    },
                    success: function(data) {

                        console.log('%cdashboard.blade.php line:183 object', 'color: #007acc;', data);

                        $('#totalTransaction').html(data.transactionStats.total_transaction);
                        $('#successfulTransaction').html(data.transactionStats.successful_transaction);
                        $('#failedTransaction').html(data.transactionStats.failed_transaction);
                        $('#gtv').html('₹' + data.transactionStats.gtv);
                        $('#refund').html('₹' + data.transactionStats.refund);
                        $('#chargeback').html();

                    }
                });
            }


            function callinggraphapi(start, end, merchantid) {
                //graph
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "GET",
                    dataType: "json",
                    data: {
                        'start': start.format('YYYY-MM-DD HH:mm:ss'),
                        'end': end.format('YYYY-MM-DD HH:mm:ss'),
                        'merchantId': merchantid

                    },
                    url: '{{ url('/') }}/reseller/dashboardTransactionGraph',
                    success: function(data) {
                        console.log(data);

                        //graph 1 transaction start
                        var currency_symbol = "₹";
                        var currency_code = "INR";

                        function indianNumberFormat(number, type, currency_code) {
                            if (type == "currency") {
                                return parseFloat(number).toLocaleString("en-IN", {
                                    style: type,
                                    currency: currency_code,
                                    currencyDisplay: "symbol",
                                });
                            } else {
                                return parseInt(number).toLocaleString("en-IN", {
                                    style: type,
                                });
                            }
                        }

                        function drawDoughnutGraph(chart, x_axes_label, y_axes_label, label_format,
                            currency_symbol) {

                            chart.radius = am4core.percent(50);
                            chart.innerRadius = am4core.percent(30);

                            // Add and configure Series
                            var pieSeries = chart.series.push(new am4charts.PieSeries());
                            pieSeries.dataFields.value = y_axes_label;
                            pieSeries.dataFields.category = x_axes_label;
                            pieSeries.slices.template.stroke = am4core.color("#fff");
                            pieSeries.slices.template.strokeWidth = 2;
                            pieSeries.slices.template.strokeOpacity = 1;

                            // This creates initial animation
                            pieSeries.hiddenState.properties.opacity = 1;
                            pieSeries.hiddenState.properties.endAngle = -90;
                            pieSeries.hiddenState.properties.startAngle = -90;
                            pieSeries.slices.template.interactionsEnabled = true;

                            var button = chart.chartContainer.createChild(am4core.Button);
                            button.label.text = "Details";
                            button.padding(5, 5, 5, 5);
                            button.width = 100;
                            button.align = "right";
                            button.valign = "bottom";
                            button.marginRight = 15;

                            switch (label_format) {
                                case "amount":
                                    pieSeries.slices.template.tooltipText = "{category}: {amount}";
                                    button.events.on("hit", function(ev) {
                                        window.location.replace(
                                            "rpdaywisebankcodemerchanttransaction/payment-mode-details"
                                        );
                                    });
                                    break;
                                case "count":
                                    pieSeries.slices.template.tooltipText =
                                        "{category}: {tran_count} Transactions";
                                    button.events.on("hit", function(ev) {
                                        window.location.replace(
                                            "rpdaywisemerchantdevicetransaction/device-details"
                                        );
                                    });
                            }
                        }


                        function dashborad_summary_amchartgraph() {

                            // Apply chart themes
                            am4core.useTheme(am4themes_animated);
                            //am4core.useTheme(am4themes_kelly);

                            // Create chart instance
                            var gtv_chart = am4core.create("transactionGraph", am4charts.XYChart);

                            // set scrollbar for x-axes date range
                            gtv_chart.scrollbarX = new am4core.Scrollbar();

                            // setting data for the gtv and tran count chart


                            gtv_chart.data = data.bar_graph;




                            // Legend for the gtv and tran count in the chart
                            gtv_chart.legend = new am4charts.Legend();
                            gtv_chart.legend.useDefaultMarker = true;
                            var marker = gtv_chart.legend.markers.template.children.getIndex(0);
                            marker.cornerRadius(5, 5, 5, 5);
                            marker.strokeWidth = 2;
                            marker.strokeOpacity = 1;

                            // x-axes date format
                            var gtv_dateAxis = gtv_chart.xAxes.push(new am4charts.DateAxis());
                            gtv_dateAxis.dataFields.category = "gtv_date";
                            gtv_dateAxis.dateFormats.setKey("day", "dd-MM-yyyy");

                            // creating value axis and its configuration for gtv

                            var gtv_valueAxis = gtv_chart.yAxes.push(new am4charts.ValueAxis());

                            // gtv_valueAxis.unit = "Rs.";
                            // gtv_valueAxis.unitPosition = "left";
                            gtv_valueAxis.min = 0;
                            gtv_valueAxis.numberFormatter = new am4core.NumberFormatter();
                            gtv_valueAxis.numberFormatter.numberFormat = "#,##,###a";

                            // Set up axis title
                            gtv_valueAxis.title.text = "GTV Amount (" + currency_symbol + ")";

                            // Create gtv series and its configuration
                            var gtv_series = gtv_chart.series.push(new am4charts.ColumnSeries());
                            gtv_series.dataFields.dateX = "gtv_date";
                            gtv_series.dataFields.valueY = "gtv_amount";
                            gtv_series.name = "Gross Transaction Value";

                            // Tooltip for the gtv series
                            gtv_series.tooltipHTML = `GTV Value : {gtv_amount}`;
                            gtv_series.columns.template.strokeWidth = 0;
                            gtv_series.tooltip.pointerOrientation = "vertical";
                            gtv_series.tooltip.numberFormatter.numberFormat = "#,##,###";

                            // The gtv bar chart radius
                            gtv_series.columns.template.column.cornerRadiusTopLeft = 10;
                            gtv_series.columns.template.column.cornerRadiusTopRight = 10;
                            gtv_series.columns.template.column.fillOpacity = 0.8;

                            gtv_series.yAxis = gtv_valueAxis;

                            // creating value axis and its configuration for transaction count
                            var tran_valueAxis = gtv_chart.yAxes.push(new am4charts.ValueAxis());

                            // setting min value for tran count axes
                            tran_valueAxis.min = 0;
                            // tran_valueAxis.strictMinMax=true;

                            // setting number format for transaction count axes
                            tran_valueAxis.numberFormatter = new am4core.NumberFormatter();
                            tran_valueAxis.numberFormatter.numberFormat = "#,###";

                            // Set up axis title for transaction count value axis
                            tran_valueAxis.title.text = "Count";

                            // Showing value count y-axes on the right side of the chart
                            tran_valueAxis.renderer.opposite = true;

                            // Create series and its configuration for transaction count
                            var tran_count_series = gtv_chart.series.push(new am4charts.LineSeries());
                            tran_count_series.dataFields.dateX = "gtv_date";
                            tran_count_series.dataFields.valueY = "tran_count";
                            tran_count_series.name = "Transaction Count";

                            // setting colour for line graph
                            tran_count_series.propertyFields.stroke = "line_colour";
                            tran_count_series.propertyFields.fill = "line_colour";

                            // Tooltip for the transaction count series
                            tran_count_series.tooltipText = "Transaction Count : {tran_count}";
                            tran_count_series.strokeWidth = 2;
                            tran_count_series.propertyFields.strokeDasharray = "dashLength";
                            tran_count_series.yAxis = tran_valueAxis;

                            // circular bullet
                            var circleBullet = tran_count_series.bullets.push(
                                new am4charts.CircleBullet()
                            );
                            circleBullet.circle.radius = 7;
                            circleBullet.circle.stroke = am4core.color("#fff");
                            circleBullet.circle.strokeWidth = 3;

                            // rectangular bullet on hover on tran count series
                            var durationBullet = tran_count_series.bullets.push(new am4charts.Bullet());
                            var durationRectangle = durationBullet.createChild(am4core.Rectangle);
                            durationBullet.horizontalCenter = "middle";
                            durationBullet.verticalCenter = "middle";
                            durationBullet.width = 7;
                            durationBullet.height = 7;
                            durationRectangle.width = 7;
                            durationRectangle.height = 7;

                            var durationState = durationBullet.states.create("hover");
                            durationState.properties.scale = 1.2;

                            // remove cornaer radiuses of bar chart on hover
                            var hoverState = gtv_series.columns.template.column.states.create("hover");
                            hoverState.properties.cornerRadiusTopLeft = 0;
                            hoverState.properties.cornerRadiusTopRight = 0;
                            hoverState.properties.fillOpacity = 1;

                            // setting random colour for bar chart
                            gtv_series.columns.template.adapter.add("fill", function(fill, target) {
                                return gtv_chart.colors.getIndex(target.dataItem.index);
                            });

                            // Cursor
                            gtv_chart.cursor = new am4charts.XYCursor();

                            //  gtv_chart.dispose();

                            /* payment mode graph */


                            payment_mode_graph_dom = $("#payment-mode-graph");
                            payment_mode_graph_empty_dom = $("#payment-mode-graph-empty");
                            payment_mode_json_data = [{
                                "amount": "100.52",
                                "payment_mode": "UPI"
                            }];
                            payment_mode_json_data = data.pay_mode;

                            payment_mode_chart = am4core.create("payment-mode-graph", am4charts
                                .PieChart);

                            drawDoughnutGraph(payment_mode_chart, "payment_mode", "amount", "amount",
                                currency_symbol);

                            // show error message in case if no data or if all data for payment mode is zero
                            if (payment_mode_json_data.length == 0) {

                                payment_mode_graph_empty_dom.css("display", "block");
                                payment_mode_graph_dom.css("display", "none");

                            } else {

                                payment_mode_graph_empty_dom.css("display", "none");
                                payment_mode_graph_dom.css("display", "block");

                                payment_mode_data = [];

                                $.each(payment_mode_json_data, function(key, value) {
                                    payment_mode_data.push({
                                        "payment_mode": value.transaction_mode,
                                        "amount": indianNumberFormat(value.total,
                                            'currency', currency_code),
                                    });
                                });

                                payment_mode_chart.data = payment_mode_data;
                                payment_mode_chart.reinit();


                                /* Device mode graph */

                                device_graph_dom = $("#device-graph");
                                device_graph_empty_dom = $("#device-graph-empty");
                                device_json_data = [{
                                    "tran_count": "99",
                                    "device_type": "desktop"
                                }];

                                device_chart = am4core.create("device-graph", am4charts.PieChart);

                                drawDoughnutGraph(device_chart, "device_type", "tran_count", "count",
                                    currency_symbol);

                                if (device_json_data.length == 0) {

                                    device_graph_empty_dom.css("display", "block");
                                    device_graph_dom.css("display", "none");

                                } else {

                                    device_graph_empty_dom.css("display", "none");
                                    device_graph_dom.css("display", "block");

                                    device_data = [];

                                    $.each(device_json_data, function(key, value) {
                                        device_data.push({
                                            "device_type": value.device_type,
                                            "tran_count": indianNumberFormat(value
                                                .tran_count, 'decimal', null)
                                        });
                                    });

                                    device_chart.data = device_data;
                                    device_chart.reinit();

                                }

                            }

                            // Transaction Status Graph
                            transaction_status_graph_dom = $("#transaction-status-graph");
                            transaction_status_graph_empty_dom = $("#transaction-status-graph-empty");

                            transaction_status_json_data = data.status_mode;

                            transaction_status_chart = am4core.create("transaction-status-graph",
                                am4charts.PieChart);

                            drawDoughnutGraph(transaction_status_chart, "transaction_status", "total",
                                "total", currency_symbol);

                            if (transaction_status_json_data.length == 0) {
                                transaction_status_graph_empty_dom.css("display", "block");
                                transaction_status_graph_dom.css("display", "none");
                            } else {
                                transaction_status_graph_empty_dom.css("display", "none");
                                transaction_status_graph_dom.css("display", "block");

                                transaction_status_data = [];
                                $.each(transaction_status_json_data, function(key, value) {
                                    transaction_status_data.push({
                                        "transaction_status": value.transaction_status,
                                        "total": indianNumberFormat(value.total,
                                            'decimal', null),
                                    });
                                });

                                transaction_status_chart.data = transaction_status_data;
                                transaction_status_chart.reinit();
                            }
                        }

                        dashborad_summary_amchartgraph();
                        //graph 1 end


                    }
                });
            }

        });
    </script>

    <script>
        navigator.vibrate(10000);
    </script>
@endsection
