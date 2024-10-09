<?= $this->include("layouts/header") ?>
<?= $this->include("layouts/sidebar") ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Home</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <img alt="" class="rounded-circle mt-4" style="width:12rem" src="<?= empty($user['logo']) ? '/assets/images/schools/profile-placeholder.png' : '/assets/images/schools/'.$user['logo']?>">
                                    <h4 class="card-widget__title text-dark mt-3"><?= $user['fullname']; ?></h4>
                                    <p class="text-muted"><?= $user['level'].' '.$user['schoolname']?></p>
                                    <a class="btn gradient-4 btn-lg border-0 btn-rounded px-5" href="/master/users/edit/<?= $user['id']?>">Edit Profile</a>
                                </div>
                            </div>
                            <div class="card-footer border-0 bg-transparent">
                                <div class="row">
                                    <div class="col-4 border-right-1 pt-3">
                                        <a class="text-center d-block text-muted" href="/evaluation/list">
                                            <i class="fa fa-check gradient-1-text" aria-hidden="true"></i>
                                            <p class="">Evaluations</p>
                                        </a>
                                    </div>
                                    <div class="col-4 border-right-1 pt-3">
                                        <a class="text-center d-block text-muted" target='_blank' href="https://wa.me/<?= $user['telp']?>">
                                        <i class="fa fa-phone gradient-3-text"></i>
                                            <p class="">Phone</p>
                                        </a>
                                    </div>
                                    <div class="col-4 pt-3">
                                        <a class="text-center d-block text-muted" href="mailto:<?= $user['email']?>">
                                        <i class="fa fa-envelope gradient-4-text"></i>
                                            <p class="">Email</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-8">
                        <div class="card card-widget">
                            <div class="card-body">
                                <h4 class="card-title">Log Activities</h4>
                                <div class="table-responsive">
                                    <table class="table table-striped zero-configuration" id="table_log_activity">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Menu</th>
                                                <th>Description</th>
                                                <th>Reference Id</th>
                                                <th>Date</th>
                                                <th>Created By</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<?= $this->section('javascript'); ?>
<script type="text/javascript">

var table = $('#table_log_activity').dataTable({
    "processing": true,
        "serverSide": true,
        "pageLength" : 5,
        "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, 'All']],
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('master/users/log_activity') ?>",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [],
            "orderable": false,
        }, ],

});

</script>
<?= $this->endSection(); ?>
<?= $this->include("layouts/footer"); ?>
