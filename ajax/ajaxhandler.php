<?php

require_once('../includes/functions.php');
require_once('../../grassblade/grassblade.php');

$data = $_POST["data"];
$name = (isset($data["name"])) ? $data["name"] : "Unknown User";
$verb = (isset($data["verb"])) ? $data["verb"]["display"]["en-US"] : "interacted";
$result = (isset($data["result"])) ? $data["result"]["response"] : NULL;
$object = (isset($data["object"])) ? $data["object"]["definition"]["name"] : "a button";

$statement = $name;

$statement .= " " . $verb;

$statement .= " with " . $object;


if($result){
	if ($errors = xapimozweblit_validate_user_html('' . $result)) {
		$valid_str = " is valid.";
	} else {
		$valid_str = " is not valid.";

		foreach ($errors as $error) {
			$valid_str .= PHP_EOL . $error;
		}
	}

	$statement .= " and " . $valid_str . PHP_EOL . $result;
}

/*
@verb = supported xAPI verb
@result = was the activity completed succesfully?
@object = the WordPress page the activity was attempted on
@context = the larger picture the activity is included in (Moz Badge)
*/
function grassblade_dynamic($verb, $result, $object){

	$return = 'grassblade_dynamic()' . '<br />';

	if ( !function_exists ( "grassblade_send_statements" ) ) {
	$return .= "grassblade_send_statements() does not exist." . '<br />';
		return $return;
	}

	$statement = 	array(
							"actor" => grassblade_getactor($guest_tracking = true),
							"verb" => grassblade_getverb(verb),
							"result" =>  array(
											"success" => result
											),
							/*
							Make this be the page they are currently on
							*/
							"object" => grassblade_getobject("http://domain.com/wordpress/quizzes/quiz-1/", "Walkthrough Link", "Test Desc", "http://adlnet.gov/expapi/activities/interaction"),
							/*
							Need to customize this
							Probably have it realate to the Moz Badge(s)
							"context" => array(
											"contextActivities" => array(
												"parent" => grassblade_getobject("http://domain.com/wordpress/course/course-1/", "Test Parent", "Test Parent Desc", "http://adlnet.gov/expapi/activities/course"),
												"grouping" => grassblade_getobject("http://domain.com/wordpress/course/course-1/", "Test Parent", "Test Parent Desc", "http://adlnet.gov/expapi/activities/course"),
											)
										),
										*/
							);

	$statements = array($statement);

	//Uncomment to debug
	$return .= "<h3>Statement</h3>" . '<br />';
	$return .=  "<pre>" . '<br />';
	$return .= print_r($statements) . '<br />';
	$return .= "</pre>" . '<br />';
	$return .= "<h3>Return Value</h3>" . '<br />';
	$return .= "<pre>" . '<br />';
	$return .= print_r(grassblade_send_statements($statements)) . '<br />';
	$return .= "</pre>";

	return $return;

	//grassblade_send_statements($statements);
}

$statement .= grassblade_dynamic($verb, $result, $object);

echo $statement;

?>