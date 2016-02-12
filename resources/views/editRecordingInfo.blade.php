@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
     

      <div class="row">
          <div class="col-lg-6 col-lg-offset-3">   
    <h2>Edit Recording</h2>
        
<div class="well bs-component">

        <?php 
			$recording = \App\Recording::find($recordingID);
		?>
        {!! Form::open(array('url' => 'finishEditRecording')) !!}
        {!! Form::model($recording) !!}

        
      	<div class="form-group">
            {!! Form::label('bookName', 'Title') !!}
            {!! Form::text('bookName', Input::old('bookName'), array('placeholder' => 'Book Name', 'class' => 'form-control')) !!}
        </div>
        
        <div class="form-group">
            {!! Form::label('ISBN', 'ISBN') !!}
            {!! Form::text('ISBN', Input::old('ISBN'), array('placeholder' => 'ISBN', 'class' => 'form-control')) !!}
        </div>
        
        <div class="form-group">
            <p>Listen to the current recording:</p>
            <br>
            <audio controls>
            <source src={{"recordings/" . $recording->filename}} type="audio/mp3">
            </audio>
        </div

        <div class="form-group">
          {!! Form::label('file','New File (will replace old recording)',array('id'=>'','class'=>'')) !!}
          {!! Form::file('file','',array('id'=>'','class'=>'')) !!}
        </div>
        
        {!! Form::hidden('recordingID', $recordingID) !!}
        
        <p>{!! Form::submit('Submit', array('class' => 'btn btn-primary')) !!}</p>
        {!! Form::close() !!}

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
</div>
</div>
</div>

@stop