<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title>Saved Media | Youtube Downloader</title>
    <meta name="keywords" content="Save media, Saved media, saved-media.com, Video downloader, download youtube, video download, youtube video, youtube downloader, download youtube FLV, download youtube MP4, download youtube 3GP, download video from youtube, saved media youtube, save video from youtube, download music from youtube, download mp3 file from youtube, youtube mp3, youtube downloader, download youtube mp3, save media from youtube, youtube video download" />
    <meta name="description" content="Saved media, download high quality video from Youtube"/>

	<link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
	 <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-download {
        max-width: 300px;
		position:relative;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-download .form-download-heading,
      .form-download .checkbox {
        margin-bottom: 10px;
        text-align: center;
      }
      .form-download input[type="text"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }
      .userscript {
        float: right;
        margin-top: 5px
      }

    </style>
    <!-- Google Analytics -->
    <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48215380-1', 'saved-media.com');
  ga('send', 'pageview');

</script>
    
	</head>
<body>
<!--Facebook like-->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<form class="form-download" method="get" id="download" action="getvideo.php">
		<h1 class="form-download-heading">Youtube Downloader</h1>
		<input type="text" name="videoid" id="videoid" size="40" placeholder="Youtube Url" />
		<input class="btn btn-primary" type="submit" name="type" id="type" value="Download" />
        <p></p>
		<p>Put in Youtube Url, any Url from Youtube</p>
		<p>Example: http://www.youtube.com/watch?v=YFpmgByyWFE</p>

    <!-- @TODO: Prepend the base URI -->
    <?PHP
    include_once('config.php');
    function is_chrome(){
	$agent=$_SERVER['HTTP_USER_AGENT'];
	if( preg_match("/like\sGecko\)\sChrome\//", $agent) ){	// if user agent is google chrome
		if(!strstr($agent, 'Iron')) // but not Iron
			return true;
	}
	return false;	// if isn't chrome return false
    }
    if(($config['feature']['browserExtensions']==true)&&(is_chrome()))
      echo '<a href="ytdl.user.js" class="userscript btn btn-mini" title="Install chrome extension to view a \'Download\' link to this application on Youtube video pages."> Install Chrome Extension </a>';
    ?>
    <div style="position:absolute; top:50px; right:-150px; min-width:50px; min-height:50px;">
    	<div class="fb-like" data-href="http://saved-media.com/" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div><br />
        <p></p>
        <div class="g-plusone"></div>
        <!--Google +-->
        <script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/platform.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>
		<br />
        <a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="en">Tweet</a>
        <!--twitter-->
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

    </div>
  </form>
  
</body>
</html>
