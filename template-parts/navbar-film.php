<nav class="navbar col-12 navbar-dark text-center border-bottom" id="navbar-film">
  	<ul class="nav nav-pills flex-nowrap scroll-x">
	  <?php

	  	$base_url = get_bloginfo('url').'/?s=&post_type=film';

	  	$topic = [
	  		[
	  			'name' => __('THỊNH HÀNH', 't-film'),
	  			'href' => 'most-view'
	  		],
	  		[
	  			'name' => __('NỔI BẬT', 't-film'),
	  			'href' => 'featured'
	  		],
	  		/*[
	  			'name' => __('GỢI Ý', 't-film'),
	  			'href' => 'recommend'
	  		],*/
	  		[
	  			'name' => __('MỚI', 't-film'),
	  			'href' => 'newest'
	  		]
	  	];

	  	foreach($topic as $item)
	  	{
	  		if($item['name'] == __('GỢI Ý', 't-film') && !is_user_logged_in())
	  			continue;
	  		printf(' <li class="nav-item">
	  			<a class="nav-link" href="%s">%s</a>
	  			</li>', is_front_page() ? '#'.$item['href'] : $base_url.'&topic='.$item['href'], $item['name']);
	  	}

	  	?>

	  		<li class="nav-item"><a class="nav-link" href="<?= is_front_page() ? '#phim-le' : $base_url.'&film_series=0'?>"><?= __('PHIM LẺ', 't-film') ?></a></li>
	  		<li class="nav-item"><a class="nav-link" href="<?= is_front_page() ? '#phim-bo' : $base_url.'&film_series=1'?>"><?= __('PHIM BỘ', 't-film') ?></a></li>

	  	<?php

	  	$film_genre_list = get_terms([
	  		'taxonomy' => 'film_genre',
	  		'hide_empty' => 0
	  	]);

	  	foreach($film_genre_list as $genre)
	  	{
	  		if(is_front_page())
	  			printf('<li class="nav-item"><a class="nav-link" href="#%s">%s</a></li>',
		  			$genre->slug, mb_strtoupper($genre->name)
		  		);
	  		else
	  			printf('<li class="nav-item"><a class="nav-link" href="%s">%s</a></li>',
		  			$base_url.'&film_genre[]='.$genre->term_id, mb_strtoupper($genre->name)
		  		);
	  	}

	  ?>
	  
	</ul>
</nav>