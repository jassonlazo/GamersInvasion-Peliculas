<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('functions');
?>
<!doctype html><html lang="vi" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<head>
	<title><?php echo $site_title;?></title>
	<meta name="keywords" content="<?php echo $site_keywords;?>" />
	<meta name="description" content="<?php echo $site_description;?>" />
	<meta name="robots" content="index, follow">
	<meta name="revisit-after" content="1 days">
	<meta charset="utf-8">
	<link rel="alternate" type="application/rss+xml" title="Rss Feed" href="<?php echo SITE_URL.'/rss/';?>">
	<meta property="og:title" content="<?php echo $site_title;?>">
	<meta property="og:description" content="<?php echo $site_description;?>">
	<meta property="og:type" content="website">
	<meta property="og:url" content="<?php echo SITE_URL.$cururl;?>">
	<?php echo $other_meta;?>
	<meta property="fb:app_id" content="443500962415169"/>
	<meta property="fb:admins" content="100001312082363">
	<base href="<?php echo SITE_URL; ?>" />
	<?php echo $other_meta2;?>
	<link rel="author" href="https://www.facebook.com/gamersinvasions" />
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/hdo.css">
	<link rel="shortcut icon" href="<?php echo TEMPLATE_URL;?>images/favicon.ico" type="image/x-icon"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/jquery-migrate-1.2.1.min.js"></script>
	<script type="text/javascript">var base_url = '<?php echo SITE_URL; ?>', is_login = '<?php echo IS_LOGIN; ?>';</script>
	<script type="text/javascript">
	function auto_scroll(anchor) {
		var $target = $(anchor);
		$target = $target.length && $target || $('[name=' + anchor.slice(1) + ']');
		if ($target.length) {
		var targetOffset = $target.offset().top-100;
		$('html,body').animate({
		scrollTop: targetOffset
		}, 1000);
			notification();
			return false
		}
	}
	</script>
	<script src="<?php echo TEMPLATE_URL;?>js/lib.jquery.carouFredSel-6.2.1-packed.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/jquery.prettyPhoto.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/jquery.qtip.min.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/jquery.lazyload.js"></script>
	<!--script src="< ?php echo TEMPLATE_URL;?>js/multi-pop.js"></script-->
	<script src="<?php echo TEMPLATE_URL;?>js/actor.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/search.js"></script>
	<script src="<?php echo TEMPLATE_URL;?>js/rickypro.js"></script>

</head>
<body onload="auto_scroll($('#rkplayer_wrapper'))">


<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-WRMBCR"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-WRMBCR');</script>
<!-- End Google Tag Manager -->

<div id="fb-root"></div>
<script>
	(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1&appId=xxxxxxxxxxx";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));
</script>
<div id="wrapper">
	<div id="header" class="header_gra">
		<div class="ie_mess">
			Nuestro sitio web no funcionará tan bien en el navegador que está utilizando. Por favor, actualice a la nueva versión o el uso de Google Chrome.</div>
		<div class="header_left">
			
				<a id="logo-container" href="<?php echo SITE_URL; ?>" title="<?php echo $main_title;?>">
					<img src="<?php echo TEMPLATE_URL;?>images/logo.png" alt="<?php echo $main_title;?>">
				</a>			
			<ul id="navigation" class="clearfix">
				<li class="control_subnav show-full-mn" rel="full-hd"><span class="no_child">Categoria</span>
				  <div class="sub-full-menu" id="full-mn-phim-le">
					<div class="wap-content clearfix">
						<div class="menus">
							<span class="title">Categoria</span>
							<ul class="mn mnfl">
								<?php echo li_category(); ?>
							</ul>
						</div>
						<div class="menus">
							<span class="title">En Estreno</span>
							<ul class="mn mnfl">
								<?php echo li_year('category'); ?>
							</ul>
						</div>
						<div class="menus mn-last">Peliculas Nuevas
						  <ul id="head_le_hot" class="mn-imgs clearfix">
								<?php echo li_film("filmlb = '0'",4);?>
						  </ul>
						</div>
					</div>
				</div>
				</li>
				<li class="control_subnav show-full-mn" rel="full-mn-phim-bo"><span class="no_child">Pais</span>
				  <div class="sub-full-menu" id="full-mn-phim-bo">
					<div class="wap-content clearfix">
						<div class="menus">
							<span class="title">Pais</span>
							<ul class="mn mnfl">
								<?php echo li_country(); ?>
							</ul>
						</div>
						<div class="menus">
							<span class="title">En Estreno</span>
							<ul class="mn mnfl">
								<?php echo li_year('country'); ?>
							</ul>
						</div>
						<div class="menus mn-last">
							<span class="title">Nuevo Drama</span>
							<ul id="head_bo_hot" class="mn-imgs clearfix">
								<?php echo li_film("filmlb = '1'",4);?>
							</ul>
						</div>
					</div>
				</div>
				</li>
				<li class="control_subnav"><h3><a href="<?php echo get_url(0,'Phim lẻ','Danh sách');?>" title="Movies" class="no_child lowres">Peliculas</a></h3></li>
				<li class="control_subnav">
			  <h3><a href="<?php echo get_url(0,'Phim bộ','Danh sách');?>" title="Peliculas" class="no_child lowres">Drama</a></h3></li>
				<li class="control_subnav"><h3><a href="<?php echo SITE_URL; ?>/video/" title="Video" class="no_child lowres">Video</a></h3></li>
				<li class="control_subnav show-full-mn" rel="full-mn-boxtv"><h3><a href="<?php echo SITE_URL; ?>/live-tv/" title="Live TV" class="no_child lowres">TV</a></h3>
                               
				<li class="control_subnav"><span class="no_child head_search">Busqueda</span></li>
			</ul>
			<!--/navigation-->
		</div>
		<div class="user-box">
			<div class="user_conner right">
				<?php echo user_menu(); ?>
			</div>
		</div>
		<div class="clear">
		</div>
		<div id="box_search">
			<a href="javascript:void(0)" class="close-box-search" title="Cancel"></a>
			<div id="search">
				<form id="search_form">
					<input class="search_text" id="keyword" type="text" placeholder="Escriba la palabra clave all: nombre de la película, Inglés, actor, director .... de lo que busca" autocomplete="off"/><input class="search_submit" type="submit" value="Buscar"/>
				</form>
				<div class="search_value">
					<ul class="ui-autocomplete" id="search_movie">
					</ul>
					<ul class="ui-autocomplete" id="search_actor">
					</ul>
					<div style="clear:both">
					</div>
				</div>
				<div style="clear:both">
				</div>
			</div>
		</div>
	</div>
