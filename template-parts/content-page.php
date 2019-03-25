<div id="post-<?php the_ID() ?>" <?php post_class('col-12 px-0 px-md-4 post-item')?>>
	<div class="post-detail bg-film p-3">
		<div class="mb-2"><?php t_film_post_category(); ?></div>
		<?php if(has_post_thumbnail()): ?>
			<div class="text-center post-thumbnail mb-2">
				<?php t_film_post_thumbnail(); ?>
			</div>
		<?php endif; ?>
		<h4 class="post-title"><?php the_title() ?></h4>
		<div class="mb-2"><?php t_film_post_author(); t_film_post_datetime(); ?></div>
		<div class="post-content pb-2 text-justify">
			<?php 
				the_content();
				printf('<h5>');
				t_film_link_pages();
				printf('</h5>');
			?>
		</div>
		<div class="mb-2"><?php t_film_post_tag(); ?></div>
		<div><?php t_film_post_buttons(); ?></div>
		<div class="pt-2 mt-2 border-top"><?php t_film_post_navigation(); ?></div>
	</div>
</div>