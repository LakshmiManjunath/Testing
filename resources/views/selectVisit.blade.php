@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")

	 <div class="row">
     <div class="col-lg-6 col-lg-offset-3">
     

	  <h2>Select a session.</h2> 
      
      <div class="well bs-component">
	  
      <table class="table table-striped">     	
      <thead>
            <tr>
              <th>Coordinator</th>
              <th>Site</th>
              <th>Date</th>
            </tr>
      </thead>
      <tbody>
      
	 <?php 
        $visits = \App\Visit::all();
        foreach ($visits as $visit)
        {
            $user = \App\User::find($visit->coord);
            $name = $user->first . ' ' . $user->last;
            echo "<tr class='' style='font-size:14px;'>";
            echo "<td>" . $name . "</td>";
            echo "<td>" . $visit->site . "</td>";
            echo "<td>" . $visit->date . "</td>";
            echo Form::open(array('url' => 'selectSession'));
            echo Form::hidden('visitID', $visit->id);
            echo '<td>' . Form::submit('Select Session', array('class' => 'btn btn-primary')) .  '</td>';
            echo Form::close();
            echo "</tr>";
        }
    ?>

      </tbody>
    </table>
	
    </div>
	</div>
    </div>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop