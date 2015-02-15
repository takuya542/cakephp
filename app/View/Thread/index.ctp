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
<!-- ToDo:部品化 -->
<div class="row" style="margin-top: 10px; margin-bottom: 30px">
    <form action="/create/confirm" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">スレッドを作成する</label>
            <input type="text" class="form-control" name="title" placeholder="スレッドのタイトルを入力して下さい">
        </div>
        <button type="submit" class="btn btn-primary">確認画面へ</button>
    </form>
</div>
<hr>

<?php foreach ($thread_list as $thread): ?>
<div class="row" style="margin-bottom: 20px">

    <table class="table">
        <caption>スレッドID : <?php echo $thread['id']; ?></caption>
        <caption>スレッド名 : <?php echo $thread['title']; ?></caption>
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>コメント</th>
                <th>画像投稿</th>
                <th>更新</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($thread['comments'] as $comment): ?>
            <tr>
                <th scope="row"><?php echo $comment['user_id']; ?></th>
                <td><?php echo $comment['user_name']; ?></td>
                <td><?php echo $comment['comment']; ?></td>
                <td>
                    <?php if ( isset ($comment['image']) ): ?>
                        <img src="<?php echo $comment['image']; ?>" width=200 height=200>
                    <?php else: ?>
                        なし
                    <?php endif; ?>
                </td>
                <td><?php echo date("Y年 n月 j日" , $comment['created_at']); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="/detail/<?php echo $thread['id']; ?>" class="btn btn-default" style="text-align: right">もっと見る</a>
</div>

<div class="row" style="margin-bottom: 50px">
    <form action="/response/confirm/<?php echo $thread['id'] ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">レスする</label>
            <input type="text" class="form-control" name="comment" placeholder="内容を必ず入力して下さい">
        </div>
        <?php if ($USER): ?>
            <a href="#albumModal" id="albumModal" class="btn btn-default" onClick="albumModal(this)">写真を投稿</a>
        <?php else: ?>
            <a href="/login/confirm" class="btn btn-default"">写真を投稿</a>
        <?php endif; ?>
        <input type="hidden" id="picture_source" name="picture_source">
        <input type="hidden" id="picture_id"     name="picture_id">
        <button type="submit" class="btn btn-primary">確認画面へ</button>
    </form>
</div>
<hr>
<?php endforeach; ?>

<nav>
  <ul class="pager">

    <?php if ( $pager['has_previous'] ): ?>
        <li><a href="/pages/<?php echo ($pager['page']-1); ?>">Previous</a></li>
    <?php else: ?>
        <li class="disabled"><a href="#">Previous</a></li>
    <?php endif; ?>

    <?php if ( $pager['has_next'] ): ?>
        <li><a href="/pages/<?php echo ($pager['page']+1); ?>">Next</a></li>
    <?php else: ?>
        <li class="disabled"><a href="#">Next</a></li>
    <?php endif; ?>

  </ul>
</nav>
