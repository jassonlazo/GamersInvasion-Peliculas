<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
?>
	<div class="home_tag clearfix">

                 <center>
                   <font color='black'>Gracias a todos lo que nos apoyaron GamersInvasion</font>
                 </center>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function () {
	$("#list_update").mCustomScrollbar({scrollButtons:{enable:false},theme:"light-thick"});
});
</script>
<div id="plugin_lightout" class="lightout"></div>
<div class="footer_one">
	<div class="main-width clearfix">
		<?php
		if(IS_LOGIN == '1') {
			$userid = $_SESSION["RK_Userid"];
			$username = one_data('username','user',"id = '$userid'");
		?>
		<div class="footer_mess">Bienvenido <span class="level_user_1"><?php echo $username;?></span>. Divierte viendo nuestras peliculas.</div>
		<?php }else {?>
		<div class="let_reg left">
			<h5>Invitado</h5>
			<p>
				Registrate Gratis
			</p>
			<a href="<?php echo get_url(0,'Đăng ký','Thành Viên');?>" class="btn_let_reg">Registrarse</a>
		</div>
		<div class="let_log right">
			<h5>Miembros</h5>
			<p>
				Inicia Sesion Ahora</p>
			<a href="<?php echo get_url(0,'Đăng nhập','Thành Viên');?>" class="btn_let_log">Ingresar</a>
		</div>
		<?php } ?>
	</div>
</div>
<div class="footer_two">
	<div class="main-width clearfix">
		<div class="spec_footer first">
		 <h4>Informacion</h4> 
		 <p>GamersInvasion - Servicio de peliculas en linea de rapido acceso , <a target="_blank" href="http://phim-vn.com" title="xem phim hay"><strong>Peliculas en HD </strong></a>la seleccion de peliculas con calidad de contenido web..
		 </p> 		 
			<p>
				En la actualidad hay <strong><?php echo config_site('footer_viewmem');?></strong> miembros en GamersInvasion Pelicula</p>
		 <h4>
		 <a href="http://phim-vn.com/" title="Phim hay">Peliculas</a>, <a href="http://phim-vn.com/the-loai/phim-hanh-dong/" title="Phim Hành Động"><strong>Peliculas de ACCION</strong></a>, <a href="http://phim-vn.com/the-loai/phim-ma-kinh-di/" title="Phim ma kinh dị"><strong>peliculas de TERROR</strong></a>, <a href="http://phim-vn.com/the-loai/phim-kiem-hiep/" title="Phim kiếm hiệp"><strong>Peliculas de DRAMA</strong></a>, <a href="http://phim-vn.com/quoc-gia/phim-han-quoc/" title="Phim hàn quốc"><strong>peliculas de ROMANCE</strong></a> , <a href="http://phim-vn.com/the-loai/phim-tinh-cam/" title="Phim tình cảm">peliculas COREANAS</a> 
		 </h4>
		</div>
		<div class="spec_footer year_footer">
			<h4>Soporte</h4>
			<ul>
				<li><a href="<?php echo get_url(0,'Hướng dẫn','Tin tức');?>">Terminos y condiciones</a></li>
				<li><a href="<?php echo get_url(0,'Điều khoản','Tin tức');?>">Acerca de </a></li>
                               
<script src="//images.dmca.com/Badges/DMCABadgeHelper.min.js"></script><a href="http://www.dmca.com/Protection/Status.aspx?ID=6597f96b-8730-4b8a-981b-99f6a221e15e" title="DMCA.com Protection Program" class="dmca-badge"> <img src ="//images.dmca.com/Badges/_dmca_premi_badge_2.png?ID=6597f96b-8730-4b8a-981b-99f6a221e15e"  alt="DMCA.com Protection Status" /></a>
                                
			</ul>
		</div>
		<div class="spec_footer">
			<h4>Comparte</h4>
			<p>Usted tiene peliculas o videos. Comparta las peliculas, subiendo a la comunidad de Peliculas Online</p>
			<ul>
				<li><a href="#">Upload</a></li>
				<li><a href="<?php echo SITE_URL; ?>/sitemap.xml">Sitemap</a></li>
		</ul>
		</div>
		<div class="spec_footer last">
			<h4>Contacto</h4>
			<ul>
				<li><a href="mailto:<?php echo config_site('site_mail');?>">Email: <?php echo config_site('site_mail');?></a></li>
				
				<li><a href="ymsgr:sendIM?<?php echo config_site('site_yahoo');?>">Soporte: <img src="http://opi.yahoo.com/online?u=<?php echo config_site('site_yahoo');?>&amp;m=g&amp;t=1&amp;1=us" alt="ho_tro_1"/></a></li>
			        
                    </ul>
			<ul>
			<li>Facebook</li>
                <a href="http://facebook.com/Jasson.lazo" rel="dofolow" title="Facebook Jasson Lazo">Jasson Lazo</a>
                

			</ul>
		</div>
	</div>
</div>
<!--/footer_two-->
<div class="footer_three">
	<div class="main-width">
		<p>
			<?php echo config_site('footer_text');?>
		</p>
	</div>
</div>
<div class="fixed-top" style="position: fixed; right: 5px; z-index: 9998; bottom: 30px;">
	<a class="support box-check" href="<?php echo config_site('facebook_url');?>" target="_blank" title="Kết nối với chúng tôi trên Facebook"></a>
	<div style="clear: both;">
	</div>
	<a class="support box-email" href="#" title="Báo lỗi/ Góp ý"></a>
	<div style="clear: both;">
	</div>
	<a class="support box-top" href="#" title="Lên đầu trang"></a>
</div>
<!-- Begin Popup -->
<div id="loading">Cargando Espere un momento</div>
<div class="pop-overlay"></div>
<div class="box-pop" id="login_box">
	<div class="wap-box">
		<div class="wap-box-content">
			<div class="box-head">
				<div class="hdonline-logo">
				</div>
			</div>
			<div class="box-content">
				<div class="form">
					<form method="post">
						<div class="row">
							<span><label> *</label>
							Nombre de Usuario</span>
							<input type="text" class="input" id="l_user" placeholder="Nombre de usuario o correo electrónico"/>
						</div>
						<div class="row">
							<span><label>*</label>
							Contraseña</span>
							<input type="password" class="input" id="l_pass"/>
						</div>
						<div class="row">
							<span class="ie_hide">&nbsp;</span>
							<div class="checkbox">
								<input id="l_rmb" type="checkbox"/>
							  <label for="l_rmb">Recordar Cuenta</label>
							</div>
							<div class="clear">
							</div>
						</div>
						<div class="row fborder">
							<span>&nbsp;</span><input type="submit" class="btn-login" value="Ingresar"/><a href="<?php echo get_url(0,'Quên Mật Khẩu','Thành Viên');?>">Olvidastes tu Contraseña?</a>
						</div>
						<div class="row">
							<span class="bold">No tienes cuenta?</span>
						  <input type="button" class="btn-reg" onclick="window.location.href='<?php echo get_url(0,'Đăng ký','Thành Viên');?>'" value="Registrase"/><input type="button" class="btn-reg fb" onclick="window.location.href='<?php echo get_url(0,'facebook','Thành Viên');?>'" value="Facebook"/>
						</div>
					</form>
				</div>
			</div>
		</div>
		<a href="#" class="close-box"></a>
	</div>
</div>
<!-- REGBOX-->
<div class="box-pop" id="reg_box">
	<div class="wap-box">
		<div class="wap-box-content">
			<div class="box-head">
				<div class="hdonline-logo">
				</div>
			</div>
			<div class="box-content">
				<div class="form">
					<form method="post">
						<div class="row">
							<span><label> *</label>
							Usuario</span>
						  <input type="text" class="input" id="r_username"/>
						</div>
						<div class="row">
							<span><label> *</label>
						  Password</span>
						  <input type="password" class="input" id="r_pass"/>
						</div>
						<div class="row">
							<span><label> *</label>
							Confirmar Password
							</span>
							<input type="password" class="input" id="r_confirmpass"/>
						</div>
						<div class="row">
							<span><label> *</label>Email</span><input type="text" class="input" id="r_email" placeholder="El correo electrónico no será cambiado"/>
						</div>
						<div class="row">
							<span><label> *</label>
							Codigo de Seguridad</span>
							<input id="r_security" type="text" class="input"/><img id="reg_box_ser" src='<?php echo SITE_URL; ?>/include/lib/security.php?<?php echo time();?>' border="0" title="Mã bảo vệ" style="position: absolute;padding-top: 6px;right: 99px;"/>
						</div>
						<div class="row">
							<span class="ie_hide">&nbsp;</span>
							<div class="checkbox">
								<input type="checkbox" value="1" id="agree"/>
								<label for="agree">Acepto los terminos y condiciones<a href="<?php echo get_url(0,'Điều khoản','Tin tức');?>" target="_blank" title="Terminos y condiciones">[Leer]</a></label>
							</div>
							<div class="clear">
							</div>
						</div>
						<div class="row fborder">
							<span>&nbsp;</span><input type="submit" class="btn-login" value="Registrarse"/>
						</div>
					</form>
				</div>
			</div>
		</div>
		<a href="#" class="close-box"></a>
	</div>
</div>
<div id="popup-section" style="width: 385px" class="box-pop">
	<div class="popup-content">
		<div class="popup-header" id="popup-header">
			<a href="#" class="cancel close-box" title="Cancel"></a>
		</div>
		<div id="popup-body" class="brokenpopup">
			<div class="popup-title">
				Báo lỗi/Góp ý
			</div>
			<div class="popup-des">
				Bạn gặp khó khăn khi sử dụng? Hãy báo lỗi cho chúng tôi‏
			</div>
			<div class="broken_popup">
				<label>Chủ đề</label><span class="custom-select">
				<select id="broken_type" name="broken_type" style="width: 230px;">
					<option value="">Chọn chủ đề</option>
					<option value="1">Báo lỗi phim</option>
					<option value="2">Báo lỗi video</option>
					<option value="3">Báo lỗi hệ thống</option>
					<option value="4">Yêu cầu chức năng</option>
					<option value="5">Khác</option>
				</select>
				</span>
			</div>
		</div>
	</div>
</div>