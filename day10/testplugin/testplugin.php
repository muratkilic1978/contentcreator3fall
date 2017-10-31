<?php
/**
* Plugin Name: testplugin
* Plugin URI: http://www.nodomain.com
* Description: This is my first WordPress Plugin named testplugin
* Version: 0.1
* Author: Murat Kilic
* Author URI: http://www.nodomain.com
* License: GPLv3
**/

function insert_into_db() {
    
    global $wpdb;
    # Creates a new table inside your existing wp-database if table not exists
    # Giving the table a prefix name
    $table = $wpdb->prefix . "testplugin";
    # Setting database charset
    $charset_collate = $wpdb->get_charset_collate();
    # Creating table with a SQL-QUERY
    $sql = "CREATE TABLE IF NOT EXISTS $table (
    `id` MEDIUMINT NOT NULL AUTO_INCREMENT,
    `stagename` TEXT NOT NULL,
    `capacity` MEDIUMINT NOT NULL,
    `url` TEXT NOT NULL,
    UNIQUE (`id`)
    ) $charset_collate;";
    
    #Including upgrade.php file
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php');
    
    dbDelta( $sql );
    # Starts output buffering
    ob_start();
    
?>
    <!-- Here I will create my HTML-Form with fields -->
    <form action="#v_form" method="post" id="v_form">
        <label for="stagename">
            <h3>Name of stage:</h3>
        </label>
        <input type="text" name="stagename" id="stagename">
        
        <label for="capacity">
            <h3>Max capacity of stage:</h3>
        </label>
        <input type="number" min="1000" max="50000" name="capacity" id="capacity">
        
        <label for="url">
            <h3>Type MAP Location URL:</h3>
        </label>
        <input type="url" name="url" id="url">
        <input type="submit" name="submit_form" value="submit">
        
    </form>
    <!-- END HTML-Form -->
    
    <?php
    # Gets the current buffer contents and delete current output buffer.
    $html = ob_get_clean();
    # Does the inserting part, in case the form is filled out and submitted
    if (isset ($_POST["submit_form"]) && $_POST["stagename"] != "" && $_POST["capacity"] != "" ) {
        # Setting table prefix
        $table = $wpdb->prefix."testplugin";
        # Collecting data from input fields and store it in a variable
        $stagename = strip_tags($_POST["stagename"], "");
        $capacity = strip_tags($_POST["capacity"], "");
        $url = $_POST["url"];
        # Inserting data from the variables upon into the correct columnnames inside our table testplugin
        $wpdb->insert(
            $table,
            array(
                'stagename' => $stagename,
                'capacity' => $capacity,
                'url' => $url
            )
        );
        # Writing out a message after inserting the content into the database
        $html = "<p>The stage with the folowing name <strong>$stagename</strong> was successfully added. Thanks!</p>";
    }
    # if the form is submitted but the stagename field is empty run this
    if (isset( $_POST["submit_form"] ) && $_POST["stagename"] == "" ) {
        $html .= "<p>You need to fill out the required fields!</p>";
    }
    # Outputs everything
    return $html;
}

# Adding a WordPress shortcode that can be used on either a wordpress blog or page

add_shortcode('testplugin', 'insert_into_db');






