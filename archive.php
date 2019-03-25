<?php get_header();?>

	<div class="col-md-8 col-12" id="main">

		<div class="row my-4">
			<?php
				if(have_posts()):

			?>
				<div class="col-12 mb-4 px-0 px-md-3">
					<?php the_archive_title('<div class="bg-film p-3"><strong>', '</strong></div>'); ?>
				</div>

			<?php
					if(get_the_archive_description() != '')
						printf('<div class="col-12 mb-4 px-0 px-md-3">
						<div class="p-3 bg-film">%s</div></div>', get_the_archive_description());

					while(have_posts()):
						the_post();

						if(get_post_type() == 'film')
						{
							printf('<div class="col-lg-3 col-sm-4 col-6 mb-4">');
							get_template_part( '/template-parts/content', 'film');
							printf('</div>');
						}
						else
							get_template_part( '/template-parts/content', get_post_type());
					endwhile;
				else:
					if(get_post_type() == 'film')
						get_template_part( 'template-parts/content', 'none-film' );
					else
						get_template_part( 'template-parts/content', 'none' );
				endif;
			?>
		</div>

	</div>

<?php get_sidebar(); get_footer(); ?>