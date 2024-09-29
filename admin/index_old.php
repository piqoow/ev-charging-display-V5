<?php
DEFINE("root", "http://" . htmlspecialchars($_SERVER["HTTP_HOST"]) . "/pds");
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
    <title>PDS</title>
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
                        <li class="nav-item pl-1">
                            <a class="nav-link" href="<?= root ?>/admin/configuration.php"><i class="fa fa-th-list fa-fw mr-1"></i>Configuration</a>
                        </li>
                        <li class="nav-item pl-1">
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
        <!-- <div class="jumbotron mt-3">
            <h1 class="display-4">Hello, world!</h1>
            <p class="lead">This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>
            <hr class="my-4">
            <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div> -->
    </div>
    <footer>
        <!-- Copyright -->
        <div class="footer-copyright text-center py-3">© 2021 Copyright:
            <a> PT. Centrepark Citra Corpora</a>
        </div>
        <!-- Copyright -->

    </footer>
</body>
<script src="../public/vendor/jquery-3.6.0/jquery-3.6.0.min.js"></script>
<script src="../public/vendor/bootstrap-4.1.3/js/bootstrap.bundle.min.js"></script>
<script src="../public/vendor/font-awesome/fontawesome-5.15.4/js/all.js"></script>

</html>