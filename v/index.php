<?php if(empty($_GET['vid'])){exit();} 
//header("Content-type: video/webm");
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  <title>Video | Video.js HTML5 Video Player</title>

  <!-- Chang URLs to wherever Video.js files will be hosted -->
  <link href="video-js.min.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
  <script src="video.min.js"></script>

  <!-- Unless using the CDN hosted version, update the URL to the Flash SWF -->
  <script>
    _V_.options.flash.swf = "video-js.swf";
  </script>


</head>
<body>

  <video id="video_1" class="video-js vjs-default-skin" controls preload="none" width="660" height="340"
      poster="poster/<?php echo $_GET['vid']; ?>.png"
      data-setup="{}">
    <source src="v/<?php echo $_GET['vid']; ?>.mp4" type='video/mp4' />
    <source src="v/<?php echo $_GET['vid']; ?>.webm" type='video/webm' />
    <source src="v/<?php echo $_GET['vid']; ?>.ogv" type='video/ogg' />
    <track kind="Subtitles" src="s/<?php echo $_GET['vid']; ?>.vtt" srclang="zh" label="简体中文" />
  <track kind="captions" src="c/<?php echo $_GET['vid']; ?>.vtt" srclang="zh" label="简体中文" /></video>

</body>
</html>
