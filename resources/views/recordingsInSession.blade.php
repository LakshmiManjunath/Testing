@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")

<?php 
	$visitID = Session::get('visitID');
	$visit = \App\Visit::find($visitID);
	//var_dump($visit);
?>

<h2>Recordings In This Session</h2>

<p> Search for a recording or select from list. </p>
    {!! Form::open(array('url' => 'searchRecording')) !!}

    {!! Form::text('searchName'); !!}
    {!! Form::submit('Search Recording') !!}
    {!! Form::close() !!}

<table class="table">
         
      <caption>Select a Recording.</caption>      	    
	  
      <thead>
        <tr>
          <th>Guardian Name</th>
          <th>Child Name</th>
          <th>Book Name</th>
          
        </tr>
      </thead>
      <tbody>
         <?php 
			$recordings = \App\Recording::where('sessionID','=',$visitID)->get();
			foreach ($recordings as $recording)
			{
				echo "<tr>";
				
				$child = \App\Child::find($recording->childID);
				//var_dump($child);
				$user = \App\User::find($child->userID);
				//var_dump($user);
				echo "<td>" . $user->first . " " . $user->last . "</td>";
				echo "<td>" . $child->name . "</td>";
				echo "<td>" . $recording->bookName . "</td>";
				echo Form::open(array('url' => 'editRecording'));
				echo Form::hidden('recordingID', $recording->id);
				echo '<td>' . Form::submit('Edit Recording', array('class' => 'btn btn-primary')) .  '</td>';
				echo Form::close();
				echo Form::open(array('url' => 'downloadLetter'));
				echo Form::hidden('recordingID', $recording->id);
				echo '<td>' . Form::submit('Download PDF', array('class' => 'btn btn-primary')) .  '</td>';
				echo Form::close();
				echo "</tr>";
			}
		?>

      </tbody>
    </table>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop