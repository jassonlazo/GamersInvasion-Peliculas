<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
$film = MySql::dbselect("tb_film.title,tb_film.title_en,tb_film.category,tb_film.release_time,tb_film.timeupdate,tb_film.thumb,tb_film.country,tb_film.director,tb_film.actor,tb_film.year,tb_film.duration,tb_film.viewed,tb_film_other.content,tb_film_other.keywords,tb_film.total_votes,tb_film.total_value,tb_film.trailer,tb_film.big_image,tb_film.quality,tb_film.filmlb",'film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"id = '$filmid'");
$tenphim = $film[0][0];
$tentienganh = $film[0][1];
$watchurl = get_url($epwatch,$tenphim,'Xem Phim');
$breadcrumb = breadcrumb_menu($film[0][2]);
$urlfilm = get_url($filmid,$tenphim,'Phim');
$phathanh = $film[0][3];
if(!$phathanh) $phathanh = GetDateT($film[0][4]);
$thumb = $film[0][5];
if(!$thumb) $thumb = TEMPLATE_URL.'images/grey.jpg';
$theloai = category_a($film[0][2]);
$quocgia = country_a($film[0][6]);
$genre = category_ad($film[0][2]);
$country = country_ad($film[0][6]);
$daodien_a = CheckName($film[0][7]);
$daodien = Get_List_director($film[0][7]);
$dienvien = Get_List_actor($film[0][8]);
$year = CheckName($film[0][9]);
$duration = CheckName($film[0][10]);
$viewed = $film[0][11];
$loaiphim = $film[0][19];
$content = RemoveHtml(UnHtmlChars($film[0][12]));
$tags = GetTag_a($film[0][13],2);
$image_r = explode("<img ",UnHtmlChars($film[0][12]));
$Astar = $film[0][15];
$Bstar = $film[0][14];
$Cstar = ($Astar/$Bstar);
$Dstar = number_format($Cstar,0);
$Cstar = number_format($Cstar,1);
for($i=1;$i<count($image_r);$i++) {
	preg_match('/src="([^"]+)"/', $image_r[$i], $image);
	$image = $image[1];
	$image_all .= "<li><a href=\"$image\" rel=\"screen[s]\" title=\"$tenphim - $tentienganh\"><img src=\"$image\" alt=\"$tenphim - $tentienganh\" width=\"600px\"/></a></li>";
}
for($i=1;$i<11;$i++) {
	$votes .= "<div class=\"vote-line-hv\" data-id=\"$i\"></div>";
}
$trailer = $film[0][16];
$bigthumb = $film[0][17];
if(!$bigthumb) $bigthumb = TEMPLATE_URL.'images/cover.jpg';
$quality = $film[0][18];
if($quality == 'HD') $quality = '<a title="Chất lượng HD" class="hd"></a>';
else $quality = '<a title="Chất lượng SD" class="sd"></a>';
$episodeid = $epid[0][3];
$epurl = $epid[0][3];
$epsubtitle = $epid[0][4];
?>
    <?php date_default_timezone_set('Europe/London'); if (intval( strtotime(date('Y-m-d H:i:s')) - strtotime($epid[0][6]) /3600) > 3) {global $datetime_post; echo "<script>
			function notification() {
    alertvc('Los nuevos episodios se actualizan, el servidor durante el proceso, puede volver más tarde si no se ve! ".$epid."');
}
		</script>";} ?>

<input type="hidden" id="filmid" value="<?php echo $filmid;?>">
<?php echo $idcategory;?>
	<?php if($mode == 'xem-phim') { ?>
		<div class="watch-title">
			<div class="wap-tile">
				<h2><a href="<?php echo $urlfilm;?>" title="<?php echo $tenphim;?> - <?php echo $tentienganh;?>"><?php echo $tenphim;?></a></h2> - <h3><?php echo $tentienganh;?></h3>
			</div>
			<script>$(document).ready(function () {$(".info_resize").hide();$(".watch-episode").show();$(".wap-tab a").removeClass('active');$('.wap-tab a.similar').addClass('active');});</script>
			<input type="hidden" id="episodeid" value="<?php echo $id;?>">
			<div style="display: block;width: 880px;margin: 0px auto;">
				<div class="head-wap-info" style="width: 290px;height:110px;text-align: justify;">
					 Estas Viendo la Pelicula <strong><?php echo $tenphim;?></strong>categoría <font color=orange><?php echo category_Watch($film[0][2])?></font>. Espero que tengas momentos de gran entretenimiento con las películas.</div>
				<div id="list_update" class="head-wap-info" style="width: 540px;height:110px;margin-left:10px">
					<ul>
						<?php echo li_film_h3_2("decu = '1'",20)?>
					</ul>
				</div>
				<div class="clear"></div>
			</div>
            
            <div style="display: block;width: 880px;margin: 0px auto;">
<center>Si la película de pantalla de error "Error al cargar medios: El archivo no se podría REPRODUCIR a  'continuación, haga clic en la esquina de la' DEL REPRODUCTOR 'parte inferior derecha de la pantalla (que se encuentra justo al lado de los altavoces)
vuela a darle PLAY !!
			</center>
			</div>
			<div class="watch-now" style="position:relative">
				<div class="player" style="position:relative;width: 900px; height: 500px;z-index:501">
					<?php echo player($id);?>
					<div id="rkplayer"></div>
                    <!--  ADS BY BLUESEED DO NOT MODIFY-->
   <!--<div id ="adPlayercontainer" style="height: 500px; width: 900px; top:0px; position: absolute;left: 0px;z-index: 10000;" >
       <div id="adPlayer"></div>
   </div>-->
   <!--  Add this plugin JS -->
   <script src="http://wac.A164.edgecastcdn.net/80A164/blueseed-cdn/files-blueseed/templates/26/67/jwplayer.js" type="text/javascript"></script>  
   <script type="text/javascript" src="http://wac.A164.edgecastcdn.net/80A164/blueseed-cdn/files-blueseed/templates/26/89/bsplugin-preroll.js"></script> 
   <script type="text/javascript">
   var timestamp = new Date().getTime();
   var tag = "http://blueserving.com/vast.xml?key=f98a430b409ad0b8c5b222e4eb4e83dd&genre=<?php echo $genre; ?>&country=<?php echo $country; ?>&r=" + timestamp;
       
    setupAdPlayer("adPlayercontainer", "adPlayer", "100%", "100%", tag);
   var checkPauseOnAd = true;
   jwplayer("rkplayer").onPlay(function(){
   if(jwplayer("rkplayer").getPosition() == 0 && checkPauseOnAd == true){
     jwplayer("rkplayer").pause(true);
     checkPauseOnAd = false;
     }
   });
   function startMainPlayer(){
     jwplayer("rkplayer").play(true);
   }
  </script>
  <!-- END ADS BLUESEED -->‏
				</div>
                <!--<br><iframe src="http://127.0.0.1/player.php" frameborder="0" width="900" height="500"></iframe>-->
                
			</div>
			<div id="video-description" class="player-width">
				<div class="video-description">
					<div class="functional-bar beacon">
						<a href="javascript:void(0);" id="lightout" class="player_option_button" style="position:relative;z-index:501">Apagar Luces</a>
						<a href="javascript:void(0);" id="zoombtn" class="player_option_button">Agrandar</a>
						<a href="javascript:void(0);" id="add_fav_feature" class="player_option_button" data-id="<?php echo $filmid?>">Añadir para Mas Tarde	</a>
						<a href="javascript:void(0);" id="add_fav_playlist" class="player_option_button" data-id="<?php echo $filmid?>">Añadir a Favoritos</a>
						<a href="javascript:void(0);" id="binh-luan" class="player_option_button">Comentarios</a>
						<a href="javascript:void(0);" id="tai-phim" class="player_option_button" data-id="<?php echo $id?>">Descargar Pelicula</a>
						<a href="javascript:void(0);" id="errorbtn" class="player_option_button" data-id="<?php echo $id?>">Reportar Error</a>
						<a href="<?php echo get_url(0,'Hướng dẫn','Tin tức');?>" id="helpbtn" class="player_option_button" target="_blank">Guia</a>
					</div>
					<div class="function-social">
						<div class="btn-social btn-notice">
							Gracias por preferirnos JassonLazo(GamersInvasion)</div>
						<div class="btn-social btn-fb">
							<div class="fb-like" data-width="90" data-layout="button_count" data-show-faces="false" data-share="true" data-href="<?php echo $urlfilm;?>"></div>
						</div>
						<div class="btn-social btn-gp">
							<div class="g-plusone" data-size="medium" data-href="<?php echo $urlfilm;?>"></div>
						</div>
						<div class="btn-social btn-tw">
							<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo $urlfilm;?>">Tweet</a>
						</div>
                        <div class="btn-social btn-tw">
                           <a class="" name="zm_share" type="icon" title="Chia sẻ lên Zing Me">Chia sẻ</a>
<script src="http://stc.ugc.zdn.vn/link/js/lwb.0.7.js" type="text/javascript"></script>
						</div>
                        </br >
						<div class="btn-social btn-notice">Si la carga defectuosa no ver las películas, por favor borrar la caché de su navegador web (historia&gt; borrar la caché,)</div></br >
						<div class="btn-social btn-notice">Error Enlace favor película f5, si no entonces para corregir el error tan pronto  sea posible!</div></br >
						<div class="btn-social btn-notice">Votar Por Pelicula:</div>
                                                <div class="vote clearfix"> 
						<div class="unvote-line"> 
							<div class="vote-line" style="width:<?php echo $Dstar;?>0%"></div>
							<div class="vote-line-box">
								<?php echo $votes;?>
							</div>
						</div> 
						<div class="vote-stats"> (<?php echo $Cstar;?>/10 - <?php echo $Bstar;?> Votos)</div> 
					</div><br>
					</div>
					<div class="download-box" style="display:none">
                    </div>
</div>
<div class="clear">
		</div>
		<div class="cmt-content">
			<div class="hdo_c fb-comments" data-href="<?php echo $urlfilm;?>" data-num-posts="10" data-width="800" colorscheme="dark">
			</div>
		</div>
		</div>
		
	<?php }else { ?>
		<div class="big_thumbplayer">
			<img class="lazy" data-original="<?php echo $bigthumb;?>" alt="<?php echo $tenphim;?> - <?php echo $tentienganh;?>"/>
			<a href="<?php echo $watchurl;?>" class="player_btn_big" title="Peliculas <?php echo $tenphim;?> - <?php echo $tentienganh;?>">Play</a>
		</div>
		<div class="clear"></div>
	<?php } ?>
</div>
<div class="wfff" itemscope= itemtype="http://schema.org/<?php if($film[0][19]==0) echo "Movie"; else echo "TVSeries"; ?>">

                <div class="watch-tab">
		<div class="wap-tab">
			<a href="javascript:void(0)" class="info active" rel="watch-info">Información</a>
			<a href="javascript:void(0)" class="screen" rel="watch-screen">Imagen en el Cine</a>
			<a href="javascript:void(0)" class="similar" rel="watch-episode">Lista de episodios</a>
			<a href="javascript:void(0)" class="free" rel="watch-cungloai">Generos</a>
		</div>
	</div>
	<div class="watch-episode info_resize">
		<?php echo list_episode($filmid,$tenphim);?>
	</div>
	<div class="watch-info info_resize">
		<div class="wap-info clearfix" >
			<div class="bar_clean">
				<img src="<?php echo TEMPLATE_URL;?>images/iconmoviebread.png" alt="Movies" class="iconmovie_bar left">
				<div class="breadcrumbs">
					<div class="item" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
						<a href="<?php echo SITE_URL;?>" title="<?php echo $main_title;?>" itemprop="url">Inicio</a>
					</div>
					<?php echo $breadcrumb;?>
					<h2 class="item last cur" itemprop="name">
						<a href="<?php echo $urlfilm;?>" title="<?php echo $tenphim;?>" itemprop="url">
                        <div >
							<span title="<?php echo $tenphim." - ".$tentienganh;?>" itemprop="name" id="name"><?php echo $tenphim." - ".$tentienganh;?></span></div>
						</a>
					</h2>
				</div>
				<!--/breadcrumb-->
				<div class="right">
					<!--<div class="post_date">
						 Phát hành: <strong><?php echo $phathanh;?></strong>
					</div>-->
					<div class="fb-like" data-width="90" data-layout="button_count" data-show-faces="false" data-href="https://www.facebook.com/gamersinvasions"></div>
					<span class="let_like_fb_span">Dale Me Gusta a nuestra Fan Page</span>
				</div>
			</div>
			<div class="film-info clearfix">
				<div class="fiml-img" >
                <div itemscope itemtype="http://schema.org/ImageObject">
					<img src="<?php echo $thumb;?>" alt="<?php echo $tenphim;?> - <?php echo $tentienganh;?>" itemprop="contentUrl"/></div>
				</div>
				<div class="box-info">
					<div class="publish">
						<?php echo $quality;?>
						<?php echo $theloai;?>
					</div>
					<div class="vote clearfix"> 
						<div class="unvote-line"> 
							<div class="vote-line" style="width:<?php echo $Dstar;?>0%"></div>
							<div class="vote-line-box">
								<?php echo $votes;?>
							</div>
						</div> 
						<div class="vote-stats" >
						  <div itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating" > <span itemprop="ratingValue"><?php if ($Cstar==0) echo $Cstar+9.3; else echo $Cstar?></span>/<span itemprop="bestRating">10</span> - <span itemprop="ratingCount"><?php echo $Bstar+84;?></span> Votos</div> </div>
					</div>
					<div class="fields clearfix">
						<ul>
							<li><span class="label">Pais:</span><?php echo $quocgia;?></li>
							<li><span class="label">Escenario:</span>
							  <label><?php echo $daodien_a;?></label></li>
							<li><span class="label">Duracion: </span>
							  <label><?php echo $duration?></label></li>
							<li><span class="label">Lanzamiento: </span>
							  <label><?php echo $year;?></label></li>
							<li><span class="label">Reproducciones: </span>
							  <label><?php echo $viewed;?></label></li>
                            <li><span class="label" id="price">Precio: </span><label>Gratis</label></li>
						</ul>
					</div>
					<div class="fdesc clearfix readmore-js-section" style="height: 60px;">
						<p>
							<?php echo $content;?>
						</p>
					</div>
					<a href="#" class="readmore-js-toggle">Leer Mas »</a>
				</div>
				<h3 class="info_tag">
					Etiquetas: <?php echo $tags;?>
				</h3>
				<div class="btn_watch">
					<?php 
					if($mode == 'phim') {
						echo "<a href=\"$watchurl\" class=\"btn-trailer\" title=\"$tenphim - $tentienganh\">Ver Pelicula</a>";
						if($trailer) echo "<a href=\"$trailer\" class=\"btn-trailer\" rel=\"trailer\" title=\"$tenphim\">Ver Trailer</a>";
					}
					?>
				</div>
			</div>
			<div class="actor-info" >
				<div class="actors">
					<div class="title clearfix">
						<span class="htitle">Actor</span>
						<div class="btns clearfix control">
							<a href="javascript:void(0)" class="prv btn-back"></a><a href="javascript:void(0)" class="nxt btn-next"></a>
						</div>
					</div>
					<div class="ul">
						<ul class="actor_list">
                        
							<?php echo $dienvien;?>
                        
						</ul>
					</div>
				</div>
				<div class="directors">
					<div class="title clearfix">
						<span class="htitle">Director</span>
						<div class="btns clearfix control">
							<a href="javascript:void(0)" class="prv btn-back"></a><a href="javascript:void(0)" class="nxt btn-next"></a>
						</div>
					</div>
					<div class="ul">
						<ul class="dir_list">
                        <div itemprop="director" itemscope itemtype="http://schema.org/Person">
							<span itemprop="name"><?php echo $daodien;?></span></div>
						</ul>
					</div>
				</div>
			</div>
		</div>
        <div style="margin-left: auto; margin-right: auto; margin-top:10px; box-shadow: 0 0px 5px rgba(0,0,0,.2);">
		</div>
	</div>
	<div class="screenshot-info watch-screen info_resize">
		<div class="wap-screenshot">
			<ul class="screenshot-items short-img">
				<?php echo $image_all;?>
			</ul>
			<a href="javascript:void(0)" class="screen-prev"></a><a href="javascript:void(0)" class="screen-next"></a>
		</div>
	</div>
	<div class="watch-cungloai info_resize">
		<div class="bar wfff clearfix hide_info" rel="free_film" style="width: 1168px; margin-left: 48px;"></div>
		<div class="rich_list wfff clearfix tab_info_2">
			<div class="scroll_list">
				<ul id="decu_film" class="clearfix">
					<?php echo li_filmALL('category',12,$film[0][2]);?>
				</ul>
			</div>
			<div class="wrap_prev_block">
				<a id="rand_film_control_prev" href="#" class="prev_block"></a>
			</div>
			<div class="wrap_next_block">
				<a id="rand_film_control_next" href="#" class="next_block"></a>
			</div>

		</div>
	</div>
	<div class="bar wfff clearfix" rel="rand_film">
		<span class="title_block"><a href="">Usted no ha visto aún</a></span>
	</div>
	<div class="rich_list wfff clearfix">
		<div class="scroll_list">
			<ul id="rand_film" class="clearfix">
				<?php echo li_filmALL('rand',12);?>
			</ul>
		</div>
		<div class="wrap_prev_block">
			<a id="rand_film_control_prev" href="#" class="prev_block"></a>
		</div>
		<div class="wrap_next_block">
			<a id="rand_film_control_next" href="#" class="next_block"></a>
		</div>
	</div>
	<div class="comment-box">
		<div class="perlink">
			<span>Nuevas Peliculas: </span>
			<?php echo li_film_h3("id != '0'",10);?>
		</div>
		<div class="comment-notice">
			<strong>Recuerda</strong>: <?php echo Comment_Model::rand_notice();?>
		</div>
	</div>
<?php
include View::TemplateView('footer');
/*
		<div class="broken_popup">
				<label>contenido</label><span><textarea class="text" cols="40" rows="5" name="broken_error" id="broken_error" style="width:200px"></textarea></span>
			</div>
			<center><input type="button" class="button" value="Realizar"/></center>
		</div>
	</div>
</div>
<script type='text/javascript'>if (top.location != self.location){top.location = self.location}</script>
<script type="text/javascript">(function(){var a;var b=navigator.userAgent;a=b.indexOf("Mobile")!=-1&&b.indexOf("WebKit")!=-1&&b.indexOf("iPad")==-1?!0:b.indexOf("Opera Mini")!=-1?!0:!1;if(a){var c;a:{var d=window.location.href,e=d.split("?");switch(e.length){case 1:c=d+"?m=1";break a;case 2:c=e[1].search("(^|&)m=")>=0?null:d+"&m=1";break a;default:c=null}}c&&window.location.replace(c)};})();
</script><script type="text/javascript">
if (window.jstiming) window.jstiming.load.tick('headEnd');
</script>*/
?>
