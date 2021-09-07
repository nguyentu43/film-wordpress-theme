function pull_up_poster_float()
{
	var
	poster_float = jQuery('.float-poster');
	if(poster_float.length)
	{
		poster_float.css({'margin-top': '-' + poster_float.height() / 2 + 'px', 'position': 'absolute'});
		poster_float.find('.float-content > div').css({'height': poster_float.height() / 2 + 'px', 'background': 'rgba(0,0,0,0.5)', 'color': 'white'});
		poster_float.find('.float-content a').css('color', 'white');
		jQuery('.film-info').css('margin-top', 0);
		poster_float.removeClass('bg-film');
	}
}

function pull_down_poster_float()
{
	var
	poster_float = jQuery('.float-poster');
	if(poster_float.length)
	{
		poster_float.css({'margin-top': 0, 'position': 'initial'});
		poster_float.find('.float-content > div').css({'background': 'inherit', 'color': 'black'});
		poster_float.find('.float-content a').css('color', 'black');
		jQuery('.film-info').css('margin-top', '-' + (poster_float.height() / 2 + 10) + 'px');
		poster_float.addClass('bg-film');
	}
}

jQuery().ready(function(e){

	var nav_brand = jQuery('#navbar-top .navbar-brand');
	var search_form = jQuery('#navbar-top #search-form');
	
	if(jQuery(window).width() < 768)
	{
		search_form.addClass('order-2 w-100 my-1');
	}

	jQuery('#section-search-filter input').checkboxradio();

	if(jQuery('#rpt2:checked').length == 1)
		jQuery('.filter-film').hide();

	jQuery('#rpt2').click(function(){

		jQuery('.filter-film').hide();

	});

	jQuery('#rpt1').click(function(){

		jQuery('.filter-film').show();

	});

	jQuery('.scroll-x').each(function(){
		new PerfectScrollbar(this, {
			wheelPropagation: true
		});
	});

	jQuery('.scroll-y').each(function(){
		new PerfectScrollbar(this, {
			wheelPropagation: true
		});
	});

	jQuery('.scroll').each(function(){
		new PerfectScrollbar(this, {
			wheelPropagation: true
		});
	});

	var lastView = localStorage.getItem('t_film_player_history');

	if(lastView)
	{
		lastView = JSON.parse(lastView);
		jQuery.each(lastView, function(i, v){

			jQuery('#film-' + i + ' .film-history .badge.last-view')
			.show()
			.append(' ' + Math.round((v.position / v.duration)*100) + '%');

		});
	}

	jQuery('.read-more').each(function(i, v){

		jQuery(this).css({
			'overflow': 'hidden',
			'max-height': jQuery(this).data('height') + 'px'
		});

		jQuery(this).after('<div class="text-center mt-2"><button class="btn btn-sm btn-primary btn-show">Xem thêm</button></div>');

		var
			button = jQuery(this).next();
			el = this;

		button.click(function(e){

			jQuery(el).css({
				'overflow': 'unset',
				'max-height': 'none'
			});

			button.hide();

		});
	});

	pull_up_poster_float();

});