<div id="comments">
	<nav>
	  <div class="nav nav-tabs" id="nav-tab" role="tablist">
	  	<a class="nav-item nav-link active" id="nav-fb-comment-tab" data-toggle="tab" href="#nav-fb-comment" role="tab" aria-controls="nav-fb-comment" aria-selected="false"><?= __('Facebook', 't-film') ?></a>
	    <a class="nav-item nav-link" id="nav-comments-tab" data-toggle="tab" href="#nav-comments" role="tab" aria-controls="nav-home" aria-selected="true"><?= get_bloginfo('name') ?></a>
	  </div>
	</nav>

	<div class="tab-content p-2" id="nav-tabContent">

      <div class="tab-pane fade show active" id="nav-fb-comment" role="tabpanel" aria-labelledby="nav-fb-comment-tab">
	  	<?php echo do_shortcode('[vivafbcomment]'); ?>
	  </div>

	  <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-home-tab">
	  	
	  	<?php
		if  ( have_comments() ) :
			?>
			<h5 class="comments-title border-bottom pb-2">
				<?php
				$comment_count = get_comments_number();
				printf(
					esc_html__( '%s Bình luận trên bài "%s"', 't-film' ),
					$comment_count,
					'<span>' . get_the_title() . '</span>'
				);
				?>
			</h5>

			<?php t_film_comment_navigation() ?>

			<div class="comment-list">
				<?php
					$comments = get_comments();
					foreach($comments as $comment):
				?>
						<div <?php comment_class('row p-1 m-2'); ?> id="comment-<?= $comment->comment_ID ?>" >
							<div class="p-2 <?= $comment->comment_parent == '0' ? 'col-md-3 col-12' : 'col-md-3 offset-md-1 col-11 offsett-1'?> text-center">
								<img src="<?= get_avatar_url($comment->comment_author_email);?>" >
								<div class="comment-info">
									<div class="comment-author"><?= $comment->comment_author ?></div>
									<span class="badge badge-pill badge-secondary">
										<?php
											echo t_film_get_icon('clock');
											echo $comment->comment_date;
										?>
									</span>
								</div>
							</div>
							<div class="p-2 <?= $comment->comment_parent == '0' ? 'col-md-9 col-12' : 'col-md-8 col-11 offset-1'?>">
								<?= $comment->comment_content ?>
								<div class="my-1">
									<?php if(is_user_logged_in()): ?>
									<span class="badge badge-pill badge-success">
										
										<a href="<?= get_edit_comment_link($comment)?>"><?= t_film_get_icon('pencil'). __('Chỉnh sửa', 't-film') ?></a>
									</span>
									<?php endif; ?>
									<?php 

										comment_reply_link( [

											'reply_text' => __('Trả lời', 't-film'),
											'depth' => 1,
											'max_depth' => 2,
											'before' => '<span class="badge badge-pill badge-info">'.t_film_get_icon('chat'),
											'after' => '</span>'

										], $comment );

									?>
								</div>
							</div>
							<div class="border-bottom <?= $comment->comment_parent == '0' ? 'col-12' : 'col-11 offset-1 border-left'?>"></div>
						</div>
				<?php
					endforeach;
				?>
			</div>

			<?php
			t_film_comment_navigation();

			// If comments are closed and there are comments, let's leave a little note, shall we?
			if ( ! comments_open() ) :
				?>
				<h5 class="no-comments text-center"><span class="badge badge-pill badge-primary"><?php esc_html_e( 'Bài viết này đã đóng bình luận', 't-film' ); ?></span></h5>
				<?php
			endif;

		endif;
		comment_form([

			'title_reply' => __('Bình luận', 't-film'),
			'title_reply_to' => __('Bình luận đến %s', 't-film'),
			'title_reply_before' => '<h5 class="reply-title">',
			'title_reply_after' => '</h5>',
			'cancel_reply_link' => __('Huỷ bình luận', 't-film'),
			'label_submit' => __('Đăng bình luận', 't-film'),
			'comment_field' =>  '<div class="form-group row"><label for="comment" class="col-sm-3 col-md-2 col-form-label">Nội dung * </label><div class="col-sm"><textarea id="comment" class="form-control" name="comment" rows="5" aria-required="true" placeholder="'. __('Nhập nội dung', 't-film'). '" required>' .
				'</textarea></div></div>',
			'must_log_in' => '<p class="must-log-in">' .
			    sprintf(
			      __( 'Bạn phải <a href="%s">đăng nhập</a> để bình luận.', 't-film' ),
			      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
			    ) . '</p>',
			'logged_in_as' => '<p class="logged-in-as">' .
			    sprintf(
			    __( '<span class="badge badge-pill badge-warning"><a href="%1$s">%2$s</a></span> <span class="badge badge-pill badge-dark"><a href="%3$s" title="Log out of this account">Đăng xuất?</a></span>', 't-film' ),
			      admin_url( 'profile.php' ),
			      $user_identity,
			      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
			    ) . '</p>',
			'class_submit' => 'btn btn-sm btn-success',
			'comment_notes_before' => '<p><small class="comment-notes">' . __( 'Địa chỉ email sẽ không hiển thị. Những ô có (*) là bắt buộc.', 't-film' ). '</small></p>',
			'fields' => [

				'author' =>
				    '<div class="form-group row comment-form-author"><label class="col-sm-3 col-md-2 col-form-label" for="author">' . __( 'Họ tên ', 't-film' ) .
				    ( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
				    '<div class="col-sm"><input id="author" name="author" class="form-control" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
				    '" size="30"' . $aria_req . ' required placeholder="'. __('Nhập họ tên', 't-film'). '" /></div></div>',

				  'email' =>
				    '<div class="form-group row comment-form-email"><label class="col-sm-3 col-md-2 col-form-label" for="email">' . __( 'Email ', 't-film' ) .
				    ( $req ? '<span class="required">*</span>' : '' ) . '</label>' .
				    '<div class="col-sm"><input id="email" class="form-control" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
				    '" size="30"' . $aria_req . ' required placeholder="'. __('Nhập email', 't-film'). '" /></div></div>',

				  'url' =>
				    '<div class="form-group row comment-form-url"><label class="col-sm-3 col-form-label" for="url">' . __( 'Website: ', 't-film' ) . '</label>' .
				    '<div class="col-sm"><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
				    '" size="30" class="form-control" placeholder="'. __('Nhập website', 't-film'). '" /></div></div>',

			]

		]);
		?>

	  </div>
	</div>

</div>