<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
?>
<div class="bxh-container">
	<div class="bxh-content">
		<ul id="myTab-bxh" class="nav nav-tabs">
			<li class="active"><a href="#" data-tab="#bxh-day">DIA</a></li>
			<li><a href="#" data-tab="#bxh-week">SEMANA</a></li>
			<li class="dropdown"><a href="#" data-tab="#bxh-month">MES</a></li>
			<li class="dropdown pull-right top-imdb"><a href="#" data-tab="#bxh-vote">TOP VOTOS</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade in active" id="bxh-day">
				<?php echo bxh_show("day");?>
			</div>
			<div class="tab-pane fade in active hide" id="bxh-week">
				<?php echo bxh_show("week");?>
			</div>
			<div class="tab-pane fade in active hide" id="bxh-month">
				<?php echo bxh_show("month");?>
			</div>
			<div class="tab-pane fade in active hide" id="bxh-vote">
				<?php echo bxh_show("vote");?>
			</div>
			<div class="clear">
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function(e) { 
	$("#myTab-bxh li a").click(function(e) {
		$("#myTab-bxh li").removeClass("active"); 
		$(this).parent().addClass("active");
		$(".tab-pane").fadeOut();
		$($(this).data("tab")).fadeIn(); 
		$('html,body').animate({ scrollTop: $('#myTab-bxh').offset().top - 60}, 'slow');
		return false;
	}); 
});
</script>
<?php
include View::TemplateView('footer');
?>