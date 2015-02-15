<div class="row" style="margin: 30px 0">
    <form action="/response/exec/<?php echo $thread_id ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">以下の内容でレスを返します</label>
            <input type="text" class="form-control" name="comment" value="<?php echo $comment ?>" readonly="readonly">
            <label for="exampleInputEmail1">投稿する画像</label>
            <img src="<?php echo $picture_source ?>">
        </div>
            <input type="hidden" class="form-control" name="csrf_token" value="aaa">
            <input type="hidden" class="form-control" name="picture_id"     value="<?php echo $picture_id ?>">
            <input type="hidden" class="form-control" name="picture_source" value="<?php echo $picture_source ?>">
        <button type="submit" class="btn btn-default">レスを作成する</button>
        <a href="/" class="btn btn-default">戻る</a>
    </form>
</div>
