<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
if($geturl[2]) {
	$page = explode('-',$geturl[2]);
}
$page		= 	$page[1];
$num		= 	12;
$num 		= 	intval($num);
$page 		= 	intval($page);
if (!$page) 	$page = 1;
$limit 		= 	($page-1)*$num;
if($limit<0) 	$limit=0;
$arr = MySql::dbselect('id,name,url,duration,thumb','media',"id != 0 order by id desc LIMIT $limit,$num");
$total = MySql::dbselect('id','media',"id != 0");
$allpage_site = get_allpage(count($total),$num,$page,SITE_URL."/video/page-");
?>
<div class="hdvideo">
	<div class="hdhwap">
		<ul style="height:400px">
			<?php echo get_video('slide = 1',7);?>
		</ul>
		<div style="clear:both">
		</div>
		<a href="#" id="hvideo_control_prev" class="btn_pre_ft"></a><a href="#" id="hvideo_control_next" class="btn_next_ft"></a>
	</div>
	<script type="text/javascript">$(".hdhwap ul").carouFredSel({circular: false,infinite: false,auto : false,width: "100%",prev: {button: "#hvideo_control_prev",key: "left"},next: { button: "#hvideo_control_next",key: "right"},});</script>
	<div class="videos">
		<h2 class="title">Video mới</h2>
		<div class="vwap clearfix">
			<div class="vlist">
				<ul class="ulvdieo">
					<?php
						for($i=0;$i<count($arr);$i++) {
							$id = $arr[$i][0];
							$name = $arr[$i][1];
							$url = get_url($id,$name,'Xem Video');
							$duration = $arr[$i][3];
							$thumb = $arr[$i][4];
					?>
					<li class="play-hover">
						<a href="<?php echo $url;?>" title="<?php echo $name;?>">
							<img src="<?php echo $thumb;?>" alt="<?php echo $name;?>"/>
							<span class="vtime"><?php echo $duration;?></span>
							<span class="over_play"></span>
						</a>
						<a href="<?php echo $url;?>" title="<?php echo $name;?>">
							<span class="name">
								<span class="vname"><?php echo CutName($name,30);?></span>
							</span>
						</a>
					</li>
					<?php } ?>
				</ul>
				<div class="clear"></div>
				<?php echo $allpage_site;?>
			</div>
		</div>
	</div>
</div>
<?php
include View::TemplateView('footer');
?>