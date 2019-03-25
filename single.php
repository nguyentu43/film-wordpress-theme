<?php get_header();?>

	<div class="col-md-8 col-12" id="main">
		<div class="row my-4">
			<?php
				if(have_posts()):
					while(have_posts()):
						the_post();

						if(get_post_type() == 'film')
						{
							do_action('t-film-plugin-save-user-film-data');
							do_action('t-film-plugin-update-view-count');
							get_template_part( '/template-parts/content', 'single-film');
						}
						else
							get_template_part( '/template-parts/content', get_post_type());
					endwhile;

					if ( comments_open() || get_comments_number() ) :
						echo "<div class='col-12 px-0 px-md-3'><div class='p-3 bg-film'>";
						comments_template();
						echo "</div></div>";
					endif;
				else:
						get_template_part( 'template-parts/content', 'none' );
				endif;
			?>
		</div>
	</div>

<?php 
	get_sidebar();
	get_footer(); 
?>