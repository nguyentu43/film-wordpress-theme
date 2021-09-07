<?php ob_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="<?php bloginfo('charset') ?>">
	<meta name="viewport" content="initial-scale=1,width=device-width">
	<?php 
		wp_head();
		load_user_meta();
	?>
</head>
<body <?php body_class('custom-background'); if(is_front_page()) printf('data-spy="scroll" data-target="#navbar-film" data-offset="0"'); ?> >
	<header>
		<nav class="navbar navbar-expand-lg justify-content-between" id="navbar-top">
		  <a class="navbar-brand" href="<?php bloginfo('url')?>">
				<?php if(get_site_icon_url()): ?>
					<img src="<?= get_site_icon_url() ?>" width="30" height="30" alt="icon t-film">
				<?php endif ?>
		  	<?php bloginfo('name')?>
		  </a>
		  <?php get_template_part( 'template-parts/searchbar') ?>

		  <button class="btn btn-toggler d-block d-lg-none" type="button" data-toggle="collapse" data-target="#navbar-right" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		    <?= t_film_get_icon('menu')?>
		  </button>

		  <div class="collapse navbar-collapse justify-content-end" id="navbar-right">

		    <ul class="navbar-nav">
		      <li class="nav-item">
		        <a class="nav-link" href="<?= get_permalink( get_option( 'page_for_posts' ) )?>"><?= __('Tin tức', 't-film')?></a>
		      </li>

		    <?php
		  	
		  		$locations = get_nav_menu_locations();
		  		$menu = get_term($locations['menu-top'], 'nav_menu');
		  		$menu_items = wp_get_nav_menu_items($menu->term_id);
					if(is_array($menu_items)):
		  			foreach($menu_items as $item):
		  	?>

		  		<li class="nav-item">
			        <a class="nav-link" href="<?= $item->url ?>"><?= $item->title ?></a>
			    </li>

		  	<?php endforeach; endif;?>

		      <?php if(is_user_logged_in()): ?>
		      <li class="nav-item dropdown">
		        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		          Xin chào, <?= wp_get_current_user()->display_name ?>
		        </a>
		        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
		          <a class="dropdown-item" href="<?= get_page_link( get_page_by_title( __('Thông tin tài khoản', 't-film') ) )?>"><?= __('Thông tin tài khoản', 't-film') ?></a>
		          <a class="dropdown-item" href="<?= wp_logout_url()?>"><?= __('Đăng xuất', 't-film') ?></a>
		        </div>
		      </li>
		  	  <?php else: ?>
		  	  	<li class="nav-item">
			        <a class="nav-link" href="<?= wp_login_url()?>"><?= __('Đăng nhập', 't-film') ?></a>
			      </li>
			    <li class="nav-item">
			        <a class="nav-link" href="<?= wp_registration_url()?>"><?= __('Đăng ký', 't-film') ?></a>
			      </li>
		  	  <?php endif; ?>
		    </ul>
		  </div>

		</nav>
	</header>

	<div id="primary" class="container-fluid">
		<div class="row">

			<?php

				if(isset($_GET['message'])):

					$messages = get_option( 't-film-plugin')['alert-messages'];

					$message = $messages[$_GET['message'] - 1];
			?>
				<script>alert("<?= $message?>");</script>
			<?php endif; ?>

			<?php get_template_part( 'template-parts/navbar', 'film' )?>