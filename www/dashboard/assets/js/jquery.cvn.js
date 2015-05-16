jQuery(function($){
   $("#UpTime, #EndTime, #CallTime").mask("99/99/9999 99:99 aa");
   
   $("#checkall").click(function() {
		if($(this).is(':checked')) {
			$("input[type=checkbox]").attr("checked", "checked");
		} else {
			$("input[type=checkbox]").removeAttr("checked");
		}
	});
   
   
   //Hide (Collapse) the toggle containers on load
	$(".toggle-container").hide(); 

	//Switch the "Open" and "Close" state per click
	$(".event").toggle(function(){
		$(this).addClass("active");
		}, function () {
		$(this).removeClass("active");
	});

	//Slide up and down on click
	$(".event").click(function(){ 
		$(this).next(".toggle-container").slideToggle("slow");
	});
	
	
	$("a.add-extra").live("click", function() {
		$(this).after("<div class='loading'><img src='assets/images/ajax-loader.gif' /></div>");
		ID = $(this).attr("rel");
		$.ajax({
			  url: 'load-users.php',
			  data: "event="+ ID,
			  success: function(data) {
				$("#extra-ushers-" + ID).append('<select name="extra[]" style="background-color:#FFF; padding:3px; color:#000; margin:0 0 3px 3px;">' + data + '</select><br />');
				$(".loading").hide();
			  }
			});
	});
	
	


   
});
