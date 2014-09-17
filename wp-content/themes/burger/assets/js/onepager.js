jQuery(document).ready(function () {

	// determine if onepager
	/*
	function checkIfOnepager() {
		var counter = 0;
		jQuery(".chapter").each(function () {
			counter++;
			console.log(counter);
			if (counter == 2) {
				jQuery("body").addClass("isOnepager");
				console.log("onepager");
				return false;
			}
		});
	}

	// function call
	checkIfOnepager();
	*/

	// menu for onepager
	jQuery("#nav > li > a[href^='/#']").each(function () {
		var $this = jQuery(this);
		jQuery($this.parent()).removeClass("active").addClass("onepage");
		// remove unnecessary active classes
		$this.parent().removeClass("active");
	});

	// remove unnecessary active classes
	jQuery("#nav > li > a[href='/']").parent().removeClass("active");


	if (jQuery("body").hasClass("home")) {
		//page scroll
		jQuery('body').pageScroller({
			navigation: '#nav li.onepage',
			sectionClass: 'chapter',
			scrollOffset: '-110'
		})
	}


});