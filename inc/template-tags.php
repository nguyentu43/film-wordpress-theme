<?php

if(!function_exists('t_film_get_icon')){

	function t_film_get_icon($name){

		return sprintf(
			' <span class="oi oi-%1$s" title="%1$s" aria-hidden="true"></span> ',
		 	 $name
		);

	}
}

if(! function_exists('t_film_post_thumbnail')){

	function t_film_post_thumbnail(){

		if(has_post_thumbnail())
		{
			printf('<img src="%s" class="img-fluid" alt="img %s" />', get_the_post_thumbnail_url(), get_the_title());
		}
	}
}

if(! function_exists('t_film_post_tag')){

	function t_film_post_tag(){

		if(has_tag())
		{
			$tags = get_the_tags();

			foreach($tags as $tag)
			{
				if(get_post_type() == 'film')
					printf('<span class="badge badge-dark"><a class="text-white text-decoration-none" href="%s?post_type=film">%s %s</a></span>', get_term_link( $tag), t_film_get_icon('tag'), $tag->name);
				else
					printf('<span class="badge badge-dark"><a class="text-white text-decoration-none" href="%s">%s %s</a></span>', get_term_link( $tag), t_film_get_icon('tag'), $tag->name);
			}
		}
	}
}

if(! function_exists('t_film_post_category')){

	function t_film_post_category(){

		if(has_category())
		{
			$categories = get_the_category();

			foreach($categories as $cat)
			{
				printf('<span class="badge badge-primary"><a class="text-white text-decoration-none" href="%s">%s %s</a></span>', get_term_link( $cat), t_film_get_icon('book'), $cat->name);
			}
		}
	}
}

if(! function_exists('t_film_post_author')){

	function t_film_post_author(){
		echo '<span class="badge badge-pill badge-warning">';
		echo t_film_get_icon('person');
		the_author_posts_link();
		echo '</span>';
	}
}

if(! function_exists('t_film_post_datetime')){

	function t_film_post_datetime(){

		echo '<span class="badge badge-pill badge-secondary">';
		echo t_film_get_icon('clock');
		the_time();
		the_date( $d = '', $before = ' ');
		echo '</span>';
		
	}
}

if(! function_exists('t_film_post_comments_number')){

	function t_film_post_comments_number(){

		if(comments_open())
		{
			$comments_number = get_comments_number();
			printf('<span class="badge badge-pill badge-dark">%s %d bình luận</span>', t_film_get_icon('comment-square') ,$comments_number);
		}
	}
}

if(! function_exists('t_film_post_buttons')){

	function t_film_post_buttons(){

		if(get_edit_post_link())
		{
			printf('<a href="%s" class="btn btn-sm btn-success">%s %s</a>', get_edit_post_link(), t_film_get_icon('pencil'),__('Chỉnh sửa', 't-film') );
		}
		
	}
}

if(!function_exists('t_film_post_navigation')){

	function t_film_post_navigation(){

		$prev_post = get_previous_post();
		$next_post = get_next_post();
		
?>
		<div class="post-navigation">
			<div class="d-flex">
			<?php if($prev_post)
				printf('<a class="btn btn-dark btn-sm mr-auto" href="%s">%s%s</a>',
					esc_html(get_permalink( $prev_post )),t_film_get_icon('arrow-left'),get_the_title( $prev_post ));
			?>
			
			<?php if($next_post)
				printf('<a class="btn btn-dark btn-sm ml-1" href="%s">%s%s</a>',
					esc_html(get_permalink( $next_post )), get_the_title( $next_post ), t_film_get_icon('arrow-right'));
			?>
			</div>
		</div>
<?php

	}
}

if(!function_exists('t_film_comment_navigation')){

	function t_film_comment_navigation(){

		$prev_comment = get_previous_comments_link();
		$next_comment = get_next_comments_link();
		
?>
		<div class="post-comment">
			<div class="d-flex">
			<?php if($prev_post)
				printf('<a class="btn btn-dark btn-sm mr-auto" href="%s">%s%s</a>',
					$prev_comment,t_film_get_icon('arrow-left'), __('Trước', 't-film'));
			?>
			
			<?php if($next_post)
				printf('<a class="btn btn-dark btn-sm ml-auto" href="%s">%s%s</a>',
					$next_comment, __('Sau', 't-film'), t_film_get_icon('arrow-right'));
			?>
			</div>
		</div>
<?php

	}
}

if(!function_exists('t_film_link_pages')){

	function t_film_link_pages(){

		wp_link_pages([
		'before' => '<div>'.__('Trang', 't-film'),
		'after' => '</div>',
		'separator' => ', '
		]);

	}
}

if(!function_exists('t_film_posts_pagination')){

	function t_film_posts_pagination($wp_query = null){

		if(!is_search())
		{
			global $wp_query;
		}

		if($wp_query->max_num_pages > 1):

			if(is_search())
			{
				$paged = get_query_var('page', $default = 1 );
				$url = get_bloginfo('url') . '/?';

				foreach($_GET as $key => $value)
				{
					if($key == 'page')
						continue;

					if(is_array($value))
					{
						foreach($value as $item)
							$url .= "$key".'[]'."=$item&";
						continue;
					}

					$url .= "$key=$value&";
				}

				$url .= 'page=';
			}
			else
			{
				$paged = get_query_var('paged', $default = 1 );
				$url = get_permalink(get_option( 'page_for_posts' )).'page/';
			}

			if($paged == 0)
				$paged++;
?>
			<div class="justify-content-center d-flex">
				<nav aria-label="posts-pagination">
				  <ul class="pagination mb-0">

<?php
			if($paged > 1)
			{
				$prev_link = $url. ($paged - 1);
				printf('<li class="page-item"><a class="page-link" href="%s">%s</a></li>', esc_url($prev_link), __('Trang trước' ,'t-film') );
			}
			else
			{
				printf('<li class="page-item disabled"><span class="page-link">%s</span></li>', __('Trang trước' ,'t-film'));
			}

			for($i=1; $i <= $wp_query->max_num_pages; ++$i)
			{
				if($i == $paged)
				{
					printf('<li class="page-item active"><span class="page-link">%d<span class="sr-only">(current)</span></span></li>', $i);
				}
				else
				{
					printf('<li class="page-item"><a class="page-link" href="%s">%d</a></li>', esc_url( $url.$i ), $i);
				}
			}

			if($paged < $wp_query->max_num_pages)
			{
				$next_link = $url. ($paged + 1);
				printf('<li class="page-item"><a class="page-link" href="%s">%s</a></li>', esc_url($next_link), __('Trang sau' ,'t-film') );
			}
			else
			{
				printf('<li class="page-item disabled"><span class="page-link">%s</span></li>', __('Trang sau' ,'t-film'));
			}
?>
			  </ul>
			</nav>
		</div>
<?php

		endif;

	}

}

if(!function_exists('t_film_trailer')){

	function t_film_trailer(){

		$link = get_post_meta(get_the_ID(), 'film_trailer', true);
		$banner = get_post_meta(get_the_ID(), 'film_banner', true);
		$image = $banner ?: get_the_post_thumbnail_url();
		printf('<div id="player"></div>');
		t_film_packer_js(sprintf('jwplayer("player").setup({"file": "%s", "image": "%s", "width": "100%%"});', $link, $image));

	}
}

if(!function_exists('t_film_jwplayer_script')){
	function t_film_jwplayer_script(){

		printf('<script type="text/javascript" src="%s"></script>
		<script>jwplayer.key="YgtWotBOi+JsQi+stgRlQ3SK21W2vbKi/K2V86kVbwU=";</script>', get_template_directory_uri().'/js/jwplayer.js');

	}
}

function explode_str($link)
{
	$list = explode(PHP_EOL, $link);
	$result = [];
	foreach($list as $item)
	{
		$result[] = explode('|', $item);
	}
	return $result;
}

if(!function_exists('t_film_jwplayer_link')){

	function t_film_jwplayer_link(){

		$list = get_post_meta( get_the_ID(), 'film_link', true );

		$span = '';

		$span .= sprintf('<span style="cursor: pointer" class="badge badge-pill badge-secondary" data-playlist-item="%d">%s</span>', 0, 'Trailer');
		$banner = get_post_meta(get_the_ID(), 'film_banner', true);
		$image = $banner ?: get_the_post_thumbnail_url();
		$playlist = [[
			'file' => get_post_meta(get_the_ID(), 'film_trailer', true),
			'title' => get_the_title(). ' - Trailer',
			'image' => $image
		]];

		if($list)
		{
			foreach($list as $index => $item)
			{
				$span .= sprintf('<span style="cursor: pointer" class="badge badge-pill badge-secondary" data-playlist-item="%d">%s</span>', $index + 1, $item['name']);

				$sublink = explode_str($item['link']);

				if(count($sublink) > 0)
				{
					$playlist_item = [
						'title' => get_the_title() . ' - ' . $item['name'],
						'image' => get_the_post_thumbnail_url()
					];

					foreach($sublink as $sub)
					{
						$playlist_item['sources'][] = [
							'file' => $sub[0],
							'label' => $sub[1],
							'type' => $sub[2],
							'default' => !empty($sub[3]) ? "true": "false"
						];
					}

					$subtitle = explode_str($item['subtitle']);

					foreach($subtitle as $sub_item)
					{
						$playlist_item['tracks'][] = [
							'file' => $sub_item[0],
							'label' => $sub_item[1],
							'kind' => 'captions'
						];
					}

					$playlist[] = $playlist_item;
				}
			}
		}

		echo $span;

		t_film_packer_js(sprintf('jwplayer("player").load(%s);', json_encode($playlist)));
	}
}

if(!function_exists('t_film_print_custom_tax'))
{

	function t_film_custom_tax($key){

		$list = get_the_terms( get_the_ID(), $key );

		if($list === FALSE)
			return 'Không có';

		$link = [];
		foreach($list as $item)
		{
			$link[] = sprintf('<a href="%s">%s</a>', get_term_link( $item), $item->name);
		}
		return implode(', ', $link);
	}
}

if(!function_exists('load_user_meta')){

	function load_user_meta()
	{
		if(is_user_logged_in())
		{
			$user = get_currentuserinfo();
			$history = get_user_meta( $user->ID, 't-film-plugin-history', true );

			t_film_packer_js(sprintf("
						localStorage.setItem('t_film_player_history', '%s');
			", $history, $complete));

		}
	}
}

if(!function_exists('t_film_badge_meta'))
{
	function t_film_badge_meta($meta, $badge_class = '', $before = '', $after = '')
	{
		$value = get_post_meta( get_the_ID(), $meta, $single = true );

		if($value)
		{
			printf('<span class="badge badge-pill %s">%s %s %s</span>', $badge_class, $before, $value, $after);
		}
	}
}

if(!function_exists('t_film_rating'))
{
	function t_film_rating()
	{
		$rating = get_post_meta( get_the_ID(), 'film_rating', $single = true );

		if(count($rating) > 0)
		{
			$point = array_sum($rating) / count($rating);
			printf('<span class="badge badge-pill badge-primary">WEB %.1f/5</span>', $point);
		}
	}
}

if(!function_exists('t_film_box'))
{
	function t_film_box($args)
	{
?>
		<div class="row">
			<?php

				$films = new WP_Query($args);

				if($films->have_posts()):

					while($films->have_posts()):
						$films->the_post();

						printf('<div class="col-lg-3 col-sm-4 col-6 mb-4">');
						get_template_part( '/template-parts/content', get_post_type());
						printf('</div>');
						
					endwhile;

					echo "<div class='w-100 mt-2'>";
					if(!isset($_GET['topic'])) t_film_posts_pagination($films);
					echo "</div>";

				else:
						get_template_part( 'template-parts/content', 'none-film' );
				endif;

				wp_reset_postdata();
			?>
		</div>

<?php
		
	}
}

if(!function_exists('t_film_box_scroll'))
{
	function t_film_box_scroll($args, $size="col-lg-3 col-sm-4 col-6")
	{
?>
		<div class="row scroll-x">
			<?php

				$films = new WP_Query($args);

				if($films->have_posts()):

					while($films->have_posts()):
						$films->the_post();

						printf('<div class="%s mb-4">', $size);
						get_template_part( '/template-parts/content', get_post_type());
						printf('</div>');
						
					endwhile;

				else:
						get_template_part( 'template-parts/content', 'none-film' );
				endif;

				wp_reset_postdata();
			?>
		</div>

<?php
		
	}
}

if(!function_exists('t_film_box_cover'))
{
	function t_film_box_cover($args)
	{
?>
		<div class="row flex-nowrap scroll-x">
			<?php

				$films = new WP_Query($args);

				if($films->have_posts()):
					while($films->have_posts()):
						$films->the_post();
			?>
				<div class="col-xl-2 col-md-3 col-sm-4 col-5 pr-0">
					<?php get_template_part( '/template-parts/content', 'film-cover'); ?>
				</div>

			<?php
					endwhile;
					wp_reset_postdata();
				else:
					get_template_part( 'template-parts/content', 'none-film' );
				endif;
			?>
		</div>

<?php
		
	}
}

if(!function_exists('t_film_box_list_x'))
{
	function t_film_box_list_x($args, $colCount = 6)
	{
?>
		<div class="row scroll-x pb-1">
			<div class="col-12">
			<?php

				$break = $colCount;
				$films = new WP_Query($args);
				$i = 1;
				if($films->have_posts()):
					while($films->have_posts()):
						$films->the_post();

						if($i % $break == 1)
							echo '<div class="row flex-nowrap no-gutters mr-1">';
			?>
						<div class="col-md-4 col-sm-6 col-7 mb-1">
							<?php get_template_part( '/template-parts/content', 'film-list'); ?>
						</div>

			<?php
						if($i % $break == 0)
							echo '</div>';
						$i++;
					endwhile;
					if(($i - 1) % $break != 0)
						echo '</div>';	
					wp_reset_postdata();
				else:
					get_template_part( 'template-parts/content', 'none-film' );
				endif;
			?>
			</div>
		</div>

<?php
		
	}
}

if(!function_exists('t_film_box_list_y'))
{
	function t_film_box_list_y($args, $height=450)
	{
?>
		<style>.scroll-y { max-height: <?= $height?>px;  }</style>
		<div class="row scroll-y">
			<?php

				$films = new WP_Query($args);
				if($films->have_posts()):
					while($films->have_posts()):
						$films->the_post();
			?>
						<div class="col-12 mb-2">
							<?php get_template_part( '/template-parts/content', 'film-list'); ?>
						</div>

			<?php
					endwhile;	
					wp_reset_postdata();
				else:
					get_template_part( 'template-parts/content', 'none-film' );
				endif;
			?>
		</div>

<?php
		
	}
}

if(!function_exists('t_film_carousel'))
{
	function t_film_carousel($args)
	{
?>
		<div class="carousel">
			<?php

				$films = new WP_Query($args);

				if($films->have_posts()):
					while($films->have_posts()):
						$films->the_post();
			?>	
					<?php get_template_part( '/template-parts/content', 'film-banner'); ?>
			<?php
					endwhile;
					wp_reset_postdata();
				else:
					get_template_part( 'template-parts/content', 'none-film' );
				endif;
			?>
		</div>

		<script>
			jQuery('.carousel').slick({
			  dots: true,
			  autoplay: true,
  			  autoplaySpeed: 2000,
			  slidesToShow: 3,
			  arrows: false,
			  responsive: [
			  	{
			  		breakpoint: 768,
			  		settings: {
			  			slidesToShow: 2
			  		}
			  	},
			  	{
			  		breakpoint: 576,
			  		settings: {
			  			slidesToShow: 1
			  		}
			  	},
			  ]
			});
		</script>

<?php
		
	}
}

if(!function_exists('t_film_packer_js')){
	function t_film_packer_js($script){
		echo '<script>';
		$packer = new JavaScriptPacker($script, $encoding = 62, $fast_decode = true, $special_char = false);
		$packed = $packer->pack();
		echo $packed;
		echo '</script>';
	}
}