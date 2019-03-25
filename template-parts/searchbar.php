<form class="form-horizontal mx-md-2" action="<?php bloginfo('url')?>" id="search-form">
    <div class="input-group">
      <input type="text" class="form-control" name="s" placeholder="Bạn cần tìm gì?" id="search-input" value="<?= $_GET['s'] ?>" size="50">
      <div class="input-group-append" id="searchButton">
	    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#section-search-filter" aria-haspopup="true" aria-expanded="false"><?= __('Lọc', 't-film') ?></button>
	    <button class="btn btn-success" type="submit" aria-haspopup="true" aria-expanded="false"><?= __('Tìm', 't-film')?></button>
	  </div>
    </div>
    <div id="section-search-filter" class="collapse border rounded p-2 scroll-y" style="max-height:300px">

		<fieldset class="border px-2 filter-film" id="filter-series-film">
		    <legend class="w-auto"><?= __('Hình thức', 't-film') ?></legend>
		    <label for="rFilmSeries"><?= __('Tất cả', 't-film') ?></label>
		    <input type="radio" id="rFilmSeries" name="film_series" value="" checked>
		    <label for="rFilmSeries1"><?= __('Phim lẻ', 't-film') ?></label>
		    <input type="radio" id="rFilmSeries1" name="film_series" value="0" <?= isset($_GET['film_series']) && $_GET['film_series'] === '0' ? 'checked' : '' ?> >
		    <label for="rFilmSeries2"><?= __('Phim bộ', 't-film') ?></label>
		    <input type="radio" id="rFilmSeries2" name="film_series" value="1" <?= isset($_GET['film_series']) && $_GET['film_series'] === '1' ? 'checked' : '' ?> >
		</fieldset>

		<fieldset class="border px-2 filter-film" id="filter-genre">
		    <legend class="w-auto"><?= __('Thể loại', 't-film') ?></legend>
		    <?php

			    $film_genre_list = get_terms([
			  		'taxonomy' => 'film_genre',
			  		'hide_empty' => 0
			  	]);

			  	foreach($film_genre_list as $genre)
			  	{
			  		printf('<label for="cb%2$d">%1$s</label>
			  			<input type="checkbox" id="cb%2$d" name="film_genre[]" value="%2$d" %3$s>',
			  			$genre->name, $genre->term_id, isset($_GET['film_genre']) && in_array($genre->term_id, $_GET['film_genre']) ? 'checked' : ''
			  		);
			  	}
			?>

		</fieldset>

		<fieldset class="border px-2 filter-film" id="filter-country">
		    <legend class="w-auto"><?= __('Quốc gia', 't-film') ?></legend>
		    <?php

			    $film_genre_list = get_terms([
			  		'taxonomy' => 'film_country',
			  		'hide_empty' => 0
			  	]);

			  	foreach($film_genre_list as $genre)
			  	{
			  		printf('<label for="ct%2$d">%1$s</label>
			  			<input type="checkbox" id="ct%2$d" name="film_country[]" value="%2$d" %3$s>',
			  			$genre->name, $genre->term_id, isset($_GET['film_country']) && in_array($genre->term_id, $_GET['film_country']) ? 'checked' : ''
			  		);
			  	}
			?>

		</fieldset>

		<fieldset class="border px-2 filter-film" id="filter-orderby">
		    <legend class="w-auto"><?= __('Sắp xếp', 't-film') ?></legend>
		    <label for="orderby"><?= __('Ngẫu nhiên', 't-film') ?></label>
		    <input type="radio" id="orderby" name="orderby" value="" checked>
		    <label for="orderTitle"><?= __('Tên phim', 't-film') ?></label>
		    <input type="radio" id="orderTitle" name="orderby" value="title" <?= isset($_GET['orderby']) && $_GET['orderby'] == 'title'  ? 'checked' : '' ?> >
		    <label for="orderDate"><?= __('Ngày cập nhật', 't-film') ?></label>
		    <input type="radio" id="orderDate" name="orderby" value="date" <?= isset($_GET['orderby']) && $_GET['orderby'] == 'date'  ? 'checked' : '' ?> >
		    <label for="orderView"><?= __('Lượt xem', 't-film') ?></label>
		    <input type="radio" id="orderView" name="orderby" value="film_view_count" <?= isset($_GET['orderby']) && $_GET['orderby'] == 'film_view_count'  ? 'checked' : '' ?> >

		</fieldset>

		<fieldset class="border px-2 filter-film" id="filter-order">
		    <legend class="w-auto"><?= __('Thứ tự', 't-film') ?></legend>
		    <label for="order"><?= __('Tăng dần', 't-film') ?></label>
		    <input type="radio" id="order" name="order" value="" checked>
		    <label for="orderdesc"><?= __('Giảm dần', 't-film') ?></label>
		    <input type="radio" id="orderdesc" name="order" value="DESC" <?= isset($_GET['order']) && $_GET['order'] == 'DESC'  ? 'checked' : '' ?> >

		</fieldset>

		<fieldset class="border px-2 filter-film" id="filter-year">
		    <legend class="w-auto"><?= __('Năm', 't-film') ?></legend>
		    <label for="ry"><?= __('Tất cả', 't-film') ?></label>
		    <input type="radio" id="ry" name="film_year" value="" checked>
		    <?php

		    	for($i = 2016; $i<= date('Y'); $i++)
			  	{
			  		printf('<label for="ry%1$d">%1$s</label>
			  			<input type="radio" id="ry%1$d" name="film_year" value="%1$d" %2$s>', $i, isset($_GET['film_year']) && $_GET['film_year'] == $i ? 'checked' : ''
			  		);
			  	}

		    ?>
		</fieldset>

		<fieldset class="border px-2" id="filter-post-type">
		    <legend class="w-auto"><?= __('Chỉ tìm tin tức', 't-film') ?></legend>
		    <label for="rpt1"><?= __('Không', 't-film') ?></label>
		    <input type="radio" id="rpt1" name="post_type" value="film" checked="">
		    <label for="rpt2"><?= __('Có', 't-film') ?></label>
		    <input type="radio" id="rpt2" name="post_type" value="post"  <?= isset($_GET['post_type']) && $_GET['post_type'] == 'post'  ? 'checked' : '' ?>>
		</fieldset>
    </div>
  </form>