<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
$title_page = $name;
// Bộ lọc
parse_str(parse_url(Url::curRequestURL(),PHP_URL_QUERY), $filter);
if($filter['bycat'] || $filter['bycountry'] || $filter['byquality'] || $filter['byyear'] || $filter['byorder']) {
	if($filter['bycat']) {
		$catid =$filter['bycat'];
		$sql .= " AND category like '%,$catid,%'";
	}if ($filter['bycountry']) {
		$couid = $filter['bycountry'];
		$sql .= " AND country = '$couid'";
	}if ($filter['byquality']) {
		$qualityid = $filter['byquality'];
		$sql .= " AND quality = '$qualityid'";
	}if ($filter['byyear']) {
		$getyear = $filter['byyear'];
		$sql .= " AND year = '$getyear'";
	}if ($filter['byorder']) {
		$byorder = $filter['byorder'];
		if($byorder == 'timeupdate') $byorder = 'timeupdate';
		else if($byorder == 'year') $byorder = 'year';
		else if($byorder == 'title') $byorder = 'title';
		else if($byorder == 'viewed') $byorder = 'viewed';
		else $byorder = 'timeupdate';
	}
}
$orderby = 'ORDER BY '.$byorder.' DESC';
if(!$byorder) $orderby = 'ORDER BY id DESC';
if($geturl[3]) {
	$page = explode('-',$geturl[3]);
}
$page		= 	$page[1];
$num		= 	config_site('list_limit');
$num 		= 	intval($num);
$page 		= 	intval($page);
if (!$page) 	$page = 1;
$limit 		= 	($page-1)*$num;
if($limit<0) 	$limit=0;
$arr = MySql::dbselect('tb_film.id,tb_film.title,tb_film.title_en,tb_film.thumb,tb_film.year,tb_film.big_image,tb_film_other.content,tb_film.quality,tb_film.year','film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"$sql $orderby LIMIT $limit,$num");
$bg_thumb = TEMPLATE_URL.'images/grey.jpg';
$total = MySql::dbselect('tb_film.id','film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"$sql");
$allpage_site = get_allpage(count($total),$num,$page,$url_page.'page-');
?>
<div class="p-profile-cover"></div>
<div class="bread-crumb"> 
	<ul xmlns:v="http://rdf.data-vocabulary.org/#"> 
		<li typeof="v:Breadcrumb"><a href="<?php echo SITE_URL;?>" rel="v:url" property="v:title">Peliculas</a></li> 
		<li typeof="v:Breadcrumb"><h2><a class="last" href="<?php echo $url_page;?>" rel="v:url" property="v:title"><?php echo $title_page;?></a></h2></li> 
	</ul>
</div>
<div id="filter-movie">
	<div class="clearfix list-filter">
		<div class="ft-left">
			<span class="filter-click">Filtro Peliculas</span>
		</div>
		<div class="ft-right">
			<ul>
				<li class="sort byorder"><span>Ordenar por</span>
					<?php echo get_byorder($byorder);?>
				</li>
				<li class="ui"><span>Interfaz</span><a class="grid" href="javascript:void(0)">&nbsp;</a><a class="list" href="javascript:void(0)">&nbsp;</a></li>
			</ul>
		</div>
	</div>
	<div class="fitter-mess">
		<p>
			<?php echo Comment_Model::rand_notice();?>
		</p>
	</div>
	<div class="clearfix filter-type hidden">
		<input type="hidden" id="bycountry" value="<?php echo $couid;?>"/>
		<input type="hidden" id="byquality" value="<?php echo $qualityid;?>"/>
		<input type="hidden" id="bycat" value="<?php echo $catid;?>"/>
		<input type="hidden" id="byyear" value="<?php echo $getyear;?>"/>
		<input type="hidden" id="byorder" value="<?php echo $byorder;?>"/>
		<ul>
			<li class="bycat"><span>Categoría</span>
				<?php echo category_a_f($catid);?>
			</li>
			<li class="byquality"><span>Calidad</span>
				<?php echo quality_a_f($qualityid);?>
			</li>
			<li class="byyear"><span>Año</span>
				<?php echo filmyear_a_f($getyear);?>
			</li>
			<li class="bycountry"><span>Pais</span>
				<?php echo country_a_f($couid);?>
			</li>
			<li><a href="#" class="btn-filter">Filtrar</a></li>
		</ul>
	</div>
</div>
<div class="l-items rich_list clearfix">
	<h2 class="title_block">Lista de películas de <?php echo $title_page;?></h2>
	<ul class="clearfix listmovie">
		<?php 
			for($i=0;$i<count($arr);$i++) {
				$filmid = $arr[$i][0];
				$title = $arr[$i][1];
				$title_en = $arr[$i][2];
				$quality = $arr[$i][7];
				$year = $arr[$i][8];
				$thumb = $arr[$i][3];
				$url = get_url($arr[$i][0],$title,'Phim');
		?>
		<li>
		<div class="item tooltip-movie" data-tooltip="<?php echo $filmid;?>">
			<a href="<?php echo $url;?>" title="<?php echo $title.' - '.$title_en;?>" rel="nofollow"><span class="over_play"></span></a><img class="thumbimg lazy" src="<?php echo $bg_thumb;?>" data-original="<?php echo $thumb;?>" alt="<?php echo $title.' -? '.$title_en;?>"/>
			<div class="meta_block_spec" style="bottom:10px">
				<p class="title">
					<a href="<?php echo $url;?>" title="<?php echo $title.' - '.$title_en;?>"><?php echo CutName($title,20);?></a> <?php echo $year;?> (<?php echo $quality;?>)
				</p>
				<p>
					 <?php echo CutName($title_en,20);?>
				</p>
			</div>
		</div>
		<span class="gradient_thumb"></span></li>
		<?php } ?>
	</ul>
	<?php echo $allpage_site;?>
</div>
<?php
include View::TemplateView('footer');
?>