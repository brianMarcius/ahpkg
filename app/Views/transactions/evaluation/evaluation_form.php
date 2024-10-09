<?= $this->include("layouts/header") ?>
<?= $this->include("layouts/sidebar") ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Apps</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Evaluations</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Form Evaluation</h4>
                                <p class="text-muted m-b-15 f-s-12">Take the evaluation and answer the questions</p>
                                <div class="form-validation">
                                    <form class="form-valide form-evaluation" action="/evaluation/store" method="post" id="form-evaluation">
                                        <div class="form-group row col-lg-6">
                                            <label>Tahun <span class="text-danger">*</span></label>
                                            <select class="form-control" name="tahun"required>
                                            <?php 
                                                $tahun = date('Y');
                                                for ($i=2023; $i <= $tahun; $i++) { 
                                                ?>
                                                <option values="<?php echo $i; ?>" <?php if($i == $tahun){ echo "selected";} ?>><?php echo $i; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>

                                        <table class="table">
                                            <?php $no=1;$i =0; foreach ($questions as $q) {
                                                $question_id = $q['id'];
                                                ?>
                                            <tr>
                                                <td ><?= $no++; ?></td>
                                                <td> <?= $q['question'] ?>
                                                    <input type="hidden" name="data[<?= $i; ?>]['question']" value="<?= $q['id']; ?>"/>
                                                </td>
                                            </tr>
                                            <?php foreach ($q['options'] as $opt) { ?>
                                            <tr>
                                                <td></td>
                                                <td>
                                                    <div class="form-group">
                                                        <div>
                                                        <label><input class="mr-3 required" type="radio" name="data[<?= $i; ?>]['option']" value="<?= $opt->id;?>" required><?=$opt->option;?></label>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php }?>
                                            <?php $i++;} ?>
                                        </table>
                                        <div class="form-group row">
                                            <label>Link Google Drive <span class="text-danger">*</span></label>
                                            <input class="form-control" name="link_drive" placeholder="https:\\" required/>
                                            <p class="text-danger"><i>File yang diupload di google drive berupa pdf</i></p>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-lg-8 ml-auto">
                                                <!-- <button type="button" class="btn btn-primary btn-fake" style="display:block">Submit</button> -->
                                                <button type="submit" class="btn btn-primary btn-submit">Submit</button>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script type="text/javascript">
        var errorMessage = '<?= $error_message?>';
        $(function() {
            if (errorMessage != '') {
                toastr.error(errorMessage,'Error');            
            }
        });



        // $(".btn-fake").click(function(){
        //     toastr.error("All fields are required",'Error');
        // })

        // var submitButton = $(".btn-submit");
        // var submitButtonFake = $(".btn-fake");

        // $("#form-evaluation input.required").change(function () {
        //     var valid = true;
        //     var i = 0;
        //     $.each($("#form-evaluation input.required"), function (index, value) {
        //         console.log(i++);
        //         if(!$(value).is(':checked')){
        //         valid = false;
        //         }
        //         console.log(valid);
        //     });
        //     if(valid){
        //         $(submitButton).show()
        //         $(submitButtonFake).hide()
        //     } 
        //     else{
        //         $(submitButton).hide()
        //         $(submitButtonFake).show()
        //     }
        // });

        jQuery(".form-evaluation").validate({ 
            ignore: [], 
            errorClass: "invalid-feedback animated fadeInDown", 
            errorElement: "div", 
            errorPlacement: function (e, a) { jQuery(a).parents(".form-group > div").append(e) }, 
            highlight: function (e) { jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid") }, 
            success: function (e) { jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove() }, 
            // rules: { "data[]['option']": { required: !0 } }, messages: {  "val-terms": "You must agree to the service terms!" } 
            submitHandler: function(form) {
                Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: "Submited!",
                            text: "Your submission has been submited",
                            icon: "success"
                        });
                        form.submit();
                    }else{
                        return false;
                    }
                });

            }
        });

        var i =0;

        $('input[type="radio"]').each(function() {
            console.log(i++);
            $(this).rules('add', {
                required: true,
                messages: {
                    required: "This field is required"
                }
            });

        });



        // $('#form-evaluation').submit(function() {
        //     Swal.fire({
        //         title: "Are you sure?",
        //         text: "You won't be able to revert this!",
        //         icon: "warning",
        //         showCancelButton: true,
        //         confirmButtonColor: "#3085d6",
        //         cancelButtonColor: "#d33",
        //         confirmButtonText: "Yes"
        //         }).then((result) => {
        //             if (result.isConfirmed) {
        //                 Swal.fire({
        //                     title: "Submited!",
        //                     text: "Your submission has been submited",
        //                     icon: "success"
        //                 });
        //             }else{
        //                 return false;
        //             }
        //         });
        // });


        $(".add-question").click(function(){
            var element = '<tr><td class="pl-0">';
            element += '<input type="text" class="form-control" id="val-option" name="val-option[\'option\'][]" placeholder="Enter the option">';
            element += '</td><td><input type="number" class="form-control" id="val-score" name="val-option[\'score\'][]" placeholder="Enter the score of the option">';
            element += '</td><td><button type="button" class="btn btn-sm btn-danger remove-question" onclick="removeTr(this)"><i class="fa fa-close"></i></button>';
             element += '</td></tr>';
            $("#table-option").append(element);
        });

        function removeTr(th){
            var tr = $(th).closest("tr").remove();
        }

    </script>
<?= $this->endSection()?>
<?= $this->include("layouts/footer"); ?>
