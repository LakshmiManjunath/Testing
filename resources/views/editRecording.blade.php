@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
        
        <?php 
		$user = User::find($userID);
		?>
        
        {{ Form::open(array('url' => 'editStaff')) }}
        {{ Form::model($user) }}
        <h1>Edit Session</h1>
        
       <p>
            {{ Form::label('first', 'First Name') }}
            {{ Form::text('first', Input::old('first'), array('placeholder' => 'First Name', 'class' => 'form-control')) }}
        </p>
        
        <p>
            {{ Form::label('last', 'Last Name') }}
            {{ Form::text('last', Input::old('last'), array('placeholder' => 'Last Name', 'class' => 'form-control')) }}
        </p>
        
        <p>
            {{ Form::label('username', 'Username') }}
            {{ Form::text('username', Input::old('username'), array('placeholder' => 'username', 'class' => 'form-control')) }}
        </p>
        
        <p>
            {{ Form::label('email', 'Email Address') }}
            {{ Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) }}
        </p>
        
        <p>
            {{ Form::label('password', 'New Password') }}
            {{ Form::text('newPassword', Input::old('password'), array('placeholder' => 'Password', 'class' => 'form-control')) }}
        </p>
        
        {{ Form::hidden('userID', $userID) }}
        
        <p>{{ Form::submit('Submit') }}</p>
        {{ Form::close() }}

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop