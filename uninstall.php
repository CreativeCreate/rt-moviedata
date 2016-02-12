<?php 
// If uninstall is not called from WordPress, exit
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit();
}
 
$option_name = array(
				'rt_moviedata_cc', 								// plugin option table
				'widget_rotten_tomatoes_movie_data'				// widget option table
				);				 
foreach($option_name as $value){
	delete_option( $value );
}

?>