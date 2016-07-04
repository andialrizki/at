<?php 
require_once "inc/config.php";
require_once "inc/ubig.php";
require_once 'inc/MysqliDb.php';
$db = new Mysqlidb ($database['host'], $database['username'], $database['password'], $database['database']);
$db->setPrefix ($database['prefix']);
$_SESSION['lastSearch'] = '';
// $ubig_option declate on config.php
$ubig = new \UBIG\MainSDK($ubig_option);
// $Terbaru = $ubig->GetNews(array(
//     "seo_kat"=>"olahraga-sports",
//     // "seo_skat"=>"sepak-bola-football",
//     "sort" => "t_psg:desc",
//     "limit" => 10,
//     "page" => 1,
//     "cache" => true,
// ));

$Motogp = $ubig->GetNews(array(
		"kywd" => "MotoGP",
    "seo_kat"=>"olahraga-sports",
    // "seo_skat"=>"sepak-bola-football",
    "sort" => "t_psg:desc",
    "limit" => 5,
    "page" => 1,
    "cache" => true
));
$banner = $db->orderBy('banner_sort', 'asc')->get('banner');
//print_r_mod($banner);
//print_r_mod($Headline);
//$banner = array();
 ?>


<?php include "header.php" ?>
	<!-- <div class="container body_wrapper">
		<div class="row">
			<div class="col-sm-12 text-center">
				<img src="<?php echo SITE_URL.'public/images/ads/iklan-728-90.png' ?>">
			</div>
		</div>
	</div>
	<br> -->
	
	<div class="container body_wrapper">
		<div class="row">

			<div class="col-sm-4 no-padd-marg-right">
				<div class="discover-ads">                        
          <a class="discover-ad u-vertical-half mod-recommended" href="<?php echo SITE_URL ?>jual/kategori/aksesoris-dan-spare-part-motor.html">
              <div class="discover-ad-box mod-recommended">
                  <h3 class="discover-ad-title text-uppercase">
                      <span>Aksesoris Motor</span></h3>
                  <p class="discover-ad-description visible-xs visible-sm hidden-md visible-lg">
                      <span>Buat motor lebih keren</span>
                  </p>
              </div>
          </a>
           <a class="discover-ad u-vertical-half mod-fresh" href="<?php echo SITE_URL ?>jual/kategori/aksesoris-dan-spare-part-mobil.html">
              <div class="discover-ad-box mod-fresh">
                  <h3 class="discover-ad-title text-uppercase"><span>Aksesoris Mobil</span></h3>
                  <p class="discover-ad-description visible-xs visible-sm hidden-md visible-lg">
                      <span>Temukan dengan harga termurah</span>
                  </p>
              </div>
          </a>
        </div>
			</div>
			<div class="col-sm-8 no-padd-marg-left">
				<div class="slider">
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
					  <!-- Indicators -->
					  <ol class="carousel-indicators">
					  	<?php $no=1; ?>
					  	<?php foreach($banner as $b): ?>
						    <li data-target="#carousel-example-generic" data-slide-to="<?php echo ($no-1) ?>" class="<?php echo ($no==1?'active':'') ?>"></li>
						    <?php $no++ ?>
						   <?php endforeach ?>
					  </ol>

					  <!-- Wrapper for slides -->
					  <div class="carousel-inner" role="listbox">
					  	<?php $no=1; ?>
					  	<?php foreach($banner as $b): ?>
						    <div class="item <?php echo ($no==1?'active':'') ?>">
						    	<a href="<?php echo $b['banner_url'] ?>" target="_blank">
							      <div class="headline-img">
							      	<img data-original="<?= SITE_URL.'webmin/public/images/banner/'.$b['banner_image'] ?>" alt="<?php echo $b['banner_name'] ?>" class="lazy img-responsive" style="max-height:300px">
							      </div>
							      <!-- <div class="carousel-caption">
						      		<b>Lorem Ipsum</b>
							      </div> -->
						      </a>
						    </div>
						    <?php $no++ ?>
						   <?php endforeach ?>
					  </div>

					  <!-- Controls -->
					  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
					    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
					    <span class="sr-only">Previous</span>
					  </a>
					  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
					    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
					    <span class="sr-only">Next</span>
					  </a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<br><br>
	<div class="container body_wrapper">
		<div class="row">
			<div class="col-sm-8">
				<div class="new-news">
					<h4 class="title">
						Informasi Terupdate
					</h4>
					<div class="index-news">
					</div>
				</div>
				<div class="loading-index-news text-center" style="display:none">
					<i class="fa fa-spin fa-refresh fa-2x"></i>
				</div>
				<div class="more-item text-center">
					<button class="btn btn-no-radius btn-flat btn-biru btn-sm index-more-news text-upper" type="button" click-page="1">Berita Lainnya</button>
				</div>
			</div>

			<div class="col-sm-4">
				<h4 class="title">
					Sedang Populer
				</h4>
				<div class="headline-index">	
				</div>
				<div class="loading-headline-index text-center" style="display:none">
					<i class="fa fa-spin fa-refresh fa-2x"></i>
				</div>
				<h4 class="title">
					Sedang Promo
				</h4>
				<div class="barangHome">
				</div>
				<div class="loading-diskon-index text-center" style="display:none">
					<i class="fa fa-spin fa-refresh fa-2x"></i>
				</div>
				<div class="more-item text-center">
					<button class="btn btn-no-radius btn-flat btn-biru btn-sm text-upper">Barang Lainnya</button>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 no-padd-marg">
				<h4 class="title">
				MotoGP
			</h4>
			</div>
			<?php if ($Motogp["IsError"] == "false"): ?>
				<?php $ListBerita = ($Motogp["pagging"]["Count"] > 1 ? $Motogp["lstdt"]["DtBerita"] : array($Motogp["lstdt"]["DtBerita"])); ?>
				<div class="col-sm-8">
					<?php if(is_array($ListBerita)): ?>
						<div class="headline-img">
							<img data-original="<?= ($ListBerita[0]["gs"] =="default.png"? "/img/default.png" : $ListBerita[0]["gs"]) ?>" class="lazy img-rounded img-responsive">
						</div>
						<br>
						<a href="<?=SITE_URL.'baca/'.UrlSeo($ListBerita[0]["jdl"]).'-'.$ListBerita[0]["_id"] ?>.html">
							<p class="news-title font-15"><?php echo $ListBerita[0]['jdl'] ?></p>
						</a>
						<p class="news-detail">
							<?=LimitWord($ListBerita[0]["rksn"], 265) ?><a href="<?=SITE_URL.'baca/'.UrlSeo($ListBerita[0]["jdl"]).'-'.$ListBerita[0]["_id"] ?>.html">Baca Selengkapnya</a>
						</p>
						<?php unset($ListBerita[0]) ?>
					<?php endif ?>
				</div>
				<div class="col-sm-4">
					<div class="postModifikasi">
						<?php foreach ($ListBerita as $brt): ?>
							<div class="row news-item">
								<div class="col-xs-4">
									<div class="index-bawah-img">
										<img data-original="<?= ($brt["gs"] =="default.png"? "/img/default.png" : $brt["gs"]) ?>" class="lazy img-rounded img-responsive">
									</div>
								</div>
								<div class="col-xs-8">
									<a href="<?=SITE_URL.'baca/'.UrlSeo($brt["jdl"]).'-'.$brt["_id"] ?>.html">
										<p class="news-title"><?php echo $brt['jdl'] ?></p>
									</a>
									<p class="news-detail">
										<?= $brt["n_smbr"].', '.FormatTanggal($brt["t_psg"]) ?>
									</p>
								</div>
							</div>
						<?php endforeach ?>
					</div>
					<div style="text-align:right; padding:15px;">
						<a href="<?php echo SITE_URL.'berita/motogp.html' ?>">
							<button class="btn btn-biru btn-flat btn-sm btn-no-radius text-upper">Berita Lainnya</button>
						</a>
					</div>
				</div>
			<?php endif ?>
		</div>
	</div>
<?php include "footer_script.php"; ?>
	<script type="text/javascript">
		$("body").attr('onload', 'init_index_news(); init_index_headline(); init_index_promo();');
	</script>
<?php include "footer.php"; ?>
