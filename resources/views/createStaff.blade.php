@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
      	
        <div class="row">
          <div class="col-lg-6 col-lg-offset-3">

        <h2>Create Staff</h2>
        
        <div class="well bs-component">

        @if(isset($createStatus))
        <div class="alert alert-success">
            Staff Member Created Successfully
        </div>
        @endif
        Enter Information Below
        {!! Form::open(array('url' => 'createStaff')) !!}
        
        
        <!-- if there are login errors, show them here -->
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
            {!! Form::label('email', 'Email Address') !!}
            {!! Form::text('email', Input::old('email'), array('placeholder' => 'Email', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('level', 'Level') !!}
            {!! Form::select('level', array('staff' => 'staff', 'admin' => 'admin'), null, array('class' => 'form-control')) !!}
        </p>
        
        <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}

        </div>
        </div>
        </div>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop