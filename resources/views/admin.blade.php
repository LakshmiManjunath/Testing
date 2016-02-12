@extends("layout")
@section("content")
	  

    <h1 class="text-center">Administration Console</h1>
    
    @if (Session::has('visitID'))
    <div class="row">
    <div class="col-lg-4 col-lg-offset-4 text-center">
    <h3>Active Session: </h3>
    <p><a class="btn btn-success" style="" href="{{ URL::to('continueVisit') }}">Continue this session.</a> <a class="btn btn-danger" style="" href="{{ URL::to('closeVisit') }}">Close this session.</a></p>
    		<?php 
				$visitID = Session::get('visitID');
				$visit = \App\Visit::find($visitID);
				//var_dump($visit);
			?>
      @if($visit!=NULL)
      
      <?php
      $user = \App\User::find($visit->coord);
      $name = $user->first . ' ' . $user->last;
      ?>

      <p>Coordinator: {{$name}}</p>
			<p>Site: {{$visit->site}}</p>
			<p>Date: {{$visit->date}}</p>
			@endif

	<p>   </p>
    </div>
    </div>
    @endif
        <div class="row">
        <div class="col-lg-6 text-center">
          <h4>Sessions</h4>
             <p><a class="btn btn-success" style="" href="{{ URL::to('createSession') }}">
                New Session
            </a>
            
             <a class="btn btn-primary" style="" href="{{ URL::to('selectSession') }}">
                Continue
            </a>
            
            <a class="btn btn-danger" style="" href="{{ URL::to('deleteSession') }}">
                Delete
            </a>
           
			</p>
          
          <br>
          <h4>Guardian Account Management</h4>
                   <p>   <a class="btn btn-success" style="" href="{{ URL::to('createUser') }}">
                Create
            </a>
                      
                      <a class="btn btn-primary" style="" href="{{ URL::to('editUser') }}">
                Edit
            </a>
            
            <a class="btn btn-danger" style="" href="{{ URL::to('deleteUser') }}">
                Delete
            </a></p>

        </div>



        <div class="col-lg-6 text-center">
          @if (Auth::user()->level=="admin")
          <h4>Admin/Staff Account Management</h4>
          <p> <a class="btn btn-success" style="" href="{{ URL::to('createStaff') }}">
                Create
            </a>
            
            <a class="btn btn-primary" style="" href="{{ URL::to('selectStaff') }}">
                Edit
            </a>
            
            <a class="btn btn-danger" style="" href="{{ URL::to('deleteStaff') }}">
                Delete
            </a></p>
         
         <br>
         @endif 
         <h4>Recording Management</h4>
            <a class="btn btn-primary" style="" href="{{ URL::to('editRecording') }}">
                Edit
            </a>
            
            <a class="btn btn-danger" style="" href="{{ URL::to('deleteRecording') }}">
                Delete
            </a></p>

        </div>
      </div>
   
@stop
