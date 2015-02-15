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


<div class="row" style="margin: 30px 0">
<table class="table">
    <caption>スレッド:<?php echo $thread['title']; ?></caption>
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
        <?php foreach ($comments as $comment): ?>
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
</div>

<div class="row" style="margin: 30px 0">
    <form action="/response/confirm/<?php echo $thread['id'] ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">レスする</label>
            <input type="text" class="form-control" name="comment" placeholder="レスを入れて">
        </div>
        <a href="#albumModal" id="albumModal" class="btn btn-default" onClick="albumModal()">写真を投稿</a>
        <input type="hidden" id="picture_source" name="picture_source">
        <input type="hidden" id="picture_id"     name="picture_id">
        <button type="submit" class="btn btn-default">確認画面へ</button>
    </form>
</div>
