<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
?>
<div id="feature">
	<ul id="cinema" class="big_rich_list clearfix">
		<?php echo slider_film("slider = '1'",5);?>
	</ul>
	<div style="clear:both">
	</div>
	<a href="#" id="cinema_control_prev" class="btn_pre_ft"></a><a href="#" id="cinema_control_next" class="btn_next_ft"></a>
	<div class="paging_ft" id="cinema_paging_ft">
	</div>
</div>
<script type="text/javascript">$(document).ready(function(e) { $("#cinema").carouFredSel({ circular: true, infinite: true, auto: {
                    play: true,
                    duration: 900,
                    timeoutDuration: 4300
                }, prev: { button: "#cinema_control_prev", key: "left" }, next: {  button: "#cinema_control_next", key: "right" } });});</script>
<div class="ftcat clearfix">
	<div class="scroll_list">
		<ul class="clearfix head_cat">
			<?php echo cat_hotlist();?>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="head_cat_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="head_cat_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="phim_moi">
	
	<div class="fright">
		<div class="drop-menu-fitter-home">
			<div class="home-fb">
				<div class="fb-like" data-width="90" data-layout="button_count" data-show-faces="false" data-share="true" data-href="https://www.facebook.com/gamersinvasions"></div>
			</div>
			<div class="home-gg">
				<div class="g-plusone" data-size="medium" data-href="<?php echo SITE_URL; ?>"></div>
			</div>
		</div>
	</div>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="phim_moi" class="clearfix">
			<?php echo li_filmALL('decu',17);?>
			<li><a href="http://phim-vn.com/danh-sach/phim-de-cu/" title="Phim đề cử"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>

</div>
<div class="bar clearfix" rel="new_episode">
	<span class="title_block">Videos de Youtube</span>
</div>
<div class="spec_block clearfix">
	<div class="scroll_list">
		<ul class="clearfix" id="new_episode">
			<?php echo li_video();?>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="tap_moi_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="tap_moi_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="phim_le">
	<h3 class="title_block"><a href="<?php echo get_url(0,'Phim lẻ','Danh sách');?>" title="Phim Lẻ Mới">Peliculas</a></h3>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="phim_le" class="clearfix">
			<?php echo li_filmALL('phimle',17);?>
			<li><a href="<?php echo get_url(0,'Phim lẻ','Danh sách');?>" title="Movies"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="phim_bo">
	<h3 class="title_block"><a href="<?php echo get_url(0,'Phim bộ','Danh sách');?>" title="Series">Peliculas</a></h3>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="phim_bo" class="clearfix">
			<?php echo li_filmALL('phimbo',17);?>
			<li><a href="<?php echo get_url(0,'S','Danh sách');?>" title="Series"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="hanh_dong">
	<h3 class="title_block"><a href="<?php echo get_url(0,'Hành Động','Thể loại');?>" title="Hành động">Pelicula de accion</a></h3>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="hanh_dong" class="clearfix">
			<?php echo li_filmALL('category',17,',1,');?>
			<li><a href="<?php echo get_url(0,'Hành Động','Thể loại');?>" title="Hành động"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="hanh_dong">
	<h3 class="title_block"><a href="<?php echo get_url(0,'Kinh dị','Thể loại');?>" title="Kinh dị">Peliculas de Horror</a></h3>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="hanh_dong" class="clearfix">
			<?php echo li_filmALL('category',17,',21,');?>
			<li><a href="<?php echo get_url(0,'Kinh dị','Thể loại');?>" title="Kinh dị"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="hanh_dong">
	<h3 class="title_block"><a href="<?php echo get_url(0,'Hài hước','Thể loại');?>" title="Hài hước">Peliculas de Comedia</a></h3>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="hanh_dong" class="clearfix">
			<?php echo li_filmALL('category',17,',6,');?>
			<li><a href="<?php echo get_url(0,'Hài hước','Thể loại');?>" title="Hài hước"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<div class="bar clearfix" rel="hanh_dong">
	<h3 class="title_block"><a href="<?php echo get_url(0,'Hoạt hình','Thể loại');?>" title="Hoạt hình">Dibujos Animados</a></h3>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="hanh_dong" class="clearfix">
			<?php echo li_filmALL('category',17,',4,');?>
			<li><a href="<?php echo get_url(0,'Hoạt hình','Thể loại');?>" title="Hoạt hình"><img src="<?php echo TEMPLATE_URL;?>images/watch_more.png" class="thumb" alt="More"/></a></li>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<?php
include View::TemplateView('footer');
?>