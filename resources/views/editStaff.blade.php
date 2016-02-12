@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
        
        <?php 
		$user = \App\User::find($userID);
		?>
        
        <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
        {!! Form::open(array('url' => 'editStaff')) !!}
        {!! Form::model($user) !!}
        <h1>Edit Staff</h1>
        <div class="well bs-component">

       <p>
            {!! Form::label('first', 'First Name') !!}
            {!! Form::text('first', Input::old('first'), array('placeholder' => 'First Name', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('last', 'Last Name') !!}
            {!! Form::text('last', Input::old('last'), array('placeholder' => 'Last Name', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('username', 'Username') !!}
            {!! Form::text('username', Input::old('username'), array('placeholder' => 'username', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('email', 'Email Address') !!}
            {!! Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) !!}
        </p>
        
       <p>
            {!! Form::label('level', 'Level') !!}
            {!! Form::select('level', array('staff' => 'staff', 'admin' => 'admin'), null, array('class' => 'form-control')) !!}
        </p>
        
        {!! Form::hidden('userID', $userID) !!}
        
        <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
    </div>
    </div>
    </div>
@stop