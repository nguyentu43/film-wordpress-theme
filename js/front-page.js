jQuery().ready(function(e){

	var navbar_category = jQuery('#navbar-film');
	var prevPageYOffset = window.pageYOffset;

	jQuery(window).on('activate.bs.scrollspy', function () {

		var left = 0;

		jQuery('#navbar-film .nav-item').each(function(){

			if(jQuery(this).find('a').hasClass('active'))
			{
				jQuery('#navbar-film .scroll-x')[0].scrollLeft = left;
				return;
			}
			else
			{
				left += jQuery(this).width();
			}

		});

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

	