@extends("layout")
@section("content")


        <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
<h2>Delete Staff</h2>

<div class="well bs-component">
<p> Search for a staff member or select from list. </p>
    {!! Form::open(array('url' => 'searchStaff')) !!}

    {!! Form::text('searchName') !!}
    {!! Form::submit('Search Staff', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

<table class="table">
         
      <caption>Select a staff member.</caption>      	    
	  
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
        </tr>
      </thead>
      <tbody>
      
         <?php 
			$users = \App\User::all();
			foreach ($users as $user)
			{
				if ($user->level=="staff")
				{
					echo "<tr>";
					echo "<td>" . $user->first . "</td>";
					echo "<td>" . $user->last . "</td>";
					echo "<td>" . $user->email . "</td>";
					echo Form::open(array('url' => 'deleteStaff'));
					echo Form::hidden('userID', $user->id);
					echo '<td>' . Form::submit('Delete Staff', array('class' => 'btn btn-danger')) .  '</td>';
					echo Form::close();
					echo "</tr>";
				}
			}
		?>

      </tbody>
    </table>
    
    </div>
    </div>
    </div>

@stop