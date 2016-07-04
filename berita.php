<?php 
require_once "inc/config.php";
require_once "inc/ubig.php";

// $ubig_option declate on config.php
$q = $_REQUEST['query'];
if (!empty($_GET['page'])) {
	$page = $_GET['page'];
} else {
	$page = 1;
}

$keyword = UrlDeseo($q);
$ubig = new \UBIG\MainSDK($ubig_option);
$opt = array(
    "seo_kat"=>"olahraga-sports",
    "seo_skat"=>"sepak-bola-football",
    "sort" => "t_psg:desc",
    "limit" => 10,
    "page" => $page,
    "cache" => true,
);
if (!empty($q)) {
	$opt['kywd'] = $q;
}
$News = $ubig->GetNews($opt);
// $Headline = $ubig->GetNews(array(
//     "seo_kat"=>"olahraga-sports",
//     "seo_skat"=>"sepak-bola-football",
//     "sort" => "t_psg:desc",
//     "limit" => 10,
//     "page" => 1,
//     "cache" => true
// ));
// print_r_mod($News);
 ?>
<?php include "header.php" ?>
	<div class="container body_wrapper">
		<div class="row">
			<div class="col-sm-8">
				<div class="new-news">
					<h4 class="title">
						Informasi Terupdate
					</h4>
					<?php if ($News["IsError"] == "false"): ?>
						<?php $ListBerita = ($News["pagging"]["Count"] > 1 ? $News["lstdt"]["DtBerita"] : array($News["lstdt"]["DtBerita"])); ?>
            <?php foreach ($ListBerita as $brt): ?>
							<div class="row news-item">
								<div class="col-xs-4">
									<img data-original="<?= (is_array($brt["gs"])? "/img/default.png" : $brt["gs"]) ?>" class="img-rounded img-responsive lazy">
								</div>
								<div class="col-xs-8">
									<a href="<?php echo SITE_URL.'readnews/' ?><?php echo UrlSeo($brt["jdl"]) ?>-<?php echo $brt["_id"] ?>.html">
										<p class="news-title"><?php echo $brt['jdl'] ?></p>
									</a>
									<p class="news-time"><?= $brt["n_smbr"] ?>, <?= FormatTanggal($brt["t_psg"]) ?></p>
									<p class="news-detail">
										<?=LimitWord($brt["rksn"], 20) ?>
									</p>
								</div>
							</div>
						<?php endforeach ?>
					<?php endif ?>
				</div>
				<?php if ($News["IsError"] == "false"): ?>
					<div class="more-item text-center">
						<?php echo CreateButtonPagging($News['pagging']['IsNext'], $News['pagging']['IsPrev'], $page, $News['pagging']['Total'], 10) ?>
						<br>
						Sekitar <?php echo $News["pagging"]['Total'] ?> (<?php echo $News["pagging"]['Waktu'] ?> detik)
					</div>
				<?php endif ?>
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
				<?php if(!empty($q)): ?>
					<div class="new-news">
						<h4 class="title">
							Terbaru
						</h4>
						<div class="index-news">
						</div>
					</div>
					<div class="loading-index-news text-center" style="display:none">
						<i class="fa fa-spin fa-refresh fa-2x"></i>
					</div>
					<div class="more-item text-center">
						<a href="<?php echo SITE_URL.'berita.html' ?>">
							<button class="btn btn-no-radius btn-flat btn-biru btn-sm text-upper" type="button">Lainnya</button>
						</a>
					</div>
				<?php endif ?>
			</div>
		</div>
	</div>
<?php include "footer_script.php"; ?>
<script type="text/javascript">
		$("body").attr('onload', 'init_index_headline(); init_index_news(5);');
	</script>
<?php include "footer.php"; ?>
