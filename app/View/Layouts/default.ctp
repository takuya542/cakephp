<!DOCTYPE html>
<html>
<head>
	<title>test</title>
</head>
<body>
	<div id="container">
		<div id="header"></div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
		</div>
	</div>
</body>
</html>
