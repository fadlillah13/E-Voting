<?php
if(!isset($_SESSION['id_admin'])) {
   header('location: ../');
}

if(isset($_POST['add_user'])) {

   $nis  = $_POST['nis'];
   $nama = $_POST['nama'];
   $jk   = $_POST['jk'];
   $kls  = $_POST['kelas'];
   //cek nis
   $get_id = $con->prepare("SELECT * FROM t_user WHERE id_user = ?");
   $get_id->bind_param('s', $nis);
   $get_id->execute();
   $get_id->store_result();
   $numb = $get_id->num_rows();
   //validasi
   if($nis == '' || $nama == '' || $jk == '' || $kls == '') {

      echo '<script type="text/javascript">alert("Semua form harus terisi");</script>';

   } else if(!preg_match("/^[a-zA-z \'.]*$/",$nama)) {

      echo '<script type="text/javascript">alert("Nama hanya boleh mengandung huruf, titik(.), petik tunggal");</script>';

   } else if($numb > 0){

      echo '<script type="text/javascript">alert("Nis tidak dapat digunakan");window.history.go(-1);</script>';

   } else {

      $sql = $con->prepare("INSERT INTO t_user(id_user, fullname, id_kelas, jk) VALUES(?, ?, ?, ?)");
      $sql->bind_param('ssss', $nis, $nama, $kls, $jk);
      $sql->execute();

      header('location: ?page=user');

   }

}
?>
<h3>Tambah Data Siswa</h3>
<hr />
<div class="row">
    <div class="col-md-8 col-sm-12">
        <form action="" method="post" class="form-horizontal">

            <div class="form-group">
                <label class="col-sm-2 control-label">NIS</label>
                <div class="col-md-4">
                    <input class="form-control" type="number" name="nis" placeholder="NIS" type="number"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Nama Siswa</label>
                <div class="col-md-8">
                    <input class="form-control" name="nama" type="text" placeholder="Nama Siswa"/>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Jenis Kelamin</label>
                <div class="col-md-10">
                    <label class="radio-inline">
                        <input type="radio" name="jk" value="L" id="L"> Laki - laki
                    </label>

                    <label class="radio-inline">
                        <input type="radio" name="jk" value="P" id="P"> Perempuan
                    </label>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label">Kelas</label>
                <div class="col-md-6">
                    <select name="kelas" required="kelas" class="form-control">
                        <option value="#">-- Pilih Kelas --</option>
                        <?php
                            $kelas = mysqli_query($con, "SELECT * FROM t_kelas");
                            while ($key = mysqli_fetch_array($kelas)) {
                            ?>
                                <option value="<?php echo $key['id_kelas']; ?>">
                                    <?php echo $key['nama_kelas']; ?>
                                </option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-8 col-md-offset-2">
                    <button type="submit" name="add_user" value="Tambah User" class="btn btn-success">Tambah Siswa</button>
                    <button type="button" onclick="window.history.back()" class="btn btn-danger">Kembali</button>
                </div>
            </div>
        </form>
    </div>
</div>
