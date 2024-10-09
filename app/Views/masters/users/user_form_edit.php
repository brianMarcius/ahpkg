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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit User</h4>
                                <p class="text-muted m-b-15 f-s-12">Used to edit application users, both school principals and supervisors.</p>
                                <div class="form-validation">
                                    <form class="form-valide" action="/master/users/update" method="post">
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-username">Username <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-username" name="val-username" placeholder="Enter a username.." value='<?= $user['username']?>'>
                                                <input type="hidden" class="form-control" id="val-id" name="val-id" value='<?= $user['id']?>'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-fullname">Fullname <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-fullname" name="val-fullname" placeholder="Enter a fullname.." value='<?= $user['fullname']?>'>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-nip">Nip <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="number" class="form-control" id="val-nip" name="val-nip" placeholder="Your nip number.." value='<?= $user['nip']?>' required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-gol">Pangkat/Golongan <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-gol" name="val-gol" placeholder="Your rank/class" value='<?= $user['golongan']?>' required>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-jabatan">Jabatan <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-jabatan" name="val-jabatan" placeholder="Your position" value='<?= $user['jabatan']?>' required>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-email">Email <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="text" class="form-control" id="val-email" name="val-email" placeholder="Your valid email.." value='<?= $user['email']?>'>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-password">Password </span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Choose a safe one..">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-confirm-password">Confirm Password</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="..and confirm it!">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label" for="val-level">Level <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <select class="form-control" id="val-level" name="val-level" <?= $_SESSION['level']==3 ? '' : 'disabled' ?>>
                                                    <option value="">Please select</option>
                                                    <?php foreach ($levels as $level) { ?>
                                                        <option value='<?=$level->id?>' <?php if($level->id == $user['level']){ echo "selected" ; }?>><?= $level->level ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row" id="school-container">
                                            <label class="col-lg-4 col-form-label" for="val-school">School <span class="text-danger">*</span>
                                            </label>
                                            <div class="col-lg-6">
                                                <?php if ($_SESSION['level']==2) { ?>
                                                    <input type="hidden" id="val-school" name="val-school" value="<?= $user['school_id'];?> ">
                                                    <input type="hidden" id="val-level" name="val-level" value="<?= $user['level'];?> ">

                                                <?php }?>
                                                <select class="form-control" id="val-school" name="val-school"  <?= $_SESSION['level']==3 ? '' : 'disabled' ?>>
                                                    <option value="">Please select</option>
                                                    <?php foreach ($schools as $school) { ?>
                                                        <option value='<?=$school->id?>' <?php if($school->id == $user['school_id']){ echo "selected" ; }?>><?= $school->schoolname ?></option>
                                                    <?php } ?>

                                                </select>
                                                <a class="text-info" href="/master/school/list" target="_blank">Cannot find your school ? Go to school menu here</a>
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
        var level = "<?= $user['level'] ?>";
        $(function() {
            if (errorMessage != '') {
                toastr.error(errorMessage,'Error');            
            }

            if (level==1||$level==3) {
                $("#school-container").hide();
            }else{
                $("#school-container").show();
            }

        });

        $("#val-level").change(function(){
            if ($(this).val()==1||$(this).val()==3) {
                $("#school-container").hide();
            }else{
                $("#school-container").show();
            }
        })

        $("#password").rules('add', {
                minlength: 6,
                messages: {
                    minlength: "The password must consist of 6 or more characters"
                }
            });

            $("#confirm-password").rules('add', {
                minlength: 6,
                equalTo: "#password",
                messages: {
                    minlength: "The password must consist of 6 or more characters",
                    equalTo: "passwords are not the same"
                }
            });


    </script>
<?= $this->endSection()?>
<?= $this->include("layouts/footer"); ?>
