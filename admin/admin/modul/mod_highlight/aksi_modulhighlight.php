<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";
include "../../../config/library.php";
include "../../../config/fungsi_thumb.php";


$module=$_GET[module];
$act=$_GET[act];

// Input data
if ($module=='modulhighlight' AND $act=='input'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file;

  // Apabila ada gambar yang diupload
  if (!empty($lokasi_file)){

	 	 	 UploadBanner($nama_file_unik);
	  		mysqli_query($config,"INSERT INTO edit_highlight(judul,gambar,deskripsi)
	  				VALUES('$_POST[judul]',
	                       '$nama_file_unik','$_POST[deskripsi]')");
	  		 echo '<script language="javascript">
			alert("Input Data Berhasil");
			window.location="../../media.php?module='.$module.'";
			</script>';
		exit();
		
	}
	 else {
	 	 mysqli_query($config,"INSERT INTO edit_highlight(judul,deskripsi)
	  				VALUES('$_POST[judul]','$_POST[deskripsi]')");
	 	  echo '<script language="javascript">
		alert("Input Data Berhasil");
		window.location="../../media.php?module='.$module.'";
		</script>';
		exit();
		  }
  
}
//Hapus
elseif ($module=='modulhighlight' AND $act=='hapus') {
	mysqli_query($config,"DELETE FROM edit_highlight WHERE id='$_GET[id]'");
     echo '<script language="javascript">
	alert("Hapus Data Berhasil");
	window.location="../../media.php?module='.$module.'";
	</script>';
	exit();
}
// Update 
elseif ($module=='modulhighlight' AND $act=='update'){
  $lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $acak           = rand(1,99);
  $nama_file_unik = $acak.$nama_file;

  // Apabila gambar tidak diganti
  if (empty($lokasi_file)){
    mysqli_query($config,"UPDATE edit_highlight SET judul = '$_POST[judul]', 
    									deskripsi = '$_POST[deskripsi]'
                             WHERE id = '$_POST[id]'");
  }
  else{
    UploadBanner($nama_file_unik);
    mysqli_query($config,"UPDATE edit_highlight SET judul = '$_POST[judul]',
                                   gambar  = '$nama_file_unik', deskripsi = '$_POST[deskripsi]'
                             WHERE id = '$_POST[id]'");
  }
   echo '<script language="javascript">
	alert("Update Data Berhasil");
	window.location="../../media.php?module='.$module.'";
	</script>';
	exit();
}

}
?>