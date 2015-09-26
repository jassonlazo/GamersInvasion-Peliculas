<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
class Site_Controller {
	public static function display($params) {
		$cururl = Url::curRequestURL();
		# Actor de caché y el cine
		Film_Model::CacheActorSeatch();
		# Restablecer Vistas
		Film_Model::ResetViewed();
		# Get info url
		$geturl = explode('/',$cururl);
		$mode = $geturl[1];
		// Film and cinema
		if(in_array($mode,array('phim','xem-phim'))) {
			$id = $geturl[2];
			$id = explode('-',$id);
			$id = $id[0];
			if($mode == 'phim') {
				$arr = MySql::dbselect('tb_film.id,tb_film.title,tb_film.thumb,tb_film.year,tb_film.big_image,tb_film_other.content,tb_film.title_en,tb_film_other.keywords','film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"id = '$id'");
				//TITULO PRINCIPAL DE TODA LA WEB 
				$site_title = 'Pelicula '.$arr[0][1].' | '.$arr[0][6].' full HD';
				$site_description = str_replace('"', '',CutName(RemoveHtml(UnHtmlChars($arr[0][5])),200));
				$site_keywords = FixTags($arr[0][7]);
				$filmid = intval($arr[0][0]);
				$epwatch = MySql::dbselect('id','episode',"filmid = '$filmid' order by id asc limit 1");
				$epwatch = $epwatch[0][0];
			}else if($mode == 'xem-phim') {
				$epid = MySql::dbselect('id,name,filmid,url,subtitle','episode',"id = '$id'");
				$filmid = intval($epid[0][2]);
				MySql::dbupdate('film',"viewed = viewed+100, viewed_day = viewed_day+1, viewed_week = viewed_week+1, viewed_month = viewed_month+1","id = '$filmid'");
				$arr = MySql::dbselect('tb_film.id,tb_film.title,tb_film.thumb,tb_film.year,tb_film.big_image,tb_film_other.content,tb_film.title_en,tb_film_other.keywords','film JOIN tb_film_other ON (tb_film_other.filmid = tb_film.id)',"id = '$filmid'");
				$site_title = 'Pelicula '.$arr[0][1].' Tập '.$epid[0][1].' - Pelicula '.$arr[0][6];
				$site_description = 'Pelicula '.$arr[0][1].' Tập '.$epid[0][1].' | '.$arr[0][6].'  Ep '.$epid[0][1].'. Pelicula '.$arr[0][1].' Tập '.$epid[0][1].' Calidad HD.';
				$site_keywords = FixTags('Pelicula '.$arr[0][1].' Tập '.$epid[0][1].', '.$arr[0][1].' Tập '.$epid[0][1].', '.$arr[0][6].' Ep '.$epid[0][1].', '.$arr[0][7]);
			}
			if(!$arr) header('Location: '.s404_URL);
			$other_meta = '<meta property="og:image" content="'.$arr[0][2].'">';
			$other_meta2 = '<link href="'.SITE_URL.$cururl.'" rel="canonical">';
			include View::TemplateView('film');
		}
		// Trang danh sách
		else if(in_array($mode,array('danh-sach','the-loai','quoc-gia','search','tag'))) {
			if($mode == 'the-loai') {
				$id = $geturl[2];
				$arr = MySql::dbselect('id,name','category',"name_seo = '$id'");
				$id = $arr[0][0];
				$catid = $id;
				$name = $arr[0][1];
				$url_page = Url::get(0,$name,'Thể loại');
				$site_title = head_site($name,'category_title');
				$site_description = head_site($name,'category_description');
				$site_keywords = head_site($name,'category_keywords');
				$sql = "tb_film.category like '%,$id,%'";
			}else if($mode == 'quoc-gia') {
				$id = $geturl[2];
				$arr = MySql::dbselect('id,name','country',"name_seo = '$id'");
				$id = $arr[0][0];
				$couid = $id;
				$name = $arr[0][1];
				$url_page = Url::get(0,$name,'Pais');
				$site_title = head_site($name,'country_title');
				$site_description = head_site($name,'country_description');
				$site_keywords = head_site($name,'country_keywords');
				$sql = "tb_film.country = '$id'";
			}else if(in_array($mode,array('search','tag'))) {
				$id = str_replace('-',' ',urldecode($geturl[2]));
				$name = $id;
				$url_page = Url::get(0,$name,'Search');
				$site_title = head_site($name,'search_title');
				$site_description = head_site($name,'search_description');
				$site_keywords = head_site($name,'search_keywords');
				$sql = "tb_film.title like '%$id%' OR tb_film.title_en like '%$id%' OR tb_film_other.searchs like '%$id%' OR tb_film_other.keywords like '%$id%' OR tb_film.actor like '%$id%' OR tb_film.director like '%$id%'";
			}else if($mode == 'danh-sach') {
				$id = $geturl[2];
				if($id == 'phim-moi') {
					$name = 'Nuevas Películas';
					$url_page = Url::get(0,$name,'Danh sách');
					$sql = "id != '0'";
					$site_title = "Nuevas Películas y 2014, lista nueva géneros cinematográficos";
					$site_description = "Lista de Cine Última actualización continua, consulte delicia y un número ilimitado de películas.";
					$site_keywords = "Nuevas películas , una nueva película o, seleccionada nuevas películas";
				}
				else if($id == 'phim-de-cu') {
					$name = 'Peliculas Nominadas';
					$url_page = Url::get(0,$name,'Danh sách');
					$sql = "decu = '1'";
					$site_title = "Película con alta calidad";
					$site_description = "Las películas nominadas para el más caliente o 2014, se seleccionaron y evaluaron la más alta calidad.";
					$site_keywords = "películas calientes, mejores películas, películas o 2014";
				}
				else if($id == 'phim-le') {
					$filmlb = $id;
					$name = 'Movie';
					$url_page = Url::get(0,$name,'Danh sách');
					$sql = "filmlb = '0'";
					$site_title = "Película con alta calidad";
					$site_description = "Lista de los géneros cinematográficos individuales o múltiples, la selección constantemente actualizada de nuevas películas y la más atractiva al por menor";
					$site_keywords = "Películas o películas seleccionadas impares, películas la nueva película de venta";
				}
				else if($id == 'phim-bo') {
					$filmlb = $id;
					$name = 'Drama';
					$url_page = Url::get(0,$name,'Danh sách');
					$sql = "filmlb IN (1,2)";
					$site_title = "Película con alta calidad";
					$site_description = "Lista de sistemas de la película o actualizada de forma continua y nueva selección de películas y más atractivo.";
					$site_keywords = "Drama o, las películas seleccionadas, la nueva película, la película";
				}
				else if(preg_match("#phim-nam-([0-9]+)#", $id, $yearurl)) {
					$getyear = $yearurl[1];
					$name = 'Año '.$getyear;
					$url_page = Url::get(0,'Phim '.$name,'Danh sách');
					$sql = "year = '$getyear'";
					$site_title = "Peliculas $name mới nhất, Pelicula $name , Pelicula $name de Estreno";
					$site_description = "Danh sách phim $name mới nhất, phim $name hay chọn lọc, phim $name.";
					$site_keywords = "Pelicula $name, Pelicula $name, Estrenos $name, descarga Pelicula $getyear";
				}
			}
			include View::TemplateView('list');
		}
		// Trang thành viên
		else if($mode == 'thanh-vien') {
			$userid = $geturl[2];
			$userid = explode('-',$userid);
			$userid = intval($userid[0]);
			if($geturl[2] == 'dang-ky') {
				$site_title = 'Miembros Registrados';
			} else if($geturl[2] == 'dang-nhap') {
				$site_title = 'Ingresar';
			} else if($geturl[2] == 'quen-mat-khau') {
				$site_title = '¿Olvidaste tu contraseña?';
			} else {
				$site_title = 'Perfil';
			}
			$site_description = Config_Model::ConfigName('site_description');
			$site_keywords = Config_Model::ConfigName('site_keywords');
			if(IS_LOGIN && !$userid) header('Location: '.SITE_URL);
			include View::TemplateView('member');
		}
		// Tabla de posiciones
		else if($mode == 'bang-xep-hang') {
			$site_title = 'Top películas o ver la calidad de alta definición rápido';
			$site_description = "Película o una selección de alta calidad, busque gratuitas nuevas películas ilimitadas";
			$site_keywords = Config_Model::ConfigName('site_keywords');
			include View::TemplateView('rank');
		}
		// Vídeo y ver video
		else if($mode == 'video' || $mode == 'xem-video') {
			$id = $geturl[2];
			$id = explode('-',$id);
			$id = intval($id[0]);
			if(!$id) {
				$site_title = 'Videos Youtube';
				$site_description = "	Últimas Reclutamiento video divertido, mejores clips de comedia, ver chistes vídeos de humor, clip exclusivo divertido CALIENTE ";
				$site_keywords = "divertida risa videoclip, videos graciosos, videos divertidos";
				include View::TemplateView('listvideo');
			}else {
				$arr = MySql::dbselect('name,url,duration,thumb','media',"id = '$id'");
				if($arr) MySql::dbupdate('media',"viewed = viewed+1","id = '$id'");
				$name = $arr[0][0];
				$url = $arr[0][1];
				$duration = $arr[0][2];
				$thumb = $arr[0][3];
				$site_title = "$name";
				$site_description = Config_Model::ConfigName('site_description');
				$site_keywords = Config_Model::ConfigName('site_keywords');
				$urlvideo = SITE_URL.$cururl;
				$other_meta = '<meta property="og:image" content="'.$thumb.'">';
				$other_meta2 = '<link href="'.$urlvideo.'" rel="canonical">';
				include View::TemplateView('video');
			}
		}
		// Bài viết
		else if($mode == 'tin-tuc') {
			$seotitle = $geturl[2];
			$arr = MySql::dbselect('id,title,content','news',"seotitle = '$seotitle'");
			$id = $arr[0][0];
			$title = $arr[0][1];
			$content = $arr[0][2];
			$site_title = "$title";
			$site_description = Config_Model::ConfigName('site_description');
			$site_keywords = Config_Model::ConfigName('site_keywords');
			include View::TemplateView('post');
		}
		else if($mode == 'live-tv') {
			parse_str(parse_url(Url::curRequestURL(),PHP_URL_QUERY), $data);
			$key = $data['k'];
			$id = $geturl[2];
			$id = explode('-',$id);
			$id = $id[0];
			if($key) {
				$site_title = 'Buscar canales: '.$key;
				$sql = "symbol like '%$key%' OR name like '%$key%'";
			}else if($id) {
				$livetv = MySql::dbselect('id,symbol,name,quality,speed,viewed,content,linktv,thumb,lang','tv',"id = '$id'");
				if($livetv) MySql::dbupdate('tv',"viewed = viewed+1","id = '$id'");
				$symbol = $livetv[0][1];
				$site_title = "$symbol - Ver la televisión en línea, el canal de televisión en línea";
				$type = '1';
				$other_meta = '<meta property="og:image" content="'.$livetv[0][8].'">';
				$other_meta2 = '<link href="'.SITE_URL.$cururl.'" rel="canonical">';
			}else {
				$site_title = 'Lista de canales de TV';
				$sql = 'id != 0';
			}
			$site_description = Config_Model::ConfigName('site_description');
			$site_keywords = Config_Model::ConfigName('site_keywords');
			include View::TemplateView('tv');
		}
		// Admincp
		else if($mode == ADMINCP_NAME) {
			include View::AdminView('admin');
		}
		// Configs
		else if(!$mode) {
			$site_title = Config_Model::ConfigName('site_name');
			$site_description = Config_Model::ConfigName('site_description');
			$site_keywords = Config_Model::ConfigName('site_keywords');
			include View::TemplateView('home');
		}
		// Error 404
		else {
			$site_title = 'ERROR 404';
			$site_description = Config_Model::ConfigName('site_description');
			$site_keywords = Config_Model::ConfigName('site_keywords');
			include View::TemplateView('404');
		}
	}
}
