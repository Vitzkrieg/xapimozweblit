
var myURL = document.URL;

// Get the editor instance that you want to interact with.
var editor = undefined;

function initCKEditor() {

	// The instanceReady event is fired, when an instance of CKEditor has finished
	// its initialization.
	CKEDITOR.on( 'instanceReady', function( ev ) {
		// Show the editor name and description in the browser status bar.
		if (ev.editor.name !== "comment") {
			editor = ev.editor;

			//listen to click events of ckeditor buttons
			var buttons = jQuery('#cke_' + ev.editor.name + ' .cke_button');
			buttons.on('click', trackButtonClick);
		}
	});

	//create instance of CKEditor
	$( 'textarea.ckeditor' ).ckeditor();

	//submit button
	$( '#mozweblitsubmit' ).on('click', GetContents);

}


//start things off after everything is loaded
$( document ).ready( function(){
	initCKEditor();
} );



function handleAJAXResponse( response ) {
	var contents = editor.getData();
	contents += "<p>Response: " + response + "</p>";
	$("#displayoutput").contents().find('body').html(contents);
}


function passStatementArgs(action, data){
	$("#displayoutput").contents().find('body').html('');

	jQuery.post(
		MyAjax.ajaxurl,
		{
			action : action,
			postCommentNonce : MyAjax.postCommentNonce,
			postID : MyAjax.postID,
			data : data
		},
		handleAJAXResponse
	);
}


function trackButtonClick(event){
	if (!editor) return;

	var buttonTitle = jQuery(this).attr('title');

	var verb = ADL.verbs.interacted;
	verb["display"] = {"en-US" : "clicked"};

	//track editor button clicks
	passStatementArgs( 'myajax-button', {
		verb: verb,
		name : buttonTitle
	});
}


function GetContents() {
	if (!editor) return;

	var contents = editor.getData();
	//alert(contents);

	var verb = ADL.verbs.answered;

	passStatementArgs( 'myajax-submit', {
		verb: verb,
		result: {
			response: '"' + contents + '"'
		}
		});
}


function validateContents(contents){

	var pattern = /^<([a-z]+)([^<]+)*(?:>(.*)<\/\1>|\s+\/>)$/;

}