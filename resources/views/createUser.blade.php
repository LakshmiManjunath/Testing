@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
      	

        <script src="js/jquery.liveaddress.min.js"></script>
        <script>jQuery.LiveAddress("5465813890678758773");</script>

         <div class="row">
          <div class="col-lg-6 col-lg-offset-3">
        <h1>Create User</h1>
        <div class="well bs-component">

        @if(isset($createStatus))
        <div class="alert alert-success">
        User Created Successfully - Create another or <a class="btn btn-primary" style="" href="{{ URL::to('createChild') }}">add Child to last user</a>
        </div>
        @endif
        Enter Information Below
      
        {!! Form::open(array('url' => 'createUser')) !!}
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
            {!! Form::label('address', 'Mailing Address') !!}
            {!! Form::text('address', Input::old('address'), array('placeholder' => 'Mailing Address', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('city', 'City') !!}
            {!! Form::text('city', Input::old('city'), array('placeholder' => 'City', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('state', 'State') !!}
            {!! Form::text('state', Input::old('state'), array('placeholder' => 'State', 'class' => 'form-control')) !!}
        </p>

        <p>
            {!! Form::label('zip', 'Zip Code') !!}
            {!! Form::text('zip', Input::old('zip'), array('placeholder' => 'Zip Code', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('phone', 'Phone') !!}
            {!! Form::text('phone', Input::old('phone'), array('placeholder' => 'Phone', 'class' => 'form-control')) !!}
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