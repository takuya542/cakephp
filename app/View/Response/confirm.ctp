<h1>response / confirm </h1>

<div class="row" style="margin: 30px 0">
    <form action="/response/exec/<?php echo $thread_id ?>" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">レス確認</label>
            <input type="text" class="form-control" name="comment" value="<?php echo $comment ?>">
        </div>
            <input type="hidden" class="form-control" name="csrf_token" value="aaa">
        <button type="submit" class="btn btn-default">れするぜ</button>
    </form>
</div>
