<?php require_once "proses_cari.php" ?>
<?php 
  $prov=$ubig->GetProvinsi([
    "ngr"=>"id",
    "cache"=>true
  ]);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>At Pitstop</title>

    <!-- Bootstrap -->
    <link href="<?= SITE_URL ?>public/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>public/css/owl.carousel.css" rel="stylesheet">

    <link href="<?= SITE_URL ?>public/css/owl.theme.default.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>public/plugins/select2/select2.css" rel="stylesheet">
    
    <link href="<?= SITE_URL ?>public/css/atpitstop.css" rel="stylesheet">
    <link href="<?= SITE_URL ?>public/css/font-awesome.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body style="padding-top:120px;">
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container body_wrapper">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">AtPitstop</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <!-- <ul class="nav navbar-nav">
            <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
            <li><a href="#">Link</a></li>
          </ul> -->
          <ul class="nav navbar-nav navbar-right">
            <li><a href="<?php echo SITE_URL ?>">Home</a></li>
            <li><a href="<?php echo SITE_URL.'berita/motogp.html' ?>">MotoGP</a></li>
            <li><a href="<?php echo SITE_URL.'berita/f1.html' ?>">F1</a></li>
            <li><a href="<?php echo SITE_URL.'berita/tips-motor.html' ?>">Tips Motor</a></li>
            <li><a href="<?php echo SITE_URL.'berita/tips-mobil.html' ?>">Tips Mobil</a></li>
            <li><a href="<?php echo SITE_URL.'berita/modifikasi.html' ?>">Modifikasi</a></li>
            <li><a href="#">Bandingkan Harga (0)</a></li>
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>
    <input type="hidden" id="site_url" value="<?php echo SITE_URL ?>">
    <div class="container body_wrapper">
      <div class="row">
        <!-- <div style="max-width:480px;margin:0 auto">
          <h4 class="title text-center">
            Cari Sesuatu
          </h4>
        </div> -->
        <div class="col-sm-12">
          <div class="text-center" style="margin:0 auto">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
              <li role="presentation" class="<?php echo (PHP_FILE == 'berita.php' || PHP_FILE == 'index.php' ? 'active' : '') ?>">
                <a href="#berita" aria-controls="home" role="tab" data-toggle="tab">Cari Berita</a>
              </li>
              <li role="presentation" class="<?php echo (PHP_FILE == 'harga.php' ? 'active' : '') ?>">
                <a href="#barang" aria-controls="profile" role="tab" data-toggle="tab">Cek Harga</a>
              </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content" style="margin-bottom:30px;">
              <div role="tabpanel" class="tab-pane fade in <?php echo (PHP_FILE == 'berita.php' || PHP_FILE == 'index.php' ? 'active' : '') ?>" id="berita">               
                <form class="cariHargaHome" action="" method="get" onsubmit="cariBeritaFunc();">
                  <div class="input-group">
                    <input type="hidden" name="typ" value="harga">
                    <input type="text" class="form-control fLeft formCariBerita" name="q" placeholder="ketikkan judul berita, topik atau kata kunci tertentu..." value="<?php echo @$keyword ?>" required>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary fRight">
                        <i class="fa fa-search"></i> Cari 
                      </button>
                    </span>
                  </div>
                  <p class="loadingCari" style="display:none">
                    <i class="fa fa-spin fa-refresh"></i> Sedang melakukan pencarian...
                  </p>
                  <!-- <p style="padding:10px">
                    Terakhir dicari: <a href="">Lorem ipsum</a>, <a href="">dolor sit amet</a>, <a href="">Ban dalam tubless</a>
                  </p> -->
                </form>
              </div>
              <div role="tabpanel" class="tab-pane fade in <?php echo (PHP_FILE == 'harga.php' ? 'active' : '') ?>" id="barang">
                <form class="cariHargaHome" action="" method="get" onsubmit="cariHargaFunc();">
                  <div class="input-group">
                    <input type="hidden" name="typ" value="harga">
                    <input type="text" class="form-control fLeft formCariHarga" name="q" placeholder="ketikkan nama barang, seperti sparepart atau variasi..." style="width:60%" value="<?php echo @$keyword ?>" required>
                    <select class="form-control hidden-xs hidden-sm" id="selectProv" style="width:20%!important; height:50px!important" name="prov">
                      <option value="all">Semua Provinsi</option>
                      <?php if ($prov["IsError"] == "false"): ?>
                        <?php $ListProv = ($prov["pagging"]["Count"] > 1 ? $prov["lstdt"]["DtIntPropinsi"] : array($prov["lstdt"]["DtIntPropinsi"]));  ?>
                        <?php foreach ($ListProv as $p): ?>
                          <?php //$provkywd = explode(',', $p['kywd']); ?>
                          <option value="<?php echo $p['n'].'-'.$p['_id'] ?>"><?php echo $p['n'] ?></option>
                        <?php endforeach ?>
                      <?php endif ?>
                    </select>
                    <select class="form-control hidden-xs hidden-sm" id="selectKota" style="width:20%!important" name="kota">
                      <option value="all">Semua Kota/Kab</option>
                    </select>
                    <span class="input-group-btn">
                      <button type="submit" class="btn btn-primary fRight">
                        <i class="fa fa-search"></i> Cari
                      </button>
                    </span>
                  </div>
                  <p class="loadingCari" style="display:none">
                    <i class="fa fa-spin fa-refresh"></i> Sedang melakukan pencarian...
                  </p>
                  <!-- <p style="padding:10px">
                    Terakhir dicari: <a href="">Lorem ipsum</a>, <a href="">dolor sit amet</a>, <a href="">Ban dalam tubless</a>
                  </p> -->
                </form>
              </div>
            </div>
            <div class="line-orange"></div>
          </div>
        </div>
      </div>
    </div>