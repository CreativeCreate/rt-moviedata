<?php
/*
* 	Wrapper for Admin page
*	Display admin's front-end data and settings
* 	Inputs : rtmdcc_apikey, Movies per page, Type(in theaters, dvd), Show Tooltip
*/

?>
<h3><?php esc_attr_e( get_admin_page_title(), 'wp_admin_style' ); ?></h3>

<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>
	<h2><?php esc_attr_e( 'Settings', 'wp_admin_style' ); ?></h2>
	<div id="poststuff">
		<div id="post-body" class="metabox-holder columns-2">
			<!-- main content (Settings & Results Display) -->
			<div id="post-body-content">
				<div class="meta-box-sortables ui-sortable">
					
					<!-- API-Key Error Display -->
					<?php if($rtmdcc_errAPI) : ?>
						<div class="postbox">
							<div class="handlediv" title="Click to toggle"><br></div>	<!-- Toggle -->
							<h3 class="hndle"><span><?php esc_attr_e( 'Add User API Key', 'wp_admin_style' ); ?></span></h3>
							<div class="inside">
								<p>This plugin uses RT (Rotten Tomatoes) API and only registered users with RT who already have credentials can access to feeds. Users need to enter RT API-Key in order to access data through this plugin. <a href="http://developer.rottentomatoes.com/member/register" target="_blank">Click here to register</a> for a user account at RT. Once the registration is completed please enter your API Key below. Find more detail about this API <a href='http://developer.rottentomatoes.com/' target="_blank">here.</a> 
                                </p>
                                <p><strong>Important: </strong>This plugin does not have any ties to RT and it only parses and reads the API, XML content. Using these parsed data within terms of RT is responsibility of the user. Please view <a href="http://www.rottentomatoes.com/terms" target="_blank">Rotten Tomatoes Terms</a> for more info.<p>
								<p>
									<form action="" method="post" name="form_rtmdcc_apikeysubmit">
										<input type="hidden" name="rtmdcc_last_update" value="<?php echo time(); ?>">
										<label for="rtmdcc_apikey">Your API KEY :</label>
										<input type="text" name="rtmdcc_apikey" value="" class="regular-text <?php echo ($rtmdcc_errAPI) ? 'errAPI' : null; ?>" 
										style="border: 2px solid #F00;" placeholder="<?php echo $rtmdcc_errAPI ?>" />
										<input type="submit" value="Add User">
									</form>
								</p>
							</div><!-- .inside -->
						</div><!-- .postbox -->
					<?php endif ?>

					<!-- API Pass. Settings & Results Display -->
					<?php if(!$rtmdcc_errAPI) : ?>
                       
                        <!-- Movie Display Settings -->
						<div class="postbox">
							<div class="handlediv" title="Click to toggle"><br></div>	<!-- Toggle -->
							<h3 class="hndle"><span><?php esc_attr_e( 'Movie Display Settings', 'wp_admin_style' ); ?></span></h3>
							<div class="inside">
								<p><?php esc_attr_e( 'Default settings for results to be filtered and displayed in pages/posts.', 'wp_admin_style' ); ?></p>
								<p>
									<form action="" method="post" name"form_displaysetting">
										<?php //settings_fields('rtmdcc_admin_settings_group' ); ?>
    									<?php //echo 'test'.get_option('rtmdcc_last_update'); ?>

										<input type="hidden" id="rtmdcc_last_update" name="rtmdcc_last_update" value="<?php echo time() ?>">
										<label for="rtmdcc_movie_limit">Number of Movies :</label>
										<input type="number" min="1" max="30" step="1" name="rtmdcc_movie_limit" value="<?php echo ($rtmdcc_options['rtmdcc_movie_limit'])? $rtmdcc_options['rtmdcc_movie_limit'] : '' ; ?>" class="small-text" />
										<br><br>
										<label for="rtmdcc_num_cols" >Number of Columns :</label>
										<select name="rtmdcc_num_cols">
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '0' ? 'selected' : '' ; ?> value='0'>auto</option>
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '1' ? 'selected' : '' ; ?> value='1'>1</option>
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '2' ? 'selected' : '' ; ?> value='2'>2</option>
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '3' ? 'selected' : '' ; ?> value='3'>3</option>
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '4' ? 'selected' : '' ; ?> value='4'>4</option>
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '5' ? 'selected' : '' ; ?> value='5'>5</option>
											<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '6' ? 'selected' : '' ; ?> value='6'>6</option>
										</select>
										<br><br>
										<label for="rtmdcc_show_tooltips">Display Tool tips :</label>
										<input type="checkbox" name="rtmdcc_show_tooltips" value="Y" <?php echo ($rtmdcc_options['rtmdcc_show_tooltips'] === 'Y') ? 'checked': ''; ?> />
										<br><br>
										<label for="rtmdcc_movie_type">Type of Movies to display  :</label>
										<select name="rtmdcc_movie_type" id="rtmdcc_movie_type">
											<option <?php echo ($rtmdcc_options['rtmdcc_movie_type'] == 'box_office') ? 'selected' : '' ; ?> value="box_office">Box Office</option>
											<option <?php echo ($rtmdcc_options['rtmdcc_movie_type'] == 'in_theaters') ? 'selected' : '' ; ?> value="in_theaters">In Theaters</option>
											<option <?php echo ($rtmdcc_options['rtmdcc_movie_type'] == 'opening') ? 'selected' : '' ; ?> value="opening">Opening Movies</option>
											<option <?php echo ($rtmdcc_options['rtmdcc_movie_type'] == 'upcoming') ? 'selected' : '' ; ?> value="upcoming">Upcoming Movies</option>
										</select>
										<br><br>
										<label for="rtmdcc_hi_res">Use Hi-Resolution Poster Image :</label>
										<input type="checkbox" name="rtmdcc_hi_res" value="Y" <?php echo ($rtmdcc_options['rtmdcc_hi_res'] == 'Y') ? 'checked':''; ?> />
										<br><br>
										<input type="submit" value="Save Changes">
									</form>
								</p>
							</div><!-- .inside -->
						</div><!-- .postbox -->

						<!-- Results Preview -->
						<div class="postbox">
							<div class="handlediv" title="Click to toggle"><br></div>		<!-- Toggle -->
							<h3 class="hndle"><span><?php esc_attr_e( 'Result Preview', 'wp_admin_style' ); ?></span></h3>
							<div class="inside" style="max-height:400px; overflow:auto;">	<!-- only 2 inline styles. Let's avoid server request -->						
								<?php require('rt-moviedata-page.php'); //preview uses same front-end as pages ?>
							</div><!-- .inside -->
						</div><!-- .postbox -->


					<?php endif ?>
					

				</div><!-- .meta-box-sortables .ui-sortable -->
			</div><!-- post-body-content -->

			<!-- sidebar (API-Key Detail) -->
			<div id="postbox-container-1" class="postbox-container">
				<div class="meta-box-sortables">

					<!-- API Key Info -->
					<?php if(!$rtmdcc_errAPI) : ?>
					<div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div><!-- Toggle -->
						<h3 class="hndle"><span><?php esc_attr_e('Current User Info', 'wp_admin_style'); ?></span></h3>
						<div class="inside">
							<p><?php esc_attr_e( 'Current data is displayed for following API-KEY user. To change user, please insert a new API-KEY and resubmit.', 'wp_admin_style' ); ?></p>
							<p>
								<form action="" method="post" name="form_rtmdcc_apikeyEdit">
									<input type="hidden" name="rtmdcc_last_update" value="<?php echo time(); ?>">
									<label for="rtmdcc_apikey">Your API KEY :</label>
									<input class="<?php echo $rtmdcc_errAPI ?>" type="text" name="rtmdcc_apikey" value="<?php echo $rtmdcc_options['rtmdcc_apikey']; ?>"/>
									<input type="submit" value="Change">
								</form>
						</div><!-- .inside -->
					</div><!-- .postbox -->
					
					<!-- Shortcode list -->
                    <div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div><!-- Toggle -->
						<h3 class="hndle"><span><?php esc_attr_e('How To Use', 'wp_admin_style'); ?></span></h3>
						<div class="inside">
							<p><strong>In Pages/Posts</strong></p>
                            <p>Copy and past below shortcode and modify it's attributes in your Page/Post.</p>
                            <code>[rtmdcc_sc rtmdcc_movie_limit = '3' rtmdcc_num_cols = '1' rtmdcc_movie_type ='in_theaters' rtmdcc_show_tooltips ='Y' rtmdcc_hi_res ='Y']</code>
                            <ol>
                            	<li><code>[rtmdcc_sc]</code> (Default settings)</li>
                                <li><code>rtmdcc_movie_limit = 'Number'</code> (Max 40. Number of total movies to display)</li>
                                <li><code>rtmdcc_num_cols = 'Number'</code> (1 to 6. Number of columns)</li>
                                <li><code>rtmdcc_movie_type = 'box_office | in_theaters | opening | upcoming'</code> (Movie category)</li>
                                <li><code>rtmdcc_show_tooltips = 'Y|N'</code> (Show tooltips)</li>
                                <li><code>rtmdcc_hi_res = 'Y|N'</code> (Display Hi-res images)</li>
                            </ol><br>
							<p><strong>In Widgets</strong></p>
                            <p>Use <strong>"Movie Data from RT"</strong> widget from the <a href="/wp-admin/widgets.php">available widgets list.</a></p>
                            <br>
						</div><!-- .inside -->
					</div><!-- .postbox -->
					
					<!-- Disclaimer info -->
                    <div class="postbox">
						<div class="handlediv" title="Click to toggle"><br></div><!-- Toggle -->
						<h3 class="hndle"><span><?php esc_attr_e('Important Note: The sole purpose of this plugin', 'wp_admin_style'); ?></span></h3>
						<div class="inside">
							<p>This plugin uses RT (Rotten Tomatoes) API and only registered users with RT who already have credentials can access to feeds. Users need to enter RT API-Key in order to access data through this plugin. This plugin does not have any ties to RT and it only parses and reads the API, XML content. Using these parsed data within terms of RT is responsibility of the user. Please view <a href="http://www.rottentomatoes.com/terms" target="_blank">Rotten Tomatoes Terms</a> for more info.</p>

						</div><!-- .inside -->
					</div><!-- .postbox -->
                    
					<?php endif ?>
                    
                    
				</div><!-- .meta-box-sortables -->
			</div><!-- #postbox-container-1 .postbox-container -->

		</div><!-- #post-body .metabox-holder .columns-2 -->
		<br class="clear">
	</div><!-- #poststuff -->
</div> <!-- .wrap -->