<?php

/*

	Template Name: Video Player

*/

get_header();

t_film_jwplayer_script();

?>

	<div class="col-12 px-0 px-md-1" id="main">

		<div class="row my-4 mx-0 mx-md-3">

			<?php
				$film = new WP_Query([
					'p' => $_GET['film_id'],
					'post_type' => 'film'
				]);

				if($film->have_posts()):
					$film->the_post();

					if(!is_array(get_post_meta(get_the_ID(), 'film_link', true))):
			?>
						<script type="text/javascript">
							confirm('Phim đang được cập nhật');
							history.back();
						</script>

			<?php
					else:
					do_action('t-film-plugin-update-view-count');
			?>
		
			<div class="col-12 mb-4 px-0 film-<?php the_ID()?>">

				<?= t_film_trailer() ?>

				<div id="dialog-resume">
					<?= __('Bạn có muốn xem tiếp tục?', 't-film') ?>
				</div>
				
				<script type="text/javascript">	
				<?php 

				$film_id = $_GET['film_id'];
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
						    lastView,
						    film_id = '$film_id',
						    user_id = '$user_id',
						    begin_time = new Date().valueOf(),
						    sync_second = 1000*3;

						jQuery('#dialog-resume').dialog({
							resizable: false,
							modal: true,
							autoOpen: false,
							title: 'Bạn chưa xem hết bộ phim này',
							buttons: {
								'Xem tiếp tục': function(){
									jwplayer().load(lastView[film_id]['item']);
									jwplayer().seek(lastView[film_id]['position']);
									jwplayer().play();
									jQuery(this).dialog('close');
								},
								'Không': function(){
									jQuery(this).dialog('close');
								}
							}

						});

						lastView = get_parse('t_film_player_history');
						if(lastView)
						{
							if(lastView[film_id])
							{
								jQuery('#dialog-resume').dialog('open');
							}
						}

						jwplayer().on('playlistComplete', function(){

							var complete = get_parse('t_film_player_complete');
							if(!complete) complete = [];

							if(complete.indexOf(film_id) == -1)
								complete.push(film_id);
							localStorage.setItem('t_film_player_complete', JSON.stringify(complete));

							if(wpApiSettings.nonce)
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
								        't-film-plugin-complete' : JSON.stringify(complete)
								    }
								} ).done( function ( response ) {
								    console.log( response );
								} );

								begin_time = last_time;

							}

						});

						jwplayer().on('time', function(player){

							var history = get_parse('t_film_player_history');
							if(history == null)
								history = {};
							history[film_id] = {
								'item': playlist_item,
								'position': player.position,
								'duration': player.duration
							};

							localStorage.setItem('t_film_player_history', JSON.stringify(history));

							if(wpApiSettings.nonce)
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
								    console.log( response );
								} );

								begin_time = last_time;
							}

						});

						jwplayer().on('playlistItem', function(playlist){

							playlist_item = playlist.index;

						});

						jQuery('[data-playlist-item]').click(function(e){

							playlist_item = jQuery(this).index() - 1;

							jwplayer().load(jQuery(this).data('playlist-item'));

							window.scrollTo(0, 120);

						});

					});
				
SCRIPT;
				$packer = new JavaScriptPacker($script, $encoding = 62, $fast_decode = true, $special_char = false);
  				$packed = $packer->pack();

  				echo $packed;

				?>
				</script>
			</div>

			<div class="bg-film col-12 mb-4 p-3">

				<div class="row">

					<div class="col-12">
						<h5 class="title title-red"><?= __('Thông tin phim', 't-film') ?></h5>
					</div>
					
					<div class="col-md-3 col-12 text-center">
						<img src="<?= get_the_post_thumbnail_url(get_the_ID(), 'medium') ?>" class="img-fluid">
					</div>

					<div class="col mt-2 mt-md-0">

						<h3><?= mb_strtoupper(get_the_title()) ?></h3>
						
						<ul class="list-group list-group-flush list-film-info">
							<li class="list-group-item ">
							<?= __('Tên khác:', 't-film') ?> 
								<?= get_post_meta( get_the_ID(), 'film_title_other', true ); ?>
							</li>
							<li class="list-group-item ">
							<?= __('Hình thức:', 't-film') ?> 
								<?= $film_series ? __('Phim bộ', 't-film') : __('Phim lẻ', 't-film') ?>	
							</li>
							<li class="list-group-item"><?= __('Thể loại: ', 't-film'). t_film_custom_tax('film_genre')?></li>
							<li class="list-group-item"><?= __('Đạo diễn: ', 't-film'). t_film_custom_tax('film_director')?></li>
							<li class="list-group-item"><?= __('Diễn viên: ', 't-film'). t_film_custom_tax('film_actor')?></li>
							<li class="list-group-item"><?= __('Quốc gia: ', 't-film'). t_film_custom_tax('film_country')?></li>
							<li class="list-group-item"><?php _e('Điểm IMDb: ', 't-film'); t_film_badge_meta('film_imdb', 'badge-warning');?></li>
							<li class="list-group-item"><?php _e('Đánh giá từ trang: ', 't-film'); t_film_rating() ?></li>
						</ul>
						<div><?= the_excerpt()?></div>

						<div class="border p-2">
							<?php t_film_jwplayer_link() ?>
						</div>
					</div>

				</div>

			</div>

			<div class="bg-film col-12 mb-4 p-3 order-2" id="comments">

				<?php

					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				?>

			</div>

			<div class="bg-film col-12 mb-4 p-3">
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

								t_film_box_scroll($args, 'col-lg-2 col-sm-3 col-6');
							else:
								get_template_part( 'template-parts/content', 'none-film' );
							endif;
						?>
					</div>
				</div>
			</div>

			<?php 
					endif;
				else: 
					get_template_part( '/template-parts/content', 'none');
			?>

			<?php endif; ?>
		</div>

	</div>
<?php wp_reset_postdata(); get_footer(); ?>