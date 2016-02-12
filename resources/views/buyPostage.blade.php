@extends("layout")
@section("content")
	   
    <?php
        $recording = \App\Recording::find($recordingID);
        $child = \App\Child::find($recording->childID); 
        $user = \App\User::find($child->userID);

    ?>



    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
        <h1>Buy Postage</h1>
            <div class="well bs-component">
                <h2> To Address:</h2>
                <p> Name: {!! $user->first . " " . $user->last!!} </p>
                <p> Street: {!! $user->address !!} </p>
                <p> City: {!! $user->city !!}</p>
                <p> State: {!! $user->state !!}</p>
                <p> Zip: {!! $user->zip !!}</p>

                {!! Form::open(array('url' => 'requestEstimates', 'class' => 'form-horizontal')) !!}
                <fieldset>
                {!! Form::hidden('recordingID', $recording->id) !!}

                <h2>Package Details:</h2>

                <p>
                    {!! Form::label('length', 'Length (in)') !!}
                    {!! Form::number('length', Input::old('length'), array('placeholder' => 'Length (in)', 'class' => 'form-control')) !!}
                </p>

                <p>
                    {!! Form::label('width', 'Width (in)') !!}
                    {!! Form::number('width', Input::old('width'), array('placeholder' => 'Width (in)', 'class' => 'form-control')) !!}
                </p>

                <p>
                    {!! Form::label('height', 'Height (in)') !!}
                    {!! Form::number('height', Input::old('height'), array('placeholder' => 'Height (in)', 'class' => 'form-control')) !!}
                </p>

                <p>
                    {!! Form::label('weightPounds', 'Weight (lb)') !!}
                    {!! Form::number('weightPounds', Input::old('weightPounds'), array('placeholder' => 'Weight (lb)', 'class' => 'form-control')) !!}
                </p>

                <p>
                    {!! Form::label('weightOz', 'Weight (oz)') !!}
                    {!! Form::number('weightOz', Input::old('weightOz'), array('placeholder' => 'Weight (oz)', 'class' => 'form-control')) !!}
                </p>

                <p>{!! Form::submit('Request Estimates', array('class' => 'btn btn-primary')) !!}</p>
                </fieldset>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    
@stop