<?php
require_once 'config.php';

$nama_user = $password = $confirm_password = "";
$nama_user_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (empty(trim($_POST['nama_user']))) {
        $nama_user_err = '<span style="color: red">Masukkan Username</span>';
    } else {
        $sql = "SELECT id_user FROM user WHERE nama_user = :nama_user";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':nama_user', $param_nama_user, PDO::PARAM_STR);
            $param_nama_user = trim($_POST['nama_user']);
            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                    $nama_user_err = '<span style="color: red">Username Ini Telah Diisi</span>';
                } else {
                    $nama_user = trim($_POST['nama_user']);
                }
            } else {
                echo "oops! ada yang salah. Harap coba kembali";
            }
        }
        unset($stmt);
    }
    if (empty(trim($_POST['password']))) {
        $password_err = '<span style="color: red">Masukkan Password</span>';
    } else if (strlen(trim($_POST['password'])) < 4) {
        $password_err = '<span style="color: red">Password Minimal 4 Karakter</span>';
    } else {
        $password = trim($_POST['password']);
    }

    if (empty(trim($_POST['confirm_password']))) {
        $confirm_password_err = '<span style="color: red">Konfirmasi password</span>';
    } else {
        $confirm_password = trim($_POST['confirm_password']);
        if ($password != $confirm_password) {
            $confirm_password_err = '<span style="color: red">Password tidak cocok</span>';
        }
    }
    if (empty($nama_user_err) && empty($password_err) && empty($confirm_password_err)) {
        $sql = "INSERT INTO user (nama_user, password) VALUES (:nama_user, :password)";
        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':nama_user', $param_nama_user, PDO::PARAM_STR);
            $stmt->bindParam(':password', $param_password, PDO::PARAM_STR);
            $param_nama_user = $nama_user;
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            if ($stmt->execute()) {
                header("location: logsis.php");
            } else {
                echo "Something went wrong. Please try again later";
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

    <title>Register</title>
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

<body>

    <body class="text-center">

        <main class="form-signin text-center">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="w-100 mx-auto"
                style="max-width: 330px;">

                <img class="mb-4" src="assets/brand/smk.png" alt="" width="72" height="57">
                <h1 class="h4 mb-3 fw-normal">Please Sign Up</h1>

                <div class="mb-3 form-floating <?php echo (!empty($nama_user_err)) ? 'has error' : ''; ?>">
                    <input type="text" name="nama_user" value="<?php echo $nama_user; ?>" class="form-control"
                        placeholder="Username">
                    <label>Username</label>
                    <span class="help-block">
                        <?php echo $nama_user_err; ?>
                    </span>
                </div>

                <div class="mb-3 form-floating <? echo (!empty($password_err)) ? 'has error' : ''; ?>">
                    <input type="password" name="password" class="form-control" value="<?php echo $password; ?>"
                        placeholder="password">
                    <label>Password</label>
                    <span class="help-block">
                        <?php echo $password_err; ?>
                    </span>
                </div>

                <div class="mb-3 form-floating <?php echo (!empty($confirm_password_err)) ? 'has error' : ''; ?>">
                    <input type="password" name="confirm_password" class="form-control"
                        value="<?php echo $confirm_password; ?>" placeholder="password">
                    <label>Konfirmasi Password</label>
                    <span class="help-block">
                        <?php echo $confirm_password_err; ?>
                    </span>
                </div>
                <button class="w-100 btn btn-lg btn-primary" type="submit">Sign In</button>
            </form>
    </body>

</html>