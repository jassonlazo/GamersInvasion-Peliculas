<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
include View::TemplateView('header');
$page = $geturl[2];
if($page == 'dang-nhap') {
?>
<div style="margin-top:70px"></div>
<div class="p-profile clearfix" id="login_page">
	<div class="user-info">
		<label class="tit">Ingresar</label>
		<div class="middle_left" style="width:39%">
			<form method="post">
				<div class="stat">
					<ul>
						<li><label for="l_user">Tên đăng nhập</label><span><input type="text" id="l_user" class="text" placeholder="Tên đăng nhập hoặc Email"/></span></li>
						<li><label for="l_pass">Mật khẩu</label><span><input type="password" class="text" id="l_pass"/></span></li>
					</ul>
				</div>
				<div class="block_submit" style="margin-left: 35%;text-align: left;padding-left: 20px;">
					<input type="submit" value="Đăng nhập" class="button"/><a href="<?php echo SITE_URL; ?>/thanh-vien/facebook/" id="logFacebook" title="Facebook" class="fb-reg fb" style="width:70px;padding-left: 32px;height: 32px;">Facebook</a><br/><a href="<?php echo get_url(0,'Quên Mật Khẩu','Thành Viên');?>" title="Quên mật khẩu">Quên mật khẩu?</a>
				</div>
			</form>
		</div>
		<div class="middle_right" style="width:57%">
			<div class="stat">
				<ul class="login_rule">
					<li class="fav"><strong>Cập nhật thông tin về các phim yêu thích của bạn</strong><i>Lưu phim để xem sau, đăng ký nhận phim mới qua facebook.</i></li>
					<li class="sh"><strong>Chia sẻ yêu thích</strong><i>Kho phim HD khổng lồ - xem trên điện thoại di động, máy tính bảng hoặc TV thông minh.</i></li>
					<li class="wat"><strong>Cảm nhận cùng bạn bè</strong><i>Dịch vụ xem phim HD không giới hạn với tất cả bạn bè và các trang mạng xã hội, diễn đàn.</i></li>
					</li>
				</ul>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
</div>
<?php } else if($page == 'facebook') { 
require_once(RK_ROOT . '/include/lib/facebook/facebook.php');
$facebook = new Facebook(array(
  "appId"  => "776430565729625",
  "secret" => "417127c83a295734e754a8fd275a3e40",
  'cookie' => true,
));
$user = $facebook->getUser();
if ($user) {
  try {
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}
$loginUrl = $facebook->getLoginUrl(array(
	'scope'	 => 'email,user_birthday,user_location', // Permissions to request from the user
));
if ($user) {
	//print_r($user_profile);
	//LoginAuth::loginUser($user_profile["username"],$_POST['password'],$_POST['remember']);
	$username = $user_profile["username"];
	$user = MySql::dbselect("id,username,password,codesecurity","user","username = '$username' OR email = '$username'");
	if($user) {
		$userid = $user[0][0];
		$lastlogin = time();
		MySql::dbupdate('user',"lastlogin = '$lastlogin'","id = '$userid'");
		$_SESSION["RK_Userid"] 	= $userid;
	}else {
		$username = $user_profile["username"];
		$fullname = $user_profile["name"];
		$email = $user_profile["email"];
		$facebookurl = 'https://www.facebook.com/'.$user_profile["id"];
		$codesecurity = rand(1000,9999);
		$lastreg = time();
		MySql::dbinsert("user","username,email,codesecurity,lastreg,facebookid,fullname","'$username','$email','$codesecurity','$lastreg','$facebookurl','$fullname'");
		$userid = mysql_insert_id();
		$_SESSION["RK_Userid"] 	= $userid;
	}
	header("Location: ".SITE_URL);
} else header("Location: ".$loginUrl);
?>
<?php } elseif($page == 'dang-ky') { ?>
<div style="margin-top:70px"></div>
<div class="p-profile clearfix" id="reg_page">
	<div class="user-info">
		<div class="middle_left" style="width:45%">
			<label class="tit">Đăng ký</label>
			<div class="stat">
				<ul>
					<li>
						<label for="r_username">Tên đăng nhập (<font color="#FF0000">*</font>)</label>
						<span><input type="text" name="r_username" size="30" maxlength="50" id="r_username" class="text"></span>
					</li>
					<li>
						<label for="r_pass">Mật khẩu (<font color="#FF0000">*</font>)</label>
						<span><input type="password" name="r_pass" size="30" maxlength="50" id="r_pass" class="text"></span>
					</li>
					<li>
						<label for="r_confirmpass">Xác nhận lại (<font color="#FF0000">*</font>)</label>
						<span><input type="password" name="r_confirmpass" size="30" maxlength="50" id="r_confirmpass" class="text">
						</span>
					</li>
					<li>
						<label for="r_email">Email (<font color="#FF0000">*</font>)</label>
						<span><input type="text" name="r_email" size="30" maxlength="50" id="r_email" class="text"></span>
					</li>
					<li>
						<label for="r_security">Mã bảo vệ (<font color="#FF0000">*</font>)</label>
						<span><input type="text" class="text" name="r_security" id="r_security"/>
							<img src='<?php echo SITE_URL; ?>/include/lib/security.php?<?php echo time();?>' border=0 style="position: absolute;right: 87px;top: 4px;height: 21px;"/>
						</span>
					</li>
					<li>
						<label style="text-align:right;width:40%">
						<div class="checkbox" style="width:20px;height:13px">
							<input type="checkbox" value="1" id="agree"/><label for="agree"></label>
						</div>
						</label>
						<span>Tôi đồng ý với <a href="<?php echo get_url(0,'Điều khoản','Tin tức');?>">Điều khoản sử dụng</a></span>
					</li>
				</ul>
			</div>
			<div class="block_submit" style="text-align: left;margin-left: 39%;">
				<input type="submit" value="Đăng ký" class="button"/>
			</div>
		</div>
		<div class="middle_right">
			<label class="tit">Tài khoản liên kết</label>
			<div class="stat">
				<ul>
					<li><a href="<?php echo SITE_URL; ?>/thanh-vien/facebook/" id="logFacebook" title="Facebook" class="fb-reg fb">Đăng nhập Facebook</a></li>
				</ul>
			</div>
			<label class="tit" style="margin-top: 25px;">Điều khoản đăng ký</label>
			<div class="stat">
				<ul class="rule_des">
					<li>Không chửi bới, kích động, lôi kéo, bôi nhọ các thành viên khác.</li>
					<li>Không đăng tải hay bình luận các thông tin liên quan tới chính sách của Đảng và Nhà nước CHXHCN Việt Nam.</li>
					<li>Không truyền bá các nội dung văn hoá phẩm bạo lực, đồi trụy, trái với thuần phong mỹ tục Việt Nam.</li>
					<li>Không nói tục chửi bậy khi bình luận.</li>
					<li>Không lợi dụng diễn đàn để tiếp tay cho các hành động vi phạm pháp luật nước CHXHCN Việt Nam.</li>
					<li>Những thành viên cố tình vi phạm hoặc vi phạm nhiều lần quy định sẽ bị loại ra khỏi website.</li>
					<li>Không chấp nhận bất cứ thông tin nào đi ngược lại với thuần phong mỹ tục và truyền thống văn hoá của nước Việt Nam.</li>
					<li>Mọi bài viết có nội dung hoặc chứa liên kết đến các trang web có nội dung vi phạm những điều trên đều sẽ được xóa mà không cần thông báo trước.</li>
				</ul>
			</div>
		</div>
		<div class="clear">
		</div>
	</div>
</div>
<?php } elseif($page == 'quen-mat-khau') { ?>
<div style="margin-top:70px"></div>
<div class="p-profile clearfix" id="lost_pass">
	<div class="user-info">
		<div class="middle_left" style="width:65%">
			<label class="tit">Olvidastes tu contraseña</label>
			<div class="stat">
				<ul>
					<li><label>Email</label><span><input type="text" id="email" class="text"/></span></li>
					<li>
					  <label>Codigo de seguridad</label><span style="position:relative"><input type="text" class="text" name="security" id="security"/><img src='<?php echo SITE_URL; ?>/include/lib/security.php?<?php echo time();?>' border=0 style="position: absolute;right: 5px;top: -1px;height: 20px;"/></span></li>
					<li><label></label><span><input type="submit" value="¿Olvidastes tu contraseña?" class="button"/></span></li>
				</ul>
			</div>
		</div>
		<div class="middle_right" style="width:35%">
			<label class="tit">Recuperar</label>
			<div class="stat" style="color:#414141">
				 Porfavor ingrese su Email correcto para que pueda recuperar su cuenta.</div>
		</div>
	</div>
</div>
<?php } elseif($userid) { 
$user = MySql::dbselect('username,email,lastlogin,lastreg,facebookid,fullname,ugroup,fav_feature,fav_playlist','user',"id = '$userid'");
$fullname = $user[0][5];
$username = $user[0][0];
$email = $user[0][1];
$lastlogin = GetDateT($user[0][2]);
$lastreg = GetDateT($user[0][3]);
$ugroup = LoginAuth::GroupUser($user[0][6]);
$facebookurl = $user[0][4];
if(!$image) $image = TEMPLATE_URL.'images/noavatar.jpg';
?>
<div class="p-profile-cover">
	<!-- <a href="javascript:void(0)" class="change-cover">Thay đổi ảnh bìa</a>-->
</div>
<div class="p-profile clearfix" id="edit_user">
	<div class="basic-info">
		<img src="<?php echo $image;?>" alt=""/>
		<div class="profile-name">
			<span class="name"><?php echo $fullname;?></span><span>Fecha de Ingreso: <?php echo $lastreg;?></span><span>Ultimo Ingreso: <?php echo $lastlogin;?></span><span>Tipo de Cuenta: <font class="level_user_1"><?php echo $ugroup;?></font></span>
		</div>
	</div>
	<div class="user-info">
		<div class="middle_left">
			<label class="tit">Editar Perfil</label>
			<div class="stat">
				<ul>
					<li>
				  <label>Nombre de Cuenta</label><span><input type="text" id="username" class="text" value="<?php echo $username;?>" disabled/></span></li>
					<li><label>Email</label><span><input type="text" id="email" class="text" value="<?php echo $email;?>" disabled/></span></li>
					<?php if($_SESSION["RK_Userid"] == $userid) { ?>
					<li>
					  <label>Nombre Real</label><span><input type="text" id="fullname" class="text" value="<?php echo $fullname;?>"/></span></li>
					<li>
				  <label>Enlace Facebook</label><span><input type="text" id="facebookid" class="text" value="<?php echo $facebookurl;?>"/></span></li>
					<li>
					  <label>Codigo de Verificacion</label><span style="position:relative"><input type="text" class="text" name="security" id="security"/><img src='<?php echo SITE_URL; ?>/include/lib/security.php?<?php echo time();?>' border=0 style="position: absolute;right: 5px;top: -1px;height: 20px;"/></span></li>
					<li><label></label><span><input type="submit" value="Editar Informacion" class="button"/></span></li>
					<?php }else { ?>
					<li><label>Nombre Completo</label><span><input type="text" id="fullname" class="text" value="<?php echo $fullname;?>" disabled/></span></li>
					<li><label>Link de Facebook</label><span><input type="text" id="facebookid" class="text" value="<?php echo $facebookurl;?>" disabled/></span></li>
					<?php } ?>
				</ul>
			</div>
		</div>
		<div class="middle_right">
			<label class="tit">Términos de miembros</label>
			<div class="stat">
				<ul class="rule_des">
					<li>No maldecir, provocar, seducir, difamar a otros miembros.</li>
					<li>No hay comentarios publicados o información relacionadas con las políticas del Partido v Nh República Socialista de Vietnam.</li>
					<li>No difusión de los productos culturales de contenidos violentos, depravados, en contra de los hábitos y costumbres de Vietnam.</li>
					<li>No maldecir al comentar.</li>
					<li>No aprovechando el foro para ABET la violación de la ley de la República Socialista de Vietnam.</li>
					<li>Los miembros violación deliberada o repetidas violaciones de las disposiciones serán removidos del sitio web.</li>
					<li>No acepte ninguna información contraria a los usos y costumbres de v cultural tradicional de Vietnam.</li>
					<li>Todos los artículos con contenido o contienen enlaces a sitios con contenido en violación de la m por encima será eliminado sin previo aviso.</li>
					<li></li>
			  </ul>
		  </div>
		</div>
		<div class="clear">
		</div>
	</div>
</div>
<?php if($_SESSION["RK_Userid"] == $userid) { ?>
<?php if($user[0][7]) { ?>
<div class="bar clearfix" rel="phim_xemsau">
	<h2 class="title_block">Phim xem sau</h2>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="phim_xemsau" class="clearfix">
			<?php echo li_filmMEM(17,$user[0][7],'fav_feature');?>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<?php } if($user[0][8]) { ?>
<div class="bar clearfix" rel="phim_yeuthich">
	<h2 class="title_block">Phim yêu thích</h2>
</div>
<div class="rich_list clearfix home_list_movie">
	<div class="scroll_list">
		<ul id="phim_yeuthich" class="clearfix">
			<?php echo li_filmMEM(17,$user[0][8],'fav_playlist');?>
		</ul>
	</div>
	<div class="wrap_prev_block">
		<a id="de_cu_control_prev" href="#" class="prev_block"></a>
	</div>
	<div class="wrap_next_block">
		<a id="de_cu_control_next" href="#" class="next_block"></a>
	</div>
</div>
<?php } ?>
<?php
}
}
include View::TemplateView('footer');
?>
