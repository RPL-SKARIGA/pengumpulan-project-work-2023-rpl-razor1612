<?php

require_once 'config.php';

$nama_user = $password = "";
$nama_user_err = $password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["nama_user"]))) {
        $nama_user_err = '<span style="color: red">Please enter nama</span>';
    } else {
        $nama_user = trim($_POST["nama_user"]);
    }

    if (empty(trim($_POST['password']))) {
        $password_err = '<span style="color: red">Please enter your password</span>';
    } else {
        $password = trim($_POST['password']);
    }

    if (empty($nama_user_err) && empty($password_err)) {
        $sql = "SELECT nama_user, password FROM user WHERE nama_user = :nama_user";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':nama_user', $param_nama_user, PDO::PARAM_STR);
            $param_nama_user = trim($_POST["nama_user"]);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $hashed_password = $row['password'];
                        if (password_verify($password, $hashed_password)) {

                            session_start();
                            $_SESSION['nama_siswa'] = $nama_siswa;

                            header("location: dashsis.php");
                            //header("location: welcome.php");
                        } else {
                            $password_err = '<span style="color: red">Password anda salah</span>';
                        }
                    }
                } else {
                    $nis_err = '<span style="color: red;">anda belum memiliki nis</span>';
                }
            } else {
                echo "oops! ada yang salah. harap coba lagi";
            }
        }
        unset($stmt);
    }
    unset($pdo);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.104.2">
    <title>Login</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.2/examples/sign-in/">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    </style>
    <link href="sign-in/signin.php" rel="stylesheet">
</head>

<body class="text-center">

    <main class="form-signin text-center">
        <form action="logsis.php" method="post" class="w-100 mx-auto" style="max-width: 330px;">
            <div class="mb-3"></div>
            <img class="mb-4" src="assets/brand/smk.png" alt="" width="72" height="57">
            <h1 class="h4 mb-3 fw-normal">Please Sign Up</h1>

            <div class="mb-3 form-floating <?php echo (!empty($nama_user_err)) ? 'has error' : ''; ?>">
                <input type="text" name="nama_user" value="<?php echo $nama_user; ?>" class="form-control"
                    id="floatingInput" placeholder="nis">
                <label for="floatingInput">Username</label>
                <span class="help-block">
                    <?php echo $nama_user_err; ?>
                </span>
            </div>

            <div class="mb-3 form-floating <? echo (!empty($password_err)) ? 'has error' : ''; ?>">
                <input type="password" name="password" value="<?php echo $password; ?>" class="form-control"
                    id="floatingPassword" placeholder="password">
                <label for="floatingPassword">Password</label>
                <span class="help-block">
                    <?php echo $password_err; ?>
                </span>
            </div>

            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>

            <div class="mb-3">Belum memiliki akun? <a href="regisis.php"><b>Sign-Up</b></a>
            </div>
        </form>
</body>

</html>