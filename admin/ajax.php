<?php
define("BASEPATH", dirname(__FILE__));
session_start();

if(!isset($_SESSION['id_admin'])) {
   header('location:./');
}

include('../include/connection.php');

   if (isset($_POST['periode'])) {
      $periode = $_POST['periode'];
   } else {
      $now     = date('Y');
      $dpn     = date('Y') + 1;
      $periode = $now.'/'.$dpn;
   }

   $get = $con->prepare("SELECT * FROM t_kandidat WHERE periode = ?");
   $get->bind_param('s', $periode);
   $get->execute();
   $get->store_result();
   $htg = $get->num_rows();

   if($htg > 0) {
      ?>
      <div class="row">
         <?php
         for ($i = 0; $i < $htg; $i++) {
            $get->bind_result($id, $nama, $foto, $visi, $misi, $suara, $per);
            $get->fetch();
         ?>
         <div class="col-md-3">
            <div class="thumbnail">
                  <img class="kandidat" src="../assets/img/kandidat/<?php echo $foto; ?>">
                  <div class="suara">
                     <span class="badge alert-success"><?php echo $suara; ?> Suara</span>
                  </div>
                  <div class="caption" style="text-align:center">
                        <h4><?php echo $nama; ?></h4>
                        <a href="?page=kandidat&action=edit&id=<?php echo $id; ?>" class="btn btn-warning">Edit</a>
                        <a href="?page=kandidat&action=view&id=<?php echo $id; ?>" class="btn btn-success">View</a>
                        <a href="?page=kandidat&action=hapus&id=<?php echo $id; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kandidat ini ?')">Hapus</a>
                  </div>
            </div>
         </div>
         <?php
         }
         ?>
      </div>
      <?php
   } else {

   echo '<div class="medium-8 medium-offset-2" style="padding-top:60px;">
            <div class="warning callout" style="padding: 30px 20px; text-align: center; color:#545252;">
               <h4>Tidak ada kandidat</h4>
            </div>
         </div>';

   }
?>
