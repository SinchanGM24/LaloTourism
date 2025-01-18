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

$koneksi = new mysqli("localhost", "root", "", "lalotourism2");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}


// Mengambil profil admin berdasarkan username yang disimpan dalam session
$username = $_SESSION['Username'];
$sql2 = "SELECT * FROM admin WHERE Username = '$username'"; // Mengambil data profil admin berdasarkan username session
$q2 = $koneksi->query($sql2);

if (!$q2) {
    die("Error: " . $koneksi->error);
}

$r2 = $q2->fetch_assoc(); // Mengambil data profil dari hasil query



$nama = $r2['Nama_admin'];
$username = $r2['Username'];
$password = $r2['Password'];
$media = $r2['media_admin'];
$alamat = $r2['Alamat_admin'];
$kelamin = $r2['Jenis_kelamin'];
$lahir = $r2['tanggal_lahir'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $kelamin = $_POST['kelamin'];
    $lahir = $_POST['lahir'];

    // Proses file upload jika ada file yang diunggah
    if (isset($_FILES['media_admin']) && $_FILES['media_admin']['error'] == 0) {
        $targetDir = "img/"; // Tentukan direktori penyimpanan file
        $fileName = basename($_FILES["media_admin"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    
        // Izinkan hanya beberapa jenis file tertentu
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            // Pindahkan file yang diunggah ke direktori target
            if (move_uploaded_file($_FILES["media_admin"]["tmp_name"], $targetFilePath)) {
                $media = "img/" . $fileName;
            } else {
                $error = "Maaf, terjadi kesalahan saat mengunggah file.";
            }
        } else {
            $error = 'Maaf, hanya file JPG, JPEG, PNG, GIF, dan PDF yang diizinkan untuk diunggah.';
        }
    }
    
    // Ubah query pembaruan profil Anda untuk menyertakan $media yang baru
    $sql = "UPDATE admin SET Nama_admin = '$nama', Alamat_admin = '$alamat', Jenis_kelamin = '$kelamin', tanggal_lahir = '$lahir' , media_admin = '$media' WHERE Username = '$username'";
    
 

 // Debug statement to check the generated SQL query
 echo "SQL Query: $sql <br>";

 if ($koneksi->query($sql) === TRUE) {
     $_SESSION['message'] = "Profil berhasil diperbarui!";
 } else {
     $_SESSION['message'] = "Error updating profile: " . $koneksi->error;
 }

 // Debug statement to check for any database errors
 if ($koneksi->error) {
     echo "Database Error: " . $koneksi->error . "<br>";
 }
 
 // Refresh the page to reflect the changes
 header("Location: Profile.php");
 exit();
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

    <title>Profile Admin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            color: #333;
        }
        
        .profile-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 10px 6px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            padding: 30px;
            margin: 20px auto;
            position: relative;
            color: #333;
        }
        
        .profile-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }
        
        .edit-icon {
            cursor: pointer;
            color: #666;
        }
        
        .edit-icon:hover {
            color: #000;
        }
        
        .profile-content {
            text-align: center;
        }
        
        .username {
            font-size: 30px;
            margin: 2% 0;
            color: #555; 
        }
        
        .profile-pic {
            border-radius: 50%;
            width: 180px;
            height: 180px;
            object-fit: cover;
            margin-bottom: 20px;
        }
        
        .contact-info {
            list-style-type: none;
            padding: 0;
            text-align: left;
            margin: 20px 0;
        }
        
        .contact-info li {
            font-size: 16px;
            margin-bottom: 15px;
            color: #555;
            display: flex;
            align-items: center;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        
        .contact-info li i {
            margin-right: 10px;
            color: #3498db;
            font-size: 18px;
        }
        
        .contact-info strong {
            display: inline-block;
            min-width: 100px;
            color: #333;
        }
        
        .btn-edit {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #fff;
            background-color: #4e73df;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .btn-edit:hover {
            background-color: #2e59d9;
        }
        
        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            color: #333;
        }
        
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            color: #333;
        }
        
        .modal .close {
            color: #666;
        }
    </style>

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
            <li class="nav-item active">
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



                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                   
                                        <!-- Profile Section -->
                                        <div class="profile-container">
    <div class="profile-header" >
    </div>
    <?php
                            if (isset($_SESSION['message'])) {
                                echo "<div class='alert alert-info'>" . $_SESSION['message'] . "</div>";
                                unset($_SESSION['message']);
                            }
                            ?>
    <div class="profile-content">
    <h1 class="h3 mb-4 text-gray-800" style="text-align: center;">Profile</h1>
        <img  class="img-profile rounded-circle" src="<?php echo $media; ?>" style="width: 150px; height: 150px;">
        <p class="username"><?php echo $nama; ?></p>
        <ul class="contact-info">
            <li><i class="fas fa-user"></i><strong>Username</strong>: <?php echo $username; ?></li>
            <li><i class="fas fa-lock"></i><strong>Password</strong>: <?php echo str_repeat('*', strlen($password)); ?></li>
            <li><i class="fas fa-map-marker-alt"></i><strong>Alamat</strong>: <?php echo $alamat; ?></li>
            <li><i class="fas fa-venus-mars"></i><strong>Jenis Kelamin</strong>: <?php echo $kelamin; ?></li>
            <li><i class="fas fa-birthday-cake"></i><strong>Tanggal Lahir</strong>: <?php echo $lahir; ?></li>
            <input type="button" id="editProfileButton" name="Edit profile" value="Edit Profile" class="btn btn-primary" />


        </ul>
    </div>
</div>
                    <!-- Edit Profile Modal -->
                    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="editProfileForm" action="Profile.php" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label for="media_admin">Media</label>
                                            <input type="file" class="form-control" id="media_admin" name="media_admin">
                                        </div>
                                        <div class="form-group">
                                            <label for="nama">Nama</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username" value="<?php echo $username; ?>" readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Password</label>
                                            <input type="text" class="form-control" id="password" name="password" value="<?php echo $password; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="kelamin">Jenis Kelamin</label>
                                             <select class="form-control" id="kelamin" name="kelamin">
                                                <option value="Laki-laki" <?php if ($kelamin == 'Laki-laki') echo 'selected'; ?>>Laki-laki</option>
                                                <option value="Perempuan" <?php if ($kelamin == 'Perempuan') echo 'selected'; ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="lahir">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="lahir" name="lahir" value="<?php echo $lahir; ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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

    <script>
    $(document).ready(function() {
        $('#editProfileButton').click(function() {
            $('#editProfileModal').modal('show');
        });
    });
    </script>
    <script>
$(document).ready(function() {
    $('#editProfileButton').click(function() {
        $('#editProfileModal').modal('show');
    });

    $('#changePasswordButton').click(function() {
        // Redirect to change password page or show password change modal
        window.location.href = 'change_password.php'; // Ganti dengan URL halaman ganti password Anda
    });
});
</script>



</body>

</html>