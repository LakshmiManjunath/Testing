@extends("layout")
@section("content")
	
<div class="row">
<div class="col-lg-6 col-lg-offset-3">
<h2>Delete a user</h2>

<div class="well bs-component">

@if(isset($deleteStatus))
    <div class="alert alert-success">
       User successfully deleted.
    </div>
@endif


<p> Search for a user or select from list. </p>
    {!! Form::open(array('url' => 'searchUser')) !!}

    {!! Form::text('searchName'); !!}
    {!! Form::submit('Search User', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}

<table class="table" style="font-size:14px">

      <thead>
        <tr>
          <th>Guardian First</th>
          <th>Guardian Last</th>
          <th>Guardian Children</th>
          
        </tr>
      </thead>
      <tbody>
         <?php 
			$users = \App\User::all();
			foreach ($users as $user)
			{
				if ($user->level=="user"){
					echo "<tr>";
					echo "<td>" . $user->first . "</td>";
					echo "<td>" . $user->last . "</td>";
					
					$children = \App\Child::where('userID','=',$user->id)->get();
					
					echo "<td>";
					
					foreach($children as $child)
					{
						echo $child->name . ", ";
					}
					
					echo Form::open(array('url' => 'deleteUser'));
					echo Form::hidden('userID', $user->id);
					echo '<td>' . Form::submit('Delete User', array('class' => 'btn btn-danger')) .  '</td>';
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