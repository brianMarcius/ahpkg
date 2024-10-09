
<!DOCTYPE html>
<html class="h-100" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>AHPKG DISDIKBUDPORA Kab. Semarang</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/images/favicon.png')?>">
    <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->
    <link href="<?= base_url('assets/css/style.css')?>" rel="stylesheet">
    
</head>
<body class="h-100">
    
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

    



    <div class="login-form-bg h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100">
                <div class="col-md-7 d-none d-md-block">
                    <div class="form-input-content">
                        <img class="w-100" src="<?= base_url('assets/images/5836.png')?>" />
                    </div>
                                <!-- <div class="bootstrap-carousel">
                                    <div data-ride="carousel" class="carousel slide" id="carouselExampleCaptions">
                                        <ol class="carousel-indicators">
                                            <li class="" data-slide-to="0" data-target="#carouselExampleCaptions"></li>
                                            <li data-slide-to="1" data-target="#carouselExampleCaptions" class=""></li>
                                            <li data-slide-to="2" data-target="#carouselExampleCaptions" class="active"></li>
                                        </ol>
                                        <div class="carousel-inner">
                                            <div class="carousel-item">
                                                <img class="d-block" style="height:100vp;overflow:hidden" src="<?= base_url('assets/images/big/img5.jpg')?>" alt="">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>First slide label</h5>
                                                    <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                                </div>
                                            </div>
                                            <div class="carousel-item">
                                                <img alt="" class="d-block" style="height:100vp;overflow:hidden" src="<?= base_url('assets/images/big/img6.jpg')?>">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Second slide label</h5>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                </div>
                                            </div>
                                            <div class="carousel-item active">
                                                <img alt="" class="d-block" style="height:100vp;overflow:hidden" src="<?= base_url('assets/images/big/img5.jpg')?>">
                                                <div class="carousel-caption d-none d-md-block">
                                                    <h5>Third slide label</h5>
                                                    <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                                                </div>
                                            </div>
                                        </div><a data-slide="prev" href="#carouselExampleCaptions" class="carousel-control-prev"><span class="carousel-control-prev-icon"></span> <span class="sr-only">Previous</span> </a><a data-slide="next" href="#carouselExampleCaptions"
                                            class="carousel-control-next"><span class="carousel-control-next-icon"></span> <span class="sr-only">Next</span></a>
                                    </div>
                                </div> -->
                </div>
                <div class="col-xl-5 bg-white col-sm-12">
                    <div class="form-input-content text-center">
                        <img class="mb-3 mt-5" style="width:12rem;margin-left:auto;margin-right:auto" src="<?= base_url('assets/images/favicon.png')?>"/>
                    <h3>SELAMAT DATANG DI AHPKG</h3>
                    <p class="text-muted">Analisis Hasil Penilaian Kinerja Guru Oleh Pengawas<br>Disdikbudpora Kab. Semarang<br><br></p>
                        <div class="card login-form mb-0">
                            <div class="card-body pt-3">
                                <a class="text-center" href="/"> <h3>Login</h3><p class="text-muted"></p></a>
                                <?php if(session()->getFlashdata('msg')):?>
                                    <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                                <?php endif;?>
                                <form action='/auth' method='POST' class="mt-5 mb-5 login-input">
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="username" placeholder="Username" require>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" placeholder="Password" require>
                                    </div>
                                    <button class="btn login-form__btn submit w-100">Sign In</button>
                                </form>
                                <!-- <p class="mt-5 login-form__footer">Dont have account? <a href="page-register.html" class="text-primary">Sign Up</a> now</p> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="<?= base_url('assets/plugins/common/common.min.js')?>"></script>
    <script src="<?= base_url('assets/js/custom.min.js')?>"></script>
    <script src="<?= base_url('assets/js/settings.js')?>"></script>
    <script src="<?= base_url('assets/js/gleek.js')?>"></script>
    <script src="<?= base_url('assets/js/styleSwitcher.js')?>"></script>
</body>
</html>





