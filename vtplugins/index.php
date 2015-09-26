<?php
include('./vtplugins.php');
$plugins = new VTPlugin();
$plugins->url = 'https://www.youtube.com/watch?v=e-ORhEE9VVg';
$plugins->server = 'youtube'; //'picasaweb, googledocs';
$plugins->on_cache = true;
$plugins->key_cache = base64_encode($plugins->server.$plugins->url);
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
		<script type="text/javascript" src="/jwplayer/jwplayer.js"></script>
		<script type="text/javascript">jwplayer.key="N8zhkmYvvRwOhz4aTGkySoEri4x+9pQwR7GHIQ=="; // Key bản quyền</script>
	</head>
	<body>
	<div id="myElement">Loading the player...</div>
	<script type="text/javascript">
	    jwplayer("myElement").setup({
	    	primary: 'html5',
	    	<?php echo $jwplayer;?>
			width: 700,
			height: 450,
			skin: '/jwplayer/skins/glow.xml',
			abouttext: 'VTPlugins <?php echo $plugins->ver;?>',
			aboutlink: 'http://fb.com/rickypro.info'
	    });
	</script>
	</body>
</html>