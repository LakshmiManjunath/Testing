@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")


<table class="table">
      <caption>Select a session to delete.</caption>      	
      <thead>
        <tr>
          <th>Coordinator</th>
          <th>Site</th>
          <th>Date</th>
          
        </tr>
      </thead>
      <tbody>
         <?php 
			//var_dump($childList); 
			$visits = \App\Visit::all();
			//var_dump($visits[0]->coord);
			foreach ($visits as $visit)
			{
				echo "<tr>";
				echo "<td>" . $visit->coord . "</td>";
				echo "<td>" . $visit->site . "</td>";
				echo "<td>" . $visit->date . "</td>";
				echo Form::open(array('url' => 'deleteSession'));
				echo Form::hidden('visitID', $visit->id);
				echo '<td>' . Form::submit('Delete Session') .  '</td>';
				//echo "<td> select </td>";
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