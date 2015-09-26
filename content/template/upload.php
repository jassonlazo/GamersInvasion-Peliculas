<?php

error_reporting(E_ALL & ~E_NOTICE);
date_default_timezone_set('Asia/Ho_Chi_Minh');

session_start();

define('DIR', dirname(__FILE__) . DIRECTORY_SEPARATOR);
include DIR . 'library/ChipVN/Loader.php';

\ChipVN\Loader::registerAutoLoad();

function up($url_input, $width_input, $height_input) {
// fiter
$params = array('server', 'resize', 'watermark', 'logo');
foreach($params as $param)
{
	$name = $param . 'id';
	$data = intval($_REQUEST[$param]);
	if($data < 0) 
	{
		$data = 0;
	}
	${$name} = $data;
}


##################### START CONFIG #######################

$sitename = 'chiplovebiz';
/**
 * Tạo và CHMOD folder này sang 777
*/
$tempdir = DIR . 'temp/';

// danh sách logo
$logolist = array(
	1 => 'logo1.png', 
	2 => 'logo2.png',
	3 => 'logo3.png',
);
// Nếu logo yêu cầu ko có trong danh sách thì dùng logo1.png 
$default['logo'] = 'logo1.png';

// vị trí logo (right bottom, right center, right top, left top, .v.v.)
$logoPosition = 'rb';



// kích cỡ resize
$resizelist = array(
	0	=> 0, // ko resize
	1	=> 100, 
	2	=> 150,
	3	=> 320,
	4	=> 640,
	5	=> 800,
	6	=> 1024
);
$default['resize'] = 800;


##################### END CONFIG #######################



$watermark = $watermarkid > 0 ? TRUE : FALSE;

$logoPath = DIR . 'logo/' . (in_array($logoid, array_keys($logolist)) ? $logolist[$logoid] : $default['logo']);

$resizeWidth = $width_input;


if($_FILES['Filedata'] AND !$_FILES['Filedata']['error'])
{
	move_uploaded_file($_FILES['Filedata']['tmp_name'], $imagePath = $tempdir . $sitename .date('dmY'). '.jpg');
	$isUpload = TRUE;
}
else 
{
	$isUpload = FALSE;
	\ChipVN\Image::leech($url_input, $imagePath = $tempdir . $sitename . date('dmY').'.jpg');
}


// resize
if($resizeWidth > 0)
{
	if ($height_input > 0) {
		\ChipVN\Image::resize($imagePath, 0, $height_input);
	}
	else {
	\ChipVN\Image::resize($imagePath, $resizeWidth, 0);
	}
}
// watermark
if($watermark)
{
	\ChipVN\Image::watermark($imagePath, $logoPath, $logoPosition);
}

switch($serverid)
{
	case 1:	
		$service = 'Imageshack';
		break;
	case 2:
		$service = 'Imgur';
		break;
	case 3:
		$service = 'Picasa';
		break;
	case 4:
		$service = 'Flickr';
		break;	
	default:
		$service = 'Imgur';			
}

$uploader = \ChipVN\Image_Uploader::factory('Imgur');

switch($service)
{
	case 'Imageshack':
		/**
		 * Không bắt buộc đăng nhập
		 * Có thể đăng nhập hoặc ko. Tuy nhiên nên tham khảo quy định của ImageShack ở đây http://imageshack.us/content.php?page=rules
		 * Xóa comment "#" ở bên dưới nếu muốn up vào account của bạn
		**/
		 $uploader->login('tjeubao01@gmail.com', 'anhyeuem)*)!!((5');
		break;
		
	case 'Imgur':
		/**
		 * Không bắt buộc đăng nhập
		 * Có thể đăng nhập hoặc ko, nhưng ảnh mà ko up vào account thì có thể bị xóa sau 1 thời gian.
		 * Account thường chỉ up đc 225 ảnh. Xem thông tin upgrade lên PRO tại đây https://imgur.com/register/upgrade
		 * Xóa comment "#" ở bên dưới nếu muốn up vào account của bạn
		**/
		# $uploader->login('your user', 'your pass');
		break;	
		
	case 'Picasa':
		/**
		 * Picasa bắt buộc phải đăng nhập 
		 * AlbumID lấy ở link RSS trong album (ko biết thì tự tìm hiểu ở google)
		 * Phần albumID có thể set 1 array('id1', 'id2'); Code sẽ tự động lấy ngẫu nhiên 1 album trong số đó để upload vào.
		 * Nếu ko setAlbumID thì code sẽ up vào album default của picasa 
		 * Giới hạn upload ca Picasa xem tại đây: https://support.google.com/picasa/answer/43879?hl=vi
		 * Nếu ko dùng AlbumID thì thêm dấu # ở trước
		*/
		$uploader->login('tjeubao01@gmail.com', 'anhyeuem)*)!!((5');
		#$uploader->setAlbumID('album id của bạn');

		break;	
}

if(!$imagePath)
{
	die('Mising an image');
}
$url = $uploader->upload($imagePath);

if(file_exists($imagePath)) 
{
	unlink($imagePath);
}

if($isUpload)
{
	echo 'image=' . $url;
}
else
{
	echo $url;
} 
}
up("http://phim-vn.com/upload/images/23000_large.jpg", 800,0);