<?php foreach ($albums as $album): ?>
    <div id="album-list">
        <button class="btn btn-default" onClick="picModal(<?php echo $album['id'] ?>)">
            <?php echo $album['name'] ?>
        </button>
    </div>
<?php endforeach; ?>
