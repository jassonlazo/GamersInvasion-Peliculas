<script type="text/javascript" src="http://127.0.0.1/player/rickypro.js"></script>
	<script type="text/javascript">jwplayer.key="vmAEdu5OJSCiJfE3aWibJZ6338lN/A7tybduu0fdEfxYgi7AkWpjckRUFeI=";</script>
    <div id='player'></div>
	<script type='text/javascript'>
	var link = '<?php echo $_GET["link"]; ?>';
		jwplayer('player').setup({
			file: link,
			type: 'video/mp4',
			width: '900px',
			aspectratio: '16:9',
			skin: 'roundster',
			logo: {
				file: "http://127.0.0.1/player/logo.png",
				link: 'http://facebook.com/jasson.lazo',
			},
			sharing: {
      			code: encodeURI("<iframe src='http://seo.blogk.net/embed/MEDIAID.html' />"),
      			link: "http://seo.blogk.net",
   			}
		});
	</script>