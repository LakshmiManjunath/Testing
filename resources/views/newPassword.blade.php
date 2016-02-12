@extends("layout")
@section("content")

<?php
	//var_dump($code)
    $user = \App\User::where('resetCode','=',$code)->first();
?>
	
<div class="row">
<div class="col-lg-6 col-lg-offset-3">
    
    <h3> Welcome {{$user->first}} {{$user->last}} </h3>
    <h4> Please enter a new password. </h3>

	<div class="well bs-component">
        {!! Form::open(array('url' => 'resetLink')) !!}
        
         <p>
            {!! Form::label('pass', 'New Password') !!}
            {!! Form::text('pass', Input::old('pass'), array('placeholder' => '', 'class' => 'form-control')) !!}
        </p>
        
         <p>
            {!! Form::label('pass2', 'Repeat New Password') !!}
            {!! Form::text('pass2', Input::old('pass2'), array('placeholder' => '', 'class' => 'form-control')) !!}
        </p>
       
        {!! Form::hidden('code', $code) !!}

         <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}
        
    </div>
    
</div>
</div>	
             

@stop