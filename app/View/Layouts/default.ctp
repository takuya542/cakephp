<!DOCTYPE html>
<html>
<head>
	<title>test</title>
</head>
<body>
	<div id="container">
		<div id="header"></div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
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
