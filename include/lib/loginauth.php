<?php
if (!defined('RK_MEDIA')) die("You does have access to this!");
// Miembro de procesamiento de la información Registro
class LoginAuth {
	public static function isLogin() {
        if(!$_SESSION["RK_Userid"]) {
            return false;
        }else{
            return true;
        }
    }
	public static function isLoginADMIN() {
        if(!$_SESSION["RK_Adminid"]) {
            return false;
        }else{
            return true;
        }
    }
	public static function addUser($username,$password,$confirmpass,$email,$captcha) {
		$username = RemoveHack($username);
		$password = RemoveHack($password);
		$confirmpass = RemoveHack($confirmpass);
		$email = RemoveHack($email);
		$captcha = RemoveHack($captcha);
		if(MySql::dbselect("id","user","username = '$username'")) $arr = 'user';
		else if(MySql::dbselect("id","user","email = '$email'") OR !filter_var($email, FILTER_VALIDATE_EMAIL)) $arr = 'email';
		else if($password !== $confirmpass) $arr = 'confirmpass';
		else if(strlen($password) < 6 OR strlen($password) > 15) $arr = 'password';
		else if($captcha !== $_SESSION["security_code"]) $arr = 'captcha';
		else {
			$codesecurity = rand(1000,9999);
			$password =	md5(md5($password).$codesecurity);
			$lastreg = time();
			MySql::dbinsert("user","username,password,email,codesecurity,lastreg","'$username','$password','$email','$codesecurity','$lastreg'");
			$arr = 'done';
		}
		return $arr;
	}
	public static function loginUser($username,$password,$remember) {
		$username = RemoveHack($username);
		$password = RemoveHack($password);
		$remember = RemoveHack($remember);
		$user = MySql::dbselect("id,username,password,codesecurity","user","username = '$username' OR email = '$username'");
		$upassword = $user[0][2];
		$password = md5(md5($password).$user[0][3]);
		if(!$user) $arr = 'user';
		else if($upassword !== $password) $arr = 'pass';
		else {
			$userid = $user[0][0];
			$lastlogin = time();
			MySql::dbupdate('user',"lastlogin = '$lastlogin'","id = '$userid'");
			// Set session login
			$_SESSION["RK_Userid"] 	= $userid;
			$arr = 'done';
		}
		return $arr;
	}
	public static function loginAdmin($username,$password) {
		$username = RemoveHack($username);
		$password = RemoveHack($password);
		$user = MySql::dbselect("id,username,password,codesecurity,ugroup","user","username = '$username' AND ugroup IN (1,2)");
		$upassword = $user[0][2];
		$password = md5(md5($password).$user[0][3]);
		if(!$user) $arr = 'user';
		else if($upassword !== $password) $arr = 'pass';
		else {
			$userid = $user[0][0];
			$ugroup = $user[0][4];
			// Set session login
			$_SESSION["RK_Admingroup"] = $ugroup;
			$_SESSION["RK_Adminid"] = $userid;
			$_SESSION["RK_Userid"] 	= $userid;
			$arr = 'done';
		}
		return $arr;
	}
	public static function Forgot($email,$captcha) {
		$email = RemoveHack($email);
		$captcha = RemoveHack($captcha);
		if($captcha !== $_SESSION["security_code"]) $arr = 'captcha';
		else {
			$user = MySql::dbselect("id,username,password,codesecurity","user","email = '$email'");
			if(!$user) $arr = 'email';
			else {
				$userid = $user[0][0];
				MySql::dbupdate('user',"forgot = '1'","id = '$userid'");
				$arr = 'done';
			}
		}
		return $arr;
	}
	public static function Edituser($fullname,$facebookid,$captcha) {
		$fullname = RemoveHack($fullname);
		$facebookid = RemoveHack($facebookid);
		$captcha = RemoveHack($captcha);
		if($captcha !== $_SESSION["security_code"]) $arr = 'captcha';
		else {
			$userid = $_SESSION["RK_Userid"];
			MySql::dbupdate('user',"fullname = '$fullname', facebookid = '$facebookid'","id = '$userid'");
			$arr = 'done';
		}
		return $arr;
	}
	public static function logoutUser() {
		if($_SESSION["RK_Userid"]) {
            session_destroy();
			return 1;
        }else{
            return false;
        }
    }
	public static function logoutAdmin() {
		if($_SESSION["RK_Adminid"]) {
            session_destroy();
			return 1;
        }else{
            return false;
        }
    }
	public static function GroupUser($id) {
		if($id == '2') $arr = 'Quản trị viên';
		else if($id == '1') $arr = 'Hợp tác viên';
		else $arr = 'Thành viên thường';
		return $arr;
    }
}
