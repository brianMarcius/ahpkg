<?= $this->include("layouts/header") ?>
<?= $this->include("layouts/sidebar") ?>
<?php 
$db = db_connect();
$awal_tahun = date('Y-m-01');
$now = date('Y-m-d');
if ($awal_tahun == $now) {
    $db->table('users')->update([
        'first_login' => 1
    ]);
}
?>
 <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">

            <div class="container-fluid mt-3">
                <?php if ($_SESSION['level']==1 || $_SESSION['level']==3 ) { ?>
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-1">
                            <div class="card-body">
                                <h3 class="card-title text-white">Schools</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?= $schools_count ?> </h2>
                                    <p class="text-white mb-0">Schools registered</p>
                                </div>
                                <span class="float-right display-6 opacity-5"><i class="fa fa-university"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white">Users</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?= $users_count ?></h2>
                                    <p class="text-white mb-0">Users registered</p>
                                </div>
                                <span class="float-right display-6 opacity-5"><i class="fa fa-users"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Evaluations</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?= $evaluations_count?></h2>
                                    <p class="text-white mb-0">Evaluations taken</p>
                                </div>
                                <span class="float-right display-6 opacity-5"><i class="fa fa-check-square-o"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4>Top 10 Schools</h4>
                                <p>Summary evaluation score</p>
                                <div class="active-member">
                                    <div class="table-responsive">
                                        <table class="table table-xs mb-0">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>School Name</th>
                                                    <th>Principal Name</th>
                                                    <th>Date</th>
                                                    <th style="width:40%">Score</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no=1; foreach ($top_ten_schools as $t) { 
                                                    $query_detail = $db->table('evaluation_details')->where('evaluation_id',$t->id)->get()->getResult();
                                                    $det_score = '<table class="table bg-white">';
                                                    $i = 1;
                                                    foreach ($query_detail as $qd) {
                                                        $persentase = round(($qd->score/$qd->max_score)*100);
                                                        if($qd->score == 2){  
                                                            $color = 'gradient-2';
                                                        }elseif ($qd->score == 3) {
                                                            $color = 'gradient-3';
                        
                                                        }else{
                                                            $color = 'gradient-1';
                                                        }
                        
                                                        $det_score .= '<tr>
                                                                        <td>'.$qd->question_text.'</td>
                                                                        <td style="width:60%">
                                                                            <div class="progress" style="height: 10px">
                                                                                <div class="progress-bar '.$color.'" style="width: '.$persentase.'%;" role="progressbar"><span class="sr-only">'.$qd->option_text.'</span>
                                                                                </div>
                                                                            </div> 
                                                                        </td>
                                                                        <td>'.$qd->option_text.'</td>
                                                                        </tr>';
                                                    }
                                                    $det_score .= '</table>';

                                                    ?>
                                                    <tr>
                                                        <td><?= $no++;?></td>
                                                        <td><?= $t->schoolname ?></td>
                                                        <td><?= $t->fullname?></td>
                                                        <td><?= $t->date?></td>
                                                        <td><?= $det_score?></td>
                                                        <td><a class="btn btn-sm btn-primary text-white" href="/evaluation/view/<?= $t->id ?>"><i class="fa fa-eye"></i> View</a></td>
                                                    </tr>
                                                <?php  } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </div>
                </div>
                <?php }else{ ?>
                    <div class="row">
                        <?php $i=1; 
                        if (!empty($detail)) {
                            foreach ($detail as $dt) { 
                                if($dt->score == 2){  
                                    $icon = 'fa fa-cube';
                                    $color = 'gradient-2';
                                }elseif ($dt->score == 3) {
                                    $icon = 'fa fa-check-square-o';
                                    $color = 'gradient-3';

                                }else{
                                    $icon = 'fa fa-star';
                                    $color = 'gradient-1';

                                }
                                ?>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card <?= $color ?>">
                                    <div class="card-body">
                                        <h3 class="card-title text-white"><?= $dt->question_text?></h3>
                                        <div class="d-inline-block">
                                            <h2 class="text-white"><?= $dt->option_text?></h2>
                                            <p class="text-white mb-0"><?= date("jS \of F", strtotime($latest_score[0]->date ?? '-'))?></p>
                                        </div>
                                        <span class="float-right display-6 opacity-5"><i class="<?= $icon ?>"></i></span>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            }
                        }else{ 
                            foreach ($question as $q) { ?>
                            <div class="col-lg-3 col-sm-12">
                                <div class="card gradient-<?=$i++?>">
                                    <div class="card-body">
                                        <h3 class="card-title text-white"><?= $q->question?></h3>
                                        <div class="d-inline-block">
                                            <h2 class="text-white">0</h2>
                                            <p class="text-white mb-0">No Data Found</p>
                                        </div>
                                        <span class="float-right display-6 opacity-5"><i class="fa fa-cube"></i></span>
                                    </div>
                                </div>
                            </div>
                        <?php } 
                        }?>

                    <!-- <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-1">
                            <div class="card-body">
                                <h3 class="card-title text-white">Latest Score</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?= $latest_score[0]->score ?? 0 ?></h2>
                                    <p class="text-white mb-0"><?= date("jS \of F", strtotime($latest_score[0]->date ?? '-'))?></p>
                                </div>
                                <span class="float-right display-6 opacity-5"><i class="fa fa-cube"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-2">
                            <div class="card-body">
                                <h3 class="card-title text-white">Highest Score</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?= $max_score[0]->score ?? 0?></h2>
                                    <p class="text-white mb-0"><?= date("jS \of F", strtotime($max_score[0]->date ?? '-'))?></p>
                                </div>
                                <span class="float-right display-6 opacity-5"><i class="fa fa-star"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div class="card gradient-3">
                            <div class="card-body">
                                <h3 class="card-title text-white">Evaluations</h3>
                                <div class="d-inline-block">
                                    <h2 class="text-white"><?= $evaluations_count ?? 0?></h2>
                                    <p class="text-white mb-0">Evaluations Taken</p>
                                </div>
                                <span class="float-right display-6 opacity-5"><i class="fa fa-check-square-o"></i></span>
                            </div>
                        </div>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="container_scoreChart">
                                    <p id="alert8" style="text-align:center;color:#aaa;"></p>
                                    <canvas id="scoreChart"  width="200" height="200"></canvas>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
		        </div>
                <?php } ?>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<?= $this->section('javascript') ?>
<script src="<?= base_url('assets/js/dashboard/dashboard-1.js')?>"></script>
<script type="text/javascript">
    // var firstLogin = "<?= $_SESSION['first_login']?>";
    var firstLogin = 0;
    var level = "<?= $_SESSION['level']?>";
    var width = $(window).width(); 
    var height = $(window).height(); 

    // alert(width);


    $(document).ready(function(){
    getDataChart();
    if ((width >= 1024)) {
        if (level == 2 || level==1) {
            var options = {
                container: 'body',
                spacing: 20,
                actions: {
                next: {
                    text: 'Next step',
                    class: 'btn btn-default'
                },
                finish: {
                    text: 'OK! I know',
                    class: 'btn btn-success'
                }
                },
                entries: [
                {
                    selector: '#step1',
                    text: 'Click icon profile untuk setting profile',
                    position: 'bottom'
                },
                {
                    selector: '#step2',
                    text: 'Pilih menu profile untuk melihat log user dan mengedit profile',
                    onEnter: function () {
                        $('#step2').parent().parent().parent().addClass('show');
                    },

                },
                {
                    selector: '#step3',
                    text: 'Pilih menu logout untuk keluar',
                    onExit: function () {
                        $('#step2').parent().parent().parent().removeClass('show');
                    },

                },
                {
                    selector: '#step4',
                    text: 'Click menu school untuk melihat data sekolah anda',
                    onEnter: function () {
                        $('#step4').parent().addClass('in');
                    },
                    onExit: function () {
                        $('#step4').parent().removeClass('in');
                    },

                }, {
                    selector: '#step5',
                    text: 'Click evaluation untuk melihat data evaluasi',
                    onExit: function () {
                    // $('#step3').text('This example text is changed!');
                    }
                }
                ]
            };
        }else{
            var options = {
                container: 'body',
                spacing: 20,
                actions: {
                next: {
                    text: 'Next step',
                    class: 'btn btn-default'
                },
                finish: {
                    text: 'OK! I know',
                    class: 'btn btn-success'
                }
                },
                entries: [
                {
                    selector: '#step1',
                    text: 'Click icon profile untuk setting profile',
                    position: 'bottom',
                },
                {
                    selector: '#step2',
                    text: 'Pilih menu profile untuk melihat log user dan mengedit profile',
                    onEnter: function () {
                        $('#step2').parent().parent().parent().addClass('show');
                    },

                },
                {
                    selector: '#step3',
                    text: 'Pilih menu logout untuk keluar',
                    onExit: function () {
                        $('#step4').parent().addClass('in');
                        $('#step2').parent().parent().parent().removeClass('show');
                    },

                },
                {
                    selector: '#step6',
                    text: 'Click menu user untuk mengelola data user',
                    setTooltipPosition : 'right',
                    onEnter: function () {
                    },
                },
                {
                    selector: '#step4',
                    text: 'Click menu school untuk melihat data sekolah anda',
                    onExit: function () {
                        $('#step4').parent().removeClass('in');
                    },

                },
                {
                    selector: '#step7',
                    text: 'Click menu setting question untuk mengelola pertanyaan',
                    onEnter: function () {
                        $('#step7').parent().addClass('in');
                    },
                    onExit: function () {
                        $('#step7').parent().removeClass('in');

                    },

                },
                {
                    selector: '#step5',
                    text: 'Click evaluation untuk melihat data evaluasi',
                    onExit: function () {
                    // $('#step3').text('This example text is changed!');
                    }
                }
                ]
            };

        }
    }else {
        if (level == 2 || level==1) {
            var options = {
                container: 'body',
                spacing: 20,
                actions: {
                next: {
                    text: 'Next step',
                    class: 'btn btn-default'
                },
                finish: {
                    text: 'OK! I know',
                    class: 'btn btn-success'
                }
                },
                entries: [
                {
                    selector: '#step1',
                    text: 'Click icon profile untuk setting profile',
                    position: 'bottom'
                },
                {
                    selector: '#step2',
                    text: 'Pilih menu profile untuk melihat log user dan mengedit profile',
                    onEnter: function () {
                        $('#step2').parent().parent().parent().addClass('show');
                    },

                },
                {
                    selector: '#step3',
                    text: 'Pilih menu logout untuk keluar',
                    onExit: function () {
                        $('#step2').parent().parent().parent().removeClass('show');
                    },

                },
                {
                    selector: '#step8',
                    text: 'Klik icon bar untuk memunculkan menu',
                    onEnter: function () {
                        $('.hamburger').trigger('click')
                    },

                },
                {
                    selector: '#step4',
                    text: 'Click menu school untuk melihat data sekolah anda',
                    onEnter: function () {
                        $('#step4').parent().addClass('in');
                    },
                    onExit: function () {
                        $('#step4').parent().removeClass('in');
                    },

                }, {
                    selector: '#step5',
                    text: 'Click evaluation untuk melihat data evaluasi',
                    onExit: function () {
                    // $('#step3').text('This example text is changed!');
                    $('.hamburger').trigger('click')

                    }
                }
                ]
            };
        }else{
            var options = {
                container: 'body',
                spacing: 20,
                actions: {
                next: {
                    text: 'Next step',
                    class: 'btn btn-default'
                },
                finish: {
                    text: 'OK! I know',
                    class: 'btn btn-success'
                }
                },
                entries: [
                {
                    selector: '#step1',
                    text: 'Click icon profile untuk setting profile',
                    position: 'bottom',
                },
                {
                    selector: '#step2',
                    text: 'Pilih menu profile untuk melihat log user dan mengedit profile',
                    onEnter: function () {
                        $('#step2').parent().parent().parent().addClass('show');
                    },
                },
                {
                    selector: '#step3',
                    text: 'Pilih menu logout untuk keluar',
                    onExit: function () {
                        $('#step4').parent().addClass('in');
                        $('#step2').parent().parent().parent().removeClass('show');
                    },

                },
                {
                    selector: '#step8',
                    text: 'Klik icon bar untuk memunculkan menu',
                    onEnter: function () {
                        $('.hamburger').trigger('click')
                    },

                },

                {
                    selector: '#step6',
                    text: 'Click menu user untuk mengelola data user',
                    onEnter: function () {
                    },
                },
                {
                    selector: '#step4',
                    text: 'Click menu school untuk melihat data sekolah anda',
                    onExit: function () {
                        $('#step4').parent().removeClass('in');
                    },

                },
                {
                    selector: '#step7',
                    text: 'Click menu setting question untuk mengelola pertanyaan',
                    onEnter: function () {
                        $('#step7').parent().addClass('in');
                    },
                    onExit: function () {
                        $('#step7').parent().removeClass('in');

                    },

                },
                {
                    selector: '#step5',
                    text: 'Click evaluation untuk melihat data evaluasi',
                    onExit: function () {
                    // $('#step3').text('This example text is changed!');
                    $('.hamburger').trigger('click')
                    }
                }
                ]
            };

        }
    }
    if (firstLogin == 1) {
        setTimeout(() => {
            PageIntro.init(options);
            PageIntro.start();

        }, 500);
    }
});


function getDataChart(){
	$('#alert8').html('');
	$('#keterangan8').html('Chart of this year score');
	$.ajax({
		url : "/getdata_score",
		method : "GET",
		dataType : "JSON",
		success : function(result){
			console.log(result);
			if (result.length ==0) {
				$('#alert8').html('no data available');
			}else{
				$('#alert8').html('');
				var data = [];
				var label = [];
                var color = [];
				$.each(result,function(index,value){
					data.push(value.score);
                    if (value.score == 2) {
                        color.push('rgba(255, 99, 132, 1)');
                    }else if(value.score == 3){
                        color.push('rgba(255, 159, 64, 1)');
                    }else{
                        color.push('rgb(117, 113, 249)');
                    }
					label.push(value.question_text);

				})

				labarugiChart(label,data,color);
			}
			
		}
	})
}
function labarugiChart(label,data,color){
			$("#scoreChart").remove();
    		$("#container_scoreChart").html('<canvas id="scoreChart"></canvas>')
			var ctx = document.getElementById("scoreChart").getContext('2d');
			var myChart = new Chart(ctx, {
			type: 'bar',
			data: {
				labels: label,
				datasets: [{
                    label: "Score",
					data: data,
					backgroundColor: color,
					borderColor: color,
					borderWidth: 1
				}]
			},
			options : {
				// tooltips: {
				// 	callbacks: {
				// 		label: function(tooltipItem, data) {
				// 			let nilai = formatRupiah(data.datasets[0].data[tooltipItem.index]);
				// 			let biaya = data.labels[tooltipItem.index];
				// 			var total = data.datasets[0].data.reduce(function(previousValue, currentValue, currentIndex, array) {
				// 				return previousValue*1 + currentValue*1;
				// 			});	

				// 			let currentValue = data.datasets[0].data[tooltipItem.index];

				// 			var percentage = Math.floor(((currentValue/total) * 100)+0.5);
				// 			// console.log(data);
				// 			return biaya+" : Rp. "+nilai+" ("+percentage+"%)";


				// 		}
				// 	}
				// },
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
                scales: {
                    xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'dates'
                            }
                        }],
                    yAxes: [{
                            display: true,
                            ticks: {
                                beginAtZero: true,
                                steps: 1,
                                stepValue: 5,
                                max: 4
                            }
                        }]
                },

			},

		});
		}


            </script>
        <?= $this->endSection() ?>

<?= $this->include("layouts/footer"); ?>
