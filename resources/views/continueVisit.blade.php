@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")

	<?php 
		$visitID = Session::get('visitID');
		$visit = \App\Visit::find($visitID);
		$user = \App\User::find($visit->coord);
        $name = $user->first . ' ' . $user->last;
        $num_recordings = \App\Recording::where('sessionID','=',$visitID)->count();
        //var_dump($num_recordings);
	?>
    <div class="row">
    <div class="col-lg-4 col-lg-offset-2">
    <h2> Session Info </h2>
    <div class="well bs-component">
    
	<p>Coordinator: {{$name}}</p>
    <p>Site: {{$visit->site}}</p>
    <p>Date: {{$visit->date}}</p>
    <p>Mothers: {{$visit->mothers}}</p>
    <p>Fathers: {{$visit->fathers}}</p>
    <p>Packages: {{$visit->packages}}</p>
    <p>Volunteers: {{$visit->volunteers}}</p>
    <p>Hours: {{$visit->hours}}</p>
    <p>Delivery: {{$visit->delivery}}</p>

	<p>Number of recordings uploaded: {{$num_recordings}}/{{$visit->packages}}</p>
	</div>
    </div>

	<div class="col-lg-4">
    <h2>Options</h2>
	<p><a class="btn btn-success" style="width:100%" href="{{ URL::to('editVisit') }}">Edit Session</a></p>
    <p><a class="btn btn-success" style="width:100%" href="{{ URL::to('selectUser') }}">Add New Recordings to Session</a></p>
    <p><a class="btn btn-success" style="width:100%" href="{{ URL::to('viewRecordingsInSession') }}">View Recordings</a></p>
    <p><a class="btn btn-success" style="width:100%" href="{{ URL::to('pdfZIP') }}">Generate PDFs</a></p>
    <p><a class="btn btn-success" style="width:100%" href="{{ URL::to('viewPostage') }}">Generate Postage</a></p>
    </div>
    </div>
    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop