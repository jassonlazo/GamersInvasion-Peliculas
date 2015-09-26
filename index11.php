<?php
include('src/vtplugins.php');
$plugins = new VTPlugin();
$plugins->url = 'https://picasaweb.google.com/101287294653338782659/T3?authkey=Gv1sRgCOPUxuCYxfbqKA#6108610193281994194';
$plugins->server = 'picasaweb';
$plugins->on_cache = true;
$arrqt = $plugins->result();
foreach ($arrqt as $key => $value) {
	if($value['type'] == 'image/gif')
		$image = 'image: "'.$value['url'].'",';
	if($key >= 360)
		$file[] = (string)'{label: "' . $key . 'p", file: "' . $value['url'] . '/vantoan.mp4"}';
}
$jwplayer = (string)'sources: [' . @implode(",",$file) . '],';
?>
<html>
	<head>
		<title>Demo JWPlayer - VTPlugins</title>
		<script type="text/javascript" src="./jwplayer/jwplayer.js"></script>
		<script type="text/javascript">jwplayer.key="N8zhkmYvvRwOhz4aTGkySoEri4x+9pQwR7GHIQ=="; // Key bản quyền</script>
	</head>
	<body>
	<div id="myElement">Loading the player...</div>
	<script type="text/javascript">
	    jwplayer("myElement").setup({
	    	primary: 'html5',
	    	<?php echo $image;?>
	    	<?php echo $jwplayer;?>
			width: 700,
			height: 450,
	    });
	</script>
	</body>
</html>