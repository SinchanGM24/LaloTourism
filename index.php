<?php
    // Koneksi ke database
    $koneksi = new mysqli("localhost", "root", "", "lalotourism2");
    if ($koneksi->connect_error) {
        die("Koneksi gagal: " . $koneksi->connect_error);
    }

    // Array untuk menyimpan hasil query
    $results = [];

    // Query untuk mengambil data dari tabel objek_wisata
    $sql2 = "SELECT * FROM objek_wisata GROUP BY id_object ASC";
    $q2 = $koneksi->query($sql2);
    if (!$q2) {
        die("Error: " . $koneksi->error);
    }
    $results['objek_wisata'] = $q2->fetch_all(MYSQLI_ASSOC);

    // Query untuk mengambil data dari tabel kuliner
    $sql2 = "SELECT * FROM kuliner GROUP BY id_kuliner ASC";
    $q2 = $koneksi->query($sql2);
    if (!$q2) {
        die("Error: " . $koneksi->error);
    }
    $results['kuliner'] = $q2->fetch_all(MYSQLI_ASSOC);

    // Query untuk mengambil data dari tabel event
    $sql2 = "SELECT * FROM event GROUP BY id_event ASC";
    $q2 = $koneksi->query($sql2);
    if (!$q2) {
        die("Error: " . $koneksi->error);
    }
    $results['event'] = $q2->fetch_all(MYSQLI_ASSOC);

    // Query untuk mengambil data dari tabel koleri
    $sql2 = "SELECT * FROM penginapan GROUP BY id_penginapan ASC";
    $q2 = $koneksi->query($sql2);
    if (!$q2) {
        die("Error: " . $koneksi->error);
    }
    $results['penginapan'] = $q2->fetch_all(MYSQLI_ASSOC);

    // Query untuk mengambil data dari tabel kolara
    $sql2 = "SELECT * FROM souvenir GROUP BY id_souvenir ASC";
    $q2 = $koneksi->query($sql2);
    if (!$q2) {
        die("Error: " . $koneksi->error);
    }
    $results['souvenir'] = $q2->fetch_all(MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Lalo Tourism</title>
    <link rel="stylesheet" href="style.css" />
  </head>
  <body>
    <nav>
      <div class="layar-dalam">
        <div class="logo">
          <a href=""><img src="asset/Logo white.png" class="putih" /></a>
          <a href=""><img src="asset/Logo black.png" class="hitam" /></a>
        </div>
        <div class="menu">
          <a href="#" class="tombol-menu">
            <span class="garis"></span>
            <span class="garis"></span>
            <span class="garis"></span>
          </a>
          <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#about">About</a></li>
            <li><a href="#destinasi">Destinasi</a></li>
            <li><a href="#event">Event</a></li>
            <li><a href="#penginapan">Penginapan</a></li>
            <li><a href="#kuliner">Kuliner</a></li>
            <li><a href="#souvenir">Souvenir</a></li>
            <li><a href="#contact">Contact</a></li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="layar-penuh">
      <header id="home">
        <div class="overlay"></div>
        <video autoplay muted loop>
          <source src="asset/Video_LL.mp4" type="video/mp4" />
        </video>
        <div class="intro">
          <h3>Visit Labuhan Lombok</h3>
          <p>
            Memulai perjalanan indah menuju kebahagiaan tak terbatas
          </p>
        </div>
      </header>
      <main>
        <section id="about">
          <div class="layar-dalam">
            <h3>About Us</h3>
            <p class="ringkasan">
              Labuhan Lombok, Pringgabaya, Kabupaten Lombok Timur, Nusa Tenggara Barat, Indonesia.
            </p>
            <div class="konten-isi">
              <p>
                Desa Labuhan Lombok adalah gerbang timur Pulau Lombok, desa yang memiliki keunikan tersendiri, dimulai dari keragaman suku, budaya dan keindahan  hayatinya.  
                Desa Labuhan Lombok dikenal sebagai miniatur Indonesia yang  memiliki keragaman suku dan budaya, hal ini lah yang mendasari  moto pembangunan Desa Labuhan Lombok yakni satu dalam kebhinekaan maju dalam kebersamaan.
                Keramahan dan keharmonisan warga Desa labuhan lombok yang beragam ini diabadikan dengan monumen simbol dua jari di Bukit Kayangan.
                Sebagai desa wisata, Labuhan Lombok akan membuat wisatawan tidak hanya menikmati keindahan laut pulau lombok tapi juga dimanjakan dengan keindahan gunung yang menjadi kebanggaan warga sasak yakni gunung Rinjani. 
              </p>
            </div>
          </div>
        </section>
        <section class="abuabu" id="destinasi">
          <div class="layar-dalam">
            <h3>Destinasi</h3>
            <p class="ringkasan">
              Bukit, Pantai, Laut, hingga Goa. Hanya Untukmu
            </p>

<div class="blog">
    <?php foreach ($results['objek_wisata'] as $r2) : ?>
        <div class="area">
            <div
                class="gambar"
                style="background-image: url('<?php echo $r2['media_objek']; ?>')"
            ></div>
            <div class="text">
                <article>
                    <h4><a href="#"><?php echo $r2['nama_objek']; ?></a></h4>
                    <p>
                        <?php echo $r2['deskripsi_objek']; ?>
                    </p>
                </article>
            </div>
        </div>
    <?php endforeach; ?>
</div>
              </div>
            </div>
          </div>
        </section>
        <section id="gallery">
          <div><img src="asset/Pic1.JPG" /></div>
          <div><img src="asset/Pic2.JPG" /></div>
          <div><img src="asset/Pic3.JPG" /></div>
          <div><img src="asset/Pic4.JPG" /></div>
          <div><img src="asset/Pic5.jpg" /></div>
          <div><img src="asset/Pic6.JPG" /></div>
          <div><img src="asset/Pic7.JPG" /></div>
          <div><img src="asset/Pic8.JPG" /></div>
        </section>
        <section id="event">
          <div class="layar-dalam">
            <h3>Event</h3>
            <p class="ringkasan">
              Mencoba Hal Baru, Hanya Denganmu
            </p>
            <div class="tim">
            <?php foreach ($results['event'] as $r2) : ?>
        <div>
            <img class='fotoset'src="<?php echo $r2['media_event']; ?>" />
            <h6><?php echo $r2['nama_event']; ?></h6>
            <span><?php echo $r2['deskripsi_event']; ?></span>
        </div>
    <?php endforeach; ?>
                    </div>
            </div>
          </div>
        </section>
      <section id="penginapan">
        <div class="layar-dalam">
          <h3>Penginapan</h3>
          <p class="ringkasan">
            Tempat yang Nyaman, Menutup Hari yang Menyenangkan
          </p>
          <div class="tim">
          <?php foreach ($results['penginapan'] as $r2) : ?>
            <div>
            <img src="<?php echo $r2['media_penginapan']; ?>" />
            <h6><?php echo $r2['nama_penginapan']; ?></h6>
            <span><?php echo $r2['deskripsi_penginapan']; ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
      </section>
      <section id="kuliner">
        <div class="layar-dalam">
          <h3>Kuliner</h3>
          <p class="ringkasan">
            Hidangan spesial, Hanya Untukmu
          </p>
          <div class="tim">
          <?php foreach ($results['kuliner'] as $r2) : ?>
            <div>
            <img src="<?php echo $r2['media_kuliner']; ?>" />
            <h6><?php echo $r2['nama_kuliner']; ?></h6>
            <span><?php echo $r2['deskripsi_kuliner']; ?></span>
        </div>
        <?php endforeach; ?>
          </div>
        </div>
      </section>
      <section id="souvenir">
        <div class="layar-dalam">
          <h3>Souvenir</h3>
          <p class="ringkasan">
            Bawalah Pulang, Untuk Mengenang
          </p>
          <div class="tim">
          <?php foreach ($results['souvenir'] as $r2) : ?>
            <div>
            <img src="<?php echo $r2['media_souvenir']; ?>" />
            <h6><?php echo $r2['nama_souvenir']; ?></h6>
            <span><?php echo $r2['deskripsi_souvenir']; ?></span>
        </div>
        <?php endforeach; ?>
          </div>
        </div>
      </section>
      </main>
      <footer id="contact">
        <div class="layar-dalam">
        <div class="contact-info">
        <h5>Contact Person</h5>
        <div class="info-item" style="display: flex; align-items: center;">
            <img src="asset/logoW.png" width="25" height="25" alt="Whatsapp">
            <a href="https://wa.me/6281803337666" style="color:white;">Whatsapp</a>
        </div>
        <div class="info-item" style="display: flex; align-items: center;">
            <img src="asset/gmail.png" width="25" height="25" alt="Email">
            <a href="https://tinyurl.com/mvk4rh4d" style="color:white;">Email</a>
        </div>
    </div>

    <div class="social-media">
        <h5>Ikuti Kami</h5>
        <div class="info-item" style="display: flex; align-items: center;">
            <img src="asset/instagram.png" width="30" height="30" alt="Instagram">
            <a href="https://www.instagram.com/bukitkayangan_?igsh=bGM5aTF5MXR3c2cy" style="color:white;">Instagram</a>
        </div>
        <div class="info-item" style="display: flex; align-items: center;">
            <img src="asset/facebook.png" width="30" height="30" alt="Facebook">
            <a href="https://www.facebook.com/pemdes.lombok" style="color:white;">Facebook</a>
        </div>
        <div class="info-item" style="display: flex; align-items: center;">
            <img src="asset/twitter.png" width="35" height="30" alt="X">
            <a href="https://x.com/DesaLombok?t=SwpjeLEV-SLTkIUCa8k1vA&s=09" style="color:white;">Twitter</a>
        </div>
    </div>

    <div class="maps">
        <h5>Maps</h5>
        <div class="info-item" style="display: flex; align-items: center;">
            <img src="asset/map.png" width="30" height="30" alt="Maps">
            <a href="https://tinyurl.com/Labuhan-Lombok" style="color:white;">Google Maps</a>
        </div>
    </div>
        </div>
        <div class="layar-dalam">
          <div class="copyright">&copy; 2024 Karang Taruna Labuhan Lombok</div>
        </div>
      </footer>
    </div>
    <script
      src="https://code.jquery.com/jquery-3.6.0.min.js"
      integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
      crossorigin="anonymous"
    ></script>
    <script src="javascript.js"></script>
  </body>
</html>
