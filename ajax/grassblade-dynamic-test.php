<?php

/*
@verb = supported xAPI verb
@result = was the activity completed succesfully?
@object = the WordPress page the activity was attempted on
@context = the larger picture the activity is included in (Moz Web Lit)
*/
function grassblade_dynamic($verb, $result, $object){

	if ( !function_exists ( "grassblade_send_statements" ) ) {
		return;
	}

	$statement = 	array(
							"actor" => grassblade_getactor($guest_tracking = true),
							"verb" => grassblade_getverb($verb),
							"result" =>  array(
											"success" => $result
											),
							/*
							Make this be the page they are currently on
							*/
							"object" => grassblade_getobject("http://domain.com/wordpress/quizzes/quiz-1/", "Walkthrough Link", "Test Desc", "http://adlnet.gov/expapi/activities/interaction"),
							/*
							Need to customize this
							Probably have it realate to the Moz Web Lit(s)
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
	echo "<h3>Statement</h3>";
	echo "<pre>";
	print_r($statements);
	echo "</pre>";
	echo "<h3>Return Value</h3>";
	echo "<pre>";
	print_r(grassblade_send_statements($statements));
	echo "</pre>";

	//grassblade_send_statements($statements);
}
//add_action("init", "grassblade_api_test");
?>