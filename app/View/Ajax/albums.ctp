<div id="album-list">
    <?php foreach ($albums as $album): ?>
        <button class="btn btn-default btn-lg btn-block" onClick="picModal(<?php echo $album['AlbumData']['album_id'] ?>)">
            <?php echo $album['AlbumData']['name'] ?>
        </button>
    <?php endforeach; ?>
</div>
