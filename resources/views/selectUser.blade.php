@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin" || Auth::user()->level=="staff")
 <div class="row">
          <div class="col-lg-4 col-lg-offset-2">

<h2> Add a new guardian.</h2>
<p ><a style="width:100%" class="btn btn-success"  href="{{ URL::to('createUser') }}">Add Guardian</a></p> 

<h2>Search for existing guardian.</h2>
    {!! Form::open(array('url' => 'searchUser')) !!}

    {!! Form::text('searchName'); !!}
    {!! Form::submit('Search Guardian', array('class' => 'btn btn-primary')) !!}
    {!! Form::close() !!}
</p>
</div>

<div class="col-lg-4">
<h2> Select guardian from list.</h2>
<table class="table table-striped" style="font-size:14px">   
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
</div>

    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop