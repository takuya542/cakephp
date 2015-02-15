<?php if ( isset ($invalidParams) ): ?>
<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
    入力値が正しくありません
</div>
<?php endif; ?>

<?php if ( isset ($invalidRequest) ): ?>
<div class="alert alert-danger" role="alert">
  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
  <span class="sr-only">Error:</span>
    不正なリクエストです
</div>
<?php endif; ?>


<!-- スレ立て -->


<!-- スレ立て -->
<!-- ToDo:部品化 -->
<div class="row" style="margin: 30px 0">
    <form action="/create/confirm" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">スレッドを作成する</label>
            <input type="text" class="form-control" name="title" placeholder="スレッドのタイトルを入力して下さい">
        </div>
        <button type="submit" class="btn btn-default">確認画面へ</button>
    </form>
</div>

<?php foreach ($thread_list as $thread): ?>
<div class="row">

    <h2>スレタイ:<?php echo $thread['title']; ?></h2>
    <h2>立てたやつ:<?php echo $thread['create_user']['name']; ?></h2>
    <h2>更新日時:<?php echo $thread['updated_at']; ?></h2>

    <?php foreach ($thread['comments'] as $comment): ?>
    <ul>
        <li>コメント:<?php echo $comment['comment']; ?></li>
        <li>画像投稿:<img src="<?php echo $comment['image']; ?>"></li>
        <li>誰:<?php echo $comment['user_name']; ?></li>
        <li>id:<?php echo $comment['user_id']; ?></li>
    </ul>
    <?php endforeach; ?>
<a href="/detail/<?php echo $thread['id']; ?>">もっと見る</a>


<div class="row" style="margin: 30px 0">
    <form action="/response/confirm/<?php echo $thread['id'] ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">レスする</label>
            <input type="text" class="form-control" name="comment" placeholder="レスを入れて">
        </div>
        <a href="#albumModal" id="albumModal" class="btn btn-default" onClick="albumModal()">写真をせんたく</a>
        <input type="hidden" id="picture_source" name="picture_source">
        <input type="hidden" id="picture_id"     name="picture_id">
        <button type="submit" class="btn btn-default">確認画面へ</button>
    </form>
</div>



</div>
<?php endforeach; ?>
