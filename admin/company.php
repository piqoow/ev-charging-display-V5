<?php
DEFINE("root", "https://" . htmlspecialchars($_SERVER["HTTP_HOST"]) . "/pgs");
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
    <style>
        .navbar {
            background-color: #023047;
        }

        .navbar .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #fbc531;
        }

        .navbar .navbar-nav .active>.nav-link {
            color: #fbc531;
        }

        footer {
            position: fixed;
            height: 50px;
            bottom: 0;
            width: 100%;
        }
    </style>
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
                        <li class="nav-item pl-1">
                            <a class="nav-link" href="<?= root ?>/admin/configuration.php"><i class="fa fa-th-list fa-fw mr-1"></i>Configuration</a>
                        </li>
                        <li class="nav-item active pl-1">
                            <a class="nav-link" href="<?= root ?>/admin/company.php"><i class="fa fa-info-circle fa-fw mr-1"></i>Company</a>
                        </li>
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
                <form>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Company Name</label>
                                <input type="text" class="form-control" id="floor" name="floor" placeholder="Input Floor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Logo</label>
                                <input type="file" class="form-control-file" id="exampleFormControlFile1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Telp. Number</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Website</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Address</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="exampleInputEmail1">District</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">City</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Province</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Postal Code</label>
                                <input type="text" class="form-control" id="floor" name="floor">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
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
<!-- <script src="../public/vendor/bootstrap-4.1.3/js/popper.js"></script> -->
<script src="../public/vendor/bootstrap-4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="../public/vendor/font-awesome/fontawesome-5.15.4/js/all.js"></script>

</html>