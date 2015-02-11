<h1>create / confirm</h1>

<!-- スレ立て -->
<!-- ToDo:部品化 -->
<div class="row" style="margin: 30px 0">
    <form action="/create/exec" method="post">
        <div class="form-group">
            <label for="exampleInputEmail1">すれたい確認</label>
            <input type="text" class="form-control" name="title" value="<?php echo $title ?>">
        </div>
            <input type="hidden" class="form-control" name="csrf_token" value="aaa">
        <button type="submit" class="btn btn-default">つくるぜ</button>
    </form>
</div>
