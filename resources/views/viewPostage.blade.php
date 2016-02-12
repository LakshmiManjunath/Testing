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
          <th>Children's Names</th>
          <th>Book Name</th>
          <th>Postage Status</th>
          
        </tr>
      </thead>
      <tbody>
         <?php 
			$recordings = \App\Recording::where('sessionID','=',$visitID)->get();
			
			//calculate which recordings have the same guardian
			$recordingsArray = [];
			foreach ($recordings as $recording)
			{
				$child = \App\Child::find($recording->childID);
				$user = \App\User::find($child->userID);
				$recordingsArray[$recording->id] = $user->id;
			}
			
			//var_dump($recordingsArray);

			asort($recordingsArray);


			//var_dump($recordingsArray);



			$numberArray = array_count_values($recordingsArray);
			$numberArray2 = array_count_values($recordingsArray);

			//var_dump($numberArray);
			foreach ($recordingsArray as $recordingID => $userID)
			{
				$recording = \App\Recording::find($recordingID);
				$child = \App\Child::find($recording->childID);
				$user = \App\User::find($child->userID);
				if($numberArray[$userID] == $numberArray2[$userID])
				{
					echo "<tr>";
					echo "<td>" . $user->first . " " . $user->last . "</td>";
					echo "<td>" . $child->name;					

					//print($numberArray[$]);

				}
				else
				{
					echo ", " . $child->name;
				}

				$numberArray[$userID] = $numberArray[$userID] - 1;

				if($numberArray[$userID] == 0)
				{
					echo "</td>";
					echo "<td>" . $recording->bookName . "</td>";
					echo "<td>" . $recording->postageStatus . "</td>";
					if($recording->postageStatus == "not ordered")
					{
						echo Form::open(array('url' => 'buyPostage'));
						echo Form::hidden('recordingID', $recording->id);
						echo '<td>' . Form::submit('Buy Postage', array('class' => 'btn btn-primary')) .  '</td>';
						echo Form::close();
					}

					echo "</tr>";
				}

			}
/*
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
				echo "<td>" . $recording->postageStatus . "</td>";
				if($recording->postageStatus != "ordered")
				{
					echo Form::open(array('url' => 'buyPostage'));
					echo Form::hidden('recordingID', $recording->id);
					echo '<td>' . Form::submit('Buy Postage', array('class' => 'btn btn-primary')) .  '</td>';
					echo Form::close();
				}
				echo "</tr>";
			}

*/
		?>

      </tbody>
    </table>

    <?php
	    echo Form::open(array('url' => 'downloadLabels'));
		//echo Form::hidden('recordingID', $recording->id);
		echo '<td>' . Form::submit('Print Labels', array('class' => 'btn btn-primary')) .  '</td>';
		echo Form::close();
	?>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop