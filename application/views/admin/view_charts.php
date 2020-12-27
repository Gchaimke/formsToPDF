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
        $userMont = ${'user_' . $user['id']};
        $userColor = 'user' . $user['id'];
        if ($userMont != ',,,,,,,,,,,,') {
            $dataSets .= "{
        label:'" . $user['view_name'] . "',
        backgroundColor: color(window.chartColors.$userColor).alpha(0.7).rgbString(),
        borderColor: window.chartColors.$userColor,
        borderWidth: 1,
        data: [$userMont]
        },";
            if (!isset($csv_user)) {
                $usersButtons .= "<a href='/admin/view_charts/{$user['id']}' class='btn btn-outline-info'>{$user['view_name']}</a>";
            }
        }
    }
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
        <?php
        $csv_user_str = '';
        if (isset($csv_user)) {
            $csv_user_str = "?user=$csv_user";
        }
        for ($i = 1; $i < 13; $i++) {
            echo "<a target='blank' href='/production/export_to/$i$csv_user_str' class='btn btn-outline-info'>$i</a>";
        }
        ?>
    </div>
    <div class="left">
        <a href='/admin/view_charts/' class='btn btn-outline-info'>All Users</a>
        <?php echo $usersButtons; ?>
    </div>
    <div id="container" style="width: 75%;margin: auto;">
        <canvas id="canvas" dir="rtl"></canvas>
    </div>

</main>
<script>
    $('#show_csv').click(function() {
        $('#csv_month').toggle();
    });

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
                    display: true,
                    position: 'top',
                },
                title: {
                    display: false,
                    text: ''
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