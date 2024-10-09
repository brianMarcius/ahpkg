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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Data School <?php if($_SESSION['level']==3) { ?> <a class="btn btn-sm btn-primary text-white" href="/master/school/form"><i class='fa fa-plus'></i> Add</a><?php } ?></h4>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered zero-configuration" id="table_school">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>School Name</th>
                                                <th>NPSN</th>
                                                <th>Address</th>
                                                <th>Telp</th>
                                                <th>Principal Name</th>
                                                <th>Pengawas</th>
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
                                        <h5 class="modal-title">View School</h5>
                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div id="img-container" style="text-align:center"></div>
                                                <div class="basic-form">
                                                     <div class="form-row">
                                                        <div class="form-group col-md-6">
                                                            <label>School Name</label>
                                                            <input type="text" id="schoolname" class="form-control" placeholder="Email" disabled>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label>NPSN</label>
                                                            <input type="text" id="npsn" class="form-control" placeholder="Password" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Principal Name</label>
                                                        <input type="text" id="principalname" class="form-control" placeholder="Apartment, studio, or floor" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Supervisor Name</label>
                                                        <input type="text" id="supervisorname" class="form-control" placeholder="Apartment, studio, or floor" disabled>
                                                    </div>

                                                    <div class="form-group">
                                                        <label>Address</label>
                                                        <input type="text" id="address" class="form-control" placeholder="1234 Main St" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input type="text" id="telp" class="form-control" placeholder="Apartment, studio, or floor" disabled>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h5>History Evaluation</h5>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No.</th>
                                                                <th>Date</th>
                                                                <th>Total Score</th>
                                                                <th>Notes</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="last_evaluation">

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
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
<script src="<?= base_url('assets/plugins/toastr/js/toastr.min.js')?>"></script>
<script type="text/javascript">

        var table = $('#table_school').dataTable({
            "processing": true,
                "serverSide": true,
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('master/school/data') ?>",
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
                            url : "/master/school/delete/"+id,
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
                url : "/master/school/view/"+id,
                type : "GET",
                dataType : "JSON",
                success : function(response){
                    $("#last_evaluation").html('');
                    var html = "";
                    if (response.code == 200) {
                        console.log(response.data.last_evaluation);
                        if (response.data.last_evaluation.length != 0) {
                            html += "<tr>";
                            html += "<td>1.</td>";
                            html += "<td>"+response.data.last_evaluation[0].date+"</td>";
                            html += "<td>"+response.data.last_evaluation[0].score+"</td>";
                            html += "<td>"+response.data.last_evaluation[0].notes+"</td>";
                            html += "<td><a class='btn btn-sm btn-warning' href='/evaluation/view/"+response.data.last_evaluation[0].id+"'><i class='fa fa-eye'></i></a></td>";
                            html += "</tr>";

                            $("#last_evaluation").html(html);
                        }else{
                            html += "<tr class='table-active'>";
                            html += "<td colspan=4 style='text-align:center' class='text-muted'>Empty Data</td>";
                            html += "</tr>";

                            $("#last_evaluation").html(html);

                        }
                        // console.log(response.data.pengawas);
                        $("#schoolname").val(response.data.school.schoolname);
                        $("#npsn").val(response.data.school.npsn);
                        $("#address").val(response.data.school.address);
                        $("#telp").val(response.data.school.telp);
                        $("#principalname").val(response.data.school.fullname);
                        $("#supervisorname").val(response.data.pengawas[0].fullname ?? '-');
                        $("#img-container").html("<img style='width:10rem' class='mb-4' src='/assets/images/schools/"+response.data.school.logo+"'/>");
                        $("#modal-view").modal('show');
                    }
                }
            })
        }

        function bookmark(user_id,school_id){
            $.ajax({
                url : "/master/school/bookmark/",
                type : "POST",
                data : {
                    user_id : user_id,
                    school_id : school_id
                },
                dataType : "JSON",
                success : function(response){
                    if (response.code==200) {
                        toastr.success(response.message,'Success');            
                        table.api().ajax.reload();
                    }else{
                        toastr.error(response.message,'Failed');            
                        table.api().ajax.reload();

                    }
                }
            })

        }

        function unbookmark(bookmark_id){
            $.ajax({
                url : "/master/school/unbookmark/",
                type : "POST",
                data : {
                    bookmark_id : bookmark_id,
                },
                dataType : "JSON",
                success : function(response){
                    if (response.code==200) {
                        toastr.warning(response.message,'Success');            
                        table.api().ajax.reload();
                    }
                }
            })

        }


</script>
<?= $this->endSection(); ?>
<?= $this->include("layouts/footer"); ?>
