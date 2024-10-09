<?= $this->include("layouts/header") ?>
<?= $this->include("layouts/sidebar") ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="row page-titles mx-0">
                <div class="col p-md-0">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Form</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Evaluation</a></li>
                    </ol>
                </div>
            </div>
            <!-- row -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Evaluation <?php if($_SESSION['level']==2){ ?><a class="btn btn-sm btn-primary text-white" href="/evaluation/form"><i class='fa fa-plus'></i>Take Evaluation</a><?php } ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="table_evaluation">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>School Name</th>
                                                <th>Principal Name</th>
                                                <th>Date</th>
                                                <th>Year</th>
                                                <th>Pengawas</th>
                                                <!-- <th>Notes</th> -->
                                                <th>Action</th>
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
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<?= $this->section('javascript'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

        var table = $('#table_evaluation').dataTable({
            "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('evaluation/data') ?>",
                    "type": "POST"
                },
                "columnDefs": [{
                    "targets": [],
                    "orderable": false,
                }, ],

        });

        function confirmDelete(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : "/evaluation/delete/"+id,
                            type : "GET",
                            dataType : "JSON",
                            success : function(response){
                                if (response.code == 200) {
                                    Swal.fire({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });

                                    table.api().ajax.reload();
                                }
                            }
                        })
                    }
                });
        }
</script>
<?= $this->endSection(); ?>
<?= $this->include("layouts/footer"); ?>
