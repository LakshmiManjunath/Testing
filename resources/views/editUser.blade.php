@extends("layout")
@section("content")

<div class="row">
<div class="col-lg-6 col-lg-offset-3">

<p> Search for a user or select from list. </p>
    {!! Form::open(array('url' => 'searchUser')) !!}

    {!! Form::text('searchName'); !!}
    {!! Form::submit('Search User') !!}
    {!! Form::close() !!}

<table class="table">
         
      <caption>Select a user.</caption>      	    
	  
      <thead>
        <tr>
          <th>Guardian First</th>
          <th>Guardian Last</th>
          <th>Guardian Children</th>
          
        </tr>
      </thead>
      <tbody>
         <?php 
			//var_dump($childList); 
			$users = \App\User::all();
			//var_dump($visits[0]->coord);
			foreach ($users as $user)
			{
				if ($user->level=="user"){
					echo "<tr>";
					echo "<td>" . $user->first . "</td>";
					//$user = User::find($child->userID);
					echo "<td>" . $user->last . "</td>";
					
					$children = \App\Child::where('userID','=',$user->id)->get();
					//var_dump($children);
					
					echo "<td>";
					
					foreach($children as $child)
					{
						echo $child->name . ", ";
					}
					
					echo Form::open(array('url' => 'selectUser'));
					echo Form::hidden('userID', $user->id);
					echo '<td>' . Form::submit('Select User') .  '</td>';
					//echo "<td> select </td>";
					echo Form::close();
					echo "</tr>";
				}
			}
		?>

      </tbody>
    </table>

</div>
</div>
    
@stop