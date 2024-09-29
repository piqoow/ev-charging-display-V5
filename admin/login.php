<!doctype html>
<html lang="en">

<head>
    <link rel="shortcut icon" href="../images/logo-cp.png" />
    <title>PDS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../public/vendor/bootstrap-4.1.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../public/vendor/font-awesome/fontawesome-5.15.4/css/all.css" />

    <link rel="stylesheet" href="../public/css/style.css">

</head>

<body class="img js-fullheight" style="background-image: url(../images/bg/login-bg.jpg);">
    <section class="ftco-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                    <img src="../images/logo-second.png" style="width: 170px" alt="">
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="login-wrap p-0">
                        <h3 class="mb-4 text-center"><b>Welcome Back Again to PGS Admin</b></h3>
                        <form action="action-login.php" method="POST" class="signin-form">
                            <div class="form-group">
                                <input type="text" class="form-control" name="username" placeholder="Username" required>
                            </div>
                            <div class="form-group">
                                <input id="password-field" type="password" name="password" class="form-control" placeholder="Password" required>
                                <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="form-control btn submit px-3" style="background-color: #054D80;">Sign In</button>
                            </div>
                            <div class="form-group d-md-flex">
                                <div class="w-50">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="../public/vendor/jquery-3.6.0/jquery-3.6.0.min.js"></script>
    <script src="../public/vendor/bootstrap-4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="../public/vendor/font-awesome/fontawesome-5.15.4/js/all.js"></script>

</body>

</html>