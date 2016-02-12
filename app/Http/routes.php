<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('index');
});

Route::get('login', array('uses' => 'HomeController@showLogin'));

// route to process the form
Route::post('login', array('uses' => 'HomeController@doLogin'));

Route::get('logout', array('uses' => 'HomeController@doLogout'));

Route::group(["before" => "auth"], function() {

Route::any('profile', array('uses' => 'HomeController@profile'));

Route::any('admin', array('uses' => 'HomeController@admin'));

});

Route::get('/', function()
{
	return View::make('index');
});

Route::get('about', function()
{
	return View::make('about');
});

//test file
Route::get('listUsers', function()
{
	$users = User::all();
	return $users;
});


//test file
Route::get('testDownload', function()
{
	$pathToFile = "../recordings/test.mp3";
	return Response::download($pathToFile);
});

// User Managment routes
	Route::get('createUser', array('uses' => 'HomeController@showCreateUser'));
	Route::post('createUser', array('uses' => 'HomeController@doCreateUser'));
	
	Route::get('editUser', array('uses' => 'HomeController@showEditUser'));
	Route::post('editUser', array('uses' => 'HomeController@startEditUser'));
	Route::post('finishEditUser', array('uses' => 'HomeController@doEditUser'));
	
	Route::get('deleteUser', array('uses' => 'HomeController@showDeleteUser'));
	Route::post('deleteUser', array('uses' => 'HomeController@doDeleteUser'));

// Create staff routes
Route::get('createStaff', array('uses' => 'HomeController@showCreateStaff'));
Route::post('createStaff', array('uses' => 'HomeController@doCreateStaff'));

Route::get('createChild', array('uses' => 'HomeController@showCreateChild'));
Route::post('createChild', array('uses' => 'HomeController@doCreateChild'));

// Edit staff
Route::get('editStaff', array('uses' => 'HomeController@showEditStaff'));
Route::post('editStaff', array('uses' => 'HomeController@doEditStaff'));
	Route::get('selectStaff', array('uses' => 'HomeController@showSelectStaff'));
	Route::post('selectStaff', array('uses' => 'HomeController@doSelectStaff'));

// Delete Staff
Route::get('deleteStaff', array('uses' => 'HomeController@showDeleteStaff'));
Route::post('deleteStaff', array('uses' => 'HomeController@doDeleteStaff'));

// Edit Recording
Route::get('editRecording', array('uses' => 'HomeController@showEditRecording'));
Route::post('editRecording', array('uses' => 'HomeController@startEditRecording'));
Route::post('finishEditRecording', array('uses' => 'HomeController@doEditRecording'));

// Delete Recording
Route::get('deleteRecording', array('uses' => 'HomeController@showDeleteRecording'));
Route::post('deleteRecording', array('uses' => 'HomeController@doDeleteRecording'));

Route::get('generateLetter', array('uses' => 'HomeController@showLetter'));

Route::get('uploadAudio', array('uses' => 'HomeController@showUploadAudio'));

Route::post('uploadAudio', array('uses' => 'HomeController@doUploadAudio'));

Route::post('downloadLabels', array('uses' => 'HomeController@doDownloadLabels'));

Route::any('audioSubmit', function(){
	
	$seed = str_split('abcdefghijklmnopqrstuvwxyz'
                 .'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
                 .'0123456789'); // and any other characters
	shuffle($seed); // probably optional since array_is randomized; this may be redundant
	$rand = '';
	foreach (array_rand($seed, 50) as $k) $rand .= $seed[$k];
	
	$filename = "recording_". $rand . ".mp3";
	$recording = new \App\Recording;
	$recording->childID = Session::get('childID');
	$recording->sessionID = Session::get('visitID');
	$recording->bookName = Input::get('title');
	$recording->ISBN = Session::get('isbn');
	$recording->filename = $filename;
	$recording->postageStatus = "not ordered";
	$recording->save();
	
	//$number = DB::table('recordings')->orderBy('id', 'desc')->first()->id;
	//$filename = 'recording' . $number . '.mp3';

	//Input::file('file')->move('recordings',$filename);
	Storage::disk('s3')->put($filename, file_get_contents(Input::file('file')));
	//return "file uploaded successfully.";
	return Redirect::to('continueVisit');
	//var_dump(Input::file('file'));
});

Route::any('home', array('uses' => 'HomeController@home'));
Route::any('support', array('uses' => 'HomeController@support'));

Route::post('downloadRecording', array('uses' => 'HomeController@downloadRecording'));

Route::get('createSession', array('uses' => 'HomeController@showCreateVisit'));
Route::post('createSession', array('uses' => 'HomeController@doCreateVisit'));

Route::get('selectSession', array('uses' => 'HomeController@showSelectVisit'));
Route::post('selectSession', array('uses' => 'HomeController@doSelectVisit'));

Route::get('continueVisit', array('uses' => 'HomeController@showContinueVisit'));

// Edit Visit
Route::get('editVisit', array('uses' => 'HomeController@showEditVisit'));
Route::post('editVisit', array('uses' => 'HomeController@doEditVisit'));

// Delete Session
Route::get('deleteSession', array('uses' => 'HomeController@showDeleteVisit'));
Route::post('deleteSession', array('uses' => 'HomeController@doDeleteVisit'));

// Select User
Route::get('selectUser', array('uses' => 'HomeController@showSelectUser'));
Route::post('selectUser', array('uses' => 'HomeController@doSelectUser'));
	//Select User helper routes
	Route::post('searchUser', array('uses' => 'HomeController@doSearchUser'));

//Select Child
Route::get('selectChild', array('uses' => 'HomeController@showSelectChild'));
Route::post('selectChild', array('uses' => 'HomeController@doSelectChild'));

Route::get('addRecording', array('uses' => 'HomeController@showAddRecording'));

Route::post('lookupISBN', array('uses' => 'HomeController@doLookupISBN'));

Route::any('closeVisit', function()
{
	Session::forget('visitID');
	return Redirect::to('admin');
});

Route::get('testEmail', function()
{
	Mail::send('emails.test', [], function($message)
	{
		$message->from('admin@storybook.cjtinc.org', 'Admin');
		$message->to('zdiggins@gmail.com')->subject('Laracasts Email');
	});
});

//Change Password
Route::get('changePassword', array('uses' => 'HomeController@showForcePasswordChange'));
Route::post('changePassword', array('uses' => 'HomeController@doForcePasswordChange'));

Route::get('validateEmail', array('uses' => 'HomeController@showValidateEmail'));
Route::post('validateEmail', array('uses' => 'HomeController@doValidateEmail'));

Route::any('validationLink', array('uses' => 'HomeController@checkValidationLink'));

Route::get('reset', function()
{
	return View::make('resetStart')->with('foundStatus', 'NA');
});

Route::post('reset', function()
{
	$searchID = Input::get('reset');
	//Check username first, then check email
	//Can improve by looking for @
	$user = \App\User::where('username','=',$searchID)->first();
	if($user==null)
	{
		$user = \App\User::where('email','=',$searchID)->first();
		if($user==null)
		{
			return View::make('resetStart')->with('foundStatus', 'false');
		}
		
	}
	
	//generate reset code
	$seed = str_split('abcdefghijkmnopqrstuvwxyz'
                 .'ABCDEFGHJKLMNPQRSTUVWXYZ'
                 .'23456789'); // and any other characters
	shuffle($seed); // probably optional since array_is randomized; this may be redundant
	$rand = '';
	foreach (array_rand($seed, 30) as $k) $rand .= $seed[$k];

	$user->resetCode = $rand;
	$user->save();
	$data = array('name' => $user->first . " " . $user->last, 'code' => 'https://storybook.cjtinc.org/resetLink?code=' . $user->resetCode, 'toEmail' => $user->email);
		
	//Send the message
	Mail::send('emails.reset', $data, function($message) use ($data)
	{
		$message->from('admin@storybook.cjtinc.org', 'Storybook Admin');
		$message->to($data['toEmail'])->subject('Storybook Password Reset');
	});
	
	
	return View::make('resetSent');
	
	//echo $user->first . " " . $user->last;
	
	
	//return View::make('resetStart');
});

Route::get('resetLink', function()
{
	//$user = \App\User::where('confirmationCode','=',Input::get('code'))->first();
	return View::make('newPassword')->with('code', Input::get('code'));
	
});

Route::post('resetLink', function()
{
	//echo "password changed";
	$user = \App\User::where('resetCode','=',Input::get('code'))->first();
	//var_dump($user);
	$user->password = Hash::make(Input::get('pass'));
	$user->save();
	return Redirect::to('login');
});




//pdf test
Route::any('downloadLetter', function()
{
	
$recordingID = Input::get('recordingID');
$recording = \App\Recording::find($recordingID);
$child = \App\Child::find($recording->childID);
$user = \App\User::find($child->userID);
require_once('tcpdf/tcpdf_autoconfig.php');
require_once('tcpdf/config/tcpdf_config.php');
require_once('tcpdf/tcpdf.php');

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


// ---------------------------------------------------------

//============================================================+
// END OF FILE
//============================================================+
$content = $pdf->Output(dirname(__FILE__). "/../lastGeneratedPDF.pdf", 'F');

$letterName = "letter_ " . $user->first . "_" . $user->last . "_" . $child->name . ".pdf";
return Response::download(dirname(__FILE__). "/../lastGeneratedPDF.pdf",$letterName);
//unlink(dirname(__FILE__) . "/../lastGeneratedPDF.pdf");
});

//pdf test
Route::get('viewRecordingsInSession', array('uses' => 'HomeController@showViewRecordings'));

Route::get('viewPostage', array('uses' => 'HomeController@showViewPostage'));

Route::post('buyPostage', array('uses' => 'HomeController@showBuyPostage'));

Route::post('requestEstimates', array('uses' => 'HomeController@doRequestEstimates'));

Route::post('finishPostage', array('uses' => 'HomeController@doFinishPostage'));

Route::get('testPath', function()
{
	//return "test path";
	//return getcwd();
	return dirname(__FILE__). "/../lastGeneratedPDF.pdf";
});

Route::any('testPostage',function()
{
	/*
	require_once(base_path() . "/vendor/easypost/easypost-php/lib/easypost.php");
	\EasyPost\EasyPost::setApiKey('1B8rYqvyKcxm2Nap4v0SbA');
	
	$fromAddress = \EasyPost\Address::create(array(
	  'company' => 'EasyPost',
	  'street1' => '118 2nd Street',
	  'street2' => '4th Floor',
	  'city' => 'San Francisco',
	  'state' => 'CA',
	  'zip' => '94105',
	  'phone' => '415-528-7555'
	));

	$toAddress = \EasyPost\Address::create(array(
	  'name' => 'George Costanza',
	  'company' => 'Vandelay Industries',
	  'street1' => '1 E 161st St.',
	  'city' => 'Bronx',
	  'state' => 'NY',
	  'zip' => '10451'
	));

	$parcel = \EasyPost\Parcel::create(array(
	  "length" => 9,
	  "width" => 6,
	  "height" => 2,
	  "weight" => 10
	));

	$shipment = \EasyPost\Shipment::create(array(
	  "to_address" => $toAddress,
	  "from_address" => $fromAddress,
	  "parcel" => $parcel,
	  "options" => array('special_rates_eligibility' => 'USPS.MEDIAMAIL')
	));

	foreach ($shipment->rates as $rate) {
	  //print("carrier");
	  var_dump($rate->carrier);
	  var_dump($rate->service);
	  var_dump($rate->rate);
	  var_dump($rate->id);
	}

/*
	$shipment = \EasyPost\Shipment::create(array(
	  'to_address' => array(
		'name' => 'George Costanza',
		'company' => 'Vandelay Industries',
		'street1' => '1 E 161st St.',
		'city' => 'Bronx',
		'state' => 'NY',
		'zip' => '10451'
	  ),
	  'from_address' => array(
		'company' => 'EasyPost',
		'street1' => '164 Townsend Street',
		'street2' => 'Unit 1',
		'city' => 'San Francisco',
		'state' => 'CA',
		'zip' => '94107',
		'phone' => '415-528-7555'
	  ),
	  'parcel' => array(
		'length' => 9,
		'width' => 6,
		'height' => 2,
		'weight' => 10
	  )
	));
	
	$shipment->buy($shipment->lowest_rate(array('USPS'), array('First')));
	$postage_label = json_decode($shipment->postage_label);
	//$shipmentDecode = json_decode($shipment);
	//file_get_contents
	//print ($shipmentDecode['label_url']);
	
	var_dump($postage_label);
	var_dump($postage_label->label_url);

	$url = $postage_label->label_url;
	$img = base_path() . "/storage/app/testPostage.png";
	file_put_contents($img, file_get_contents($url));
*/

});

Route::any('printPostage',function()
{
	require_once('tcpdf/tcpdf_autoconfig.php');
	require_once('tcpdf/config/tcpdf_config.php');
	require_once('tcpdf/tcpdf.php');
	$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	
	$pdf->SetPrintHeader(false);
	$pdf->AddPage();
	
	$pdf->StartTransform();
	$pdf->Rotate(90, 45, 45);
	$pdf->Image(base_path() . "/storage/app/testPostage1.png", -30, 20, 100, '', '', 'http://www.tcpdf.org', '', false, 300);
	$pdf->StopTransform();

	$pdf->StartTransform();
	$pdf->Rotate(90, 45, 45);
	$pdf->Image(base_path() . "/storage/app/testPostage1.png", -170, 20, 100, '', '', 'http://www.tcpdf.org', '', false, 300);
	$pdf->StopTransform();

	/*
	$pdf->AddPage();

	$pdf->StartTransform();
	$pdf->Rotate(90, 45, 45);
	$pdf->Image(base_path() . "/storage/app/testPostage1.png", -160, 20, 100, '', '', 'http://www.tcpdf.org', '', false, 300);
	$pdf->StopTransform();

	*/

	$content = $pdf->Output(dirname(__FILE__). "/../lastGeneratedPostage.pdf", 'F');

	$letterName = "postageTest.pdf";
	return Response::download(dirname(__FILE__). "/../lastGeneratedPostage.pdf",$letterName);


	echo "route test";
});


Route::any('pdfZIP', array('uses' => 'HomeController@doDownloadPDFzip'));

Route::post('donate',function()
{
	echo "success";
});

Route::any('filetest', array('uses' => 'HomeController@filetest'));

Route::any('testtime', array('uses' => 'HomeController@testtime'));