<?php t_film_jwplayer_script() ?>

<script type="text/javascript" src="<?= get_template_directory_uri().'/js/jquery.emojiRatings.js'?>"></script>

<div id="film-<?php the_ID() ?>" <?php post_class('col-12 film-single px-0 px-md-3')?>>
	
	<div class="film-header">

		<?php t_film_trailer() ?>

		<div id="dialog-resume">
			<?= __('Bạn có muốn xem tiếp tục?', 't-film') ?>
		</div>

		<div id="dialog-choose">
			<?php t_film_jwplayer_link() ?>
		</div>
		
		<?php

			$film_id = get_the_ID();
			$user_id = get_currentuserinfo()->ID;

			$script = <<< SCRIPT

				jQuery().ready(function(){

					function get_parse(key)
					{
						var value = localStorage.getItem(key);
						if(value == null) return null;
						try{
							return JSON.parse(value);
						}catch(err){
							localStorage.removeItem(key);
							return null;
						}
					}

					var playlist_item = 0,
					    last_view,
					    last_position = 0,
					    film_id = '$film_id',
					    user_id = '$user_id',
					    begin_time = new Date().valueOf(),
					    sync_second = 1000*3;
					    firstPlay = false;

					jQuery('#dialog-resume').dialog({
						resizable: false,
						autoOpen: false,
						title: 'Bạn chưa xem hết bộ phim này',
						buttons: {
							'Xem tiếp tục': function(){
								last_position = last_view[film_id]['position'];
								jwplayer('player').load(last_view[film_id]['item']);
								jwplayer('player').play();
								jQuery(this).dialog('close');
							},
							'Không': function(){
								jQuery(this).dialog('close');
							}
						}
					});

					jQuery('#dialog-choose').dialog({
						modal: true,
						title: 'Chọn link',
						resizable: true,
						autoOpen: false
					});

					jQuery('#btn-choose-link').click(function(){

						jQuery('#dialog-choose').dialog('open');

					});

					last_view = get_parse('t_film_player_history');
					if(last_view)
					{
						if(last_view[film_id])
						{
							jQuery('#dialog-resume').dialog('open');
						}
					}

					jwplayer('player').on('firstFrame', function() {
						jwplayer('player').seek(last_position);
						last_position = 0;
					});

					jwplayer('player').on('time', function(player){

						if(playlist_item == 0) return;

						var history = get_parse('t_film_player_history');
						if(history == null)
							history = {};
						history[film_id] = {
							'item': playlist_item,
							'position': player.position,
							'duration': player.duration
						};

						localStorage.setItem('t_film_player_history', JSON.stringify(history));

						if(user_id != 0)
						{

							var last_time = new Date().valueOf();
							if(last_time - begin_time <= sync_second) return;

							jQuery.ajax( {
							    url: wpApiSettings.root + 'wp/v2/users/' + user_id,
							    method: 'POST',
							    beforeSend: function ( xhr ) {
							        xhr.setRequestHeader( 'X-WP-Nonce', wpApiSettings.nonce );
							    },
							    data:{
							        't-film-plugin-history' : JSON.stringify(history)
							    }
							} ).done( function ( response ) {

							} );

							begin_time = last_time;
						}

					});

					jwplayer('player').on('playlistItem', function(playlist){
						playlist_item = playlist.index;
					});

					jwplayer('player').on('play', function(){

						if(!firstPlay)
						{
							firstPlay = true;
							pull_down_poster_float();
						}

					});

					jQuery('[data-playlist-item]').click(function(e){

						playlist_item = jQuery(this).index() - 1;
						jwplayer('player').load(jQuery(this).data('playlist-item'));
						jwplayer('player').play();
						jQuery('#dialog-choose').dialog('close');
						pull_down_poster_float();

					});

				});
				
SCRIPT;
			t_film_packer_js($script);

			?>

		<div class="row no-gutters px-2 px-lg-4 float-poster">
			<div class="col-sm-4 col-4 col-xl-3 text-center film-poster">
				<img class="img-fluid" src="<?= get_the_post_thumbnail_url()?>" alt="poster <?= get_the_title()?>"/>
				<div class="badge-rating text-left">
					<?php
						t_film_badge_meta('film_imdb', 'badge-warning', 'IMDb'); t_film_rating();
					?>
				</div>
			</div>
			<div class="col float-content">
				<div class="px-3 py-2">
					<h5 class="text-ellipsis">
						<?php 
							$runtime = get_post_meta( get_the_ID(), 'film_runtime', true );
							echo get_the_title(). ' ('.($runtime ? $runtime.__(' phút', 't-film'): 'N/A'. __(' phút', 't-film')) .')' ?></h5>
					<h6 class="text-ellipsis d-none d-sm-block"><?= esc_html(get_post_meta(get_the_ID(), 'film_title_other', true)) ?></h6>
					<h6 class="d-none d-sm-block"><?= t_film_custom_tax('film_genre')?></h6>
					<?php if(in_array($film_status, [0, 1]) && is_array(get_post_meta(get_the_ID(), 'film_link', true))): ?>
					<button class="btn btn-sm btn-success" id="btn-choose-link">
						<?= t_film_get_icon('media-play'). __('Xem phim', 't-film') ?>
					
					</button>
					<?php endif;?>

					<?php 
						$user_id = get_currentuserinfo()->ID;
						$wishlist = get_user_meta( $user_id, 't-film-plugin-wishlist', true);
						$wishlist = !empty($wishlist) ? $wishlist : [];

						$is_add_wishlist = false;
						if(in_array(get_the_ID(), $wishlist))
							$is_add_wishlist = true;

					?>
					<form method="post" class="d-inline-block" id="form-wishlist">
						<button name="add-wishlist" type="submit" class="btn btn-sm btn-danger"><?= t_film_get_icon('heart'). ($is_add_wishlist ? __('Bỏ yêu thích', 't-film') :  __('Yêu thích', 't-film')) ?></button>
					</form>
					<?php 

						if(!is_user_logged_in()):
					?>

						<script>
							jQuery().ready(function(){

								jQuery('#form-wishlist').submit(function(){

									alert('Đăng nhập để thêm yêu thích'); return false;

								});

							});
						</script>

					<?php endif;?>
				</div>

			</div>
		</div>

		<div class="row no-gutters bg-film p-3 film-info">
			<div class="col-xl-9 col-sm-8 col-8 offset-xl-3 offset-4 offset-sm-4 pl-3">
				<?php
					$film_country = get_post_meta( get_the_ID(), 'film_country', true);
					$film_date = esc_html(get_post_meta( get_the_ID(), 'film_date', true));
					$film_series = get_post_meta(get_the_ID(), 'film_series', true);
					$film_status = get_post_meta( get_the_ID(), 'film_status', true);
					$film_quality = get_post_meta( get_the_ID(), 'film_quality', true);
					$film_subtitle = esc_html(get_post_meta(get_the_ID(), 'film_subtitle', true));
					$film_trailer = esc_url(get_post_meta(get_the_ID(), 'film_trailer', true));
					$film_episode_count = get_post_meta(get_the_ID(), 'film_episode_count', true);
					$film_view_count = get_post_meta( get_the_ID(), 'film_view_count', true);
					$status = get_option('t-film-plugin')['film-status'];

					$list_color = ['list-group-item-success', 'list-group-item-warning', 'list-group-item-danger'];
				?>

				<span class="badge badge-pill badge-success"><?= sprintf(__('%s Đã có %s lượt xem'), t_film_get_icon('graph'), $film_view_count) ?></span>
				<div class="film-history">
					<span class="badge badge-pill badge-secondary last-view" style="display: none"><?= t_film_get_icon('eye')?></span>
				</div>

				<div class='film-rating'>
					<form method="post" id="form-rating">
						<span class="badge badge-pill badge-warning"><?= __('Đánh giá: ', 't-film')?></span><span id="star"></span>
						<?php

							$rating = get_post_meta( get_the_ID(), 'film_rating', $single = true );

							echo '(' . count($rating) . ')';

						?>
					</form>
				</div>

				<ul class="list-group list-group-flush list-film-info mt-3 mr-2 ml-1 read-more" data-height="220">
					<li class="list-group-item <?= $list_color[$film_status] ?>">
					<?= __('Tình trạng:', 't-film') ?> 
							<?= $status[$film_status ?: 1] ?>
					</li>
					<li class="list-group-item d-block d-sm-none"><?= __('Tên khác: ', 't-film'). esc_html(get_post_meta(get_the_ID(), 'film_title_other', true)) ?></li>
					<li class="list-group-item d-block d-sm-none"><?= __('Thể loại: ', 't-film'). t_film_custom_tax('film_genre')?></li>
					<li class="list-group-item ">
					<?= __('Hình thức:', 't-film') ?> 
						<?= $film_series ? __('Phim bộ', 't-film') : __('Phim lẻ', 't-film') ?>	
					</li>
					
					<li class="list-group-item"><?= __('Đạo diễn: ', 't-film'). t_film_custom_tax('film_director')?></li>
					<li class="list-group-item"><?= __('Quốc gia: ', 't-film'). t_film_custom_tax('film_country')?></li>
					<li class="list-group-item"><?= __('Phụ đề: ', 't-film').$film_subtitle?></li>
					<li class="list-group-item"><?= __('Năm: ', 't-film'). date_format(date_create($film_date), 'Y') ?></li>
					<li class="list-group-item"><?=__('Ngày ra mắt: ', 't-film'). ($film_date ? date_format(date_create($film_date), 'd/m/Y') : 'N/A')?></li>
					<li class="list-group-item"><?=__('Chất lượng: ', 't-film'). $film_quality ?></li>
					<?= $film_series == 1 ? '<li class="list-group-item">'.__('Số tập: ', 't-film'). $film_episode_count . '</li>' : '' ?>
				</ul>

				<div class="film-tags my-2">
					<?= t_film_post_tag() ?>
				</div>

			</div>
		</div>
	</div>

	<?php 
		$actor_by_film = get_the_terms( get_the_ID(), 'film_actor' );

		if($actor_by_film):
	?>

	<div class="film-actor bg-film p-3 my-4">
		<div class="row"><div class="col-12"><h5 class="title"><?= __('Diễn viên', 't-film')?></h5></div></div>
		<div class="row flex-nowrap scroll-x">
			<?php

					foreach($actor_by_film as $actor)
					{
						if(function_exists('get_wp_term_image'))
						{
							$url = get_wp_term_image($actor->term_id);
						}

						if(!$url)
							$url = get_template_directory_uri().'/img/person.png';

						printf('<div class="col-5 col-sm-3 col-md-2 text-center"><a href="%s"><img src="%s" width="auto" height="80"><br/><small>%s</small></a></div>', get_term_link( $actor ), $url, $actor->name);
					}

			?>
		</div>
	</div>

	<?php endif; ?>

	<div class="film-content bg-film p-3 my-4 scroll">
		<div class="row">
			<div class="col-12"><h5 class="title">Nội dung</h5></div>
			<div class="col"><?= the_content() ?></div>
		</div>
	</div>

	<script>

		jQuery().ready(function(){

			jQuery('#star').emojiRating({
				emoji: 'U+2B50',
				count: 5,
				fontSize: 16,
				color: 'red',
				inputName: 'film-rating',
				onUpdate: function() {

					jQuery('#form-rating').submit();
				}
			});

		});
	</script>

	<div class="film-relation bg-film p-3 mb-4">
		<div class="row">
			<div class="col-12"><h5 class="title title-green"><?= __('Phim liên quan', 't-film')?></h5></div>
			<div class="col">
				<?php

					$terms = get_the_terms( get_the_ID(), 'film_genre' );
					
					if($terms != FALSE):

						$film_genre = [];
						foreach($terms as $genre)
							$film_genre[] = $genre->term_id;

						$args = [
							'post_type' => 'film',
							'orderby' => 'rand',
							'posts_per_page' => get_option( 't-film-plugin')['films-per-page']['list-x'],
							'tax_query' => [
								[
									'taxonomy' => 'film_genre',
									'field' => 'term_id',
									'terms' => $film_genre,
									'operator' => 'IN'
								]
							],
							'meta_query' => [
								'key' => 'film_title_other',
								'value' => get_the_title(),
								'compare' => 'LIKE'
							],
							'_meta_or_title' => get_the_title(),
							'post__not_in' => [get_the_ID()]
						];

						t_film_box_scroll($args);
					else:
						get_template_part( 'template-parts/content', 'none-film' );
					endif;
				?>
			</div>
		</div>
	</div>
</div>