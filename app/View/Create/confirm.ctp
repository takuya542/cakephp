<!-- スレ立て -->
<!-- ToDo:部品化 -->
<div class="row" style="margin: 30px 0">
    <form action="/create/exec" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">このタイトルでスレッドを作成します</label>
            <input type="text" class="form-control"   name="title" value="<?php echo $title ?>" readonly="readonly">
            <input type="hidden" class="form-control" name="csrf_token" value="aaa">
        </div>
        <button type="submit" class="btn btn-default">作成する</button>
        <a href="/" class="btn btn-default">戻る</a>
    </form>
</div>
