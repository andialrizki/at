<?php 
if (!isset($_SESSION['lastSearch'])) {
  $_SESSION['lastSearch'] = 'berita';
}
if (isset($_GET['q'])) {
  $q = $_GET['q'];
  $typ = $_GET['typ'];
  if (!empty($q)) {
     if ($typ == 'harga') {
      $_SESSION['lastSearch'] = 'harga';
       $ky_prov = explode('-', $_GET['prov']);
       $ky_kota = $_GET['kota'];
       $lokasi = ($ky_kota != 'all' ? '-'.$ky_kota : ($_GET['prov'] == 'all' ? '' : '-'.$ky_prov[0]));
      //echo $lokasi;
      header('Location: '.SITE_URL.'jual/'.UrlSeo($q.$lokasi).'.html');
      exit;
    } else if (empty($typ) || $typ == 'berita') {
      $_SESSION['lastSearch'] = 'berita';
      header('Location: '.SITE_URL.'berita/'.UrlSeo($q).'.html');
      exit;
    }
  }
  exit;
}
?>