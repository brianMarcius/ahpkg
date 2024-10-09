<?= $this->include("layouts/header") ?>
<?= $this->include("layouts/sidebar") ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Setting</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Criteria</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Form Classification</h4>
                                <p class="text-muted m-b-15 f-s-12">Used to classificate score of evaluation.</p>
                                <div class="form-validation">
                                    <form class="form-valide" action="/setting/criteria/store" method="post">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-criteria">classification Score <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="number" class="form-control" id="val-criteria" max=100 min=0 name="val-criteria">
                                                <p class="text-muted m-b-15 f-s-12">Input classification score 0 - 100</p>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-notes">Text <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-notes" name="val-notes" placeholder="Enter text of classification..">
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
    <script type="text/javascript">
        var errorMessage = '<?= $error_message?>';
        $(function() {
            if (errorMessage != '') {
                toastr.error(errorMessage,'Error');            
            }
        });

    </script>
<?= $this->endSection()?>
<?= $this->include("layouts/footer"); ?>
