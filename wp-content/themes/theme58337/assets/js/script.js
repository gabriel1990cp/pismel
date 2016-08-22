jQuery( document ).ready(function() {
	// ---------------------------------------------------------
	// Hamburger button
	// ---------------------------------------------------------
	var hamburgerBtn = jQuery('#hamburger-btn'),
		hamburgerArea = jQuery('#static-area-header-bottom'),
		logoArea = jQuery('#static-area-header-top'),
		motoSlider = jQuery('.static-moto-slider.moto-slider');

	if(hamburgerBtn[0]) {
		hamburgerBtn.on('click', function(event){
			event.preventDefault();

			logoArea.toggleClass('opened');
			hamburgerArea.toggleClass('opened');
			jQuery('body').toggleClass('opened');
		})
	}

	if(hamburgerArea[0]) {
		hamburgerAreaSize();

		jQuery(window).on('resize scroll orientationChange', function() {
			hamburgerAreaSize();
		});

		if(motoSlider[0]) {
			jQuery('.site-header').addClass('with-slider');
		}

		// ---------------------------------------------------------
		// Custom scroll for hamburger zone init 
		// ---------------------------------------------------------
		hamburgerArea.find('.container').mCustomScrollbar();
	}

	function hamburgerAreaSize() {
		var windowHeight = jQuery(window).height(),
			logoAreaHeight = logoArea.find('.container').height(),
			logoHeight = logoArea.find('.site-logo-wrap').height(),
			hamburgerHeight = logoArea.find('.site-hamburger').height(),
			topMenuOffset,
			hamburgerAreaOffset,
			scrollOffset = jQuery(window).scrollTop(),
			contentHeight = hamburgerArea.find('.row').innerHeight(),
			menu = hamburgerArea.find('#menu-primary'),
			adminAreaHeight = jQuery('#wpadminbar').height();

		if (logoHeight < logoAreaHeight || hamburgerHeight < logoAreaHeight) {
			if (logoHeight > hamburgerHeight) {
				topMenuOffset = logoHeight;
			} else {
				topMenuOffset = hamburgerHeight
			}
			hamburgerAreaOffset = logoArea.offset().top + topMenuOffset;
		} else {
			topMenuOffset = logoAreaHeight;
			hamburgerAreaOffset = logoArea.offset().top + logoArea.height();
		}

		var containerHeight = windowHeight - hamburgerAreaOffset;

		// Full height
		hamburgerArea.css({
			'height': windowHeight
		})
		if (scrollOffset <= 0) {
			hamburgerArea.css({
				'padding-top': hamburgerAreaOffset
			})
		} else {
			hamburgerArea.css({
				'padding-top': topMenuOffset + adminAreaHeight + 30
			})
		}
		
		logoArea.css({
			'height': logoAreaHeight,
		})
		motoSlider.css({
			'top': '-'+(logoAreaHeight + 40)+'px',
			'margin-bottom': '-'+(logoAreaHeight + 40)+'px'
		})
		motoSlider.find('.motoslider_wrapper').addClass('full-height').css({
			'height': (windowHeight - adminAreaHeight - 60) + 'px'
		})

		// Menu top/bottom paddings
		if (menu[0]) {
			if (containerHeight > contentHeight) {
				var diff = (containerHeight - contentHeight - 40) / 2;
				
				menu.css({
					'padding-top': diff,
					'padding-bottom': diff,
				})
			} else {
				menu.css({
					'padding-top': '0',
					'padding-bottom': '0',
				})
			}
		}
	}

	// ---------------------------------------------------------
	// Slider new timer progress bars
	// ---------------------------------------------------------
	jQuery(window).on('load', function(){
		var motoSlider = jQuery('.static-moto-slider.moto-slider');

		if(motoSlider[0]) {
			var bullet = motoSlider.find('.ms_bullet_wrapper > a');
			
			// Progress bars script
			bullet.each(function() {
				var _this = jQuery(this);
				_this.find('>div').append('<div class="timer-bullet"><div class="timer"></div></div>');
			});
		}
	})
	jQuery(window).on('load resize', function(){
		var motoSlider = jQuery('.static-moto-slider.moto-slider');

		if(motoSlider[0]) {
			var bullet = motoSlider.find('.ms_bullet_wrapper > a'),
				timer = bullet.find('.timer');

			jQuery('.ms_arrows > .ms_banner_timer > div').attrchange({
				trackValues: true,

				callback: function(e) {
					var activeBullet = motoSlider.find('.ms_bullet_wrapper > a.ms_active');

					timer.css({'width': '0'});
					activeBullet.find('.timer').attr({'style': e.newValue});
				}
			});
		}
	})

	// ---------------------------------------------------------
	// Back to Top
	// ---------------------------------------------------------
	jQuery( window ).scroll(function() {
		if ( jQuery( this ).scrollTop() > 100 ) {
			jQuery( '#back-top' ).addClass( 'show-totop' );
		} else {
			jQuery( '#back-top' ).removeClass( 'show-totop' );
		}
	});

	jQuery( '#back-top a' ).click(function() {
		jQuery( 'body,html' ).stop( false, false ).animate({
			scrollTop: 0
		}, 800 );
		return false;
	});

	// ---------------------------------------------------------
	// Wow animation script init
	// ---------------------------------------------------------
	new WOW().init();

	// ---------------------------------------------------------
	// IE11 grayscale
	// ---------------------------------------------------------
	if (getInternetExplorerVersion() >= 10){
		jQuery('body').addClass('ie11');

		jQuery('.cherry-posts-item.clients-item img').each(function(){
			var el = jQuery(this);
			el.css({"position":"absolute"}).wrap("<div class='img_wrapper' style='display: inline-block'>").clone().addClass('img_grayscale').css({"position":"absolute","z-index":"5","opacity":"0"}).insertBefore(el).queue(function(){
				var el = jQuery(this);
				el.parent().css({"width":this.width,"height":this.height});
				el.dequeue();
			});
			this.src = grayscaleIE10(this.src);
		});
		
		// Quick animation on IE10+ 
		jQuery('.cherry-posts-item.clients-item img').hover(
			function () {
				jQuery(this).parent().find('img:first').stop().animate({opacity:1}, 200);
			}, 
			function () {
				jQuery('.img_grayscale').stop().animate({opacity:0}, 200);
			}
		);	
		
		function grayscaleIE10(src){
			var canvas = document.createElement('canvas');
			var ctx = canvas.getContext('2d');
			var imgObj = new Image();
			imgObj.src = src;
			canvas.width = imgObj.width;
			canvas.height = imgObj.height; 
			ctx.drawImage(imgObj, 0, 0); 
			var imgPixels = ctx.getImageData(0, 0, canvas.width, canvas.height);
			for(var y = 0; y < imgPixels.height; y++){
				for(var x = 0; x < imgPixels.width; x++){
					var i = (y * 4) * imgPixels.width + x * 4;
					var avg = (imgPixels.data[i] + imgPixels.data[i + 1] + imgPixels.data[i + 2]) / 3;
					imgPixels.data[i] = avg; 
					imgPixels.data[i + 1] = avg; 
					imgPixels.data[i + 2] = avg;
				}
			}
			ctx.putImageData(imgPixels, 0, 0, 0, 0, imgPixels.width, imgPixels.height);
			return canvas.toDataURL();
		};
	};

	function getInternetExplorerVersion(){
		var rv = -1;
		if (navigator.appName == 'Microsoft Internet Explorer'){
			var ua = navigator.userAgent;
			var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
			rv = parseFloat( RegExp.$1 );
		}
		else if (navigator.appName == 'Netscape'){
			var ua = navigator.userAgent;
			var re  = new RegExp("Trident/.*rv:([0-9]{1,}[\.0-9]{0,})");
			if (re.exec(ua) != null)
			rv = parseFloat( RegExp.$1 );
		}
		return rv;
	};
});