<div id="album-list">
    <?php foreach ($albums as $album): ?>
        <button class="btn btn-default" onClick="picModal(<?php echo $album['id'] ?>)">
            <?php echo $album['name'] ?>
        </button>
    <?php endforeach; ?>
</div>
