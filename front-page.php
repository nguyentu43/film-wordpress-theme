<?php get_header(); ?>

	<div class="col-sm-12 col-12">
		<div class="row list-film list-film-most-view">
			<div class="col mt-4 mx-md-3 py-2 bg-film" style="overflow: hidden;">

				<h3 id="most-view" class="title title-red">
					<a href="<?= get_bloginfo('url').'/?s=&post_type=film&topic=most-view'?>">
						<?= __('THỊNH HÀNH', 't-film') ?>
					</a>
				</h3>
				<?php 
						t_film_carousel([
						'post_type' => 'film',
						'posts_per_page' => get_option('t-film-plugin')['films-per-page']['cover'],
						'meta_key' => 'film_view_count',
						'orderby' => [
							'meta_value_num' => 'DESC'
							]
						]
					);
				?>

			</div>
		</div>

		<div class="row list-film list-film-featured">
			<div class="col bg-film mx-md-3 mt-4 py-2">
				<h3 id="featured" class="title title-blue">
					<a href="<?= get_bloginfo('url').'/?s=&post_type=film&topic=featured'?>">
						<?= __('NỔI BẬT', 't-film') ?>
					</a>
				</h3>
				<?php 
						t_film_box_cover([
							'post_type' => 'film',
							'meta_key' => 'film_featured',
							'meta_value' => 'on',
							'meta_compare' => 'IN',
							'posts_per_page' => get_option('t-film-plugin')['films-per-page']['cover']
						]
					);
				?>
			</div>
		</div>

		<div class="row list-film list-film-newest">
			<div class="col mt-4 mx-md-3 py-2 bg-film">
				<h3 id="newest" class="title title-yellow">
					<a href="<?= get_bloginfo('url').'/?s=&post_type=film&topic=newest'?>">
						<?= __('MỚI NHẤT', 't-film') ?>
					</a>
				</h3>
				<?php 
						t_film_box_cover([
							'post_type' => 'film',
							'posts_per_page' => get_option('t-film-plugin')['films-per-page']['cover'],
							'orderby' => 'date'
						]
					);
				?>
			</div>
		</div>

	</div>

	<div class="col-md-8 col-12 mt-4" id="main">

		<div class="row">
			<div class="col mx-md-3 py-2 bg-film list-film">
				<h3 id="phim-le" class="title">
					<a href="<?= get_bloginfo('url').'/?s=&post_type=film&film_series=0'?>">
						<?= __('Phim lẻ', 't-film') ?>
					</a>
				</h3>
					<?php

					t_film_box_list_x([
						'post_type' => 'film',
						'meta_key' => 'film_series',
						'meta_value' => '0',
						'posts_per_page' => get_option('t-film-plugin')['films-per-page']['list-x']
					]);

				?>
			</div>
		</div>

		<div class="row mt-4">
			<div class="col mx-md-3 py-2 bg-film list-film">
				<h3 id="phim-bo" class='title'>
					<a href="<?= get_bloginfo('url').'/?s=&post_type=film&film_series=1'?>">
						<?= __('Phim bộ', 't-film') ?>
					</a>
				</h3>
				<?php

					t_film_box_list_x([
						'post_type' => 'film',
						'meta_key' => 'film_series',
						'meta_value' => '1',
						'posts_per_page' => get_option('t-film-plugin')['films-per-page']['list-x']
					]);

				?>
			</div>
		</div>

		<?php

			$film_genre_list = get_terms([
		  		'taxonomy' => 'film_genre',
		  		'hide_empty' => 0
		  	]);

			foreach($film_genre_list as $genre):
		?>
			<div class="row my-4">
				<div class="col mx-md-3 py-2 bg-film list-film">
					<h3 id="<?= $genre->slug?>" class="title">
						<a href="<?= bloginfo('url').'/?s=&post_type=film&film_genre[]='.$genre->term_id ?>">
							<?= $genre->name ?>
						</a>
					</h3>
					<?php 

						t_film_box_list_x([
							'post_type' => 'film',
							'tax_query' => [
								[
								'taxonomy' => 'film_genre',
								'field' => 'term_id',
								'terms' => $genre->term_id
								]
							],
							'posts_per_page' => get_option('t-film-plugin')['films-per-page']['list-x']
						]);

					?>
				</div>
			</div>

		<?php endforeach; ?>

	</div>

<?php 
	get_sidebar();
	get_footer(); 
?>