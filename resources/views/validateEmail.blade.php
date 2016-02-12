@extends("layout")
@section("content")

<?php
	$id = Auth::user()->id;
	$user = \App\User::find($id);
?>
	
<div class="row">
<div class="col-lg-6 col-lg-offset-3">
    
    <h3> Welcome {{$user->first}} {{$user->last}} </h3>
    <h4> Please enter your email address. An email will be sent to you with information on how to activate your account. </h3>

	<div class="well bs-component">
        {!! Form::open(array('url' => 'validateEmail')) !!}
        
         <p>
            {!! Form::label('email', 'Email Address') !!}
            {!! Form::text('email', Input::old('email'), array('placeholder' => 'Email Address', 'class' => 'form-control')) !!}
        </p>
        
         <p>
            {!! Form::label('email2', 'Repeat Email Address') !!}
            {!! Form::text('email2', Input::old('email2'), array('placeholder' => 'Email Address', 'class' => 'form-control')) !!}
        </p>
       
         <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}
        
    </div>
    
</div>
</div>	
             

@stop