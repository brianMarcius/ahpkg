<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AHPKG DISDIKBUDPORA Kab. Semarang</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicon.png')?>">
    <!-- Pignose Calender -->
    <link href="<?= base_url('assets/plugins/pg-calendar/css/pignose.calendar.min.css')?>" rel="stylesheet">
    <!-- Chartist -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/chartist/css/chartist.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/plugins/chartist-plugin-tooltips/css/chartist-plugin-tooltip.css')?>">
    <!-- Custom Stylesheet -->
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="<?= base_url('assets/css/style.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/icons/font-awesome/css/font-awesome.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/tables/css/datatable/dataTables.bootstrap4.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/toastr/css/toastr.min.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/sweetalert/css/sweetalert.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/plugins/summernote/dist/summernote.css')?>" rel="stylesheet">
    <!-- <link rel="stylesheet" href="http://cdn.jsdelivr.net/jquery.joyride/2.1/joyride.css" /> -->
    <!-- <link href="<?= base_url('assets/css/skeleton.css')?>" rel="stylesheet"> -->
    <link href="<?= base_url('assets/css/normalize.css')?>" rel="stylesheet">
    <link href="<?= base_url('assets/css/pageintro.css')?>" rel="stylesheet">
    <style type="text/css">

@media print {
    /* * { overflow: visible !important; }  */

    body * {
    visibility: hidden;
  }
  
  #section-to-print, #section-to-print * {
    visibility: visible;
  }

  #notprint{
      display : none !important;
  }

  #section-to-print {
    left: 0 !important;
    top: 0 !important;
    margin-left : 0px !important;
    width:100%;
  }

}


</style>





</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo">
                <a href="/dashboard" class="pt-2 pl-2">
                    <span class="logo-abbr"><img class="mr-3"  style="width:3rem;" src="<?= base_url('assets/images/logo_kab_semarang.png')?>" alt=""></span>
                    <span class="logo-compact"><img src="<?= base_url('assets/images/logo_kab_semarang.png')?>" alt=""></span>
                    <span class="brand-title">
                    <h2 class="text-white"><img class="mr-2" style="width:3rem;" src="<?= base_url('assets/images/logo_kab_semarang.png')?>"/> AHPKG</h2>
                    </span>
                </a>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">    
            <div class="header-content clearfix">
                
                <div class="nav-control">
                    <div class="hamburger">
                        <span class="toggle-icon" id="step8"><i class="icon-menu"></i></span>
                    </div>
                </div>
                <div class="header-left">
                    <!-- <div class="input-group icons">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-transparent border-0 pr-2 pr-sm-3" id="basic-addon1"><i class="mdi mdi-magnify"></i></span>
                        </div>
                        <input type="search" class="form-control" placeholder="Search Dashboard" aria-label="Search Dashboard">
                        <div class="drop-down animated flipInX d-md-none">
                            <form action="#">
                                <input type="text" class="form-control" placeholder="Search">
                            </form>
                        </div>
                    </div> -->
                </div>
                <div class="header-right" id="">
                    <ul class="clearfix">
                        <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="fa fa-question-circle-o"></i>
                                <!-- <span class="badge badge-pill gradient-1">3</span> -->
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">Tutorial</span>  
                                    <a href="javascript:void()" class="d-inline-block">
                                        <!-- <span class="badge badge-pill gradient-1">3</span> -->
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <h4 class="float-left mr-3">1.</h4>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Profile</div>
                                                    <!-- <div class="notification-timestamp">08 Hours ago</div> -->
                                                    <div class="notification-text">Klik icon profile pada bagian pojok kanan untuk mengatur profile dan logout. </div>
                                                </div>
                                        </li>
                                        <li>
                                        <h4 class="float-left mr-3">2.</h4>
                                                <div class="notification-content">
                                                    <div class="notification-heading">School</div>
                                                    <!-- <div class="notification-timestamp">08 Hours ago</div> -->
                                                    <div class="notification-text">Klik menu master data pada bagian kiri halaman kemudian pilih submenu school untuk mengelola sekolah. </div>
                                                </div>
                                        </li>
                                        <li>
                                        <h4 class="float-left mr-3">3.</h4>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Evaluation</div>
                                                    <!-- <div class="notification-timestamp">08 Hours ago</div> -->
                                                    <div class="notification-text">Klik menu evaluation pada bagian kiri halaman untuk mengisikan data evaluasi sekolah. </div>
                                                </div>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </li>
                        <!-- <li class="icons dropdown"><a href="javascript:void(0)" data-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="badge badge-pill gradient-2">3</span>
                            </a>
                            <div class="drop-down animated fadeIn dropdown-menu dropdown-notfication">
                                <div class="dropdown-content-heading d-flex justify-content-between">
                                    <span class="">2 New Notifications</span>  
                                    <a href="javascript:void()" class="d-inline-block">
                                        <span class="badge badge-pill gradient-2">5</span>
                                    </a>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events near you</h6>
                                                    <span class="notification-text">Within next 5 days</span> 
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Started</h6>
                                                    <span class="notification-text">One hour ago</span> 
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Event Ended Successfully</h6>
                                                    <span class="notification-text">One hour ago</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-danger-lighten-2"><i class="icon-present"></i></span>
                                                <div class="notification-content">
                                                    <h6 class="notification-heading">Events to Join</h6>
                                                    <span class="notification-text">After two days</span> 
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                    
                                </div>
                            </div>
                        </li> -->
                        <li class="icons dropdown d-none d-md-flex">
                            <a href="javascript:void(0)" class="log-user"  data-toggle="dropdown">
                                <span>English</span>  <i class="fa fa-angle-down f-s-14" aria-hidden="true"></i>
                            </a>
                            <div class="drop-down dropdown-language animated fadeIn  dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="javascript:void()">English</a></li>
                                        <!-- <li><a href="javascript:void()">Indonesia</a></li> -->
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="icons dropdown" id="step1">
                            <div class="user-img c-pointer position-relative "   data-toggle="dropdown">
                                <span class="activity active"></span>
                                <img src="<?= base_url('assets/images/user/1.png')?>" height="40" width="40" alt="">
                            </div>
                            <div class="drop-down dropdown-profile animated fadeIn dropdown-menu">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li id="step2">
                                            <a href="/master/users/profile"><i class="icon-user"></i> <span>Profile</span></a>
                                        </li>
                                        <!-- <li>
                                            <a href="javascript:void()">
                                                <i class="icon-envelope-open"></i> <span>Inbox</span> <div class="badge gradient-3 badge-pill gradient-1">3</div>
                                            </a>
                                        </li> -->
                                        
                                        <hr class="my-2">
                                        <!-- <li>
                                            <a href="page-lock.html"><i class="icon-lock"></i> <span>Lock Screen</span></a>
                                        </li> -->
                                        <li id="step3"><a href='/logout'><i class="icon-key"></i> <span>Logout</span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
