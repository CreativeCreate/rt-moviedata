<?php 
	echo "<div id='rtmdcc_table' class='col". $rtmdcc_options['rtmdcc_num_cols'] ."''>";
	echo ($rtmdcc_options['rtmdcc_num_cols'] >= 2) ? '<ul id="mtd_widegt_wrapper" class="std-page col'. $rtmdcc_options['rtmdcc_num_cols'] .'">' : null;
	for ($i=0; $i <= $rtmdcc_options['rtmdcc_movie_limit']-1; $i++){
		if(count($movie_data->{'movies'}) > $i){			// if API list is less than movie limit
			$des = ($rtmdcc_options["rtmdcc_show_tooltips"]) ? str_replace("'", "", $movie_data->{"movies"}[$i]->synopsis) : '' ;
			
			$output ='';
			if($rtmdcc_options['rtmdcc_num_cols'] <= 1){
				$output = '<table><tr data-desc="'. $des .'">';
				$output .= "<td><a href='".$movie_data->{'movies'}[$i]->{'links'}->alternate."' target='_blank'><img src='".rtmdcc_getPosterImg($movie_data->{'movies'}[$i]->{'posters'}->thumbnail, $rtmdcc_options['rtmdcc_hi_res'])."'></a></td>" ;
				$output .= "<td><table>";
					$output .= "<tr><td>Title </td><td>: ".$movie_data->{'movies'}[$i]->title ."</td></tr>" ;
					$output .= "<tr><td>Year </td><td>: ".$movie_data->{'movies'}[$i]->year ."</td></tr>" ;
					$output .= "<tr><td>Rating </td><td>: ".$movie_data->{'movies'}[$i]->mpaa_rating ."</td></tr>" ;
					$output .= "<tr><td>Score </td><td>: Critics (".$movie_data->{'movies'}[$i]->{'ratings'}->critics_score .") | Audience (".$movie_data->{'movies'}[$i]->{'ratings'}->audience_score.")</td></tr>" ;
				$output .= "</table></td>";
				$output .= "</tr></table>";
			}
			if($rtmdcc_options['rtmdcc_num_cols'] > 1){
				$output = "<li><a href='".$movie_data->{'movies'}[$i]->{'links'}->alternate."' target='_blank'><img src='".rtmdcc_getPosterImg($movie_data->{'movies'}[$i]->{'posters'}->thumbnail, $rtmdcc_options['rtmdcc_hi_res'])."'></a>" ;
				$output .= "<p>".$movie_data->{'movies'}[$i]->title ."</p>" ;
				if($rtmdcc_options['rtmdcc_show_tooltips'] == 'Y'){
					$output .= "<ul>";
					$output .= "<li>Title : ".$movie_data->{'movies'}[$i]->title ."</li>" ;
					$output .= "<li>Year : ".$movie_data->{'movies'}[$i]->year ."</li>" ;
					$output .= "<li>Rating : ".$movie_data->{'movies'}[$i]->mpaa_rating ."</li>" ;
					$output .= "<li>Score : Critics (".$movie_data->{'movies'}[$i]->{'ratings'}->critics_score .") | Audience (".$movie_data->{'movies'}[$i]->{'ratings'}->audience_score.")</li>" ;
					$output .= "</ul>";
				}
				$output .= "</li>";
			}
			echo $output;
		}
	}
	echo ($rtmdcc_options['rtmdcc_num_cols'] >= 2) ? '</ul>' : null;
	echo "</div>";
?>	