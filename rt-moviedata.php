<?php
/*
Plugin Name: Movie Data from RT
Description: Display various movie data (Title, Year, Rating, Poster, Description etc.) from "Rotten Tomatoes". Flexible column design, tool-tips, short-codes & widget to display your movies professionally.
Plugin URI: http://creativecreate.com/rtmd/
Version: 1.0.4
Author: CreativeCreate LLC
Author URI: http://creativecreate.com
License: GPL2
*/

/*
* global vars
*/
$rtmdcc_dbTable = 'rt_moviedata_cc';								// option db table
$rtmdcc_options = array(											// default settings
	'rtmdcc_movie_type'		=> 	'in_theaters',
	'rtmdcc_movie_limit'	=> 	'6',
	'rtmdcc_num_cols'		=> 	'auto',
	'rtmdcc_show_tooltips'	=>	'Y',
	'rtmdcc_hi_res'			=>	'',
	'rtmdcc_apikey' 		=>	''	 				
	);
$rtmdcc_errAPI				= null;									// api-key error check
	$rtmdcc_savedOptions 	= get_option($rtmdcc_dbTable); 			// if rtmdcc_apikey is not set yet
	$rtmdcc_errAPI 			= ($rtmdcc_savedOptions['rtmdcc_apikey'] === null) ? 'API-Key is not set' : null; 

/*
*	Set Admin Menu Links
*/
function rtmdcc_menu(){
	add_menu_page( 'Movie Data from RT', 'RT Movie Data', 'manage_options', 'movie-data-from-rt', 'rtmdcc_settings','','20.111');
}
add_action( 'admin_menu', 'rtmdcc_menu' );


/*
*	functions
*/
//	get saved settings
function rtmdcc_get_settings(){
	global $rtmdcc_dbTable, $rtmdcc_options;
	return get_option( $rtmdcc_dbTable, $rtmdcc_options ); 			// set saved db settings if exsist Or use default
}
// update
function rtmdcc_update_setting($newdata){ 
	global $rtmdcc_dbTable, $rtmdcc_errAPI;
	$rtmdcc_options = rtmdcc_get_settings();						// get saved db settings
	foreach ($newdata as $key => $value) { 							// assign new values
		$rtmdcc_options[$key] = strip_tags($value); 
	}
	update_option( $rtmdcc_dbTable, $rtmdcc_options);				// saved to db
}
//	get json data from rottentomato
function rtmdcc_getMovieData($rtmdcc_options){
	global $rtmdcc_errAPI;
	$url = "http://api.rottentomatoes.com/api/public/v1.0/lists/movies/".$rtmdcc_options['rtmdcc_movie_type'].".json?apikey=".$rtmdcc_options['rtmdcc_apikey'];
	$jsonData = wp_remote_get( $url );
	$resultsArray = json_decode($jsonData['body']);
	if(isset($resultsArray->{'error'})){
		$rtmdcc_errAPI = $resultsArray->{'error'};					// error message True and assigned
	}else{
		return $resultsArray; 										// movie data
	}
}
// validate API-Key
function rtmdcc_validate_apikey($validateValues){
	$validateValues['rtmdcc_movie_type']	= 	'in_theaters';		// temp req movie_type value for validating
	return rtmdcc_getMovieData($validateValues);
};
// hi-res vs low-res poster image selection. Replace "resizing.flixster.com/...cloudfront.net" to "content6.flixster.com"
// 03/07/2016 update after RT switches it's urls. Hi-res poster be created only if it available

function rtmdcc_getPosterImg($imgurl, $hiResImg){	
	if($hiResImg == 'Y'){											// if hi-res selected
		$posterUrl	= explode('.net', $imgurl);						// get url text after "...cloudfront.net"
		$imgurl		= ($posterUrl[1]) ?'http://content6.flixster.com'.$posterUrl[1]:$imgurl;	// add hi-res domain if available.	
	}
	return $imgurl;
}


/*
*	Admin Front-End
*/	
// when new admin settings post
// the only settings we save to the db
if( isset($_POST['rtmdcc_last_update'])){
	if(!array_key_exists('rtmdcc_apikey', $_POST)){															// when settings only updated 
		$_POST['rtmdcc_show_tooltips'] = (array_key_exists('rtmdcc_show_tooltips', $_POST)) ? 'Y' : null ;		// if tooltip checked
		$_POST['rtmdcc_hi_res'] 		= (array_key_exists('rtmdcc_hi_res', $_POST)) ? 'Y' : null ;			// if tooltip checked
		rtmdcc_update_setting($_POST); 																			// run update fun
	}else{																									// when API-Key only updated (*need to validate)
		$validateResults = rtmdcc_validate_apikey($_POST);
		if($validateResults != null){ 
			global $rtmdcc_errAPI;
			rtmdcc_update_setting($_POST);		// run update if validated
			$rtmdcc_errAPI = null;				// set API KEY error to null;
		}
	}
}
// display admin front-end
function rtmdcc_settings(){
	global $rtmdcc_errAPI;
	$rtmdcc_options = rtmdcc_get_settings();							// get saved db settings
	(!current_user_can('manage_options'))? wp_die('Sorry you do not have enough permission to preform this task'): null ;
	$movie_data = rtmdcc_getMovieData($rtmdcc_options);					// get db data
	require('inc/rt-moviedata-settings.php');							// settings page
}


/*
* register widget
*/
class rtmdcc_Widget extends WP_Widget {
	/**
	 * Sets up the widgets name etc
	 */
	public function __construct() {
		parent::__construct(
			'rt_moviedata_cc',											// base name
			'Movie Data from RT',								// Title
			array('description' => 'Display various movie data (Title, Year, Rating, Poster, Description etc.) from "Rotten Tomatoes".')	
			);
	}

	/**
	 * Outputs the content of the widget
	 */
	public function widget( $args, $instance ) {
		$title = null; 
		global $rtmdcc_errAPI;		
		$rtmdcc_options = rtmdcc_get_settings();						// get saved db settings
		extract($args);	
		foreach ($instance as $key => $value) {							// get saved widegt-settings and assigned to options
			($key === 'title') ? $title = apply_filters( 'widget_title', $instance['title'] ) :	$rtmdcc_options[$key] = $value ;
		}
		// output widget content
		echo $before_widget;											// outputs widget struture
		echo $before_title. $title . $after_title;						// outputs widget title
		if($rtmdcc_errAPI === null){
			$movie_data	= rtmdcc_getMovieData($rtmdcc_options);			// get jason data
			require('inc/rt-moviedata-widget.php');						// front-end.php
		}else{
			echo '<p class="rtmdcc_error_message">'. $rtmdcc_errAPI.'. Data cannot be retrieved.Please check the plugin settings page</p>';
		}
		echo $after_widget;												// outputs widget struture
	}

	/**
	 * Outputs the options form for admin
	 */
	public function form( $instance ) {
		global $rtmdcc_options, $rtmdcc_errAPI, $rtmdcc_dbTable;		
		$rtmdcc_options = rtmdcc_get_settings();						// get saved db settings
		foreach ($instance as $key => $value) {							// get saved widegt-settings
			$rtmdcc_options['rtmdcc_hi_res'] = !empty($instance['rtmdcc_hi_res']) ? $instance['rtmdcc_hi_res'] : null ;
			$rtmdcc_options['rtmdcc_show_tooltips'] = !empty($instance['rtmdcc_show_tooltips']) ? $instance['rtmdcc_show_tooltips'] : null ;
			$rtmdcc_options[$key] = !empty($instance[$key]) ? esc_attr( $value ) : null ;
		}
		if($rtmdcc_errAPI === null){
			require('inc/rt-moviedata-widget-settings.php');
		}else{
			echo '<p class="rtmdcc_error_message">'. $rtmdcc_errAPI.'. Please check the plugin settings page</p>';	// if errors error message
		}
	}

	/**
	 * Processing widget options on save ( class WP_widget creates option table and no need of a new table )
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		foreach ($new_instance as $key => $value) {
			$instance[$key] = ($new_instance[$key] != null) ? strip_tags($value) : $old_instance[$key];	// sanitized & update widget settings
		}
		$instance['rtmdcc_hi_res'] = !empty($new_instance['rtmdcc_hi_res']) ? $new_instance['rtmdcc_hi_res'] : null ;
		$instance['rtmdcc_show_tooltips'] = !empty($new_instance['rtmdcc_show_tooltips']) ? $new_instance['rtmdcc_show_tooltips'] : null ;
		return $instance;
	}

}

function rtmdcc_register_widgets (){
	register_widget('rtmdcc_Widget');
}
add_action('widgets_init', 'rtmdcc_register_widgets' );



/*
* register shortcode
*/
function rtmdcc_shortcode($atts, $content = null){
	global $post,$rtmdcc_options,$rtmdcc_errAPI;
	$rtmdcc_options = rtmdcc_get_settings();							// get saved db settings	
	$shortcodelist = shortcode_atts($rtmdcc_options, $atts);			// get SC values
	
	foreach ($shortcodelist as $key => $value) {
		if($key === 'rtmdcc_show_tooltips' || $key === 'rtmdcc_hi_res'){
			$value === 'Y' ? $rtmdcc_options[$key] = 'Y' : $rtmdcc_options[$key] = '';		
		}else{
			$rtmdcc_options[$key] = $value;								// assign SC settings 
		}
	}
	// API no Errors
	if($rtmdcc_errAPI === null){
		$movie_data	= rtmdcc_getMovieData($rtmdcc_options);				// get jason data
		ob_start(); 													// buffer loading content
		require('inc/rt-moviedata-page.php');
		$content = ob_get_clean();
		return $content;
	}else{
		echo '<p class="rtmdcc_error_message">'. $rtmdcc_errAPI.'. Data cannot be retrieved.Please check the plugin settings page</p>';
	}
}
add_shortcode('rtmdcc_sc', 'rtmdcc_shortcode');


/*
* enque_styles and scripts
*/
// front-end-styles
function rtmdcc_styles(){
	wp_enqueue_style( 'rtmdcc_styles', plugins_url( 'movie-data-from-rt/assets/rt-moviedata-styles.css' ));
	wp_enqueue_script('rtmdcc_scripts', plugins_url('movie-data-from-rt/assets/rt-moviedata-scripts.js'), null, '0.9',true);
}
add_action('wp_enqueue_scripts', 'rtmdcc_styles');

// back-end scripts and styles
function rtmdcc_styles_Admin($suffix) {
	if( strpos($suffix, 'movie-data-from-rt')){
		// we use same css and js for front and back both.
		wp_enqueue_style( 'rtmdcc_styles', plugins_url( 'movie-data-from-rt/assets/rt-moviedata-styles.css' ));
		wp_enqueue_script('rtmdcc_scripts', plugins_url('movie-data-from-rt/assets/rt-moviedata-scripts.js'), null, '0.9',true);
        //Since WP admin UI postbox show-hide option is not default.
        wp_enqueue_script( 'postbox' );
        wp_enqueue_script( 'postbox-edit', plugins_url('movie-data-from-rt/assets/rt-moviedata-scripts-admin.js'), array('jquery', 'postbox') );
    }
}
add_action( 'admin_enqueue_scripts', 'rtmdcc_styles_Admin' );

?>