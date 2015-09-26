<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
if($type !== '1') {
?>
<div class="p-profile-cover"></div>
<div class="bread-crumb">
	<ul>
		<li><a href="<?php echo SITE_URL;?>">Peliculas</a></li>
		<li><a class="last" href="javascript:void(0)">Live TV </a></li>
		<li style="float:right">
		<form method="get">
			<input placeholder="Gõ ký hiệu kênh (Ví dụ: HTV7)" type="text" size="50" name="k" style="color: #7E7E7E;padding-left: 10px;background: #1F1E1E;border: 1px solid #363636;line-height: 25px;width: 250px;"/><input type="submit" value="Tìm kênh" style="background: #1F1E1E;border: 1px solid #363636;line-height: 25px;color: #7E7E7E;">
		</form>
		</li>
	</ul>
</div>
<div class="tv_list_page clearfix">
	<ul>
		<?php
			$livetv = MySql::dbselect('id,symbol,name,quality,speed,thumb','tv',"$sql");
			for($i=0;$i<count($livetv);$i++) {
				$id = $livetv[$i][0];
				$name = $livetv[$i][2];
				$symbol = $livetv[$i][1];
				$thumb = $livetv[$i][5];
				$url = get_url($id,$symbol,'Live TV');
				echo "<li><div class=\"pageSlide\">
				<a href=\"$url\" title=\"$symbol - $name\">
					<img src=\"$thumb\" alt=\"$symbol - $name\"/>
					<div class=\"maskMv\"></div>
				</a>
				</div></li>";
			}
		?>
	</ul>
</div>
<?php }else { 
$name = $livetv[0][2];
$linktv = $livetv[0][7];
$thumb = $livetv[0][8];
$lang = $livetv[0][9];
$quality = $livetv[0][3];
$speed = $livetv[0][4];
$viewed = $livetv[0][5];
$content = $livetv[0][6];
$urltv = get_url($id,$symbol,'Live TV');
?>
<div class="watch-title">
	<div class="wap-tile">
		<h2><a href="<?php echo $urltv;?>" title="<?php echo $symbol;?> - <?php echo $name;?>"><?php echo $symbol;?> - <?php echo $name;?></a></h2>
	</div>
</div>
<div class="none-space-top">
<div class="watch-now">
	<div class="player" style="text-align:center;position:relative">
		<div id="player">
			<iframe scrolling="no" frameborder="0" style="border: medium none; width: 900px; height: 500px;" allowtransparency="true" src="<?php echo $linktv;?>" allowfullscreen></iframe>
		</div>
	</div>
</div>
<div class="wfff">
	<div class="watch-tab">
		<div class="wap-tab">
			<a href="javascript:void(0)" class="info active" rel="watch-tivi">Thông tin</a>
			<a href="javascript:void(0)" class="free" rel="watch-channel">Danh sách kênh</a>
			<a href="javascript:void(0)" class="free" rel="watch-decu">Phim đề cử</a>
		</div>
	</div>
	<div class="watch-tivi info_resize">
		<div class="wap-info clearfix">
			<div class="film-info clearfix">
				<div style="position: absolute;z-index: 501;background: #F9F9F9;">
					<div id="titleSlider">
						Thông tin
					</div>
					<div class="fiml-img">
						<img src="<?php echo $thumb;?>" alt="" width="200px"/>
					</div>
					<div class="box-info">
						<div class="fields clearfix">
							<ul>
								<li><span class="label">Tên kênh: </span><label><?php echo $name;?></label></li>
								<li><span class="label">Ký hiệu: </span><label><?php echo $symbol;?></label></li>
								<li><span class="label">Ngôn ngữ: </span><label><?php echo $lang;?></label></li>
								<li><span class="label">Chất lượng: </span><label><?php echo $quality;?></label></li>
								<li><span class="label">Tốc độ: </span><?php echo $speed;?><label></label></li>
								<li><span class="label">Lượt xem: </span><label><?php echo $viewed;?></label></li>
							</ul>
						</div>
						<div class="fdesc clearfix">
							<p>
								<?php echo $content;?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
	</div>
	<div class="watch-decu info_resize">
		<div class="bar wfff clearfix hide_info" rel="free_film"></div>
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
	<div class="watch-channel info_resize">
		<div class="tv_list_page clearfix">
			<ul>
				<?php
					$livetv = MySql::dbselect('id,symbol,name,quality,speed,thumb','tv',"id != 0 order by rand() desc limit 21");
					for($i=0;$i<count($livetv);$i++) {
						$id = $livetv[$i][0];
						$name = $livetv[$i][2];
						$symbol = $livetv[$i][1];
						$thumb = $livetv[$i][5];
						$url = get_url($id,$symbol,'Live TV');
						echo "<li><div class=\"pageSlide\">
						<a href=\"$url\" title=\"$symbol - $name\">
							<img src=\"$thumb\" alt=\"$symbol - $name\"/>
							<div class=\"maskMv\"></div>
						</a>
						</div></li>";
					}
				?>
			</ul>
		</div>
	</div>
	<div class="watch-video">
		<div id="mainVideo" class="main">
			<div class="scroll">
				<span class="title hide_info"><a href="<?php echo SITE_URL;?>/video/" title="Video Mới">DANH SÁCH VIDEO</a></span>
				<ul style="width: 1168px; margin-left: 0px;">
					<?php echo get_video('id != 0',8,'rand');?>
				</ul>
			</div>
			<div class="clear">
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
			<div class="hdo_c fb-comments" data-href="<?php echo $urltv;?>" data-num-posts="10" data-width="800" colorscheme="light">
			</div>
		</div>
	</div>
</div>
<?php
}
include View::TemplateView('footer');
?>