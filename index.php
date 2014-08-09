<?php
require_once('includes/init.php');

$config = new Config;
?>

<!DOCTYPE html>
<html lang="<?php echo $config->language(); ?>">
	<head>
		<meta charset="<?php echo $config->charset(); ?>">
		<meta name="viewport" content="width=device-width; initial-scale=1.0">

		<!--[if lt IE 9]>
			<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
		<![endif]-->

		<link rel="stylesheet" href="style/style.css">
		<title><?php echo $config->title(); ?></title>
	</head>

	<head>
		
	</head>

	<body>
		<div class="page">
			<div class="top">
				<div class="nav">
					<a class="item" href="#new-post" style="background-image: url('style/new_post2.png')"></a>
					<a class="item" href="#followed" style="background-image: url('style/followed.png')"></a>
					<a class="item" href="#search" style="background-image: url('style/search.png')"></a>
					<a class="item" href="#login" style="background-image: url('style/login.png')"></a>
				</div>

				<div class="content">
					<div class="nav-arrow"></div>
				</div>
			</div>

			<div class="content">
			
			</div>

			<div class="footer">
				
			</div>
		</div>
	
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	</body>

</html>
