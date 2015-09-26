<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
class Film_Model {
	public static function get($id,$item) {
		$arr = MySql::dbselect("$item",'film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"id = '$id'");
		if($arr) return $arr[0][0];
	}
	public static function Votes($filmid) {
		$userid = $_SESSION["RK_Userid"];
		$filmid = intval($filmid);
		if(!$userid) $err = 'user';
		else {
			$checkuser = MySql::dbselect("vote_star", "user", "id = '$userid' AND vote_star like '%|$filmid|%'");
			if($checkuser) $err = 'err';
			else {
				$getuser = MySql::dbselect("vote_star", "user", "id = '$userid'");
				$star = $_POST['star'];
				$vote_star = $getuser[0][0]."|$filmid|";
				MySql::dbupdate('film',"total_votes = total_votes+1, total_value = total_value+'$star'","id = '$filmid'");
				MySql::dbupdate('user',"vote_star = '$vote_star'","id = '$userid'");
				$arr = MySql::dbselect('total_votes,total_value','film',"id = '$filmid'");
				$Astar = $arr[0][1];
				$Bstar = $arr[0][0];
				$Cstar = ($Astar/$Bstar);
				$Cstar = number_format($Cstar,1);
				$err = $Cstar."/10 - $Bstar";
			}
		}
		return $err;
	}
	public static function Tooltip($filmid) {
		$filmid = intval($filmid);
		$film = MySql::dbselect("
				tb_film.title,
				tb_film.title_en,
				tb_film.category,
				tb_film.release_time,
				tb_film.timeupdate,
				tb_film.thumb,
				tb_film.country,
				tb_film.director,
				tb_film.actor,
				tb_film.year,
				tb_film.duration,
				tb_film.viewed,
				tb_film_other.content,
				tb_film_other.keywords,
				tb_film.total_votes,
				tb_film.total_value,
				tb_film.trailer
				",'film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"id = '$filmid'");
		$tenphim = $film[0][0];
		$tentienganh = $film[0][1];
		$trailer = $film[0][16];
		if($trailer) $trailer = '<a href="'.$trailer.'" onclick="$.prettyPhoto.open(this.href);return false;"> Ver Trailer </a>';
		$urlfilm = Url::get($filmid,$tenphim,'Phim');
		$year = CheckName($film[0][9]);
		$content = CutName(RemoveHtml(UnHtmlChars($film[0][12])),100);
		$Astar = $film[0][15];
		$Bstar = $film[0][14];
		$Cstar = ($Astar/$Bstar);
		$Dstar = number_format($Cstar,0);
		$Cstar = number_format($Cstar,1);
		$image_r = explode("<img ",UnHtmlChars($film[0][12]));
		preg_match('/src="([^"]+)"/', $image_r[1], $image);
		$image = $image[1];
		if(!$image) $image = $film[0][5];
		$catlist = substr($film[0][2], 1);
		$catlist = substr($catlist, 0, -1);
		$category  = MySql::dbselect("name", "category", "id IN (" . $catlist . ")");
		for($i=0;$i<count($category);$i++) {
			$name = $category[$i][0];
			$url = Url::get(0,$name,'Thể Loại');
			$cat .= "<a href=\"$url\" title=\"Phim $name\">$name</a>";
		}
		$theloai = $cat;
		$html = '
			<div class="f-tool-tip">
				<div class="wap-tt">
					<h2><a href="'.$urlfilm.'">'.$tenphim.'</a></h2><h3>'.$tentienganh.'</h3>
					<ul class="clearfix f-icon"><li class="year">'.$year.'</li></ul>
					<div class="ftype clearfix">'.$theloai.'</div>
					<div class="vote clearfix">
						<div class="unvote-line"><div class="vote-line" style="width: '.$Dstar.'0%"></div></div>
						<div class="vote-stats">'.$Cstar.'/10</div>
					</div>
					<div class="fdesc clearfix">'.$content.'</div>
					<div class="thumbnail play-hover">
						<div class="thumb"><a href="'.$image.'" onclick="$.prettyPhoto.open(this.href);return false;" ><img src="'.$image.'"></a></div>
						<div class="add-wl">
							'.$trailer.'
							<a href="javascript:void(0)" onclick="add_fav_feature('.$filmid.');">+ Ver Mas Tarde</a>
							<a href="javascript:void(0)" onclick="add_fav_playlist('.$filmid.');">+ Favorito</a>
						</div>
					</div>
				<div class="clear"></div>
				</div>
			</div>
		';
		return $html;
	}
	public static function Fav_Feature($filmid) {
		$userid = $_SESSION["RK_Userid"];
		$filmid = intval($filmid);
		if(!$userid) $err = 'user';
		else {
			$checkuser = MySql::dbselect("fav_feature", "user", "id = '$userid' AND fav_feature like '%|$filmid|%'");
			if($checkuser) $err = 'err';
			else {
				$getuser = MySql::dbselect("fav_feature", "user", "id = '$userid'");
				$fav_feature = "|$filmid|".$getuser[0][0];
				MySql::dbupdate('user',"fav_feature = '$fav_feature'","id = '$userid'");
				$err = '1';
			}
		}
		return $err;
	}
	public static function Fav_Playlist($filmid) {
		$userid = $_SESSION["RK_Userid"];
		$filmid = intval($filmid);
		if(!$userid) $err = 'user';
		else {
			$checkuser = MySql::dbselect("fav_playlist", "user", "id = '$userid' AND fav_playlist like '%|$filmid|%'");
			if($checkuser) $err = 'err';
			else {
				$getuser = MySql::dbselect("fav_playlist", "user", "id = '$userid'");
				$fav_playlist = "|$filmid|".$getuser[0][0];
				MySql::dbupdate('user',"fav_playlist = '$fav_playlist'","id = '$userid'");
				$err = '1';
			}
		}
		return $err;
	}
	public static function Fav_Error($epid) {
		$id = intval($epid);
		$epid = MySql::dbselect('id,name,filmid,url,subtitle','episode',"id = '$id'");
		$filmid = intval($epid[0][2]);
		MySql::dbupdate('film',"error = '1'","id = '$filmid'");
		MySql::dbupdate('episode',"error = '1'","id = '$id'");
		return 1;
	}
	public static function RK_Remove($filmid,$type) {
		$userid = $_SESSION["RK_Userid"];
		$filmid = intval($filmid);
		$getuser = MySql::dbselect("$type", "user", "id = '$userid'");
		$list = str_replace("|$filmid|",'',$getuser[0][0]);
		MySql::dbupdate('user',"$type = '$list'","id = '$userid'");
		return 1;
	}
	public static function ResetViewed() {
		
		return false;
	}
	public static function CacheActorSeatch() {
		$actor				= 	TEMPLATE_PATH."js/actor.js";
		$search				= 	TEMPLATE_PATH."js/search.js";
		$expire 			= 	86400;
		if (!file_exists($actor) && filemtime($actor) < (time() - $expire)) {
			$arr = MySql::dbselect("name,info,urlmore,thumb","actor","id != '0'");
			for($i=0;$i<count($arr);$i++) {
				$name = $arr[$i][0];
				$url = Url::get(0,$name,'search');
				$thumb = $arr[$i][3];
				if(!$thumb) $thumb = TEMPLATE_URL.'images/noactoravatar.gif';
				$actor_html[] = array('name' => $name, 'name_ascii' => VietChar(strtolower($name)), 'name_other' => '', 'job' => 'Diễn viên', 'img' => $thumb, 'link' => $url);
			}
			$actor_html = json_encode($actor_html);
			$actor_html = str_replace(array('[',']'),'',$actor_html);
			Cache::END_CACHE('var ins_actor = Array('.$actor_html.')',$actor);
		} 
		if (!file_exists($search) && filemtime($search) < (time() - $expire)) {
			/*$arr = MySql::dbselect('id,title,thumb,year,title_en,actor','film',"id != '0'");
			for($i=0;$i<count($arr);$i++) {
				$name = $arr[$i][1];
				$name_en = $arr[$i][4];
				$url = Url::get($arr[$i][0],$name,'Phim');
				$thumb = $arr[$i][2];
				$year = $arr[$i][3];
				$actor = $arr[$i][5];
				$search_html .= '{"title":"'.$name.'","title_real":"'.$name_en.'","title_ascii":"'.VietChar(strtolower($name)).'","img":"'.$thumb.'","actor":"'.$actor.'","year":"'.$year.'","link":"'.$url.'"},';
			}*/
			$arr = MySql::dbselect('id,title,thumb,year,title_en,actor','film',"id != '0'");
			for($i=0;$i<count($arr);$i++) {
				$name = $arr[$i][1];
				$name_en = $arr[$i][4];
				$url = Url::get($arr[$i][0],$name,'Phim');
				$thumb = $arr[$i][2];
				$year = $arr[$i][3];
				$actor = $arr[$i][5];
				$search_html[] = array('title' => $name, 'title_real' => $name_en, 'title_ascii' => VietChar(strtolower($name)), 'img' => $thumb, 'actor' => $actor, 'year' => $year, 'link' => $url);
			}
			$search_html = json_encode($search_html);
			$search_html = str_replace(array('[',']'),'',$search_html);
			Cache::END_CACHE('var ins_search = Array('.$search_html.')',$search);
		} 
	}
}
