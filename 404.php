<?php get_header(); ?>

	<div class="col-md-8 col-12" id="main">
		<div class="row my-4">
			<div class="error-404 not-found col py-2 bg-film text-center mx-md-3">
				<h3 class="page-title"><?php esc_html_e( 'Trang này không tồn tại!', 't-film' ); ?></h3>
				<h1 class="my-5"><?= __('404 Page Not Found', 't-film') ?></h1>
			</div>
		</div>
	</div>

<?php
	get_sidebar();
	get_footer(); 
?>
