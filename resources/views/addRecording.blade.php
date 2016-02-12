@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
      	
        
<div class="row">
<div class="col-lg-6 col-lg-offset-3">

        <h1>Add Recording</h1>
  		<div class="well bs-component">
  		{!! Form::open(array('url' => 'lookupISBN')) !!} 
        <div class="form-group">
            {!! Form::label('isbn', 'ISBN') !!}
            {!! Form::text('isbn') !!}
            {!! Form::submit('Look up ISBN', array('class' => 'btn btn-primary')) !!}
        </div>
        {!! Form::close() !!}
        
        {!! Form::open(array('url'=>'audioSubmit','files'=>true, 'id'=>'form1')) !!}
        
          <img src ="
          <?php
         	if(isset($bookInfo['imageLink']))
			{
				if($bookInfo['imageLink']!='not found')
				{
					echo $bookInfo['imageLink'];
				}
			}
			else
			{
			  $bookInfo['title'] = 'title';	
			}
			
		  ?>
          ">
      
        <div class="form-group">
            {!! Form::label('title', 'Title') !!}
            {!! Form::text('title', $bookInfo['title'], array('class' => 'form-control')) !!}
        
        </div>
        
        <div class="form-group">
          {!! Form::label('file','File',array('id'=>'','class'=>'')) !!}
          {!! Form::file('file','',array('class'=>'btn btn-primary')) !!}
        </div>
        
          <!-- submit buttons -->
          {!! Form::submit('Save Recording', array('class' => 'btn btn-success')) !!}
          
          <!-- reset buttons -->
          {!! Form::reset('Reset', array('class' => 'btn')) !!}
          
          {!! Form::close() !!}
 
</div>         
</div>
</div>
          
    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop