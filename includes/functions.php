<?php
/**
 * General functions file for the plugin.
 *
 * @package xapimozweblit
 * @subpackage Functions
 */


/*
|--------------------------------------------------------------------------
| USER HTML VALIDATION
|--------------------------------------------------------------------------
*/

/*
 * Validates the HTML submitted by the user for the current activity
 *
 * @todo find a good way to validate HTML - some resources submitted by the group (W3C)
 */
function xapimozweblit_validate_user_html( $html ) {
    return true;

    $html = preg_replace('/\s+/', '', $html);

    try{
        //$dom = new xapimozweblit_DOMDocument(new DOMDocument());
        $dom = new DOMDocument();
        $dom->LoadHTML($html);
        if ( $dom->validate() ) {
            return true;
        } else {
            return !$myDoc->hasErrors;
        }
    }catch (Exception $ex) {
        return false;
    }
    /*
    if ($dom->validate()) {
        echo "This document is valid!\n";
    }
    */
}

/**
 * Class to handle PHP DOMDocument errors
 *
 * @author found online, should document source
 */
class xapimozweblit_DOMDocument {

    private $_delegate;
    private $_validationErrors;

    public function __construct (DOMDocument $pDocument) {
        $this->_delegate = $pDocument;
        $this->_validationErrors = array();
    }

    public function __call ($pMethodName, $pArgs) {
        if ($pMethodName == "validate") {
            $eh = set_error_handler(array($this, "onValidateError"));
            $rv = $this->_delegate->validate();
            if ($eh) {
                set_error_handler($eh);
            }
            return $rv;
        }
        else {
            return call_user_func_array(array($this->_delegate, $pMethodName), $pArgs);
        }
    }

    public function __get ($pMemberName) {
        if ($pMemberName == "errors") {
            return $this->_validationErrors;
        }
        elseif ($pMemberName == "hasErrors") {
            return count($this->_validationErrors) > 0;
        }
        else {
            return $this->_delegate->$pMemberName;
        }
    }

    public function __set ($pMemberName, $pValue) {
        $this->_delegate->$pMemberName = $pValue;
    }

    public function onValidateError ($pNo, $pString, $pFile = null, $pLine = null, $pContext = null) {
        $this->_validationErrors[] = preg_replace("/^.+: */", "", $pString);
    }
}

?>