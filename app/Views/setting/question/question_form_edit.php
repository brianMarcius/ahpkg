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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Question</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit Question</h4>
                                <p class="text-muted m-b-15 f-s-12">Used to edit a question and options.</p>
                                <div class="form-validation">
                                    <form class="form-valide" action="/setting/question/update" method="post">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-criteria">Question<span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-question" name="val-question" value="<?= $question['question']?>" placeholder="Enter the Question" required>
                                                <input type="hidden" class="form-control" id="val-id" name="val-id" value="<?= $question['id']?>" placeholder="Enter the Question">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-notes">Options <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-8 container-options">
                                                <?php $no=0; foreach ($options as $key) { ?>
                                                    <div class="row row-option">
                                                        <div class="col-lg-8">
                                                            <input type="text" class="form-control" id="val-option" name="val-option['option'][]" placeholder="Enter the option" value="<?= $key->option?>" required>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <input type="number" class="form-control" id="val-score" name="val-option['score'][]" placeholder="Score" value="<?= $key->score?>" required>
                                                        </div>
                                                        <div class="col-lg-2">
                                                        <?php if($no==0) { ?>
                                                                <button type="button" class="btn btn-sm btn-primary add-question"><i class="fa fa-plus"></i></button>
                                                            <?php }else{ ?>
                                                                <button type="button" class="btn btn-sm btn-danger remove-question" onclick="removeTr(this)"><i class="fa fa-close"></i></button>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-lg-10" style="margin:20px 0px 20px 0px">
                                                            <textarea class="form-control summernote" id="val-notes" name="val-option['notes'][]" placeholder="Enter Notes" required><?= $key->notes?></textarea>
                                                        </div>
                                                    </div>
                                                <?php $no++;} ?>
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
    <script src="<?= base_url('assets/plugins/summernote/dist/summernote.min.js')?>"></script>


    <script type="text/javascript">
        var errorMessage = '<?= $error_message?>';
        $(function() {
            if (errorMessage != '') {
                toastr.error(errorMessage,'Error');            
            }
        });

        $('.summernote').summernote({
            placeholder: 'Notes here',
            tabsize: 2,
            height: 100
        });


        $(".add-question").click(function(){

        var element = '';
            element += '<div class="row row-option">';
            element += '<div class="col-lg-8">';
            element += '<input type="text" class="form-control" id="val-option" name="val-option[\'option\'][]" placeholder="Enter the option" required>';
            element += '</div>';
            element += '<div class="col-lg-2">';
            element += '<input type="number" class="form-control" id="val-score" name="val-option[\'score\'][]" placeholder="Score" required>';
            element += '</div>';
            element += '<div class="col-lg-2">';
            element += '<button type="button" class="btn btn-sm btn-danger remove-question" onclick="removeTr(this)"><i class="fa fa-close"></i></button>';
            element += '</div>';
            element += '<div class="col-lg-10" style="margin:20px 0px 20px 0px" id="summernote-container">';
            element += '<textarea class="form-control summernote" id="val-notes" name="val-option[\'notes\'][]" placeholder="Enter Notes" required></textarea>';
            element += '</div>';
            element += '</div>'
            $(".container-options").append(element);

        $('.summernote').summernote({
            placeholder: 'Notes here',
            tabsize: 2,
            height: 100
        });


        });

        function removeTr(th){
        var tr = $(th).closest(".row-option").remove();
        }

    


    </script>
<?= $this->endSection()?>
<?= $this->include("layouts/footer"); ?>
