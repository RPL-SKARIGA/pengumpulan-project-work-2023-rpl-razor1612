<?php

session_start();
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="assets/dist/css/bootstrap.icons.css">
    <link rel="stylesheet" type="text/css" href="assets/dist/css/bootstrap.min.css">

    <style type="text/css">
        .wrapper {
            width: auto;
            margin: 0 auto;
        }

        .page-header h2 {
            margin-top: 0;
        }

        table tr td:last-child a {
            margin-right: 15px;
        }
    </style>
</head>

<body style="margin-top: 50px" ;>
    <div class="container-fluid padding" align="center">
        <a href="logout.php" class="btn btn-danger">Log Out or Sign Out</a>

        <br><br>
        <div class="page-header">
            <h4>HAMLOOO BOLOOOO</h4>
            <h2>
                <font color="#1a63c6"><b>
                        <? echo htmlspecialchars($_SESSION['username']); ?>
                    </b></font>
            </h2>
            <br><br>
            <h3>Selamat Datang di Pemograman Web Kelas XI RPL<br></h3>
            <a href="#" class="btn btn-succes">Link 1</a>
            <a href="#" class="btn btn-primary">Link 2</a>
            <a href="#" class="btn btn-secondary">Link 3</a>
        </div>
    </div>
</body>

</html>