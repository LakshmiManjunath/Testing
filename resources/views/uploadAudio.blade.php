@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
      	
        <p>Upload Audio</p>
        
        <?php
        	//foreach($childList as $childInstance){
			//	echo $childInstance->name;
			//	echo '<br>';
			//}
		?>
        
        {{{ $testpass or 'no image' }}}
        
        {{ Form::open(array('url'=>'uploadAudio','files'=>true, 'id'=>'form1')) }}
  		
        <div class="form-group">
          {{ Form::label('child','Child') }}
  		  {{ Form::select('child', $childList) }}
        </div>
  		
        <div class="form-group">
            {{ Form::label('isbn', 'ISBN') }}
            {{ Form::text('isbn', 'ISBN', array()) }}
		<button type="submit" form="form1" value="lookupISBN" hrefclass="btn btn-info">Look Up ISBN</button>
        
          
          <?php
          $json = file_get_contents('https://www.googleapis.com/books/v1/volumes?q=9780007324538+isbn');
          var_dump($json);
		  $decoded = json_decode($json,true);
		  echo $decoded['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
		  echo $decoded['items'][0]['volumeInfo']['title'];
		  ?>
          
        
        </div>
        
        <div class="form-group">
            {{ Form::label('title', 'Title') }}
            {{ Form::text('title', 'Title', array('class' => 'form-control')) }}
        
        </div>
        
        <div class="form-group">
          {{ Form::label('file','File',array('id'=>'','class'=>'')) }}
          {{ Form::file('file','',array('id'=>'','class'=>'')) }}
        </div>
        
          <!-- submit buttons -->
          {{ Form::submit('Save Recording') }}
          
          <!-- reset buttons -->
          {{ Form::reset('Reset') }}
          
          {{ Form::close() }}
          

          
    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop