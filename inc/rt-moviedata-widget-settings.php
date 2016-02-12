<p>
<lable for='<?php echo $this->get_field_name("title"); ?>' >Title</lable>
<input class='regular-text' name='<?php echo $this->get_field_name("title"); ?>' type='text' value="<?php echo !empty($instance['title']) ? $instance['title'] : null; ?>">

<h4>Display Settings</h4>
<label for="<?php echo $this->get_field_name("rtmdcc_movie_limit"); ?>">Number of Movies :</label>
<input type="number" min="1" max="30" step="1" name="<?php echo $this->get_field_name("rtmdcc_movie_limit"); ?>" value="<?php echo $rtmdcc_options['rtmdcc_movie_limit']; ?>" class="small-text" />
<br><br>
<label for="<?php echo $this->get_field_name("rtmdcc_num_cols"); ?>" >Number of Columns :</label>
<select name="<?php echo $this->get_field_name("rtmdcc_num_cols"); ?>">
	<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '0' ? 'selected' : '' ; ?> value="0">	auto</option>
	<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '1' ? 'selected' : '' ; ?> value="1">	1	</option>
	<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '2' ? 'selected' : '' ; ?> value="2">	2	</option>
	<option <?php echo $rtmdcc_options['rtmdcc_num_cols'] == '3' ? 'selected' : '' ; ?> value="3">	3	</option>
</select>
<br><br>
<label for="<?php echo $this->get_field_name("rtmdcc_show_tooltips"); ?>">Display Tool tips :</label>
<input type="checkbox" name="<?php echo $this->get_field_name("rtmdcc_show_tooltips"); ?>" value="Y" <?php echo ($rtmdcc_options['rtmdcc_show_tooltips'] == 'Y') ? 'checked':''; ?> />
<br><br>
<label for="<?php echo $this->get_field_name("rtmdcc_movie_type"); ?>" >Type of Movies to display  :</label>
<select name="<?php echo $this->get_field_name("rtmdcc_movie_type"); ?>" id="rtmdcc_movie_type">
	<option <?php echo $rtmdcc_options['rtmdcc_movie_type'] == 'box_office' ? 'selected' : '' ; ?> value="box_office">Box Office</option>
	<option <?php echo $rtmdcc_options['rtmdcc_movie_type'] == 'in_theaters' ? 'selected' : '' ; ?> value="in_theaters">In Theaters</option>
	<option <?php echo $rtmdcc_options['rtmdcc_movie_type'] == 'opening' ? 'selected' : '' ; ?> value="opening">Opening Movies</option>
	<option <?php echo $rtmdcc_options['rtmdcc_movie_type'] == 'upcoming' ? 'selected' : '' ; ?> value="upcoming">Upcoming Movies</option>
</select>
<br><br>
<label for="<?php echo $this->get_field_name("rtmdcc_hi_res"); ?>">Use Hi-Resolution Poster Image :</label>
<input type="checkbox" name="<?php echo $this->get_field_name("rtmdcc_hi_res"); ?>" value="Y" <?php echo ($rtmdcc_options['rtmdcc_hi_res'] == 'Y') ? 'checked':''; ?> />
</p>