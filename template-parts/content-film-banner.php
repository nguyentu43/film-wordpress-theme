<?php
	$banner = get_post_meta(get_the_ID(), 'film_banner', true);
	$image = $banner ?: get_the_post_thumbnail_url();
?>
<a href="<?php the_permalink() ?>">
	<div <?php post_class('film-item film-v-banner mx-2 film-poster') ?> id="film-<?php the_ID()?>" style="background-image: url(<?= $image ?>)">
		<div class="caption p-2">
			<h4 class="text-ellipsis"><?= mb_strtoupper(get_the_title()) ?></h4>
		</div>
		<h6 class="badge-rating">
			<?php
				t_film_badge_meta('film_imdb', 'badge-warning', 'IMDb'); t_film_rating();
			?>
		</h6>
	</div>
</a>