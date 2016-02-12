@extends("layout")
@section("content")
	<h2>Hello {{ Auth::user()->email }} </h2>
    <p> you have {{ Auth::user()->level }} access.</p>
    @if (Auth::user()->level=="admin")
      	
        <p>Actions</p>
        <p>Create User</p>
        <p>Upload Audio</p>
        <p>Edit User</p>
        <p>Delete User</p>
        <p>Generate Letter</p>
        
        
        <p> List of users: </p>
		
		<?php
        	foreach($userList as $userInstance){
				echo $userInstance->email;
				echo "<br>";
			}
		?>
    @endif
    
    @if (Auth::user()->level=="staff")
      	<p> Staff code in development. </p>
        {{ User::all(); }}
    @endif
    
    @if (Auth::user()->level=="user")
        <a href="{{ URL::to('testDownload') }}">
        	test download
        </a>
    @endif
    
@stop
