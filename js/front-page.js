jQuery().ready(function(e){

	var navbar_category = jQuery('#navbar-film');
	var prevPageYOffset = window.pageYOffset;

	jQuery(window).on('activate.bs.scrollspy', function () {
		
		var left = jQuery('#navbar-film .nav-link.active').position().left;
		var offset = 15;

		jQuery('#navbar-film .scroll-x')[0].scrollLeft = left - offset;

	});

	jQuery(window).on('scroll', function(e){

		var currentPageYOffset = window.pageYOffset;

		if(currentPageYOffset > prevPageYOffset)
		{
			if(!navbar_category.hasClass('fixed-top'))
			{
				if(jQuery('#wpadminbar').length > 0)
				{
					navbar_category.css('margin-top', '32px');
				}
				navbar_category.addClass('fixed-top');
			}
		}
		else
		{
			if(navbar_category.hasClass('fixed-top'))
			{
				if(jQuery('#wpadminbar').length > 0)
				{
					navbar_category.css('margin-top', '0px');
				}

				navbar_category.removeClass('fixed-top');
			}
		}

		prevPageYOffset = currentPageYOffset;

	});

});

	