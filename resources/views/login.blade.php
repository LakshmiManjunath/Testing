<!-- app/views/login.blade.php -->

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

        <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <p class="lead" style="opacity: 1;"><img src="images/logo.gif" alt="Aunt Mary's Storybook"></p>

        {!! Form::open(array('url' => 'login')) !!}
        




        <!-- if there are login errors, show them here -->
        @if ($errors->first('username')!=='' || $errors->first('password')!=='')
        <div class="alert alert-danger" role="alert">
          <span class="sr-only">Error:</span>
            {!! $errors->first('username') !!}
            {!! $errors->first('password') !!}
        </div>
        @endif

        <div class="form-group">
            {!! Form::label('username', 'Username') !!}
            {!! Form::text('username', null!==Input::old('username') ? Input::old('username') : Request::input('username'), array('placeholder' => 'Username', 'class' => 'form-control')) !!}
        </div>

        <div class="form-group">
            {!! Form::label('password', 'Password') !!}
            
            @if(Request::input('pass')!=null)
            
            	{!! Form::text('password', Request::input('pass'), array('placeholder' => 'Password', 'class' => 'form-control')) !!}
        	
        	@else
        	
        	    {!! Form::password('password', array('placeholder' => 'Password', 'class' => 'form-control')) !!}
        	
        	@endif
            <p class="help-block"> <a href="{{ url('reset') }}">Forgot password? </a></p>
        </div>

        <p>{!! Form::submit('Login', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}

        </div>
        </div>


</div><!-- /container -->
</div>

</body>
</html>