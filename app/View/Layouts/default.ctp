<!DOCTYPE html>
<html>
<head>
	<title>けいじばん</title>

<!-- ToDo : CDN配信じゃなくて手元から -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>

<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="/js/common.js"></script>

</head>
<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="/">けいじばん</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
          <ul class="nav navbar-nav">
            <?php if ($USER): ?>
                <li><a href="#"><?php echo ($USER['name']); ?>としてログイン中(last login:<?php echo date("Y年 n月 j日" , $USER['updated_at']); ?>)</a></li>
                <li><?php echo $this->Html->image($USER['image'], array('height' => 45, 'width' => 45)); ?></li>
                <li><a href="/logout">ログアウト</a></li>
            <?php else: ?>
                <li><a href="/login">ログイン</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>


	<div class="container" style="margin-top: 100px">
		<?php echo $this->fetch('content'); ?>
	</div>

<div id="modal" title="アルバムから画像を選択して下さい"></div>

</body>

<!-- Facebook SDK -->
<script>
window.fbAsyncInit = function() {
    FB.init({
        appId      : '924244504263211',
            xfbml      : true,
            version    : 'v2.2'
    });
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<!-- Facebook SDK -->


</html>
