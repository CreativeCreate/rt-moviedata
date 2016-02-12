/*
* showtime display plugin js
* Author: creativecreate
* Version: 1.0.1 
*/


jQuery(document).ready(function($){

	/*
	* stretch short thumbnails heights (poster images have different heights) 
	*/
	function fixImgHeight(){
		$('ul#mtd_widegt_wrapper li img').each(function(e){
			$(this).css('height', this.width*1.4814814814815);
		});
	}
	fixImgHeight();										// default tigger
	$(window).resize(function(){ fixImgHeight(); });	// window resize tigger
	
	/*
	* tooltip position - cols display
	*/	
	$( 'ul#mtd_widegt_wrapper li , #rtmdcc_table tbody' ).on( 'mouseenter', function( f ) {
		$tTips = (this.nodeName == 'LI')? $('ul', this).html() : $('tr', this).data('desc');
		if($tTips && $tTips.length > 10){
			$('body').append('<ul id="tooltipElm"></ul>');
			$('#tooltipElm').animate({opacity:1},850,'').html($tTips);
			$(this).on('mousemove', function(i){		// tooltip position with mouse x,y
				pos = $(window).width()-i.pageX;		// check whether position is outside of the screen
				console.log(pos+'|'+i.pageX);
				(pos>300)? $('#tooltipElm').css({right: 'inherit', left: i.pageX + 10}): $('#tooltipElm').css({left:'inherit', right: pos - 10});
				$('#tooltipElm').css('top', i.pageY + 10);
			});
			$(this).on('mouseleave', function(e){			// remove tooltip when mouseout
				$('#tooltipElm').animate({opacity:0},850,'').remove();	
			})
		}
	} );

} );
