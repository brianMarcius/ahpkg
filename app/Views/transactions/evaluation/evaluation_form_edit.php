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
            <div class="container-fluid" id="section-to-print">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Evaluation Overview</h4>
                                <p class="text-muted m-b-15 f-s-12">Resume of evaluation result</p>
                                <div class="row mb-5">
                                    <div class="col-lg-12">
                                        <div class="form-validation">
                                        <!-- <form class="form-valide form-evaluation" action="/evaluation/store" method="post" id="form-evaluation"> -->
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label>School Name</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['schoolname']?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Principal Name</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['fullname']?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label>NPSN</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['npsn']?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>NIP</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['nip']?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['address']?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Pangkat/Golongan</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['golongan']?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label>No. Telp</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['telp']?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Jabatan</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['jabatan']?>" readonly>
                                                </div>
                                            </div>




                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label>Taken Date</label>
                                                    <input type="datetime" class="form-control" value="<?= $evaluation_header['date']?>" readonly>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label>Pengawas</label>
                                                    <input type="text" class="form-control" value="<?= $pengawas[0]->fullname?>" readonly>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-sm-6">
                                                    <label>Tahun</label>
                                                    <input type="text" class="form-control" value="<?= $evaluation_header['year']?>" readonly>
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label>Link Drive</label>
                                                    <p><a class="btn btn-outline-info" href="<?= $evaluation_header['link_drive'] ?>" target="_blank">Open Drive Here</a></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col-lg-12">
                                        <div id="container_scoreChart">
                                            <p id="alert8" style="text-align:center;color:#aaa;"></p>
                                            <canvas id="scoreChart"  width="200" height="200"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Question</th>
                                                        <th>Answer</th>
                                                        <!-- <th>Score</th>
                                                        <th>Max Score</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no=1; $total_score=0; $total_maxscore=0; foreach ($evaluation_detail as $detail) { ?>
                                                    <tr>
                                                        <td><?= $no++?></td>
                                                        <td style="font-weight:bolder"><?= $detail->question_text?></td>
                                                        <td style="font-weight:bolder"><?= $detail->option_text?></td>
                                                        <!-- <td style="text-align:right"><?= $detail->score?></td>
                                                        <td style="text-align:right"><?= $detail->max_score?></td> -->
                                                    </tr>
                                                    <?php if ($_SESSION['level'] == 1 || $_SESSION['level'] == 3) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan=2><?= "<b>Notes : </b><br><br>".$detail->notes?></td>
                                                    </tr>

                                                    <?php } ?>
                                                    <?php 
                                                        $total_score += $detail->score; 
                                                        $total_maxscore += $detail->max_score; 
                                                    } ?>
                                                </tbody>
                                                <!-- <tfoot>
                                                    <tr>
                                                        <th colspan=3>Total : </th>
                                                        <th style="text-align:right"><?= $total_score?></th>
                                                        <th style="text-align:right"><?= $total_maxscore?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan=3>Percentage : </th>
                                                        <th colspan=2 style="text-align:right"><?= round($total_score/$total_maxscore*100) .'%'?></th>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Notes :  </b></td>
                                                        <td colspan=4><?= $evaluation_header['notes']?></td>
                                                        
                                                    </tr> -->

                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="form-group row" id="notprint">
                                            <div class="col-lg-12 ml-auto">
                                                <a type="button" class="btn btn-primary" href="/evaluation/list">Oke</a>
                                                <button type="button" class="btn btn-warning text-white" onclick="print_div()"><i class="fa fa-print"></i>&nbsp;Print</button>
                                                    <!-- <button type="submit" class="btn btn-primary btn-submit">Submit</button> -->
                                            </div>
                                        </div>
                                        <!-- </form> -->
                                    </div>
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

            getDataChart(<?= $id ?>);

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


function getDataChart(id){
	$('#alert8').html('');
	$('#keterangan8').html('Chart of this year score');
	$.ajax({
		url : "/evaluation/getdata_chart",
		method : "GET",
        data : {
            id:id
        },
		dataType : "JSON",
		success : function(result){
			console.log(result);
			if (result.length ==0) {
				$('#alert8').html('no data available');
			}else{
				$('#alert8').html('');
				var data = [];
				var label = [];
				$.each(result,function(index,value){
					data.push(value.score);
					label.push(value.question_text);

				})

				labarugiChart(label,data);
			}
			
		}
	})
}
function labarugiChart(label,data){
			$("#scoreChart").remove();
    		$("#container_scoreChart").html('<canvas id="scoreChart" style="max-height:450px"></canvas>')
			var ctx = document.getElementById("scoreChart").getContext('2d');
			var myChart = new Chart(ctx, {
            type: 'radar',
			data: {
				labels: label,
				datasets: [{
                    label: "Score",
					data: data,
					backgroundColor: [
						// 'rgba(229,89,52,0.25)',
						// 'rgba(255, 159, 64, 1)',
						// 'rgb(253,231,76,1)',
						// 'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 0.5)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgb(91,192,235,1)',
						'rgb(155,197,1)',
						'rgb(250,121,33,1)',
						'rgb(165,102,139,1)',
						'rgb(105,48,109,1)',
						'rgb(14,16,61,1)',
						'rgb(149,198,35,1)'
					],
					borderColor: [
						// 'rgb(229,89,52,1)',
						// 'rgba(255, 159, 64, 1)',
						// 'rgb(253,231,76,1)',
						// 'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgb(91,192,235,1)',
						'rgb(155,197,1)',
						'rgb(250,121,33,1)',
						'rgb(165,102,139,1)',
						'rgb(105,48,109,1)',
						'rgb(14,16,61,1)',
						'rgb(149,198,35,1)'
					],
					borderWidth: 1
				}]
			},
			options : {
				responsive: true,
				legend: {
					position: 'bottom',
				},
				title: {
					display: true,
					text: 'Chart Evaluation Score'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				},
                scale: {
                    ticks: {
                        beginAtZero: true,
                        max: 4,
                        min: 0,
                        stepSize: 1
                    }
                }
			},

		});
		}

       function print_div(){
            $("#section-to-print").printThis();

        }

    </script>
<?= $this->endSection()?>
<?= $this->include("layouts/footer"); ?>
