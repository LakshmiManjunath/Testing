<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="icon" type="image/ico" href="images/favicon.gif"/>    
    <title>Laravel PHP Framework</title>
	<style>
		@import url(//fonts.googleapis.com/css?family=Lato:700);

		body {
			margin:0;
			font-family:'Lato', sans-serif;
			text-align:center;
			color: #999;
		}

		.welcome {
			width: 300px;
			height: 200px;
			position: absolute;
			left: 50%;
			top: 50%;
			margin-left: -150px;
			margin-top: -100px;
		}

		a, a:visited {
			text-decoration:none;
		}

		h1 {
			font-size: 32px;
			margin: 16px 0 0 0;
		}
		
		video#bgvid {
			position: fixed; right: 0; bottom: 0;
			min-width: 100%; min-height: 100%;
			width: auto; height: auto; z-index: -100;
			background: url(images/background_main.jpg) no-repeat;
			background-size: cover;
		}
		
	</style>
</head>
<body>
	<div class="welcome">
		<h1>Aunt Mary's Storybook</h1>
        <p>Login</p>
        <p>Admin Login test</p>
        <video width="640" height="360" id="bgvid" autoplay loop>
        	<source src="images/reading_360p.mov.mp4" type="video/mp4">
        	Your browser does not support the video tag.
        </video>
	</div>
</body>
</html>
