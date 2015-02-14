<h1>index /list page</h1>

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

<?php foreach ($thread_list as $thread): ?>
<div class="row">

    <h2>スレタイ:<?php echo $thread['title']; ?></h2>
    <h2>立てたやつ:<?php echo $thread['create_user']['name']; ?></h2>
    <h2>更新日時:<?php echo $thread['updated_at']; ?></h2>

    <?php foreach ($thread['comments'] as $comment): ?>
    <ul>
        <li>コメント:<?php echo $comment['comment']; ?></li>
        <li>誰:<?php echo $comment['name']; ?></li>
    </ul>
    <?php endforeach; ?>
<a href="/detail/<?php echo $thread['id']; ?>">もっと見る</a>


<div class="row" style="margin: 30px 0">
    <form action="/response/confirm/<?php echo $thread['id'] ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">レスする</label>
            <input type="text" class="form-control" name="comment" placeholder="レスを入れて">
        </div>
        <button type="submit" class="btn btn-default">確認画面へ</button>
        <a data-toggle="modal" id="picModal" href="#picModal" class="btn btn-default">写真をせんたく</a>
    </form>
</div>



</div>
<?php endforeach; ?>
