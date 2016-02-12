@extends("layout")
@section("content")
      	
        <?php 
			$user = \App\User::find($userID);
		?>

        <div class="row">
          <div class="col-lg-6 col-lg-offset-3">
    	  <h1>Edit User</h1>
        <div class="well bs-component">
        {!! Form::open(array('url' => 'finishEditUser')) !!}
        {!! Form::model($user) !!}
      
        <p>
            {!! $errors->first('email') !!}
            {!! $errors->first('password') !!}
        </p>

        <p>
            {!! Form::label('first', 'First Name') !!}
            {!! Form::text('first', Input::old('first'), array('placeholder' => 'First Name', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('last', 'Last Name') !!}
            {!! Form::text('last', Input::old('last'), array('placeholder' => 'Last Name', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('username', 'User Name') !!}
            {!! Form::text('username', Input::old('username'), array('placeholder' => 'User Name', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('newPassword', 'New Password') !!}
            {!! Form::text('newPassword', Input::old('password'), array('placeholder' => 'New Password', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('email', 'Email Address') !!}
            {!! Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('address', 'Mailing Address') !!}
            {!! Form::text('address', Input::old('address'), array('placeholder' => 'Mailing Address', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('city', 'City') !!}
            {!! Form::text('city', Input::old('city'), array('placeholder' => 'City', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('zip', 'Zip Code') !!}
            {!! Form::text('zip', Input::old('zip'), array('placeholder' => 'Zip Code', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('state', 'State') !!}
            {!! Form::text('state', Input::old('state'), array('placeholder' => 'State', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', Input::old('phone'), array('placeholder' => 'Phone', 'class' => 'form-control')) !!}
        </p>
        
        {!! Form::hidden('userID', $userID) !!}
        
        <p>{!! Form::submit('Submit') !!}</p>
        {!! Form::close() !!}
</div>
</div>
</div>
    
@stop