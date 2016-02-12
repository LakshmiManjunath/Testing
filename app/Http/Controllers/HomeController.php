<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use View;
use Form;
use Validator;
use Input;
use Auth;
use Redirect;
use Illuminate\Support\MessageBag;
use Session;
use Hash;
use Mail;
use Response;
use Storage;
use TCPDF;
//use MYPDF;
use EasyPost;
use Carbon\Carbon;

require_once('tcpdf/tcpdf_autoconfig.php');
require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');

class MYPDF extends TCPDF 
	{
	    //Page header
	    public function Header() 
	    {
	        // get the current page break margin
	        $bMargin = $this->getBreakMargin();
	        // get current auto-page-break mode
	        $auto_page_break = $this->AutoPageBreak;
	        // disable auto-page-break
	        $this->SetAutoPageBreak(false, 0);
	        // set bacground image
	        $img_file = base_path() . "/resources/assets/images/letterhead_main.jpg";
	        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
	        // restore auto-page-break status
	        $this->SetAutoPageBreak($auto_page_break, $bMargin);
	        // set the starting point for the page content
	        $this->setPageMark();
	    }
	}


class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function showLogin()
	{
		// show the form
		return View::make('login');
		//print "test";
	}
	
	public function doLogin()
	{
	
	// validate the info, create rules for the inputs
	$rules = array(
		'username'    => 'required', // make sure the email is an actual email
		'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
	);
	

	// run the validation rules on the inputs from the form
	$validator = Validator::make(Input::all(), $rules);
	

	// if the validator fails, redirect back to the form
	if ($validator->fails()) {
		return Redirect::to('login')
			->withErrors($validator) // send back all errors to the login form
			->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
	} 

	else {
	
		// create our user data for the authentication
		$userdata = array(
			'username'     => Input::get('username'),
			'password'  => Input::get('password')
		);
	
		// attempt to do the login
		if (Auth::attempt($userdata)) {
	
			// validation successful!
			// redirect them to the secure section or whatever
			// return Redirect::to('secure');
			// for now we'll just echo success (even though echoing in a controller is bad)
			if(Auth::user()->validated=="false")
			{
				return Redirect::to('validateEmail');	
			}
			
			if(Auth::user()->forcePassChange=="true")
			{
				return Redirect::to('changePassword');
			}
			
			if (Auth::user()->level=="admin" || Auth::user()->level=="staff"){
				return Redirect::to('admin');
			}
			elseif (Auth::user()->level=="user"){
				return Redirect::to('home');
			}
			else{
				
			}
	
		} else {        
	
			$errors = new MessageBag(['password' =>['Email and/or password invalid.']]);
			// validation not successful, send back to form 
			return Redirect::to('login')
				->withErrors($errors)
				->withInput(Input::except('password'));
	
		}
	
	}
	
	}

	public function doLogout()
	{
		Auth::logout(); // log the user out of our application
		return Redirect::to('login'); // redirect the user to the login screen
	}

	public function showWelcome()
	{
		return View::make('hello');
	}
	
	public function profile()
	{
		$userList = User::all();
		return View::make('profile')->with('userList', $userList);
	}
	
	public function admin()
	{
		
		//$userList = \App\User::all();
		//return View::make('admin')->with('userList', $userList);
		return View::make('admin');
	}
	
	public function showCreateUser()
	{
		// show the form
		return View::make('createUser');
	}
	
	public function doCreateUser()
	{
		$user = new \App\User;
		
		$user->first = Input::get('first');
		$user->last = Input::get('last');
		$proposedUsername = strtolower(substr($user->first,0,1) . $user->last);
		
		$incrementIndex = 2;
		
		do {
			$userWithNameExists = \App\User::where('username','=',$proposedUsername)->first()!=null;
			//echo $proposedUsername;
			//var_dump($userWithNameExists);
			if($userWithNameExists)
			{
				if($incrementIndex == 2)
				{
					$proposedUsername = $proposedUsername . $incrementIndex;
				}
				else
				{
					$proposedUsername = substr($proposedUsername,0,-1) . $incrementIndex;	
				}
				$incrementIndex++;
			}
		} while ($userWithNameExists);

		$user->username = $proposedUsername;
		
		//Gen password
		$seed = str_split('abcdefghjkmnopqrstuvwxyz'
                 .'ABCDEFGHJKLMNPQRSTUVWXYZ'
                 .'23456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
		
		
		$user->password = Hash::make($rand);
		$user->firstTimePass = $rand;
		
		$seed = str_split('abcdefghijkmnopqrstuvwxyz'
                 .'ABCDEFGHJKLMNPQRSTUVWXYZ'
                 .'23456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 20) as $k) $rand .= $seed[$k];
		
		$user->confirmationCode = $rand;
		$user->forcePassChange = "true";
		
		$user->address = Input::get('address');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->zip = Input::get('zip');
		$user->phone = Input::get('phone');
		$user->validated = 'false';

		$user->level = "user";
		
		$user-> save();

		Session::put('userID',$user->id);
		return View::make('createUser')->with('createStatus', 'true');
		//return View::make('createUser');
	}
	
	public function showEditUser()
	{
		return View::make('editUserSelect');
	}
	
	public function startEditUser()
	{
		return View::make('editUserInfo')->with('userID', Input::get('userID'));
	}
	
	public function doEditUser()
	{
		$user = \App\User::find(Input::get('userID'));
		
		$user->first = Input::get('first');
		$user->last = Input::get('last');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		
		if(null != Input::get('newPassword'))
		{
			$user->password = Hash::make(Input::get('newPassword'));
		}
		$user->address = Input::get('address');
		$user->city = Input::get('city');
		$user->state = Input::get('state');
		$user->zip = Input::get('zip');
		$user->phone = Input::get('phone');
		
		$user->level = "user";
		
		$user-> save();
		
		return Redirect::to('editUser')->with('editStatus', 'true');
		
	}
	
	public function showDeleteUser()
	{
		return View::make('deleteUser');
	}
	
	public function doDeleteUser()
	{
		$user = \App\User::find(Input::get('userID'));
		$user->delete();
		
		//echo "user deleted";
		return View::make('deleteUser')->with('deleteStatus', 'true');
	}
	
	public function showCreateStaff()
	{
		return View::make('createStaff');
	}
	
	public function doCreateStaff()
	{
		$user = new \App\User;
		
		$user->first = Input::get('first');
		$user->last = Input::get('last');
	
		$proposedUsername = strtolower(substr($user->first,0,1) . $user->last);
		
		$incrementIndex = 2;
		
		do {
			$userWithNameExists = \App\User::where('username','=',$proposedUsername)->first()!=null;
			//echo $proposedUsername;
			//var_dump($userWithNameExists);
			if($userWithNameExists)
			{
				if($incrementIndex == 2)
				{
					$proposedUsername = $proposedUsername . $incrementIndex;
				}
				else
				{
					$proposedUsername = substr($proposedUsername,0,-1) . $incrementIndex;	
				}
				$incrementIndex++;
			}
		} while ($userWithNameExists);

		$user->username = $proposedUsername;

		$user->email = Input::get('email');
		//$user->password = Hash::make(Input::get('password'));
		
		$user->level = Input::get('level');
		
		$user->validated = 'true';

//Gen password
		$seed = str_split('abcdefghjkmnopqrstuvwxyz'
                 .'ABCDEFGHJKLMNPQRSTUVWXYZ'
                 .'23456789'); // and any other characters
		shuffle($seed); // probably optional since array_is randomized; this may be redundant
		$rand = '';
		foreach (array_rand($seed, 8) as $k) $rand .= $seed[$k];
		
		
		$user->password = Hash::make($rand);
		$user->firstTimePass = $rand;
		
		$user->forcePassChange = "true";


		$data = array('name' => $user->first . " " . $user->last, 'username' => $user->username, 'pass' => $rand, 'toEmail' => $user->email);
		Mail::send('emails.newStaff', $data, function($message) use ($data)
		{
			$message->from('admin@storybook.cjtinc.org', 'Storybook Admin');
			$message->to($data['toEmail'])->subject('Storybook Email Account');
		});

		$user-> save();
		
		//add logic to send temp email

		return View::make('createStaff')->with('createStatus', 'true');
	}
	
	public function showSelectStaff()
	{
		return View::make('selectStaff');
	}
	
	public function doSelectStaff()
	{
		//Session::put('userID',Input::get('userID'));
		return View::make('editStaff')->with('userID',Input::get('userID'));
	}
	
	public function showEditStaff()
	{
		return View::make('editStaff');
	}
	
	public function doEditStaff()
	{		
		
		//echo Input::get('userID');
		$user = \App\User::find(Input::get('userID'));
		
		$user->first = Input::get('first');
		$user->last = Input::get('last');
		$user->username = Input::get('username');
		$user->email = Input::get('email');
		$user->level = Input::get('level');

		$user-> save();
		
		//echo "changes saved";
		//return View::make('continueVisit')->with('visitID', $visitID);
		return View::make('selectStaff')->with('editStatus', 'true');
	}
	
	public function showDeleteStaff()
	{
		return View::make('deleteStaff');
	}
	
	public function doDeleteStaff()
	{		
		
		//echo Input::get('userID');
		$user = \App\User::find(Input::get('userID'));
		$user->delete();;
		
		//echo "changes saved";
		//return View::make('continueVisit')->with('visitID', $visitID);
		return Redirect::to('deleteStaff');
	}
		
	public function showEditRecording()
	{
		return View::make('editRecordingSelect');
	}
	
	public function startEditRecording()
	{
		//echo Input::get('recordingID');
		return View::make('editRecordingInfo')->with('recordingID', Input::get('recordingID'));
	}
	
	public function doEditRecording()
	{
		$recording = \App\Recording::find(Input::get('recordingID'));
		$recording->bookName = Input::get('bookName');
		$recording->ISBN = Input::get('ISBN');
		
		if(Input::file('file')!=NULL)
		{
			Input::file('file')->move('recordings',$recording->filename);
		}
		$recording->save();

		return Redirect::to('viewRecordingsInSession');
	}
	
	public function showDeleteRecording()
	{
		return View::make('deleteRecordingSelect');
	}
	
	public function doDeleteRecording()
	{
		//delete the recording then return list of recordings with flash message                                             
		
		$recording = \App\Recording::find(Input::get('recordingID'));
		$recording->delete();;

		return View::make('deleteRecordingSelect')->with('deleteStatus','true');
	}	
		
		
	public function showUploadAudio()
	{
		//$childList = Child::all();
		$childList = \App\Child::lists('name','id');
		return View::make('uploadAudio')->with('childList', $childList);
	}
	
	public function doUploadAudio()
	{
		//echo "routing looks good";
		//return Redirect::to('uploadAudio')
		//	->withInput(); // send back the input (not the password) so that we can repopulate the form
		$isbn = Input::get('isbn');	
		//echo $isbn;
		//$apiURL = 'https://www.googleapis.com/books/v1/volumes?q=' . $isbn . '+isbn';
		//echo $apiURL;
		//$json = file_get_contents($apiURL);
          //var_dump($json);
		  //$decoded = json_decode($json,true);
		  //echo $decoded['items'][0]['volumeInfo']['imageLinks']['thumbnail'];	
		return Redirect::to('selectUser');
	}
	
	public function showLetter()
	{
		// show the form
		return View::make('generateLetter');
	}
	
	public function home()
	{
		// show the form
		return View::make('home');
	}
	
	public function downloadRecording()
	{
		$recordingID = Input::get('recordingID');
		echo $recordingID;
		
		$recording = \App\Recording::find($recordingID);
		//$pathToFile = "../recordings/recording" . $recordingID . ".mp3";
		$pathToFile = "recordings/" . $recording->filename;
		//echo $pathToFile;
		$recordingName = 'storybook_' . \App\Child::find($recording->childID)->name . '_' . $recording->bookName . '.mp3';
		//return Response::download($pathToFile, $recordingName);
		return Storage::disk('s3')->get($recordingName);

		// show the form
		//return 'routing works!';
		//return Input::get('recordingID');
	}
	
	public function showCreateVisit()
	{
		// show the form
		return View::make('createVisit');
	}
	
	public function doCreateVisit()
	{
	
		$visit = new \App\Visit;
		
		$visit->coord = Input::get('coord');
		$visit->site = Input::get('site');
		$visit->date = Input::get('date');
		$visit->mothers = Input::get('mothers');
		$visit->fathers = Input::get('fathers');
		$visit->packages = Input::get('packages');
		$visit->volunteers = Input::get('volunteers');
		$visit->hours = Input::get('hours');
		$visit->delivery = Input::get('delivery');
		$visit->postageDate = Input::get('postageDate');
		
		$mailedFromAddress = Input::get('mailedFrom');
		
				if($mailedFromAddress == "1")
		{
			$street = "500 N Randall Rd";
			$city = "Batavia";
			$state = "IL";
			$zip = "60510";
			$num = "1";
		}
		elseif ($mailedFromAddress == "2") 
		{
			$street = "25150 W Channon Dr"; 
			$city = "Channahon";
			$state = "IL";
			$zip = "60410";
			$num = "2";
		}
		elseif ($mailedFromAddress == "3") 
		{
			$street = "2000 McDonough St";
			$city = "Joliet";
			$state = "IL";
			$zip = "60436";
			$num = "3";
		}
		elseif ($mailedFromAddress == "4") 
		{
			$street = "1750 W Ogden Ave";
			$city = "Naperville";
			$state = "IL";
			$zip = "60540";
			$num = "4";
		}
		elseif ($mailedFromAddress == "5") 
		{
			$street = "901 Lake St";
			$city = "Oak Park";
			$state = "IL";
			$zip = "60301";
			$num = "5";
		}
		elseif ($mailedFromAddress == "6") 
		{
			$street = "2600 Oak St";
			$city = "St. Charles";
			$state = "IL";
			$zip = "60147";
			$num = "6";
		}
		elseif ($mailedFromAddress == "7") 
		{
			$street = "122 N Wheaton Ave";
			$city = "Wheaton";
			$state = "IL";
			$zip = "60187";
			$num = "7";
		}
		
		$visit->mailAddress = $street;
		$visit->mailCity = $city;
		$visit->mailState = $state;
		$visit->mailZip = $zip;
		$visit->mailLocationNum = $num;

		$visit-> save();
		
		Session::put('visitID', $visit->id);
		
		return Redirect::to('continueVisit');
	}
	
	public function showCreateChild()
	{
		return View::make('createChild');
	}
	
	public function doCreateChild()
	{
		$child = new \App\Child;
		$child->name = Input::get('name');
		$child->parentName = Input::get('parentName');
		$child->userID = Session::get('userID');
		$child->age = Session::get('age');
		$child->save();

		return Redirect::to('selectChild');

		//$childList = Child::all();
		//$childID = Input::get('visitID');
		//Session::put('visitID', Input::get('visitID'));
		//echo "session put";
		//return Redirect::to('continueVisit');
	    //return View::make('continueVisit');
	}


	public function showSelectVisit()
	{
		return View::make('selectVisit');
	}
	
	public function doSelectVisit()
	{
		//$childList = Child::all();
		//$visitID = Input::get('visitID');
		Session::put('visitID', Input::get('visitID'));
		//echo "session put";
		return Redirect::to('continueVisit');
	    //return View::make('continueVisit');
	}
	
	public function showContinueVisit()
	{
		return View::make('continueVisit');
	}
	
	public function doContinueVisit()
	{
		//$childList = Child::all();
		$actionID = Input::get('actionID');
		$visitID = Input::get('visitID');
		
		//return View::make('continueVisit')->with('visitID', $visitID);
		//echo $actionID . " " . $visitID;
		if($actionID == "edit")
		{
			return View::make('editVisit')->with('visitID', $visitID);
		}
		elseif($actionID == "add")
		{
			return View::make('selectUser')->with('visitID', $visitID);
			//echo "add";
		}
		else
		{
			echo "view";
		}
	}
	
	
	public function showEditVisit()
	{
		return View::make('editVisit');
	}
	
	public function doEditVisit()
	{
	
		$visitID = Session::get('visitID');
		
		$visit = \App\Visit::find($visitID);
		
		$visit->coord = Input::get('coord');
		$visit->site = Input::get('site');
		$visit->date = Input::get('date');
		$visit->mothers = Input::get('mothers');
		$visit->fathers = Input::get('fathers');
		$visit->packages = Input::get('packages');
		$visit->volunteers = Input::get('volunteers');
		$visit->hours = Input::get('hours');
		$visit->delivery = Input::get('delivery');
		$visit->postageDate = Input::get('postageDate');
		
		$mailedFromAddress = Input::get('mailedFrom');
		
		if($mailedFromAddress == "1")
		{
			$street = "500 N Randall Rd";
			$city = "Batavia";
			$state = "IL";
			$zip = "60510";
			$num = "1";
		}
		elseif ($mailedFromAddress == "2") 
		{
			$street = "25150 W Channon Dr"; 
			$city = "Channahon";
			$state = "IL";
			$zip = "60410";
			$num = "2";
		}
		elseif ($mailedFromAddress == "3") 
		{
			$street = "2000 McDonough St";
			$city = "Joliet";
			$state = "IL";
			$zip = "60436";
			$num = "3";
		}
		elseif ($mailedFromAddress == "4") 
		{
			$street = "1750 W Ogden Ave";
			$city = "Naperville";
			$state = "IL";
			$zip = "60540";
			$num = "4";
		}
		elseif ($mailedFromAddress == "5") 
		{
			$street = "901 Lake St";
			$city = "Oak Park";
			$state = "IL";
			$zip = "60301";
			$num = "5";
		}
		elseif ($mailedFromAddress == "6") 
		{
			$street = "2600 Oak St";
			$city = "St. Charles";
			$state = "IL";
			$zip = "60147";
			$num = "6";
		}
		elseif ($mailedFromAddress == "7") 
		{
			$street = "122 N Wheaton Ave";
			$city = "Wheaton";
			$state = "IL";
			$zip = "60187";
			$num = "7";
		}
		
		$visit->mailAddress = $street;
		$visit->mailCity = $city;
		$visit->mailState = $state;
		$visit->mailZip = $zip;
		$visit->mailLocationNum = $num;

		$visit-> save();
		
		//echo "changes saved";
		//return View::make('continueVisit')->with('visitID', $visitID);
		return Redirect::to('continueVisit');
	}
	
	public function showDeleteVisit()
	{
		$childList = \App\Child::lists('name','id');
		// show the form
		return View::make('deleteVisit')->with('childList', $childList);
	}
	
	public function doDeleteVisit()
	{

		$visitID = Input::get('visitID');
		$visit = \App\Visit::find($visitID);
		$visit->delete();
		Session::forget('visitID');
		return Redirect::to('admin');
		
	}
	
	public function showSelectUser()
	{
		return View::make('selectUser');
	}
	
	public function doSelectUser()
	{
		Session::put('userID',Input::get('userID'));
		return Redirect::to('selectChild');
	}
	
	public function doSearchUser()
	{

		echo "Search feature in development. Please press back.";
		//echo Input::get('searchName');
	}
	
	public function showSelectChild()
	{

		//echo "Show select child";
		//echo Input::get('searchName');
		return View::make('selectChild');
	}
	
	public function doSelectChild()
	{
		Session::put('childID',Input::get('childID'));
		//echo Input::get('searchName');
		return Redirect::to('addRecording');
	}
	
	public function showAddRecording()
	{

		//echo "Show add recording";
		//echo Input::get('searchName');
		return View::make('addRecording');
	}
	
	public function support()
	{
		echo "Support page under development. For assistance email zdiggins@gmail.com";
	}

	public function doLookupISBN()
	{
		Session::put('isbn',Input::get('isbn'));
		$apiString = 'https://www.googleapis.com/books/v1/volumes?q=' . Input::Get('isbn');
		$json = file_get_contents($apiString);
		$decoded = json_decode($json,true);
		if(isset($decoded['items'][0]['volumeInfo']['imageLinks']['thumbnail']))
		{
			$imageLink = $decoded['items'][0]['volumeInfo']['imageLinks']['thumbnail'];
		}
		else
		{
			$imageLink = 'not found';	
		}
				
		if(isset($decoded['items'][0]['volumeInfo']['title']))
		{
			$title = $decoded['items'][0]['volumeInfo']['title'];
		}
		else
		{
			$title = 'not found';	
		}
		//echo $title;
		$bookInfo = array('title' => $title, 'imageLink' => $imageLink);
		return View::make('addRecording')->with('bookInfo', $bookInfo);
		//return var_dump($json);
	}
	
	public function showForcePasswordChange()
	{
		return View::make('changePassword');
	}
	
	public function doForcePasswordChange()
	{
		
		$user = Auth::user();
		
		if(null != Input::get('pass'))
		{
			$user->password = Hash::make(Input::get('pass'));
		}
		
		$user->forcePassChange = 'false';
		$user->firstTimePass = '';
		$level = $user->level;

		$user-> save();
		
		if($level == "user")
		{
			return Redirect::to('home');
		}
		else
		{
			return Redirect::to('admin');
		}
	}
	
	public function showValidateEmail()
	{
		return View::make('validateEmail');
	}
	
	public function doValidateEmail()
	{
		$user = Auth::user();
		$user->email = Input::get('email');
		$email = $user->email;
		$user->validated = 'sent';
		$user->save();
		
		$data = array('name' => $user->first . " " . $user->last, 'code' => 'https://storybook.cjtinc.org/validationLink?code=' . $user->confirmationCode, 'toEmail' => $email);
		Mail::send('emails.verify', $data, function($message) use ($data)
		{
			$message->from('admin@storybook.cjtinc.org', 'Storybook Admin');
			$message->to($data['toEmail'])->subject('Storybook Email Verification');
		});
		
		//echo "email sent";
		//return View::make('validateEmailSent');
		return Redirect::to('changePassword');
	}
	
	public function showValidateEmailSuccess()
	{
		return Redirect::to('changePassword');
	}
	
	public function checkValidationLink()
	{
		$user = \App\User::where('confirmationCode','=',Input::get('code'))->first();
		if($user!=null)
		{
			$user->validated="true";
			$user->save();
		}
		
		return Redirect::to('logout');
		
		//echo $user->first . " " . $user->last;
		
		//echo "validation page ";
		//echo Input::get('code');
		//return View::make('validateEmailSent');
	}
	
	public function showViewRecordings()
	{
		return View::make('recordingsInSession');
	}

	public function showViewPostage()
	{
		return View::make('viewPostage');
	}

	public function showBuyPostage()
	{
		return View::make('buyPostage')->with('recordingID', Input::get('recordingID'));
	}

	public function doRequestEstimates()
	{


//		require_once(base_path() . "/vendor/easypost/easypost-php/lib/easypost.php");


		//Test Key
		//\EasyPost\EasyPost::setApiKey('1B8rYqvyKcxm2Nap4v0SbA');
		
		//Live Key
		\EasyPost\EasyPost::setApiKey('ci6luERtjxhCXeiw8XNVkg');


		$recordingID = Input::get('recordingID');
		Session::put('recordingID',$recordingID);


		$recording = \App\Recording::find($recordingID);
		$visit = \App\Visit::find($recording->sessionID);
        $child = \App\Child::find($recording->childID); 
        $user = \App\User::find($child->userID);

		$fromAddress = \EasyPost\Address::create(array(
		  'company' => 'Companions Journeying Together',
		  'street1' => $visit->mailAddress,
		  'street2' => '',
		  'city' => $visit->mailCity,
		  'state' => $visit->mailState,
		  'zip' => $visit->mailZip,
		  'phone' => '630-481-6231'
		));

		$returnAddress = \EasyPost\Address::create(array(
		  'company' => 'Companions Journeying Together',
		  'street1' => 'PO Box 457',
		  'street2' => '',
		  'city' => 'Western Springs',
		  'state' => 'IL',
		  'zip' => '60558',
		  'phone' => '630-481-6231'
		));


		$toAddress = \EasyPost\Address::create(array(
		  'name' => $user->first . " " . $user->last,
		  'company' => '',
		  'street1' => $user->address,
		  'city' => $user->city,
		  'state' => $user->state,
		  'zip' => $user->zip
		));

		$parcel = \EasyPost\Parcel::create(array(
		  "length" => Input::get('length'),
		  "width" => Input::get('width'),
		  "height" => Input::get('height'),
		  "weight" => (Input::get('weightPounds') * 16 + Input::get('weightOz'))
		));

		$shipment = \EasyPost\Shipment::create(array(
		  "to_address" => $toAddress,
		  "from_address" => $fromAddress,
		  "return_address" => $returnAddress,
		  "parcel" => $parcel,
		  "options" => array('special_rates_eligibility' => 'USPS.MEDIAMAIL', 'label_date' => $visit->postageDate)
		));

		Session::put('shipment',$shipment);

		return View::make('requestEstimates')->with('shipment', $shipment);
		
	}

	public function doFinishPostage()
	{

		$shipment = Session::get('shipment');
		$shipment->buy(array('rate' => array('id' => Input::get('rateID'))));

		$postage_label = json_decode($shipment->postage_label);
		$shipmentDecode = json_decode($shipment);
		//file_get_contents
		//print ($shipmentDecode['label_url']);
		
		//var_dump($shipmentDecode);
		//var_dump($postage_label);
		//var_dump($postage_label->label_url);

		$url = $postage_label->label_url;
		$trackingCode = $shipment->tracking_code;
		
		//print("URL: " . $url . " Tracking Code: " . $trackingCode);
		//print_r($trackingCode);
		//$img = base_path() . "/storage/app/testPostage.png";
		//file_put_contents($img, file_get_contents($url));
		
		$recording = \App\Recording::find(Session::get('recordingID'));
		$recording->postageStatus = "ordered";
		$recording->postageURL = $url;
		$recording->trackingNumber = $trackingCode;
		$recording->save();


		$child = \App\Child::find($recording->childID);
		$user = \App\User::find($child->userID);
		$userID = $user->id;

		$visitID = Session::get('visitID');
		$recordings = \App\Recording::where('sessionID','=',$visitID)->get();
			
		//calculate which recordings have the same guardian
		foreach ($recordings as $recording)
		{
			$child = \App\Child::find($recording->childID);
			$user = \App\User::find($child->userID);
			if($user->id == $userID)
			{	
				
			
				if($recording->postageStatus == "not ordered")
				{
					//print($recording->id . " " . $child->id . " " . $user->id);
					$recording->postageStatus = "bundeled";
					$recording->save();
				}
				
			}
		}


		return View::make('viewPostage');

	}

	public function doDownloadLabels()
	{
		//Prepare the pdf
		require_once('tcpdf/tcpdf_autoconfig.php');
		require_once('tcpdf/config/tcpdf_config.php');
		require_once('tcpdf/tcpdf.php');
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		
		$pdf->SetPrintHeader(false);

		//Pull in the recordings for the active visit
		$visitID = Session::get('visitID');
		$recordings = \App\Recording::where('sessionID','=',$visitID)->get();
		$pageCount = 1;
		$fileCount = 1;
		foreach ($recordings as $recording)
		{
			if($recording->postageStatus == "ordered")
			{	
				$tempFile = base_path() . "/storage/app/tempPostage" . $fileCount . ".png";
				$fileCount = $fileCount + 1;
				if(file_exists($tempFile))
				{
					unlink($tempFile);
				}

				$url = $recording->postageURL;
				//print("url: " . $url . "\r\n");
				file_put_contents($tempFile, file_get_contents($url));

				if($pageCount ==1 )
				{
					$pdf->AddPage();
					$pdf->StartTransform();
					$pdf->Rotate(90, 45, 45);
					$pdf->Image($tempFile, -40, 20, 120, '', '', '', '', true, 300);
					$pdf->StopTransform();
					$pageCount = 2;
				}
				else
				{
					$pdf->StartTransform();
					$pdf->Rotate(90, 45, 45);
					$pdf->Image($tempFile, -185, 20, 120, '', '', '', '', true, 300);
					$pdf->StopTransform();
					$pageCount = 1;
				}

				if(file_exists($tempFile))
				{
					unlink($tempFile);
				}
				
			}
		}


		$content = $pdf->Output(dirname(__FILE__). "/../lastGeneratedPostage.pdf", 'F');

		$letterName = "postageTest.pdf";
		return Response::download(dirname(__FILE__). "/../lastGeneratedPostage.pdf",$letterName);

	}


	public function doDownloadPDF()
	{

	}


	public function doDownloadPDFzip()
	{

		require_once('tcpdf/tcpdf_autoconfig.php');
		require_once('tcpdf/config/tcpdf_config.php');
		require_once('tcpdf/tcpdf.php');


		// Extend the TCPDF class to create custom Header and Footer
		

		// create new PDF document
		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 003');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

		// set default header data
		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
		$pdf->setPrintFooter(false);

		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		// set margins
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		// set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		// set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		// set some language-dependent strings (optional)
		if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
		    require_once(dirname(__FILE__).'/lang/eng.php');
		    $pdf->setLanguageArray($l);
		}

		// ---------------------------------------------------------

		// set font
		$pdf->SetFont('times', '', 12);

		$visitID = Session::get('visitID');
		$recordings = \App\Recording::where('sessionID','=',$visitID)->get();
		foreach ($recordings as $recording)
		{
			$child = \App\Child::find($recording->childID);
			$user = \App\User::find($child->userID);
			
			// add a page
			$pdf->AddPage();

			// set some text to print
			$html = "
			<p></p>
			<p></p>
			<p></p> " . 

			"<p>Dear " . $user->first . " " . $user->last . ":</p>
			<p>Enclosed is a book and a link to an audio file chosen and recorded by " . $child->parentName . " for the child in your care, " . $child->name . ".  Please use your own judgment on how to use the book and recording.</p>

			<p>We are grateful for the opportunity to provide these books and know that in most cases these books and recordings mean so much to the children. It is a reminder that their parent is thinking of them. However, we only see the parent and do not know the situation or needs of their child. As a direct observer you can make a decision if these recordings will help or hinder the child in your care. Our concern is first of all for the children.</p>

			<p>To access the audio file use the information below or use a QR code app on your phone to scan the code at the bottom of the page:</p>
			<p><b>Web address:</b> https://www.storybook.cjtinc.org <br>
			<b>Username: </b>" . $user->username . "<br>";

			if ($user->firstTimePass != "")
			{
				$html = $html . "
				<b>Temporary Password: </b>" . $user->firstTimePass . "</p>";
			}

			$html = $html . "
			<p>If you have any questions, please contact us at:</p>
			<p>Aunt Mary’s Storybook Project, a project of Companions, Journeying Together, Inc</p>
			<p>630-481-6231 / scott@cjtinc.org / www.cjtinc.org </p>
			";

			//$html = $recordingID;
			// print a block of text using Write()
			$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

			// new style
			$style = array(
			    'border' => false,
			    'padding' => 0,
			    'fgcolor' => array(0,0,0),
			    'bgcolor' => false
			);

			$loginURL = 'https://storybook.cjtinc.org/login?username=' . $user->username . '&pass=' . $user->firstTimePass;
			$pdf->write2DBarcode($loginURL, 'QRCODE,H', 90, 200, 40, 40, $style, 'N');

		}


		// ---------------------------------------------------------

		//============================================================+
		// END OF FILE
		//============================================================+
		$content = $pdf->Output(dirname(__FILE__). "/../lastGeneratedPDF.pdf", 'F');

		$letterName = "session.pdf";
		return Response::download(dirname(__FILE__). "/../lastGeneratedPDF.pdf",$letterName);
	}

	public function filetest()
	{
		Storage::disk('s3')->put('file.txt', 'Contents');
		return "ran file test";
	}

	public function testtime()
	{
		echo Carbon::now();
	}

	
}


