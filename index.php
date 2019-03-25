<?php get_header(); ?>

	<div class="col-md-8 col-12" id="main">
		<div class="row my-4">
		<?php
			if(have_posts()):
				while(have_posts()):
					the_post();
					get_template_part( '/template-parts/content', get_post_type());
				endwhile;
				echo "<div class='w-100'>";
				t_film_posts_pagination();
				echo "</div>";
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