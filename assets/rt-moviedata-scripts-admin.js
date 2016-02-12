/*
* WP default admin postbox show/hide script fix
* Since WP admin UI postbox show-hide option no default
*/
jQuery(document).ready(function($){
	postboxes.save_state = function(){ return;  };
    postboxes.save_order = function(){ return;  };
    postboxes.add_postbox_toggles();

} );