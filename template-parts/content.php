<?php if(is_single()): ?>
<div id="post-<?php the_ID() ?>" <?php post_class('col-12 px-0 px-md-3 post-single')?>>
	<div class="p-3 bg-film mb-4">
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
<?php else: ?>
<div id="post-<?php the_ID()?>" <?php post_class('col-sm-12 col-md-6 col-12 px-0 px-md-3 post-item')?> >
	<div class="mb-4 p-3 bg-film">
		<div class="<?= has_post_thumbnail() ? 'mb-3' : '' ?>"><?php t_film_post_category(); ?></div>
		<div class="text-center post-thumbnail">
			<a href="<?php the_permalink() ?>">
				<?php t_film_post_thumbnail(); ?>
			</a>
		</div>
		<h5 class="post-title pt-3"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h5>
	    <div class="post-excerpt text-justify"><?php the_excerpt() ?></div>
	    <?php t_film_post_comments_number();?>
	</div>
</div>
<?php endif; ?>
