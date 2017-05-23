<?php
/*
*   View: My Profile All
*/

$user_ = get_currentuserinfo();
?>

<div id="my-profile" class="dinamyc-section">
	<div id="menu" class="menu">
		<button id="general-controller" class="controller active"><i class="fa fa-cogs icon" aria-hidden="true"></i>General</button>
		<button id="contents-controller" class="controller"><i class="fa fa-coffee icon" aria-hidden="true"></i>Contents</button>
		<button id="plans-controller" class="controller"><i class="fa fa-cutlery icon" aria-hidden="true"></i>Plans</button>
		<button id="logout-controller" class="controller"><i class="fa fa-close icon" aria-hidden="true"></i>Logout</button>
	</div>
	<div id="tabs" class="tabs">
		<div id="general" class="tab active">
			<h1 class="tab-header">General</h1>
			<div id="form">
				<label for="user-id">Username</label>
				<input id="user-id" type="text" readonly="readonly" value="<?php echo $user_->user_login; ?>">
				<label for="user-email">Email</label>
				<input id="user-email" type="email" value="<?php echo $user_->user_email; ?>">
				<label for="user-password">Password</label>
				<input id="user-password" type="password">
				<button id="update-general-info" class="button simple-button animated inifite">Update</button>
			</div>
		</div>
		<div id="contents" class="tab">
			<h1 class="tab-header">Contents</h1>
			<div id="contents-controls" class="tab-controls">
				<button id="add-contents-controller" class="button simple-button">Add new</button>
			</div>
			<div id="add-contents-container">
				<div id="form" content-id="0">
					<label for="post-title">Post title</label>
					<input id="post-title" type="text">
					<label for="link-to-featuredimage">Link to Featured image</label>
					<input id="link-to-featuredimage" type="url">
					<label for="link-to-content">Link to the Content</label>
					<input id="link-to-content" type="url">
					<button id="upload-content" class="button simple-button animated inifite">Upload</button>
				</div>
			</div>
			<div id="contents-available">
				<table class="table-layout">
					<tr>
						<th>Actions</th>
						<th>Status</th>
						<th>Title</th>
						<th>Featured Image</th>
						<th>Content</th>
						<th>Active promotion</th>
					</tr>
					<?php
					$args = array(
						"posts_per_page" => -1,
						"post_type" => "promotions",
						"post_status" => "any",
						"author" => $user_->data->ID,
						"orderby" => "ID",
						"order" => "DESC"
					);
					$promotions_ = get_posts( $args );

					foreach ( $promotions_ as $promotion_ ) {
						$promotion_featured_image = get_post_meta( $promotion_->ID, "featured_image_link", true );
						$promotion_content = get_post_meta( $promotion_->ID, "content_link", true );
						?>

						<tr id="content-<?php echo $promotion_->ID; ?>">
							<td>
								<button id="edit-controller" class="table-controller fa fa-pencil" title="Edit content" content-id="<?php echo $promotion_->ID; ?>"></button>
							</td>
							<td id="status"><?php echo $promotion_->post_status; ?></td>
							<td id="title"><?php echo $promotion_->post_title; ?></td>
							<td id="featured-image"><a href="<?php echo $promotion_featured_image; ?>" target="_blank"><?php echo $promotion_featured_image; ?></a></td>
							<td id="content"><a href="<?php echo $promotion_content; ?>" target="_blank"><?php echo $promotion_content; ?></a></td>
							<td></td>
						</tr>

						<?php
					}
					?>
				</table>
			</div>
		</div>
		<div id="plans" class="tab">
			<h1 class="tab-header">Plans</h1>
		</div>
	</div>
</div>
