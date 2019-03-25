<div class="col-md-4 col-12 mt-md-4" id="sidebar">
	<div class="row">

		<?php if(!is_front_page()): ?>
		<div class="col-12 px-0 px-md-3">
			<div class="p-3 bg-film mb-4">
				<h5 class="title title-red"><?= __('Thịnh hành', 't-film') ?></h5>
				<?php

					t_film_box_list_y([
						'post_type' => 'film',
						'posts_per_page' => get_option('t-film-plugin')['films-per-page']['list-y'],
						'meta_key' => 'film_view_count',
						'orderby' => [
							'meta_value_num' => 'DESC'
						]
					]);

				?>
			</div>

			<div class="p-3 bg-film mb-4">
				<h5 class="title title-blue"><?= __('Nổi bật', 't-film') ?></h5>
				<?php

					t_film_box_list_y([
						'post_type' => 'film',
						'meta_key' => 'film_featured',
						'meta_value' => 'on',
						'meta_compare' => 'IN',
						'posts_per_page' => get_option('t-film-plugin')['films-per-page']['list-y']
					]);

				?>
			</div>
		</div>
		<?php endif; ?>

		<?php if(is_user_logged_in()): ?>
		<div class="col-12 px-0 px-md-3">
			<div class="p-3 bg-film mb-4">
				<h5 class="title"><?= __('Yêu thích', 't-film') ?></h5>
				<?php

					$wishlist = get_user_meta( get_currentuserinfo()->ID, $key = 't-film-plugin-wishlist', true );
					$wishlist = !empty($wishlist) ? $wishlist : [];

					t_film_box_list_y([
						'post_type' => 'film',
						'posts_per_page' => '-1',
						'post__in' => $wishlist
					]);

				?>
			</div>

			<div class="p-3 bg-film mb-4">
				<h5 class="title title-black"><?= __('Lịch sử xem', 't-film') ?></h5>
				<?php

					$history = get_user_meta( get_currentuserinfo()->ID, 't-film-plugin-history', true );
					$history = !empty($history) ? json_decode( $history, true) : [];

					$list = array_map(function($key){ return $key; }, array_keys($history));

					$films = new WP_Query([
						'post_type' => 'film',
						'posts_per_page' => '-1',
						'post__in' => $list
					]);

					t_film_box_list_y([
						'post_type' => 'film',
						'posts_per_page' => '-1',
						'post__in' => $list
					]);

				?>
			</div>
		</div>
		<?php endif; ?>

		<?php dynamic_sidebar( 'widget-right-1' );?>
	</div>
</div>