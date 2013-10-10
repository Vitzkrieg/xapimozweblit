<?php

/*
 * xAPIMozWebLit Admin Functions
 */

function xapimozweblit_admin_register_head() {

    $url = XAPIMOZWEBLIT_ADMIN . '/admin.css';
    echo "<link rel='stylesheet' type='text/css' href='$url' />\n";

}

add_action('admin_head', 'xapimozweblit_admin_register_head');

?>
