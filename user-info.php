<?php 

/*
Template Name: User Info
*/
get_header();

?>

	<div class="col-md-8 col-12" id="main">
		<div class="row my-4">
			<div class="col p-3 mx-md-3 bg-film border">
				
				<?php

					if(is_user_logged_in())
					{
						$user = get_currentuserinfo();
						if(isset($_POST['btnSaveProfile']))
							do_action( 't-film-plugin-save-user-profile');
						echo get_avatar( $user->data->user_email );
				?>

					<form method="post">
					  <div class="form-group row">
					    <label for="staticEmail" class="col-sm-3 col-form-label"><?= __('Địa chỉ Email: ', 't-film')?></label>
					    <div class="col-sm-9">
					      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="<?= $user->data->user_email?>">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="staticLoginName" class="col-sm-3 col-form-label"><?= __('Tên đăng nhập: ', 't-film')?></label>
					    <div class="col-sm-9">
					      <input type="text" readonly class="form-control-plaintext" id="staticLoginName" value="<?= $user->data->user_login?>">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputDisplayName" class="col-sm-3 col-form-label"><?= __('Tên hiển thị: ', 't-film')?></label>
					    <div class="col-sm-9">
					      <input type="text" name="display_name" class="form-control" id="inputDisplayName" placeholder="Nhập tên hiển thị" value="<?= $user->data->display_name ?>">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-3 col-form-label"><?= __('Mật khẩu cũ: ', 't-film')?></label>
					    <div class="col-sm-9">
					      <input type="password" name="old_password" class="form-control" id="inputPassword" placeholder="<?= __('Nhập mật khẩu', 't-film')?>">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-3 col-form-label"><?= __('Mật khẩu mới: ', 't-film')?></label>
					    <div class="col-sm-9">
					      <input type="password" name="password" class="form-control" id="inputPassword" placeholder="<?= __('Nhập mật khẩu', 't-film')?>">
					    </div>
					  </div>
					  <div class="form-group row">
					    <label for="inputPassword" class="col-sm-3 col-form-label"><?= __('Nhập lại mật khẩu mới: ', 't-film')?></label>
					    <div class="col-sm-9">
					      <input type="password" name="re_password" class="form-control" id="inputPassword" placeholder="<?= __('Nhập mật khẩu', 't-film')?>">
					    </div>
					  </div>
					  <button type="submit" class="btn btn-outline-primary" name="btnSaveProfile">Đổi thông tin</button>
					</form>

				<?php
					}
					else
					{
						_e('Bạn chưa đăng nhập', 't-film');
					}

				?>

			</div>
		</div>
	</div>

<?php get_sidebar(); get_footer();?>