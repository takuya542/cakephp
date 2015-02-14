<!DOCTYPE html>
<html>
<head>
	<title>けいじばん</title>

<!-- ToDo : CDN配信じゃなくて手元から -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <?php if ($USER): ?>
                <li><a href="#"><?php echo ($USER['name']); ?>としてログイン中</a></li>
                <li><?php echo $this->Html->image($USER['image'], array('height' => 45, 'width' => 45)); ?></li>
                <li><a href="/logout">ログアウト</a></li>
            <?php else: ?>
                <li><a href="/login">ログイン</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>


	<div class="container" style="margin-top: 50px">
		<?php echo $this->fetch('content'); ?>
	</div>




 <div class="modal" id="picModal" tabindex="-1" role="dialog" aria-labelledby="picModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">
            <span aria-hidden="true">&#215;</span><span class="sr-only">閉じる</span>
          </button>
          <h4 class="modal-title">Static Modal タイトル</h4>
        </div><!-- /modal-header -->
        <div class="modal-body">
          <p class="recipient">本文</p>
          <p>
            <a class="btn btn-info" href="#001" data-dismiss="modal">data-dismiss 有り</a>
            <a class="btn btn-info" href="#002">data-dismiss 無し</a>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
          <button type="button" class="btn btn-primary">変更を保存</button>
        </div>
      </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
  </div> <!-- /.modal -->



















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
