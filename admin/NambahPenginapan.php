<?php
session_start();

$inactive = 300;

// Check to see if $_SESSION['timeout'] is set
if (isset($_SESSION['timeout'])) {
    // Calculate the session's "time to live"
    $session_life = time() - $_SESSION['timeout'];

    if ($session_life > $inactive) {
        session_unset();     // Unset $_SESSION variable for the runtime
        session_destroy();   // Destroy session data in storage
        header("Location: index.php"); // Redirect to login page
        exit();
    }
}

if (!isset($_SESSION['Username'])) {
    // Jika tidak ada sesi Username, arahkan pengguna kembali ke halaman login
    header("Location: index.php");
    exit();
}
// Koneksi ke database
$koneksi = new mysqli("localhost", "root", "", "lalotourism2");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Mendapatkan username admin yang sedang login
$admin_username = $_SESSION['Username'];

// Mengambil data admin dari database berdasarkan username
$sql_admin = "SELECT * FROM admin WHERE Username = '$admin_username'";
$result_admin = $koneksi->query($sql_admin);

if ($result_admin->num_rows > 0) {
    $row_admin = $result_admin->fetch_assoc();
    $media_profil = $row_admin['media_admin']; // Anggaplah kolom yang menyimpan foto profil adalah 'media_profil'
}


$id        = "";
$nama       = "";
$deskripsi     = "";
$media   = "";


if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if (isset($_POST['simpan'])) { //untuk create
    $nama       = $_POST['nama_penginapan'];
    $deskripsi  = $_POST['deskripsi_penginapan'];

    // Process file upload
    if (isset($_FILES['media_penginapan']) && $_FILES['media_penginapan']['error'] == 0) {
        $targetDir = "../asset/"; // Tentukan direktori penyimpanan file
        $fileName = basename($_FILES["media_penginapan"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        // Izinkan hanya beberapa jenis file tertentu
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            // Pindahkan file yang diunggah ke direktori target
            if (move_uploaded_file($_FILES["media_penginapan"]["tmp_name"], $targetFilePath)) {
                $media = "asset/" . $fileName;
            } else {
                $error = "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        } else {
            $error = 'Maaf, hanya file JPG, JPEG, PNG, GIF, dan PDF yang diizinkan untuk diunggah.';
        }
    } else {
        $error = "Tidak ada file yang diunggah atau terjadi kesalahan saat mengunggah file.";
    }

    if ($nama && $deskripsi && $media) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update penginapan set nama_penginapan='$nama',deskripsi_penginapan = '$deskripsi',media_penginapan='$media' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into penginapan(nama_penginapan,deskripsi_penginapan,media_penginapan) values ('$nama','$deskripsi','$media')";
            $q1     = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses     = "Berhasil memasukkan data baru";
            } else {
                $error      = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silakan masukkan semua data";
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

    <title>Nambah Data</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="Profile.php">
                <div class="sidebar-brand-icon rotate-n-15">

                </div>
                <div class="sidebar-brand-text mx-3">LALOTOURISM</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="Profile.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Profile</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Fasilitas
            </div>



            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Manajemen</span>
                </a>
                <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">

                        <a class="collapse-item" href="destinasi.php">Destinasi</a>
                        <a class="collapse-item" href="event.php">Event</a>
                        <a class="collapse-item" href="penginapan.php">Penginapan</a>
                        <a class="collapse-item" href="kuliner.php">Kuliner</a>
                        <a class="collapse-item" href="souvenir.php">Souvenir</a>
                    </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>





            <!-- Nav Item - Tables -->
            <li class="nav-item">
                <a class="nav-link" href="includes/logincode.php?logout=true">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Exit</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>



                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $admin_username; ?></span>
                                <img class="img-profile rounded-circle" src="<?php echo $media_profil; ?>">
                            </a>

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="mx-auto">
                    <!-- untuk memasukkan data -->
                    <div class="card">
                        <div class="card-header text-white bg-secondary">
                            Create / Edit Data
                        </div>
                        <div class="card-body">
                            <?php if (isset($sukses)) {
                                echo "<div class='alert alert-success'>$sukses</div>";
                            } ?>
                            <?php if (isset($error)) {
                                echo "<div class='alert alert-danger'>$error</div>";
                            } ?>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 row">
                                    <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="nama" name="nama_penginapan" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="deskripsi" name="deskripsi_penginapan" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="media" class="col-sm-2 col-form-label">Media</label>
                                    <div class="col-sm-10">
                                        <input type="file" class="form-control" id="media" name="media_penginapan">
                                    </div>
                                </div>

                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                        </form>
                    </div>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; 2024 Karang Taruna Labuhan Lombok</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>