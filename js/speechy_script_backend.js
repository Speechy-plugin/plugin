
/* Color picker for admin page*/

(function( $ ) {
    $(function() {   
        // Add Color Picker to all inputs that have 'color-field' class
        $( '.speechy-color-picker, .speechy-bg-color-picker, .speechy-text-color-picker' ).wpColorPicker();  		
    });
	
})( jQuery );

/* Open window for changing plan and payment with stripe */

function open_iframe(){
	console.log('YES');
}

var speechyPopup = null;

var messageupdate = "<p>Success! Your plan has been updated successfully! The change will be effective in about 5 minutes.</p>";

function openPortal(onSubscription){
	if(speechyPopup == null){
		var url = "https://speechy.io/portal/#/";
		var w = 450;
		var h = 600;
		
	    var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
	    var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
	
	    var width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
	    var height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
	
	    var left = ((width / 2) - (w / 2)) + dualScreenLeft;
	    var top = ((height / 2) - (h / 2)) + dualScreenTop;
	    
		speechyPopup = window.open(url, "", 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=' + w + ', height=' + h + ', top=' + top + ', left=' + left);
		speechyPopup.onbeforeunload = function(){
			speechyPopup = null;
		};

		var eventMethod = window.addEventListener ? "addEventListener" : "attachEvent";
		var eventer = window[eventMethod];
		var messageEvent = eventMethod == "attachEvent" ? "onmessage" : "message";
		
		// Listen to message from child window
		eventer(messageEvent,function(e) {
			if(url.indexOf(e.origin) != -1){
			    var key = e.message ? "message" : "data";
			    var data = e[key];
			    // console.log(data);
			    onSubscription(data.messageupdate);
				
			}
		},false);
		
		speechyPopup.focus();
	}
	else{
		speechyPopup.focus();
	}
}