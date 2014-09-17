// helper - validate data attr
function validateDataAttr($attr) {
	"use strict";
	return $attr !== undefined;

}

jQuery(document).ready(function () {
	"use strict";
	// set nav position
	jQuery(".navbar-nav").each(function () {
		var $this = jQuery(this);
		$this.css($this.data("type"), $this.data("pos"));
	})

	// set logo position
	jQuery(".navbar-brand, .small-brand, .mobile-brand").each(function () {
		var $this = jQuery(this);

		$this.css({
			"position": "absolute",
			"left": "50%",
			"margin-left": (-$this.data("width") / 2),
			"top": $this.data("top")
		});

	})

	// set background image
	jQuery(".full-width-photo, .section > .inner").each(function () {
		var $this = jQuery(this);

		var image = "none";

		if (validateDataAttr($this.data("image"))) {
			image = "url(" + $this.data("image") + ")";
			$this.css("background-image", image);
		}

		$this.css("background-attachment", $this.data("scroll")).css("padding-top", $this.data("topspace") + "px").css("padding-bottom", $this.data("bottomspace") + "px");
	})


	// init prettyphoto
	jQuery("a[data-rel^='prettyPhoto']").prettyPhoto({
		deeplinking: false,
		social_tools: " ",
		hook: 'data-rel',
		animation_speed: 'fast', /* fast/slow/normal */
		slideshow: 5000, /* false OR interval time in ms */
		autoplay_slideshow: false, /* true/false */
		opacity: 0.75, /* Value between 0 and 1 */
		overlay_gallery: false,
		show_title: true, /* true/false */
		allow_resize: true, /* Resize the photos bigger than viewport. true/false */
		counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
		theme: 'pp_default', /* pp_default / light_rounded / dark_rounded / light_square / dark_square / facebook */
		horizontal_padding: 20 /* The padding on each side of the picture */
	});





	// enable HTML5 placeholder behavior for browsers that aren’t trying hard enough yet
	jQuery('input, textarea').placeholder();

});


function scrollToTop(i) {
	"use strict";
	if (i == 'show') {
		if (jQuery(this).scrollTop() != 0) {
			jQuery('#toTop').fadeIn();
		} else {
			jQuery('#toTop').fadeOut();
		}
	}
	if (i == 'click') {
		jQuery('#toTop').click(function () {
			jQuery('body,html').animate({scrollTop: 0}, 600);
			return false;
		});
	}
}

// scroll top button
jQuery(document).ready(function () {
	"use strict";
	scrollToTop('click');
});


jQuery(window).scroll(function () {
	"use strict";
	scrollToTop('show');
});

jQuery(document).ready(function(){
    // init rounded image
	jQuery(".roundedImg").each(function () {
		var $this = jQuery(this);
		var imgpath = $this.find("img").attr("src");
		$this.css("background-image", "url(" + imgpath + ")");

		var $sizeImg = $this.data("size");
		if (validateDataAttr($sizeImg)) {
			var size = $sizeImg;

			$this.css({
				width: size,
				height: size
			});
		}
	})
});

jQuery(document).ready(function () {
	"use strict";
	/* rotate text */
	if (jQuery().arctext) {
		jQuery(".curved").each(function () {
			var $this = jQuery(this);

			var radius = $this.data("radius");
			var direction = $this.data("direction");

			if ((validateDataAttr(radius)) && (validateDataAttr(direction))) {
				jQuery($this).arctext({
					radius: radius,
					dir: direction,
					// 1: curve is down,
					// -1: curve is up
					rotate: true
					// if true each letter should be rotated.
				})
			}
		})
	}

	// ini tooltips
	jQuery("[data-toggle='tooltip']").tooltip();

	// responsive video
	jQuery(".videoFrameContainer").fitVids();

	// faq page

	if (jQuery('#faq1').length > 0) {
		jQuery('#faq1').affix({
			offset: { top: jQuery('#faq1').offset().top - 30 }
		});
	}


	jQuery('.faqMenu a').bind('click', function (e) {
		e.preventDefault();
		jQuery('html, body').animate({
			scrollTop: jQuery(this.hash).offset().top }, 300);
	});


	// preloader
	if (jQuery().queryLoader2) {
		jQuery("body.preloader").queryLoader2({
			backgroundColor: "#fff",	 //Background color of the loader (in hex).
			barColor: "#584A41",	 //Background color of the bar (in hex).
			barHeight: 3,	 //Height of the bar in pixels. Default: 1
			deepSearch: true,	 //Set to true to find ALL images with the selected elements. If you don't want queryLoader to look in the children, set to false. Default: true.
			percentage: true,	 //Set to true to enable percentage visualising. Default is false.
			completeAnimation: "fade", //Set the animation type at the end. Options: "grow" or "fade". Default is "fade".
			onComplete: function () {
				jQuery("#ct_preloader").fadeOut(600);
			}
		});
	}


})

// sticky menu + scroll to section init

function setScrollOffset() {
	"use strict";
	var windowsize = jQuery(window).width();
	if (windowsize < 985) {
		return 0;
	}
	// return 248;

	if (jQuery(".navbar.navbar-default").hasClass("full-sticky-menu")) {
		return 85;
	}

	return 0;
}

function menuSticky(i) {
	"use strict";
	if (i == 'click') {

		jQuery(".full-sticky-menu").sticky({
			topSpacing: 0
		});

		jQuery('.nav.navbar-nav li a').click(function () {

			// if mobile and menu open - hide it after click
			var $togglebtn = jQuery(".navbar-toggle")

			if (!($togglebtn.hasClass("collapsed")) && ($togglebtn.is(":visible"))) {
				jQuery(".navbar-toggle").trigger("click");
			}

			var $this = jQuery(this);

			var content = $this.attr('href');

			if (content.search("/#") >= 0) {
				content = content.replace('/', '');
			} else {
				return true;
			}

			var myUrl = content.match(/^#([^\/]+)$/i);

			var windowsize = jQuery(window).width();
			var posFix = 0;
			if (windowsize > 985) {
				if (jQuery('.sticky-wrapper').length > 0) {
					posFix = parseInt(jQuery('.sticky-wrapper').height());
				}
			}

			if (jQuery(content).length > 0) {
				if (myUrl) {
					var goPosition = jQuery(content).offset().top - setScrollOffset() - posFix;

					jQuery('html,body').stop().animate({ scrollTop: goPosition}, 1000, 'easeInOutExpo', function () {
						if (jQuery(".navbar.navbar-default").hasClass("full-sticky-menu")) {
							$this.closest("li").addClass("active");
						}
					});


				} else {
					window.location = content;
				}
				return false;
			}
		});
	}

	if (i == 'scroll') {
		var menuEl, mainMenu = jQuery(".full-sticky-menu .nav.navbar-nav"), mainMenuHeight = mainMenu.outerHeight() + 500;
		var menuElements = mainMenu.find('a');

		var scrollElements = menuElements.map(function () {

			var content = jQuery(this).attr("href");

			if (content.search("/#") >= 0) {
				content = content.replace('/', '');
			}

			var myUrl = content.match(/^#([^\/]+)$/i);

			if (myUrl) {

				var item = jQuery(content);
				if (item.length) {
					return item;
				}

			}
		});

		var fromTop = jQuery(window).scrollTop() + mainMenuHeight;

		var currentEl = scrollElements.map(function () {
			if (jQuery(this).offset().top < fromTop) {
				return this;
			}
		});

		currentEl = currentEl[currentEl.length - 1];
		var id = currentEl && currentEl.length ? currentEl[0].id : "";
		if (menuEl !== id) {
			menuElements.parent().removeClass("active").end().filter("[href='/#" + id + "']").parent().addClass("active");
		}
	}
}

jQuery(document).ready(function () {
	// remove active class for onepager menu items
	jQuery(".nav.navbar-nav li a[href^='/#']").each(function () {
		jQuery(this).parent().removeClass("active");
	});


		/* clickable main parent item menu */
	jQuery(".nav.navbar-nav li.dropdown > .dropdown-toggle").removeAttr("data-toggle data-target");


});
jQuery(window).load(function () {
	"use strict";
	menuSticky('click');

});

jQuery(window).scroll(function () {
	"use strict";
	menuSticky('scroll');
});


/* ======================== */
/* ==== MAGNIFIC POPUP ==== */

if (jQuery().magnificPopup) {

    jQuery(".popup-iframe").magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });

    jQuery('.imgpopup').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        closeBtnInside: false,
        fixedContentPos: false,
        mainClass: 'mfp-fade', // class to remove default margin from left and right side
        image: {
            verticalFit: true
        }
    });
}