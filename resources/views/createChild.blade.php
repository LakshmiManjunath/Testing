@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
      	
        
        <div class="row">
          <div class="col-lg-6 col-lg-offset-3">
          <h1>Add new child</h1>
            <div class="well bs-component">
        
        {!! Form::open(array('url' => 'createChild', 'class' => 'form-horizontal')) !!}
        <fieldset>
        
        <p>
            {!! Form::label('name', 'Child Name') !!}
            {!! Form::text('name', Input::old('name'), array('placeholder' => 'Child Name', 'class' => 'form-control')) !!}
        </p>

        <p>
            {!! Form::label('parentName', 'Parent Name') !!}
            {!! Form::text('parentName', Input::old('parentName'), array('placeholder' => 'Parent Name', 'class' => 'form-control')) !!}
        </p>
        
        <p>
            {!! Form::label('age', 'Child Age') !!}
            {!! Form::number('age', Input::old('age'), array('placeholder' => 'Child Age', 'class' => 'form-control')) !!}
        </p>


        <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        </fieldset>
        {!! Form::close() !!}
</div>
</div>
</div>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop