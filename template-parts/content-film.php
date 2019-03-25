<div id="film-<?php the_ID()?>" <?php post_class('film-item film-item-default')?> title="<?=  mb_strtoupper(get_the_title())?>" >
	
	<div class="film-poster">
	<a href="<?php the_permalink() ?>">
		<img src="<?= get_the_post_thumbnail_url() ?>" class="img-fluid poster" alt="poster <?= get_the_title()?>">
	</a>

		<div class="badge-rating">
			<?php
				t_film_badge_meta('film_imdb', 'badge-warning', 'IMDb'); t_film_rating();
			?>
		</div>
	</div>
	<div class="film-title p-1">
		<div><a href="<?php the_permalink() ?>"><strong><?= mb_strtoupper(get_the_title()) ?></strong></a></div>
		<div><small><?= get_post_meta( get_the_ID(), 'film_title_other', true ); ?></small></div>
		<div><small><?= t_film_custom_tax('film_genre') ?></small></div>
		<div><small><?php $runtime = get_post_meta( get_the_ID(), 'film_runtime', true ); echo $runtime ? $runtime.__(' phút', 't-film'): 'N/A' ?>
		<?php

			if(get_post_meta(get_the_ID(), 'film_series', true) == 1)
				echo ', '. get_post_meta( get_the_ID(), 'film_episode_count', true );
		?>
		</small></div>
	</div>
	<div class="film-history fix">
		<span class="badge badge-pill badge-secondary last-view" style="display: none"><?= t_film_get_icon('eye')?></span>
		<span class="badge badge-pill badge-info complete" style="display: none"><?= __('Đã xem', 't-film')?></span>
	</div>
</div>