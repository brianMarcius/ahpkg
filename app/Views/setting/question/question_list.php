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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data Question <a class="btn btn-sm btn-primary text-white" href="/setting/question/form"><i class='fa fa-plus'></i> Add</a></h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="table_question">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Question</th>
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
        
                        <div class="modal fade bd-example-modal-lg" id="modal-view" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">View Question</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <h5>Question</h5>
                                        <p id="question_container"></p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Option</th>
                                                        <th>Score</th>
                                                        <th>Notes</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbody_option">

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                      

<?= $this->section('javascript'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script type="text/javascript">

        var table = $('#table_question').dataTable({
            "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('setting/question/data') ?>",
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
                            url : "/setting/question/delete/"+id,
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

        function viewDetail(id){
            $.ajax({
                url : "/setting/question/view/"+id,
                type : "GET",
                dataType : "JSON",
                success : function(response){
                    if (response.code == 200) {
                        $("#question_container").html(response.data.question.question);
                        var options = response.data.options;
                        var html = "";
                        var no = 0;
                        for (let i = 0; i < options.length; i++) {
                            ++no;
                            html += "<tr><td>"+no+"</td><td>"+options[i].option+"</td><td>"+options[i].score+"</td><td>"+options[i].notes+"</td></tr>";
                        }
                        $("#tbody_option").html(html);
                        $("#modal-view").modal('show');
                    }
                }
            })
        }
</script>
<?= $this->endSection(); ?>
<?= $this->include("layouts/footer"); ?>
