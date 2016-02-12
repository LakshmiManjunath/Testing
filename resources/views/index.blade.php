<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/ico" href="images/favicon.gif"/>    
    <title>Aunt Mary's Storybook</title>
    
     <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">
    
	<style>
		body{
			background-image: url("images/main_background.jpg");
		}
	</style>
	

</head>
<body>

	<div class="container">
    
        <div class="jumbotron" style="opacity: 0.9;">
            
            <p class="lead" style="opacity: 1;"><img src="images/logo.gif" alt="Aunt Mary's Storybook"></p>
            
            <p class="lead" style="opacity: 1;">Streaming and downloadable audio recordings of parents reading stories to their children. Click <a href = "http://www.cjtinc.org/programs">this link for more information</a>, or if you have an account login below.</p>
            
            
            
            <p style="opacity: 2;"><a class="btn btn-lg btn-success" href="{{ url('login') }}" role="button">Login</a></p>
        </div>
    
    </div><!-- /container -->
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    
</body>
</html>
