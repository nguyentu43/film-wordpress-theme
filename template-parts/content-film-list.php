<div id="film-<?php the_ID()?>" <?php post_class('film-item film-v-list row no-gutters')?> title="<?=  mb_strtoupper(get_the_title())?>" >
	<div class="col-sm-3 col-4">
		<a href="<?= get_the_permalink() ?>">
			<img src="<?= get_the_post_thumbnail_url() ?>" class="img-fluid poster" alt="poster <?= get_the_title()?>">
		</a>
	</div>
	<div class="col-sm-9 col-8 content">
		<div class="film-title p-1">
			<a href="<?php the_permalink() ?>"><strong><?= mb_strtoupper(get_the_title()) ?></strong></a><br/>
			<small><?= t_film_custom_tax('film_genre') ?></small><br/>
			<small><?php $runtime = get_post_meta( get_the_ID(), 'film_runtime', true ); echo $runtime ? $runtime.__(' phút', 't-film'): 'N/A' ?>
			<?php

				if(get_post_meta(get_the_ID(), 'film_series', true) == 1)
					echo ', '. get_post_meta( get_the_ID(), 'film_episode_count', true );

			?>
			</small>

			<small>
				<?php 

					$imdb = get_post_meta( get_the_ID(), 'film_imdb', true );
					echo $imdb ? ', IMDb: '.$imdb : '';

					$rating = get_post_meta( get_the_ID(), 'film_rating', $single = true );

					if(count($rating) > 0)
					{
						$point = array_sum($rating) / count($rating);
						printf(', WEB %.1f/5', $point);
					}

				?>
			</small>

			<div class="film-history">
				<span class="badge badge-pill badge-secondary last-view" style="display: none"><?= t_film_get_icon('eye')?></span>
				<span class="badge badge-pill badge-info complete" style="display: none"><?= __('Đã xem', 't-film')?></span>
			</div>
		</div>
	</div>
</div>