<?php get_header();?>

	<div class="col-md-8 col-12" id="main">

		<div class="row my-2">
			<div class="col-12 px-0 px-md-3">
				<div class="p-3 mb-4 bg-film"><strong><?= __('Kết quả tìm kiếm bài viết chứa nội dung ', 't-film'). '<u>'.esc_html(get_query_var( 's', $default = '' )).'</u>' ?></strong>
				</div>
			</div>

			<?php

				$page = empty($_GET['page']) ? 1 : $_GET['page'];
				$posts_per_page = empty($_GET['posts_per_page']) ? get_option('t-film-plugin')['films-per-page']['search'] : $_GET['posts_per_page'];

				$posts = new WP_Query([
					'post_type' => 'post',
					's' => esc_html(get_query_var( 's', $default = '' )),
					'posts_per_page' => $posts_per_page,
					'paged' => $page
				]);

				if($posts->have_posts()):
			?>

			<?php
					while($posts->have_posts()):
						$posts->the_post();
						get_template_part( '/template-parts/content', get_post_type());
					endwhile;

					echo "<div class='w-100 mt-2'>";
					t_film_posts_pagination($posts);
					echo "</div>";
				else:
						get_template_part( 'template-parts/content', 'none' );
				endif;

				wp_reset_postdata();
			?>
		</div>
	</div>

<?php get_sidebar(); get_footer(); ?>