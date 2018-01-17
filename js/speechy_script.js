var $j = jQuery.noConflict();

var speechy_mp3OuterHeight = $j('.speechy_mp3').offset().top;
var wpadminbar = document.querySelector('.admin-bar');

$j(window).scroll(function(){  
	
	if($j(window).width() > 767){
		if($j(window).scrollTop() < speechy_mp3OuterHeight) {
			$j('.single .speechy_mp3').removeClass('fixed_up');
			$j('.single .speechy_mp3 .player_title').removeClass('remove');
		}else{
			$j('.single .speechy_mp3').addClass('fixed_up');
			$j('.single .speechy_mp3 .player_title').addClass('remove');
			
			if ( wpadminbar){
			   var wpadminbarouterHeight = 32 /*wpadminbar.outerHeight()*/;
			   $j('.fixed_up').css('top', wpadminbarouterHeight + 'px');
			}else{
				$j('.fixed_up').css('top', wpadminbarouterHeight + 'px');
			}
		}
	}
	
});
