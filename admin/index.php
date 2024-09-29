<?php
DEFINE("root", "http://" . htmlspecialchars($_SERVER["HTTP_HOST"]) . "/pgs");
require_once('../db/connection.php');
include('./get_data/configuration.php');
session_start();
if($_SESSION['status_login'] !="login"){
	header("location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../images/logo-cp.png" />
    <title>PGS</title>
    <link rel="stylesheet" href="../public/vendor/bootstrap-4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../public/vendor/font-awesome/fontawesome-5.15.4/css/all.css" />
    <link rel="stylesheet" href="../public/css/admin.css">
</head>

<body>
    <header>
        <!--- Navbar --->
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand text-white" href="#">
                    <!-- <i class="fa fa-graduation-cap fa-lg mr-2"></i> -->
                    <img src="../images/logo_light.png" alt="" srcset="" style="width: 150px;">
                    <!-- PARKING GUIDE SYSTEM -->
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#nvbCollapse" aria-controls="nvbCollapse">
                    <span class="navbar-toggler-icon" style="color: white;"> <i class="fa fa-bars"></i> </span>
                </button>
                <div class="collapse navbar-collapse" id="nvbCollapse">
                    <ul class="navbar-nav ml-auto">
                        <!-- <li class="nav-item pl-1">
                            <a class="nav-link" href="#"><i class="fa fa-home fa-fw mr-1"></i>Home</a>
                        </li> -->
                        <li class="nav-item active pl-1">
                            <a class="nav-link" href="<?= root ?>/admin/configuration.php"><i class="fa fa-th-list fa-fw mr-1"></i>Configuration</a>
                        </li>
                        <!-- <li class="nav-item pl-1">
                            <a class="nav-link" href="<?= root ?>/admin/company.php"><i class="fa fa-info-circle fa-fw mr-1"></i>Company</a>
                        </li> -->
                        <li class="nav-item pl-1">
                            <a class="nav-link" href="<?= root ?>/admin/logout.php"><i class="fa fa-sign-in fa-fw mr-1"></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--# Navbar #-->
    </header>
    <div class="container">
        <div class="row">
            <div class="col-12 mt-5">
                <form action="<?= root ?>/admin/api/configuration.php" id="formUpdate" method="POST">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Sensor Name</label>
                                <select class="form-control" id="exampleFormControlSelect1" onchange="getDataSensor(this)">
                                    <option value="0">-- Select Sensor --</option>
                                    <?php
                                    foreach (getSensor() as $row) {
                                        echo '<option value="' . $row['sensor_name'] . '">' . $row['sensor_name'] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <input type="hidden" name="data_id" id="id">
                                        <label for="exampleInputEmail1">Parking Capacity</label>
                                        <input type="text" class="form-control" id="capacity" name="capacity" placeholder="Input Parking Capacity">
                                        <small class="form-text text-muted">You can update Parking Capacity when amount Capacity not balanced with real data.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Parking Used</label>
                                        <input type="text" class="form-control" id="used" name="used" placeholder="Input Parking Used">
                                        <small class="form-text text-muted">You can update Parking Used when amount Capacity & Used not balanced with real data.</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="updateData()" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>

        <div id="sensor-list" class="row">

        </div>
    </div>
    <footer>
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3 border-top bg-white">© 2021 Copyright:
            <a> PT. Centrepark Citra Corpora</a>
        </div>
        <!-- Copyright -->

    </footer>
</body>
<script src="../public/vendor/jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="../public/vendor/bootstrap-4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="../public/vendor/font-awesome/fontawesome-5.15.4/js/all.js"></script>
<script src="../public/vendor/notify/notify.min.js"></script>
<script>
    $(document).ready(function() {
        // initializeData();
        getAllDataSensor();
    });

    function getDataSensor(data) {
        var sensor = data.value;
        $.ajax({
            url: "<?= root ?>/admin/api/sensor.php",
            type: "POST",
            data: {
                sensor: sensor,
            },
            dataType: "json",
            success: function(data) {
                // console.log(data.data_parking_id);
                $('#id').val(data.data_parking_id);
                $('#capacity').val(data.capacity);
                $('#used').val(data.vehicle_in);
                // usage
            },
            error: function(request, error) {
                console.log("Request: " + JSON.stringify(request));
            },
        });
    }

    function getAllDataSensor() {
        $.ajax({
            url: "<?= root ?>/admin/api/sensor-all.php",
            type: "POST",
            data: {},
            dataType: "json",
            success: function(data) {
                var available = 0;
                if(data.capacity-data.vehicle_in < 0){
                    available = 0;
                }else{
                    available = data.capacity-data.vehicle_in;
                }
                $('#sensor-list').html(`<div class="col-lg-4 col-md-4 col-sm-12 mt-5">
                <div class="card text-center">
                    <div class="card-header">
                        <b>${data.floor}<sup>st</sup> FLOOR</b>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">PARKING CAPACITY</h5>
                        <h1>${data.capacity}</h1>
                    </div>
                    <div class="card-footer text-muted">
                        ${data.effective_date}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mt-5">
                <div class="card text-center">
                    <div class="card-header">
                        <b>${data.floor}<sup>st</sup> FLOOR</b>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">PARKING USED</h5>
                        <h1>${data.vehicle_in}</h1>
                    </div>
                    <div class="card-footer text-muted">
                        ${data.effective_date}
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 mt-5">
                <div class="card text-center">
                    <div class="card-header">
                        <b>${data.floor}<sup>st</sup> FLOOR</b>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">PARKING AVAILABLE</h5>
                        <h1>${available}</h1>
                    </div>
                    <div class="card-footer text-muted">
                        ${data.effective_date}
                    </div>
                </div>
            </div>`);
            },
            error: function(request, error) {
                console.log("Request: " + JSON.stringify(request));
            },
        });
    }

    function updateData() {
        $.ajax({
            url: "<?= root ?>/admin/api/configuration.php",
            type: "POST",
            data: $('#formUpdate').serialize(),
            dataType: "json",
            success: function(data) {
                getAllDataSensor();
                $.notify(JSON.stringify(data.message), "success");
            },
            error: function(request, error) {
                $.notify(JSON.stringify(error), "error");
            },
        });
    }
</script>

</html>