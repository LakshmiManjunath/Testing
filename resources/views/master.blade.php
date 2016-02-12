<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="icon" type="image/ico" href="images/favicon.gif"/>    
    <title>Storybook - @yield('page')</title>
    
     <!-- Bootstrap core CSS -->
    <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">-->
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- Custom styles for this template -->
    <!--<link href="css/jumbotron-narrow.css" rel="stylesheet">-->
    
	<script src="js/jquery.min.js"></script>
    
  </head>
  <body>
    <div class="container clear-top" style="min-height: 450px;">
    @yield("content")
    </div>


    @include("footer")
  
  </body>
</html>