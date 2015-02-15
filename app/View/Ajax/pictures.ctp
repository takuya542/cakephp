<div id="picture-list">
    <?php foreach ($pictures_data as $picture): ?>
    <img src="<?php echo $picture['source'] ?>" width=200 height=200 onClick="picDecide('<?php echo $picture['id'] ?>', '<?php echo $picture['source'] ?>' )" style="padding: 10px">
    <?php endforeach; ?>
</div>
