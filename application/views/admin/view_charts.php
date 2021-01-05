<?php
if (isset($this->session->userdata['logged_in'])) {
    if ($this->session->userdata['logged_in']['role'] != "Admin") {
        header("location: /");
    }
}
if (isset($this->session->userdata['logged_in'])) {
    $user_role = $this->session->userdata['logged_in']['role'];
    $user_id = $this->session->userdata['logged_in']['id'];
}

$dataSets = "";
$usersButtons = "";
if ($users) {
    foreach ($users as $user) {
        $userMonth = ${'user_' . $user['id']};
        $userColor = 'user' . $user['id'];
        if ($userMonth != ',,,,,,,,,,,,') {
            $dataSets .= "{
        label:'" . $user['view_name'] . "',
        backgroundColor: color(window.chartColors.$userColor).alpha(0.7).rgbString(),
        borderColor: window.chartColors.$userColor,
        borderWidth: 1,
        data: [$userMonth]
        },";
            if (!isset($csv_user)) {
                $usersButtons .= "<a href='/admin/view_charts/{$user['id']}' class='btn btn-outline-info'>{$user['view_name']}</a>";
            }
        }
    }
}

?>
<script src="<?php echo base_url('assets/js/ChartJs/'); ?>Chart.min.js"></script>
<script src="<?php echo base_url('assets/js/ChartJs/'); ?>chartjs-plugin-datalabels.min.js"></script>
<link href="<?php echo base_url('assets/js/ChartJs/Chart.min.css'); ?>" rel="stylesheet">
<div id="form-messages" class='alert hidden' role='alert'></div>
<main role="main">
    <div class="jumbotron">
        <div class="container">
            <center>
                <h5>דוחות כספים</h5>
            </center>
        </div>
    </div>
    <div class="container rtl col-md-10">
        <div class="form-row mb-3">
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">יוצר</div>
                    </div>
                    <select class="creator_filter">
                        <option></option>
                        <option value="">-בטל סינון-</option>
                        <?php foreach ($users as $user) {
                            echo "<option value='{$user['id']}'>{$user['view_name']}</option>";
                        } ?>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">שנה</div>
                    </div>
                    <select id="yaer-dropdown" class="year_filter">
                        <option></option>
                        <option value="">-בטל סינון-</option>
                    </select>
                </div>
            </div>
            <div class="form-group col-md-3">
                <div class="input-group">
                    <a href="" class="filter_button btn btn-info" style="color: azure;" onclick=' '>סינון</a>
                </div>
            </div>

            <div class="form-group col-md-3">
                <div class="input-group">
                    <a href='/admin/view_charts/' class='btn btn-outline-info'>הצג כולם</a>
                    <?php //echo $usersButtons; 
                    ?>
                </div>
            </div>
        </div>
        <div id="show_csv" class='btn btn-outline-info'><i class="fa fa-file-excel-o"></i></div>
        <div id="csv_month" style="display:none;">
        </div>
        <div id="container" style="position: relative; height:40vh; width:80vw;margin: auto;">
            <canvas id="canvas" dir="rtl"></canvas>
        </div>
    </div>
</main>
<script>
    var creator = "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
    var year = "<?php echo $year = (isset($_GET['year'])) ? $_GET['year'] : ''; ?>";
    $('.creator_filter').on('change', function() {
        creator = $('.creator_filter').val();
        update_filter()
    });

    $('.year_filter').on('change', function() {
        year = $('.year_filter').val();
        update_filter()
    });

    function update_filter() {
        $('.filter_button').attr("href", creator+'?creator='+creator + '&year=' + year);
    }

    function view_csv_export() {
		let creator_str = "?creator=" + "<?php echo $creator = (isset($_GET['creator'])) ? $_GET['creator'] : ''; ?>";
		let year_str = "&year=" + "<?php echo $creator = (isset($_GET['year'])) ? $_GET['year'] : ''; ?>";
		for (let index = 1; index <= 12; index++) {
			$('#csv_month').append("<a target='blank' href='/production/export_to/" + index + creator_str + year_str + "' class='btn btn-outline-info'>" + index + "</a>")
		}
	}

    window.chartColors = {
        user1: 'rgb(75, 192, 192)', //green
        user2: 'rgb(54, 162, 235)', //blue
        user3: 'rgb(255, 99, 132)', //red
        user4: 'rgb(255, 159, 64)', //orange
        user5: 'rgb(255, 205, 86)', //yellow
        user6: 'rgb(153, 102, 255)', //purple
        user7: 'rgb(201, 203, 207)' //grey
    };

    var MONTHS = ['ינואר', 'פברואר', 'מרץ ', 'אפריל ', 'מאי ', 'יוני', 'יולי', 'אוגוסט ', 'ספטמבר', 'אוקטובר', 'נובמבר', 'דצמבר'];
    var color = Chart.helpers.color;
    var barChartData = {
        labels: MONTHS,
        datasets: [<?php echo $dataSets ?>]
    };

    window.onload = function() {
        set_years();
        set_month();
        view_csv_export();
        update_filter();
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 16
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            fontSize: 16,
                            fontStyle: 'bold'
                        }
                    }]
                },
                responsive: true,
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        // This more specific font property overrides the global property
                        fontColor: 'black',
                        fontSize: 20,
                        fontStyle: 'bold'
                    }
                },
                title: {
                    display: false,
                    text: ''
                },
                plugins: {
                    // Change options for ALL labels of THIS CHART
                    datalabels: {
                        color: '#000',
                        align: 'right',
                        anchor: 'center',
                        offset: 7,
                        font: {
                            weight: 'bold'
                        },
                        formatter: Math.round
                    }
                }
            }
        });
        canvas.onclick = function(evt) {
            var activePoints = myBar.getElementsAtEvent(evt);

            if (typeof activePoints[0] != "undefined") {
                console.log(activePoints);
                console.log(activePoints[0]['_index'] + 1);
            }
        };
    };
</script>