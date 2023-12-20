<?php

require_once 'config.php';
session_start();

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header("location: login.php");
    exit;
}

$id_nilai = $nama_siswa = $nama_mapel = $nilai = "";
$id_nilai_err = $nama_siswa_err = $nama_mapel_err = $nilai_err = "";

if (isset($_POST["id_nilai"]) && !empty($_POST["id_nilai"])) {

    $id = $_POST["id_nilai"];

    $input_id_nilai = trim($_POST["id_nilai"]);
    if (empty($input_id_nilai)) {
        $id_nilai_err = '<span style="color: red;">Silakan masukkan angka saja</span>';
    } else {
        $id_nilai = $input_id_nilai;
    }

    $input_nama_siswa = trim($_POST["nama_siswa"]);
    if (empty($input_nama_siswa)) {
        $nama_siswa_err = '<span style="color: red;">Silakan masukkan nama anda</span>';
    } else {
        $nama_siswa = $input_nama_siswa;
    }

    $input_nama_mapel = trim($_POST["nama_mapel"]);
    if (empty($input_nama_mapel)) {
        $nama_mapel_err = '<span style="color: red;">Silakan masukkan nama anda</span>';
    } else {
        $nama_mapel = $input_nama_mapel;
    }

    $input_id_nilai = trim($_POST["nilai"]);
    if (empty($input_nilai)) {
        $nilai_err = '<span style="color: red;">Silakan pilih</span>';
    } else {
        $nilai = $input_nilai;
    }

    if (empty($id_nilai_err) && empty($nama_siswa_err) && empty($nama_mapel_err) && empty($nilai_err)) {

        $sql = "UPDATE nilai SET id_nilai = :id_nilai, nama_siswa = :nama_siswa, nama_mapel = :nama_mapel, nilai = :nilai WHERE id_nilai = :id_nilai";

        if ($stmt = $pdo->prepare($sql)) {
            $stmt->bindParam(':id_nilai', $param_id_nilai);
            $stmt->bindParam(':nama_siswa', $param_nama_siswa);
            $stmt->bindParam(':nama_mapel', $param_nama_mapel);
            $stmt->bindParam(':nilai', $param_nilai);


            $param_id_nilai = $id_nilai;
            $param_nama_siswa = $nama_siswa;
            $param_nama_mapel = $nama_mapel;
            $param_nilai = $nilai;


            if ($stmt->execute()) {
                header("location: nilai.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later";
            }
        }
        unset($stmt);
    }
    unset($pdo);
} else {
    if (isset($_GET["id_nilai"]) && !empty(trim($_GET["id_nilai"]))) {

        $id = trim($_GET["id_nilai"]);

        $sql = "SELECT * FROM nilai WHERE id_nilai = :id_nilai";
        if ($stmt = $pdo->prepare($sql)) {

            $stmt->bindParam("id_nilai", $param_id_nilai);

            $param_id_nilai = $id;

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {

                    $row = $stmt->fetch(PDO::FETCH_ASSOC);

                    $nis = $row["id_nilai"];
                    $pass = $row["nama_siswa"];
                    $nama_siswa = $row["nama_mapel"];
                    $kelamin = $row["nilai"];

                } else {
                    header("location: nilai_error.php");
                    exit();
                }
            } else {
                echo "oops! something went wrong. please try again later";
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

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Update Nilai</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
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
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Pages Collapse Menu -->
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

                <!-- Main Content -->
                <div id="content">

                    <!-- Topbar -->
                    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                        <!-- Topbar Navbar -->
                        <ul class="navbar-nav ml-auto">

                            <!-- Nav Item - User Information -->
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="mr-2 d-none d-lg-inline text-gray-600 small">Razor</span>
                                    <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                                </a>
                                <!-- Dropdown - User Information -->
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

                                <div class="form-group <?php echo (!empty($nama_siswa_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Siswa</b></label>
                                    <input type="text" name="nama_siswa" class="form-control"
                                        value="<?php echo $id_nilai; ?>">
                                    <span class="hep-block">
                                        <?php echo $nama_siswa_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($nama_mapel_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Mata Pelajaran</b></label>
                                    <input type="text" name="nama_mapel" class="form-control"
                                        value="<?php echo $nama_mapel; ?>">
                                    <span class="hep-block">
                                        <?php echo $nama_mapel_err; ?>
                                    </span>
                                </div>

                                <div class="form-group <?php echo (!empty($nilai_err)) ? 'has-error' : ''; ?>">
                                    <label><b>Nilai</b></label>
                                    <input type="text" name="nilai" class="form-control" value="<?php echo $nilai; ?>">
                                    <span class="hep-block">
                                        <?php echo $nilai_err; ?>
                                    </span>
                                </div>
                                <br>

                                <input type="hidden" name="id_nilai" value="<?php echo $id_nilai; ?>">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <a href="nilai.php" class="btn btn-danger">Cancel</a>
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