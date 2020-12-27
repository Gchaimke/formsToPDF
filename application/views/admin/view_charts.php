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
$monthsSum = '';
for ($i = 1; $i < 13; $i++) {
    $monthsSum .= ${'m_' . $i}.',';
}
?>
<script src="<?php echo base_url('assets/js/ChartJs/'); ?>Chart.min.js"></script>
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

    <a id="show_csv" href='#' class='btn btn-outline-info'><i class="fa fa-file-excel-o"></i></a>
    <div id="csv_month" style="display:none;">
        <?php for ($i = 1; $i < 13; $i++) {
            echo "<a target='blank' href='/production/export_to/$i' class='btn btn-outline-info'>$i</a>";
        }

        ?>
    </div>
    <div id="container" style="width: 75%;margin: auto;">
        <canvas id="canvas"></canvas>
    </div>

</main>
<script>
    $('#show_csv').click(function() {
        $('#csv_month').toggle();
    });

    window.chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        blue: 'rgb(54, 162, 235)',
        purple: 'rgb(153, 102, 255)',
        grey: 'rgb(201, 203, 207)'
    };

    var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    var color = Chart.helpers.color;
    var barChartData = {
        labels: MONTHS,
        datasets: [{
            label: 'יוסף',
            backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
            borderColor: window.chartColors.blue,
            borderWidth: 1,
            data: [<?php echo $monthsSum; ?>]
        }]

    };

    window.onload = function() {
        var ctx = document.getElementById('canvas').getContext('2d');
        window.myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                },
                responsive: true,
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'כספים לפי חודשים'
                }
            }
        });
    };
</script>