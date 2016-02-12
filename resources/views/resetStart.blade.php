@extends("layout")
@section("content")

<style>
  body{
    background-image: url("images/main_background.jpg");
  }
</style>
	
<div class="row">
<div class="col-lg-6 col-lg-offset-3">
<div class="jumbotron" style="opacity: 0.9;"> 


    <h3> Password Reset </h3>
    <h4> Please enter your email or username and a link to reset your password will be emailed to you. </h3>

	<div class="well bs-component">
        {!! Form::open(array('url' => 'reset')) !!}
        
        <?php
			if($foundStatus != null)
			{
				if ($foundStatus == "false")
				{
					
					echo '<div class="alert alert-dismissible alert-danger">';
  					echo '<button type="button" class="close" data-dismiss="alert">×</button>';
  					echo '<strong>Username/Email not found</strong> Please try again or <a href="support" class="alert-link">contact support</a>.';
					echo '</div>';
				}
			}
		?>
         <p>
            {!! Form::label('reset', 'Enter Username or Email') !!}
            {!! Form::text('reset', Input::old('reset'), array('placeholder' => 'Username/Email', 'class' => 'form-control')) !!}
        </p>
       
         <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}
        
    </div>
</div> 
</div>
</div>	
             

@stop