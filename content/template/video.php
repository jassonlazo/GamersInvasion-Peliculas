<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
?>
<div class="watch-title">
	<div class="wap-tile">
		<h2><a href="<?php echo $urlvideo;?>" title="<?php echo $name;?>"><?php echo $name;?></a></h2>
	</div>
</div>
<div class="watch-title" style="padding: 0 5% 0px 5%;">
	<div class="watch-now" style="position:relative">
		<div class="player" style="position:relative;width: 900px; height: 500px;z-index:501">
			<?php echo player($url,'video');?>
			<div id="rkplayer">
			</div>
		</div>
        <!--<br><iframe src="http://phim-vn.com/player.php?link=<php $getlink = GetLink::Mobile($url); echo rawurlencode($getlink); ?>" frameborder="0" width="900" height="500"></iframe>-->
	</div>
	<div id="video-description" class="player-width">
		<div class="video-description">
			<div class="functional-bar beacon">
				<a href="javascript:void(0);" id="lightout" class="player_option_button" style="position:relative;z-index:501">Tắt đèn</a>
				<a href="javascript:void(0);" id="zoombtn" class="player_option_button">Phóng to</a>
				<a href="javascript:void(0);" id="binh-luan" class="player_option_button">Comentarios</a>
			</div>
		</div>
	</div>
</div>
<div class="wfff">
	<div class="watch-tab">
		<div class="wap-tab">
			<a href="javascript:void(0)" class="info active" rel="watch-video">Danh sách video</a>
			<a href="javascript:void(0)" class="decu" rel="watch-decu">Phim đề cử</a>
		</div>
	</div>
	<div class="watch-video info_resize">
		<div id="mainVideo" class="main">
			<div class="scroll">
				<span class="title hide_info"></span>
				<ul>
					<?php echo get_video('id != 0',8,'rand');?>
				</ul>
			</div>
			<div class="clear">
			</div>
		</div>
	</div>
	<div class="watch-decu info_resize">
		<div class="bar wfff clearfix hide_info" rel="free_film" style="width: 1168px; margin-left: 48px;"></div>
		<div class="rich_list wfff clearfix tab_info_2">
			<div class="scroll_list">
				<ul id="decu_film" class="clearfix">
					<?php echo li_filmALL('decu',17);?>
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
	<div class="comment-box">
		<div class="perlink">
			<span>Phim mới gần đây: </span>
			<?php echo li_film_h3("id != '0'",10);?>
		</div>
		<div class="comment-notice">
			<strong>Mẹo</strong>: <?php echo Comment_Model::rand_notice();?>
		</div>
		<div class="clear">
		</div>
		<div class="cmt-content">
			<div class="hdo_c fb-comments" data-href="<?php echo $urlvideo;?>" data-num-posts="10" data-width="800" colorscheme="light">
			</div>
		</div>
	</div>
</div>
<?php
include View::TemplateView('footer');
?>