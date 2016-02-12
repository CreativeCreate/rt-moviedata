<?php
	echo '<ul id="mtd_widegt_wrapper" class="col'. $rtmdcc_options['rtmdcc_num_cols'] .'">';
	//output jason data
	
	for ($i=0; $i <= $rtmdcc_options['rtmdcc_movie_limit']-1; $i++){
		if(count($movie_data->{'movies'}) > $i){			// if API list is less than movie limit
			$output = "<li><a href='".$movie_data->{'movies'}[$i]->{'links'}->alternate."' target='_blank'><img src='".rtmdcc_getPosterImg($movie_data->{'movies'}[$i]->{'posters'}->thumbnail, $rtmdcc_options['rtmdcc_hi_res'])."'></a>" ;
			$output .= "<p>".$movie_data->{'movies'}[$i]->title ."</p>" ;
			if($instance['rtmdcc_show_tooltips'] == 'Y'){
				$output .= "<ul>";
				$output .= "<li>Title : ".$movie_data->{'movies'}[$i]->title ."</li>" ;
				$output .= "<li>Year : ".$movie_data->{'movies'}[$i]->year ."</li>" ;
				$output .= "<li>Rating : ".$movie_data->{'movies'}[$i]->mpaa_rating ."</li>" ;
				$output .= "<li>Score : Critics (".$movie_data->{'movies'}[$i]->{'ratings'}->critics_score .") | Audience (".$movie_data->{'movies'}[$i]->{'ratings'}->audience_score.")</li>" ;
				$output .= "</ul>";
			}
			$output .= "</li>";
			echo $output;
		}
	}
	echo '</ul>';
?>