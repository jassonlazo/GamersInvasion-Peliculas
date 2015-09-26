<html>
<head>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body>

<table class="table table-bordered">
 
<form action="gettv.php" method="post">

Zing TV
 <textarea class="form-control" rows="1" cols="1" name="diachia"></textarea>
 
<center><input class="btn btn-success" type="submit" value="OK BABY"></center>

</form>
<center><button class="btn btn-warning" onclick="location.href='http://phim-vn.com/phimvip.php'">Chuyển sang Leech PhimVN</button></center>
</table>
 

<?php
if(isset($_POST['diachia']))
{
	
echo '<table class="table table-bordered">';
echo '<form action="#" method="post">';

function get_curl($link){
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $link);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: text/html','charset:UTF-8'));
	curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
	curl_setopt($curl, CURLOPT_REFERER, 'http://google.com');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	$data = curl_exec($curl);
	curl_close($curl);
	return $data;
}

//Start TV.ZING.VN
class zing {
    public $_text = '';
    public $_key = 'f_pk_ZingTV_1_@z';
    public $_iv = 'f_iv_ZingTV_1_@z';
    public $_result = '';
    public function _decrypt(){
        if($this->_text != ''){
            $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv_size = mcrypt_enc_get_iv_size($cipher);
            if(mcrypt_generic_init($cipher, $this->_key, $this->_iv) != -1){
                $cipherText = mdecrypt_generic($cipher,$this->_hexToString($this->_text));
                mcrypt_generic_deinit($cipher);
                $this->_result = $cipherText;
                return true;
            }else{
                return false;
            }
        }
    }
    protected function _hexToString($hex){
        if(!is_string($hex)){
            return null;
        }
        $char = '';
        for($i=0; $i<strlen($hex);$i+=2){
            $char .= chr(hexdec($hex{$i}.$hex{($i+1)}));
        }
        return $char;
    }
}

$zing = get_curl($_POST["diachia"]);
preg_match_all('/xmlURL: "([^>]*)",/U', $zing, $link_zing);
$xml = str_replace( 'media', 'media-embed', $link_zing[1][0]);
$sourceXML = file_get_contents('compress.zlib://'.$xml);
				
$f360 = explode('<source streamingType="1"><![CDATA[',$sourceXML);$f360=explode(']]></source>',$f360[1]);$getf360=new zing; $getf360->_text=''.$f360[0].''; if($getf360->_decrypt()!=false);
if($getf360->_result != ''){
	$f480 = explode('<f480 streamingType="1"><![CDATA[',$sourceXML);$f480=explode(']]></f480>',$f480[1]);$getf480=new zing; $getf480->_text=''.$f480[0].''; if($getf480->_decrypt()!=false);
	$f720 = explode('<f720 streamingType="1"><![CDATA[',$sourceXML);$f720=explode(']]></f720>',$f720[1]);$getf720=new zing; $getf720->_text=''.$f720[0].''; if($getf720->_decrypt()!=false);
	$link = '720p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf720->_result.'</textarea><br> 480p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf480->_result.'</textarea><br> 360p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf360->_result.'</textarea>';
} else {
	$f360 = explode('<source streamingType="2"><![CDATA[',$sourceXML);$f360=explode(']]></source>',$f360[1]);$getf360=new zing; $getf360->_text=''.$f360[0].''; if($getf360->_decrypt()!=false);
	if($getf360->_result != ''){
		$f480 = explode('<f480 streamingType="2"><![CDATA[',$sourceXML);$f480=explode(']]></f480>',$f480[1]);$getf480=new zing; $getf480->_text=''.$f480[0].''; if($getf480->_decrypt()!=false);
		$f720 = explode('<f720 streamingType="2"><![CDATA[',$sourceXML);$f720=explode(']]></f720>',$f720[1]);$getf720=new zing; $getf720->_text=''.$f720[0].''; if($getf720->_decrypt()!=false);
		$link = '720p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf720->_result.'</textarea><br> 480p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf480->_result.'</textarea><br> 360p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf360->_result.'</textarea>';
	} else {
		$f360 = explode('<source streamingType="3"><![CDATA[',$sourceXML);$f360=explode(']]></source>',$f360[1]);$getf360=new zing; $getf360->_text=''.$f360[0].''; if($getf360->_decrypt()!=false);
		$f480 = explode('<f480 streamingType="3"><![CDATA[',$sourceXML);$f480=explode(']]></f480>',$f480[1]);$getf480=new zing; $getf480->_text=''.$f480[0].''; if($getf480->_decrypt()!=false);
		$f720 = explode('<f720 streamingType="3"><![CDATA[',$sourceXML);$f720=explode(']]></f720>',$f720[1]);$getf720=new zing; $getf720->_text=''.$f720[0].''; if($getf720->_decrypt()!=false);
		$link = '720p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf720->_result.'</textarea><br> 480p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf480->_result.'</textarea><br> 360p: <textarea class="form-control" rows="1" cols="1"  onclick="this.focus();this.select()">'.$getf360->_result.'</textarea>';
	}
}

echo '<tr><td>'.$link.'</tr></td>';
//End TV.ZING.VN
echo '</form>';
echo '</table>';
}
else
{
	echo "";
}

?>

</body>
</html>