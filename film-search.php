<?php get_header();?>

	<div class="col-md-8 col-12" id="main">
		<div class="row my-2">
			<div class="col-12 px-0 px-md-3">
				<div class="p-3 bg-film">
					<strong>
						<?php 
							global $wp_query;
							if(isset($_GET['topic']))
							{
								switch ($_GET['topic']) {
									case 'most-view':
									    _e('Thịnh hành', 't-film');
										break;
									case 'featured':
									    _e('Nổi bật', 't-film');
										break;
									case 'recommend':
									    _e('Gợi ý', 't-film');
										break;
									case 'newest':
									    _e('Mới', 't-film');
										break;
									case 'wishlist':
										_e('Yêu thích', 't-film');
									case 'history':
										_e('Lịch sử xem', 't-film');
								}
							}
							else
							{
								echo t_film_get_icon('magnifying-glass'). __('Kết quả tìm kiếm phim', 't-film');
							}

						?>
					</strong>
				</div>
			</div>
		</div>

		<?php

			function t_film_get_query($name, $default = FALSE)
			{
				return !isset($_GET[$name]) || $_GET[$name] == '' ? $default : $_GET[$name];
			}

			$page = t_film_get_query('page', 1);
			$posts_per_page = t_film_get_query('posts_per_page', get_option('t-film-plugin')['films_per_page']['search']);

			$args = [
				'_meta_or_title' => get_search_query( $escaped = true ),
				'posts_per_page' => $posts_per_page,
				'paged' => $page,
				'tax_query' => [],
				'meta_query' => [],
				'orderby' => [],
				'post_type' => 'film'
			];

			//meta key filter
			$film_series = t_film_get_query('film_series');

			if($film_series !== FALSE)
				$args['meta_query'][] = [
					'key' => 'film_series',
					'value' => $film_series
				];

			$film_year = t_film_get_query('film_year');

			if($film_year !== FALSE)
				$args['meta_query'][] = [
					'key' => 'film_date',
					'value' => [$film_year.'-01-01', $film_year.'-12-31'],
					'type' => 'DATE',
					'compare' => 'BETWEEN'
				];

			//taxonomy filter
			$film_country = t_film_get_query('film_country');
			if($film_country !== FALSE)
				$args['tax_query'][] = [
					'taxonomy' => 'film_country',
					'field' => 'term_id',
					'terms' => $film_country,
					'operator' => 'IN'
				];

			$film_genre = t_film_get_query('film_genre');
			if($film_genre !== FALSE)
				$args['tax_query'][] = [
					'taxonomy' => 'film_genre',
					'field' => 'term_id',
					'terms' => $film_genre,
					'operator' => 'IN'
				];

			$orderby = t_film_get_query('orderby', 'rand');

			if($orderby == 'film_view_count')
			{
				$args['meta_key'] = 'film_view_count';
			}

			if($orderby == 'rand')
			{
				$args['orderby'] = 'rand';
			}

			$order = t_film_get_query('order', 'ASC');

			if($orderby == 'film_view_count')
			{
				$args['orderby'] = [ 'meta_num_value' => $order ];
			}
			else if($orderby != 'rand')
			{
				$args['orderby'][$orderby] = $order;
			}

			$args['meta_query'][] = [
				'key' => 'film_title_other',
				'value' => get_search_query( $escaped = true ),
				'compare' => 'LIKE'
			];

			if(count($args['tax_query']) > 1)
				$args['tax_query']['relation'] = 'AND';
			else if(count($args['tax_query']) == 0)
				unset($args['tax_query']);

			if(count($args['meta_query']) > 1)
				$args['meta_query']['relation'] = 'AND';
			else if(count($args['meta_query']) == 0)
				unset($args['meta_query']);

			if(isset($_GET['topic']))
			{
				switch ($_GET['topic']) {
					case 'most-view':
						$args = [
							'post_type' => 'film',
							'posts_per_page' => '10',
							'meta_key' => 'film_view_count',
							'orderby' => [
								'meta_value_num' => 'DESC'
							]
						];
						break;
					case 'featured':
						$args = [
							'post_type' => 'film',
							'meta_key' => 'film_featured',
							'meta_value' => 'on',
							'meta_compare' => 'IN',
							'posts_per_page' => '15'
						];
						break;
					case '':
						$args = [];
						break;
					case 'newest':
						$args = [
							'post_type' => 'film',
							'posts_per_page' => '15',
							'orderby' => 'date'
						];
						break;
					case 'wishlist':
						if(is_user_logged_in())
						{
							$wishlist = get_user_meta( get_currentuserinfo()->ID, $key = 't-film-plugin-wishlist', true );
							$wishlist = !empty($wishlist) ? $wishlist : [];

							if(count($wishlist) == 0)
								$empty_topic = true;
							else
								$args = [
									'post_type' => 'film',
									'posts_per_page' => '-1',
									'post__in' => $wishlist
								];
						}
						break;
					case 'history':
						if(is_user_logged_in())
						{
							$history = get_user_meta( get_currentuserinfo()->ID, 't-film-plugin-history', true );
							$history = !empty($history) ? json_decode( $history, true) : [];
							$list = array_map(function($key){ return $key; }, array_keys($history));

							if(count($list) == 0)
								$empty_topic = true;
							else
								$args = [
									'post_type' => 'film',
									'posts_per_page' => '-1',
									'post__in' => $list
								];
						}
						break;
				}
			}

			if(!isset($empty_topic)):
				t_film_box($args);
			else:
				get_template_part( 'template-parts/content', 'none-film' );
			endif;
		?>
	</div>

<?php get_sidebar(); get_footer(); ?>