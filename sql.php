<?php
$host       = "localhost";
$user       = "root";
$pass       = "";
$db         = "akademik";

$koneksi    = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$nisn           = "";
$nama           = "";
$kelas          = "";
$pilihan_Ekskul  = "";
$sukses         = "";
$error          = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}
if($op == 'delete'){
    $id         = $_GET['id'];
    $sql1       = "delete from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error  = "Gagal melakukan delete data";
    }
}
if ($op == 'edit') {
    $id             = $_GET['id'];
    $sql1           = "select * from mahasiswa where id = '$id'";
    $q1             = mysqli_query($koneksi, $sql1);
    $r1             = mysqli_fetch_array($q1);
    $nisn           = $r1['nisn'];
    $nama           = $r1['nama'];
    $kelas          = $r1['kelas'];
    $pilihan_Ekskul  = $r1['pilihan_Ekskul'];

    if ($nisn == '') {
        $error = "Data tidak ditemukan";
    }
}
if (isset($_POST['simpan'])) { //untuk create
    $nisn           = $_POST['nisn'];
    $nama           = $_POST['nama'];
    $kelas          = $_POST['kelas'];
    $pilihan_Ekskul  = $_POST['pilihan_Ekskul'];

    if ($nisn && $nama && $kelas && $pilihan_Ekskul) {
        if ($op == 'edit') { //untuk update
            $sql1       = "update mahasiswa set nisn = '$nisn',nama='$nama',kelas = '$kelas',pilihan_Ekskul='$pilihan_Ekskul' where id = '$id'";
            $q1         = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else { //untuk insert
            $sql1   = "insert into mahasiswa(nisn,nama,kelas,pilihan_Ekskul) values ('$nisn','$nama','$kelas','$pilihan_Ekskul')";
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-- untuk memasukkan data -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");//5 : detik
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                    header("refresh:5;url=index.php");
                }
                ?>
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nisn" class="col-sm-2 col-form-label">NISN</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nisn" name="nisn" value="<?php echo $nisn ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="kelas" class="col-sm-2 col-form-label">Kelas</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="kelas" name="kelas" value="<?php echo $kelas ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="pilihan_Ekskul" class="col-sm-2 col-form-label">Pilihan Lomba</label>
                        <div class="col-sm-10">
                            <select class="form-control" name="pilihan_Ekskul" id="pilihan_Ekskul">
                                <option value="">- Pilihan Ekskul -</option>
                                <option value="Pramuka" <?php if ($pilihan_Ekskul == "Pramuka") echo "selected" ?>>Pramuka</option>
                                <option value="Paskibra" <?php if ($pilihan_Ekskul == "Paskibra") echo "selected" ?>>Paskibra</option>
                                <option value="PMR" <?php if ($pilihan_Ekskul == "PMR") echo "selected" ?>>PMR</option>
                                <option value="Silat" <?php if ($pilihan_Ekskul == "Silat") echo "selected" ?>>Silat</option>
                                <option value="Kateda" <?php if ($pilihan_Ekskul == "Kateda") echo "selected" ?>>Kateda</option>
                                <option value="Rohis" <?php if ($pilihan_Ekskul == "Rohis") echo "selected" ?>>Rohis</option>
                                <option value="Jurnalistik" <?php if ($pilihan_Ekskul == "Jurnalistik") echo "selected" ?>>Jurnalistik</option>
                                <option value="Qiroatil Quran" <?php if ($pilihan_Ekskul == "Qiroatl Quran") echo "selected" ?>>Qiroatil Quran</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                    </div>
                </form>
            </div>
        </div>

        <!-- untuk mengeluarkan data -->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Siswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Pilihan Ekskul</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2   = "select * from mahasiswa order by id desc";
                        $q2     = mysqli_query($koneksi, $sql2);
                        $urut   = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id             = $r2['id'];
                            $nim            = $r2['nisn'];
                            $nama           = $r2['nama'];
                            $kelas          = $r2['kelas'];
                            $pilihan_Ekskul  = $r2['pilihan_Ekskul'];

                        ?>
                            <tr>
                                <th scope="row"><?php echo $urut++ ?></th>
                                <td scope="row"><?php echo $nisn ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $kelas ?></td>
                                <td scope="row"><?php echo $pilihan_Ekskul ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>            
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
</body>

</html>
