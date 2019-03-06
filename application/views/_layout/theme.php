<!DOCTYPE html>
<html>
<head>
<title>Mini game: Lucky draw</title>

<!-- set device -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<meta property="og:url"
	content="https://www.your-domain.com/your-page.html" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Your Website Title" />
<meta property="og:description" content="Your description" />
<meta property="og:image"
	content="https://www.your-domain.com/path/image.jpg" />

	<?= isset($load_css) ? $load_css : ''?>
</head>
<body>
	<div class="container container-lucky-draw">
		<?=$content?>
	</div>

	<div id="LoadingImage" style="display: none;">
	  	<img src="<?=ASSETS.'images/loadingIndex.gif'?>" />
	</div>
	<?= isset($load_js) ? $load_js : ''?>
</body>
</html>