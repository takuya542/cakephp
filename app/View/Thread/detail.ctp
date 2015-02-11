<h1>detail</h1>

<!-- スレ立て -->
<!-- ToDo:部品化 -->
<div class="row" style="margin: 30px 0">
    <form action="/create/confirm" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">スレ作成</label>
            <input type="text" class="form-control" name="title" placeholder="すれたいを入れて">
        </div>
        <button type="submit" class="btn btn-default">確認画面へ</button>
    </form>
</div>

<div class="row" style="margin: 30px 0">
    <h1>すれっど情報</h1>
    <ul>
        <li>すれたい:<?php echo $thread['title']; ?></li>
    </ul>
</div>

<h1>たいむらいん</h1>
<?php foreach ($comments as $comment): ?>
<div class="row">
    <ul>
        <li>コメント:<?php echo $comment['comment']; ?></li>
        <li>誰:<?php echo $comment['name']; ?></li>
    </ul>
</div>
<?php endforeach; ?>

<div class="row" style="margin: 30px 0">
    <form action="/response/confirm/<?php echo $thread['id'] ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">レスする</label>
            <input type="text" class="form-control" name="comment" placeholder="レスを入れて">
        </div>
        <button type="submit" class="btn btn-default">確認画面へ</button>
    </form>
</div>

