<div id="picture-list">
    <?php foreach ($picture_links as $picture_link): ?>
    <!--<img src="<?php echo $picture_link ?>" width=200 height=200 onClick="picDecide(<?php echo $picture_link ?>)"> -->
        <img src="<?php echo $picture_link ?>" width=200 height=200 onClick="picDecide()">
    <?php endforeach; ?>
</div>
