<div class="col-12 no-results not-found">
	<div class="mx-2">
		<h5 class="title"><?= __( 'Không có nội dung gì', 't-film' ); ?></h5>
		<div class="content">
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) :

				printf(
					'<p>' . wp_kses(
						__( '<a href="%1$s">Đăng bài ngay</a>.', 't-film' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					) . '</p>',
					esc_url( admin_url( 'post-new.php' ) )
				);

			elseif ( is_search() ) :
				?>

				<p><?= __( 'Không tìm thấy nội dung nào phù hợp với từ khoá cần tìm. Hãy thử lại với từ khoá khác', 't-film' ); ?></p>
				<?php

			else :
				?>

				<p><?= __( 'Không tìm thấy nội dung nào phù hợp. Hãy thử với từ khoá khác', 't-film' ); ?></p>
				<?php
				get_search_form();

			endif;
			?>
		</div>
	</div>
</div>