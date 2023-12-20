<?php

require_once 'config.php';
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

$nis = $pass = $nama_siswa = $kelamin = $kelas = $jurusan = $wali = "";
$nis_err = $pass_err = $nama_siswa_err = $kelamin_err = $kelas_err = $jurusan_err = $wali_err = "";

if (isset($_POST["id_siswa"]) && !empty($_POST["id_siswa"])) {

    $id = $_POST["id_siswa"];

    $input_nis = trim($_POST["nis"]);
    if (empty($input_nis)) {
        $nis_err = '<span style="color: red;">Silakan masukkan NIS</span>';
    } elseif (!ctype_digit($input_nis)) {
        $nis_err = '<span style="color: red;">Silakan masukkan angka saja</span>';
    } else {
        $nis = $input_nis;
    }

    $input_pass = trim($_POST["password"]);
    if (empty($input_pass)) {
        $pass_err = '<span style="color: red;">Silakan masukkan password</span>';
    } else {
        $pass = $input_pass;
    }

    $input_nama_siswa = trim($_POST["nama_siswa"]);
    if (empty($input_nama_siswa)) {
        $nama_siswa_err = '<span style="color: red;">Silakan masukkan nama anda</span>';
    } else {
        $nama_siswa = $input_nama_siswa;
    }

    $input_kelamin = trim($_POST["kelamin"]);
    if (empty($input_kelamin)) {
        $kelamin_err = '<span style="color: red;">Silakan pilih</span>';
    } else {
        $kelamin = $input_kelamin;
    }

    $input_kelas = trim($_POST["kelas"]);
    if (empty($input_kelas)) {
        $kelas_err = '<span style="color: red;">Silakan masukkan kelas anda</span>';
    } else {
        $kelas = $input_kelas;
    }

    $input_jurusan = trim($_POST["jurusan"]);
    if (empty($input_jurusan)) {
        $jurusan_err = '<span style="color: red;">Silakan pilih jurusan</span>';
    } else {
        $jurusan = $input_jurusan;
    }

    $input_wali = trim($_POST["wali"]);
    if (empty($input_wali)) {
        $wali_err = '<span style="color: red;">Silakan masukkan wali</span>';
    } else {
        $wali = $input_wali;
    }

    if (empty($nis_err) && empty($pass_err) && empty($nama_siswa_err) && empty($kelamin_err) && empty($kelas_err) && empty($jurusan_err) && empty($wali_err)) {

        $sql = "UPDATE siswa SET nis = :nis, password = :password, nama_siswa = :nama_siswa, kelamin = :kelamin, kelas = :kelas, jurusan = :jurusan, wali = :wali WHERE id_siswa = :id_siswa";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':id_siswa', $param_id);
            $stmt->bindParam(':nis', $param_nis);
            $stmt->bindParam(':password', $param_pass);
            $stmt->bindParam(':nama_siswa', $param_nama_siswa);
            $stmt->bindParam(':kelamin', $param_kelamin);
            $stmt->bindParam(':kelas', $param_kelas);
            $stmt->bindParam(':jurusan', $param_jurusan);
            $stmt->bindParam(':wali', $param_wali);

            $param_id = $id;
            $param_nis = $nis;
            $param_pass = $pass;
            $param_nama_siswa = $nama_siswa;
            $param_kelamin = $kelamin;
            $param_kelas = $kelas;
            $param_jurusan = $jurusan;
            $param_wali = $wali;

            if ($stmt->execute()) {
                header("location: siswa.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later";
            }
        }
        unset($stmt);
    }
    unset($pdo);
} else {
    if (isset($_GET["id_siswa"]) && !empty(trim($_GET["id_siswa"]))) {

        $id = trim($_GET["id_siswa"]);

        $sql = "SELECT * FROM siswa WHERE id_siswa = :id_siswa";
        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam("id_siswa", $param_id);

            $param_id = $id;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $nis = $row["nis"];
                    $pass = $row["password"];
                    $nama_siswa = $row["nama_siswa"];
                    $kelamin = $row["kelamin"];
                    $kelas = $row["kelas"];
                    $jurusan = $row["jurusan"];
                    $wali = $row["wali"];

                } else {
                    header("location: siswa_error.php");
                    exit();
                }
            } else {
                echo "oops! something went wrong. please try again later";
            }
        }
        unset($stmt);

        unset($pdo);
    } else {
        header("location: siswa_error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Siswa Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <div id="wrapper">

        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard.php">
                <div class="sidebar-brand-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                </div>
                <div class="sidebar-brand-text mx-3">
                    <?php echo htmlspecialchars($_SESSION['username']); ?></b>
                </div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <li class="nav-item">
                <a class="nav-link" href="siswa.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                    <span>Data Siswa</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="kelas.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                        <path fill-rule="evenodd"
                            d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                    </svg>
                    <span>Kelas</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="mapel.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-book-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                    </svg>
                    <span>Mata Pelajaran</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="guru.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-person-workspace" viewBox="0 0 16 16">
                        <path d="M4 16s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-5.95a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                        <path
                            d="M2 1a2 2 0 0 0-2 2v9.5A1.5 1.5 0 0 0 1.5 14h.653a5.373 5.373 0 0 1 1.066-2H1V3a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v9h-2.219c.554.654.89 1.373 1.066 2h.653a1.5 1.5 0 0 0 1.5-1.5V3a2 2 0 0 0-2-2z" />
                    </svg>
                    <span>Guru</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="nilai.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-bar-chart-line-fill" viewBox="0 0 16 16">
                        <path
                            d="M11 2a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v12h.5a.5.5 0 0 1 0 1H.5a.5.5 0 0 1 0-1H1v-3a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v3h1V7a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v7h1V2z" />
                    </svg>
                    <span>Nilai</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content-wrapper" class="d-flex flex-column">

                <div id="content">

                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <ul class="navbar-nav ml-auto">

                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Admin</span>
                                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                </a>
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                    aria-labelledby="userDropdown">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                                </div>
                            </li>

                        </ul>

                    </nav>

                    <div class="container-fluid">
                        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                            <h1 class="h3 mb-0 text-gray-800">Update Data Siswa</h1>
                        </div>

                        <div class="card shadow mb-2 rounded-5 p-5">
                            <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>"
                                method="post" enctype="multipart/form-data">

                                <div class="form-group <?php echo (!empty($nis_err)) ? 'has-error' : ''; ?>">
                                    <label><b>NIS</b></label>
                                    <input type="text" name="nis" class="form-control" value="<?php echo $nis; ?>">
                                    <span class="hep-block">
                                        <?php echo $nis_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($pass_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Password</b></label>
                                    <input type="password" name="password" class="form-control"
                                        value="<?php echo $pass; ?>">
                                    <span class="hep-block">
                                        <?php echo $pass_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($nama_siswa_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Nama Siswa</b></label>
                                    <input type="text" name="nama_siswa" class="form-control"
                                        value="<?php echo $nama_siswa; ?>">
                                    <span class="hep-block">
                                        <?php echo $nama_siswa_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($kelamin_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Jenis Kelamin</b></label><br>
                                    <input type="radio" id="Laki-Laki" name="kelamin" value="Laki-Laki">
                                    <label for="Laki-Laki">Laki-Laki</label>
                                    <input type="radio" id="Perempuan" name="kelamin" value="Perempuan">
                                    <label for="Perempuan">Perempuan</label>
                                    <span class="hep-block"><br>
                                        <?php echo $kelamin_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($kelas_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Kelas</b></label><br>
                                    <input type="text" name="kelas" class="form-control" value="<?php echo $kelas; ?>">
                                    <span class="hep-block">
                                        <?php echo $kelas_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($jurusan_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Jurusan</b></label><br>
                                    <select class="form-control" type="text" name="jurusan">
                                        <option> </option>
                                        <option>Rekayasa Perangkat Lunak</option>
                                        <option>Desain Komunikasi Visual</option>
                                        <option>Teknik Komputer Jaringan</option>
                                    </select>
                                </div>

                                <div class="form-group <?php echo (!empty($wali_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Wali</b></label><br>
                                    <input type="text" name="wali" class="form-control" value="<?php echo $wali; ?>">
                                    <span class="hep-block">
                                        <?php echo $wali_err; ?>
                                    </span>
                                </div>

                                <br>

                                <input type="hidden" name="id_siswa" value="<?php echo $id; ?>">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="siswa.php" class="btn btn-danger">Cancel</a>
                            </form>
                        </div>


                    </div>

                </div>

                <div class="row">

                    <div class="row">

                        <div class="row">

                            <div class="col-lg-6 mb-4">

                            </div>
                        </div>
                        <footer class="sticky-footer bg-white px-5">
                            <div class="container my-auto">
                                <div class="copyright text-center my-auto">
                                    <span>Copyright &copy; Your Website 2023</span>
                                </div>
                            </div>
                        </footer>
                    </div>

                </div>

                <a class="scroll-to-top rounded" href="#page-top">
                    <i class="fas fa-angle-up"></i>
                </a>

                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div header="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"></span>
                                </button>
                                <div class="modal-body">Select "Logout" below if you are ready to end your current
                                    session</div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">cancel</button>
                                    <a class="btn btn-primary" href="login.php">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="vendor/jquery/jquery.min.js"></script>
                    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>