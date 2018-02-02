var $j = jQuery.noConflict();

if($j('.speechy_mp3')){
	var speechy_mp3OuterHeight = $j('.speechy_mp3').offset().top;
	var wpadminbar = document.querySelector('.admin-bar');
	
	console.log("1: "+speechy_mp3OuterHeight);
	
	if($j('#main-header')) {
		speechy_mp3OuterHeight = speechy_mp3OuterHeight + $j('#main-header').offset().top;
		console.log("2: "+speechy_mp3OuterHeight);
	}
}

if($j('.speechy_mp3')){
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
}
