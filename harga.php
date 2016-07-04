<?php 
require_once "inc/config.php";
require_once "inc/ubig.php";

// $ubig_option declate on config.php
if (!empty($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}
$q = $_REQUEST['query'];

$keyword = UrlDeseo($q);
$ubig = new \UBIG\MainSDK($ubig_option);
$opt = array(
    "sort" => "t_psg:desc",
    "limit" => 12,
    "page" => $page,
    "cache" => true,
    "seo_kat" => 'otomotif-dan-sepeda'
);
if (!empty($keyword)) {
	$opt['kywd'] = $keyword;
}
if (!empty($_GET['kat'])) {
	$opt['seo_skat'] = $_GET['kat'];
}
$Price = $ubig->GetPrice($opt);
// $Promo = $ubig->GetPrice(array(
//     "sort" => "t_psg:desc",
//     "limit" => 5,
//     "page" => 1,
//     "cache" => true
// ));
// $PromoSimiliar = $ubig->GetPrice(array(
//     "sort" => "t_psg:desc",
//     "limit" => 5,
//     "page" => 1,
//     "cache" => true
// ));
//print_r_mod($Price);

 ?>
<?php include "header.php" ?>
	<div class="container body_wrapper">
		<div class="row">
			<div class="col-sm-12">
				<div class="new-news">
					<h4 class="title">
						Iklan
					</h4>
					<?php if ($Price["IsError"] == "false"): ?>
						<div class="row">
							<?php $ListPrice = ($Price["pagging"]["Count"] > 1 ? $Price["lstdt"]["DtIklan"] : array($Price["lstdt"]["DtIklan"]));  ?>
	            <?php foreach ($ListPrice as $brt): ?>
	            	<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
									<div class="iklan-item" id="<?php echo $brt['_id'] ?>">
										<div class="iklan-image">
											<a href="<?php echo SITE_URL.'harga/' ?><?php echo UrlSeo($brt["n"]) ?>-<?php echo $brt["_id"] ?>.html">
												<img data-original="<?= (is_array($brt["gs1"])? "/img/default.png" : $brt["gs1"]) ?>" class="img-rounded lazy img-responsive">
											</a>
										</div>
										<div class="iklan-rksn">
											<a href="<?php echo SITE_URL.'harga/' ?><?php echo UrlSeo($brt["n"]) ?>-<?php echo $brt["_id"] ?>.html">
												<p class="iklan-title text-center"><?php echo $brt['n'] ?></p>
											</a>
											<p class="news-detail">
												<i class="fa fa-tag"></i> <?php echo strtonumber($brt["hrg"]); ?> (<?php echo ($brt["kon"] == 1 ? "Bekas" : "Baru"); ?>)<br>
												<i class="fa fa-clock-o"></i> <?= FormatTanggal($brt["t_psg"]) ?><br>
												<i class="fa fa-map-marker"></i> <?php echo SetAlamat($brt['n_kot'], $brt['n_prop']); ?><br>
												<i class="fa fa-user"></i> <?= $brt['n_pmsg'] ?>, <?= $brt["n_smbr"] ?>
											</p>
										</div>
										<div class="iklan-bdgkn" id="bdgkn-<?php echo $brt['_id'] ?>" style="display:none">
											<button class="btn btn-orange btn-sm"><i class="fa fa-exchange"></i> Bandingkan</button> 
										</div>
									</div>
								</div>
							<?php endforeach ?>
						</div>
					<?php endif ?>
				</div>
				<?php if ($Price["IsError"] == "false"): ?>
					<div class="more-item text-center">
						<?php echo CreateButtonPagging($Price['pagging']['IsNext'], $Price['pagging']['IsPrev'], $page, $Price['pagging']['Total'], 12) ?>
						<br>
						Sekitar <?php echo $Price["pagging"]['Total'] ?> (<?php echo $Price["pagging"]['Waktu'] ?> detik)
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
<?php include "footer_script.php"; ?>
<?php include "footer.php"; ?>
