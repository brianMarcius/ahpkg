<?= $this->include("layouts/header") ?>
<?= $this->include("layouts/sidebar") ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Master</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">School</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Form School</h4>
                                <p class="text-muted m-b-15 f-s-12">Used to add school data in application.</p>
                                <div class="form-validation">
                                    <form class="form-valide" action="/master/school/store" method="post" enctype="multipart/form-data">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-schoolname">School Name <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-schoolname" name="val-schoolname" placeholder="Enter a schoolname.." required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-npsn">NPSN <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-npsn" name="val-npsn" placeholder="Enter a npsn.." required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-address">Address <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-address" name="val-address" placeholder="Your valid address.." required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-telp">Telp
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-telp" name="val-telp" placeholder="Your valid Phone Number..">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-logo">Logo <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="file" class="form-control" id="val-logo" name="val-logo" placeholder="Your cool school logo">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-pengawas">Pengawas <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-pengawas" name="val-pengawas">
                                                    <?php foreach ($pengawas as $p) { ?>
                                                        <option value="<?= $p->id?>"><?= $p->fullname ?></option>
                                                    <?php } ?>
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>

                                        

                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

<?= $this->section('javascript') ?>
    <!-- Toastr -->
    <script src="<?= base_url('assets/plugins/toastr/js/toastr.min.js')?>"></script>
    <script src="<?= base_url('assets/plugins/toastr/js/toastr.init.js')?>"></script>
    <script src="<?= base_url('assets/plugins/validation/jquery.validate-init.js')?>"></script>

    <script type="text/javascript">
        var errorMessage = '<?= $error_message?>';
        $(function() {
            if (errorMessage != '') {
                toastr.error(errorMessage,'Error');            
            }
        });

        $("#val-level").change(function(){
            if ($(this).val()==1) {
                $("#school-container").hide();
            }else{
                $("#school-container").show();
            }
        })

        // $("#val-schoolname").rules('add', {
        //         required : true
        //     });


    </script>
<?= $this->endSection()?>
<?= $this->include("layouts/footer"); ?>
