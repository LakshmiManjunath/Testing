<!-- app/views/login.blade.php -->

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/ico" href="images/favicon.gif"/>    
    <title>Aunt Mary's Storybook</title>
    
     <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    
    <!-- Custom styles for this template -->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">
    
    <style>
        body{
            background-image: url("images/main_background.jpg");
        }
    </style>
    

</head>
<body>
<?php
	$id = Auth::user()->id;
	$user = \App\User::find($id);
?>
	<div class="container">
	<div class="jumbotron" style="opacity: 0.9;">

    <div class="row">
    <div class="col-lg-6 col-lg-offset-3">
    <div style = "float:right"><a  href="logout">Logout</a></div>
<p class="lead" style="opacity: 1;"><img src="images/logo.gif" alt="Aunt Mary's Storybook"></p>

    <h3> Welcome {{$user->first}} {{$user->last}} </h3>
    
    </div>
    </div>
	<?php
	$count = 0;
	$childIDs = \App\Child::where('userID','=',$id)->get();
	foreach($childIDs as $childInstance){

		$recordingIDs = \App\Recording::where('childID','=',$childInstance->id)->get();
		foreach($recordingIDs as $recordingInstance){
			
			echo '<div class="row well bs-component">';
    		echo '<div class="col-lg-4 col-lg-offset-3">';
			
			
			echo '<h4>Recording for: ' . $childInstance->name .'</h4>';
			echo '<p>Book Name: ' . $recordingInstance->bookName . '</p>';
			echo '<p>Date Recorded: ' . '</p>';
			

			echo Form::open(array('url'=> 'downloadRecording'));
			echo Form::hidden('recordingID',$recordingInstance->id);
			echo Form::submit('Download',array('class' => 'btn btn-primary'));
			echo Form::close();
		
			echo '<br>';
			echo '<audio controls>';
			echo '<source src="recordings/' . $recordingInstance->filename . '" type="audio/mp3">';
			echo '</audio>';

			echo '</div>';
			
			echo '<div class="col-lg-2">';
			$apiString = 'https://www.googleapis.com/books/v1/volumes?q=' . $recordingInstance->ISBN . '+isbn';
			$json = file_get_contents($apiString);
			$decoded = json_decode($json,true);
			if(isset($decoded['items'][0]['volumeInfo']['imageLinks']['thumbnail']))
			{
				$imageLink = $decoded['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
				echo '<p style=""><img style="" src="' . $imageLink . '"></p>';
			}
			echo '</div>'; 

			echo '</div>';
			$count ++;
		}
	}
	
	if($count == 0)
	{
		echo "<p>You don't have any recordings yet. If you should and they are not here please <a href='support'>contact support</a>";
	}
?>



</div><!-- /container -->
</div>
             

</body>
</html>