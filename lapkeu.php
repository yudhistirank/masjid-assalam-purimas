<?php
include('koneksi.php');

$bulan = '';
$tahun = '';
$sql = '';
$totalQuery = ''; 

if(isset($_POST['filter'])) {
  $bulan = $_POST['bulan'];
  $tahun = $_POST['tahun']; 
}

if($bulan && $tahun) {
  $sql = mysqli_query($koneksi, "SELECT * FROM laporan_keuangan WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'");
} else {
  $sql = mysqli_query($koneksi, "SELECT * FROM laporan_keuangan");  
}

if($bulan && $tahun) {
  $totalQuery = mysqli_query($koneksi, "SELECT SUM(pemasukan) AS total_pemasukan, SUM(pengeluaran) AS total_pengeluaran FROM laporan_keuangan WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'");
} else {
  $a = "SELECT SUM(pemasukan) AS total_pemasukan, SUM(pengeluaran) AS total_pengeluaran FROM laporan_keuangan";
  $totalQuery = mysqli_query($koneksi, $a);
}

$totalData = mysqli_fetch_assoc($totalQuery);
$total_saldo = $totalData['total_pemasukan'] - $totalData['total_pengeluaran'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Informasi meta dan title pada halaman HTML -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan Masjid</title>
    <!-- Menambahkan stylesheet & script Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8RAVXfNYA6VRj2uRI2ZEJL7PwkFOB6aFGoFft5BB1aE/mBtXpz5GUe/Q4Y3O" crossorigin="anonymous"></script>
    <!-- Menambahkan CSS khusus jika diperlukan -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <section class="header">
    <nav>
        <a href="index.html"><img src="asset/masjidassalam.png"></a>
            <div class="nav-link" id="navLink">
                <i class="fa fa-times" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="index.html">Beranda</a></li>
                    <li><a href="lapkeu.php">Laporan Keuangan</a></li>
                    <li><a href="tentang.html">Tentang Kami</a></li>
                </ul>
            </div>
            <i class="fa fa-bars" onclick="showMenu()"></i>
    </nav>

<div class="textbox">
    <h1>Laporan Keuangan</h1>
    <h4>Masjid As-Salam Purimas Surabaya</h4>
    <br>
    <a href="#laporan" class="btn">Cek Laporannya!</a>
</div>
</section>

<!-- Rekomendasi -->
<section id="laporan" class="rekom">
    <h1>Laporan Keuangan Masjid As-Salam</h1>
    <p>Temukan berbagai keunggulan yang menjadikan Masjid As-Salam tempat favorit untuk beribadah dan berkumpul. 
    <br> Dari fasilitas modern hingga program komunitas yang inspiratif, mari kita jelajahi bersama</p>

    <section id="rincian">
        <div>
        <!-- Form pencarian data -->
        <td><p class="text-center">Silahkan Pilih Bulan/Tahun</p></td>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <select name="bulan">
                            <option value="">Semua</option> 
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>

                        <select name="tahun">
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                        </select>

                        <input type="submit" name="filter" value="Filter">
                    </form>
        </div>

</section>
                    <!-- Bagian body card -->
                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Tanggal/Bulan</th>
                                    <th scope="col">Kegiatan</th>
                                    <th scope="col">Pemasukan</th>
                                    <th scope="col">Pengeluaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql2   = "SELECT * FROM laporan_keuangan ORDER BY id DESC";
                                $q2     = mysqli_query($koneksi, $sql2);
                                $urut   = 1;

                                // if(isset($sql)){}else{}
                                while ($r2 = mysqli_fetch_array($sql)) {
                                    $id            = $r2['id'];
                                    $tanggal       = $r2['tanggal'];
                                    $kegiatan      = $r2['kegiatan'];
                                    $pemasukan     = $r2['pemasukan'];
                                    $pengeluaran   = $r2['pengeluaran'];
                                ?>
                                    <tr>
                                        <th scope="row"><?php echo $urut++ ?></th>
                                        <td scope="row"><?php echo $tanggal ?></td>
                                        <td scope="row"><?php echo $kegiatan ?></td>
                                        <td scope="row">Rp <?php echo number_format($pemasukan, 0, ',', '.'); ?></td>
                                        <td scope="row">Rp <?php echo number_format($pengeluaran, 0, ',', '.'); ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>

                        <!-- Tabel Total Saldo -->
                        <section id="totalsaldo">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Total Pemasukan</th>
                                        <th scope="col">Total Pengeluaran</th>
                                        <th scope="col">Total Saldo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Rp <?php echo number_format($totalData['total_pemasukan'], 0, ',', '.'); ?></td>
                                        <td>Rp <?php echo number_format($totalData['total_pengeluaran'], 0, ',', '.'); ?></td>
                                        <td>Rp <?php echo number_format($total_saldo, 0, ',', '.'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </section>
                    </div>
                </div>
            </div>
        </section>

<!-- Footer -->
<section class="footer" id="Tentang">
    <h4>Tentang</h4>
    <p>Masjid Assalam Purimas memiliki Visi menjadi sentra ibadah & dakwah terbesar di Surabaya,
        <br> khususnya Surabaya Timur sehingga terbentuk masyarakat madani berakhlak mulia,
        <br> rukun dan damai sesuai ajaran Islam.</p>
    <div class="icons">
        <i class="fa fa-facebook"></i>
        <i class="fa fa-twitter"></i>
        <i class="fa fa-instagram"></i>
    </div>
    <p>Developed With <i class="fa fa-heart-o"></i> by Yudhistira Nanda Kumala</p>

</section>

        <script src="https://kit.fontawesome.com/a07b076ce3.js" crossorigin="anonymous"></script>

    </body>
</html>