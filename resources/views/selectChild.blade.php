@extends("layout")
@section("content")
	@if (Auth::user()->level=="admin")

	<?php
		if(!Session::has('userID'))
		{
			return Redirect::to('admin');	
		}
		$userID = Session::get('userID');
		$user = \App\User::find($userID);
	?>

<div class="row">

<div class="col-lg-8 col-lg-offset-2">
<h2>Select child of {{$user->first}} {{$user->last}} to add recording to:</h2>
</div>

<div class="col-lg-4 col-lg-offset-2">
<h2>Add a new child: </h2>




<p> <a class="btn btn-success" style="" href="{{ URL::to('createChild') }}">Add Child</a></p>
</div>

<div class="col-lg-4">
<h2>Select an existing child. </h2>
<div class="well bs-component">
<table class="table" style="font-size:14px">
      <thead>
        <tr>
          <th>Child Name</th>
        </tr>
      </thead>
      <tbody>
         <?php 
			//var_dump($childList); 
			$children = \App\Child::where('userID','=',Session::get('userID'))->get();
			//var_dump($visits[0]->coord);
			foreach ($children as $child)
			{
				echo "<tr>";
				echo "<td>" . $child->name . "</td>";
				echo Form::open(array('url' => 'selectChild'));
				echo Form::hidden('childID', $child->id);
				echo '<td>' . Form::submit('Select Child', array('class' => 'btn btn-primary')) .  '</td>';
				//echo "<td> select </td>";
				echo Form::close();
				echo "</tr>";
			}
		?>

      </tbody>
    </table>
</div>
</div>
</div>
</div>
    @else
    	<p>Insufficent Permissions</p>
    @endif
    
@stop