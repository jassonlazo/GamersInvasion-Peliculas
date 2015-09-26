<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
?>
<!doctype html>
<html lang="vi" itemscope="itemscope" itemtype="http://schema.org/WebPage">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $site_title;?></title>
	<meta name="keywords" content="<?php echo $site_keywords;?>" />
	<meta name="description" content="<?php echo $site_description;?>" />
	<base href="<?php echo SITE_URL; ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/reset.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo TEMPLATE_URL;?>css/hdo.css">
	<link rel="shortcut icon" href="<?php echo TEMPLATE_URL;?>images/favicon.ico" type="image/x-icon"/>
	<div id="fb-root"></div>
<head>
<body>
<span style="position:absolute">xem phim hd</span>
<div id="wrapper">
	<div class="p404">
		<div class="wap">
			<div class="content">
				<h1>OPPS! Error</h1>
				<span class="tit">La página que estás buscando no está allí. Inténtalo de nuevo</span>
				<span class="tit2">Tal vez de escribir el camino equivocado o después de la palabra clave de búsqueda. Por favor, utilice la función de búsqueda en la web para ver la película exacto que está buscando. Si el error persiste. Póngase en contacto con nosotros para obtener ayuda.</span>
				<a class="back" href="<?php echo SITE_URL; ?>">Regresar</a>
			</div>
		</div>
	</div>
</div>
</div>
</body>
</html>