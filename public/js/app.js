
/* init */
$(window).scroll(function() {
  if ($(document).scrollTop() > 50) {
    $('nav').addClass('shrink');
  } else {
    $('nav').removeClass('shrink');
  }
});

window.onunload = function(){
  alert("unload event detected!");
}
var site_url = $("#site_url").val();
var headline_options = {
		newsPerPage:6,
		autoplay:true,
		pauseOnHover:true,
		navigation:false,
		direction:'down',
		newsTickerInterval:2500,
		onToDo:null};
$(function(){
	$(".iklan-item").mouseover(function(){
		var id = $(this).attr('id');
		$(".iklan-bdgkn#bdgkn-" + id).show();
	}).mouseout(function() {
		var id = $(this).attr('id');
		$(".iklan-bdgkn#bdgkn-" + id).hide();
  });
	$("#selectProv, #selectKota").select2();
	$("img.lazy").lazyload({
      placeholder: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII='
  });


	/* slider horizontal harga sidebar */
	$("#headline-slider").bootstrapNews(headline_options);
	/* slider harga terkait */
	$("#similar-property-carousel").owlCarousel({
		dots: true,
		items: 4,
	    lazyLoad : true,
	    nav : true,
	    scrollPerPage: true,
	    navText: ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>'],
	});
	/* form cari ketika dienter */
	$(".formCari").keypress(function(e) {
	    if(e.which == 13) {
	    	cariBeritaFunc();
	    }
	});
	$(".index-more-news").click(function(){
		var cpage = $(this).attr('click-page');
		var page = parseInt(cpage) + parseInt(1);
		$.ajax({
			url: site_url + 'request.php?id=index&page=' + page,
			beforeSend: function () {
				$(".loading-index-news").fadeIn();
			},
			success:function (data) {
				$(".index-news").append(data).hide().fadeIn();
				$(".index-more-news").attr('click-page', page);
				$(".loading-index-news").fadeOut();
				$(function(){$("img.lazy").lazyload();});

			}
		});
	});
	$("#selectProv").change(function () {
		var id_prov = $(this).val();
		var query = $(".formCariHarga");
		$.ajax({
			url: site_url + 'request.php?id=get-kota&prov=' + id_prov,
			dataType: "json",
			beforeSend:function() {
				$("#selectKota").attr('disabled', 'disabled');
				$("#selectKota").html('<option value="all">Semua Kota/Kab</option>');
				$("span[aria-labelledby=select2-selectKota-container] .select2-selection__arrow").html('');
				$("span[aria-labelledby=select2-selectKota-container] .select2-selection__arrow").append('<i class="fa fa-refresh fa-spin"></i>');
			},
			success:function(data) {
				$.each(data, function(index, value) {
					$("#selectKota").append('<option value="' + value.n + '">' + value.n + '</option>');
					$("#selectKota").select2();
					$("#selectKota").removeAttr('disabled');

				$("span[aria-labelledby=select2-selectKota-container] .select2-selection__arrow").html('');
				$("span[aria-labelledby=select2-selectKota-container] .select2-selection__arrow").append('<b role="presentation"></b>');
				});
			}
		})
	});
});
function cariBeritaFunc() {
	var query = $(".formCariBerita").val();
	//$("#tipecari").html(' Berita ');
	if (query.length != 0) {
		$(".loadingCari").fadeIn();
		// $(location).attr("href", $("#site_url").val() + "?q=" + query + "&typ=berita");
	}
	return true;
}
function cariHargaFunc() {
	var query = $(".formCariHarga").val();
	//$("#tipecari").html(' Harga ');
	if (query.length != 0) {
		$(".loadingCari").fadeIn();
		//$(location).attr("href", $("#site_url").val() + "?q=" + query + "&typ=harga");
	}
	return true;
}

function init_index_news(limit = 10) {
	$.ajax({
		url: site_url + 'request.php?id=index&page=' + 1 + '&limit=' + limit,
		beforeSend: function () {
			$(".loading-index-news").fadeIn();
		},
		success:function (data) {
			$(".index-news").append(data).hide().fadeIn();
			$(".index-more-news").attr('click-page', 1);
			$(".loading-index-news").fadeOut();
			$("img.lazy").lazyload();
		},
		error:function () {
			$(".index-news").append(alert_error('gagal mengambil data, silakan refresh browser Anda'));
		}
	});
}
function init_index_promo() {
	$.ajax({
		url: site_url + 'request.php?id=harga-promo',
		beforeSend: function () {
			$(".loading-diskon-index").fadeIn();
		},
		success:function (data) {
			$(".barangHome").append(data).hide().fadeIn();
			$(".loading-diskon-index").fadeOut();
			$("img.lazy").lazyload();
		},
		error:function () {
			$(".barangHome").append(alert_error('gagal mengambil data, silakan refresh browser Anda'));
		}
	});
}
function init_index_headline() {
	$.ajax({
		url: site_url + 'request.php?id=headline-index',
		beforeSend: function () {
			$(".loading-headline-index").fadeIn();
		},
		success:function (data) {
			$(".headline-index").append(data).hide().fadeIn();
			$("#headline-slider").bootstrapNews(headline_options);
			$(".loading-headline-index").fadeOut();
		},
		error:function () {
			$("#headline-slider").append(alert_error('gagal mengambil data, silakan refresh browser Anda'));
		}
	});
}
function alert_error(string) {
	var alert = '<div class="alert alert-danger" role="alert"><b>Oops!</b> ' + string + '</div>';
	return alert;
}