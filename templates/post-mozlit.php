<?php
/*
 * Template Name: CKEditor Template
 * Template to replace <textarea class="ckeditor"></textarea> with the ckeditor
 */


get_header(); ?>
<!-- post-mozweblit.php -->
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<?php if ( has_post_thumbnail() && ! post_password_required() ) : ?>
						<div class="entry-thumbnail">
							<?php the_post_thumbnail(); ?>
						</div>
						<?php endif; ?>

						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->

					<div class="entry-content">
						<?php the_content(); ?>
                        <div css="clearfix"></div>
                        <div id="input">
                            <p>
                                <textarea class="ckeditor"></textarea>
                            </p>
                            <p>
                                <input onclick="GetContents();" type="button" value="Get Editor Contents (XHTML)">
                            </p>
                        </div>
                        <div id="output">
                        	<iframe id="displayoutput" allowtransparency="true" width="100%" height="300px"></iframe>
                        </div>
						<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentythirteen' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
					</div><!-- .entry-content -->

					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'twentythirteen' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-meta -->
				</article><!-- #post -->

				<?php comments_template(); ?>
			<?php endwhile; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<!-- ckeditor scripts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- shouldn't need this one - already loaded
<script src="http://localhost/hugolibre/wp-content/plugins/ckeditor-for-wordpress/ckeditor/ckeditor.js"></script> -->
<?php
 echo('<script src="'. get_bloginfo('url') .'/wp-content/plugins/ckeditor-for-wordpress/ckeditor/adapters/jquery.js"></script>' . PHP_EOL);
 echo('<script src="'. get_bloginfo('stylesheet_directory') .'js/verbs.js"></script>' . PHP_EOL);

?>
<script>
<?php
global $current_user;
get_currentuserinfo();
echo 'var username = "' . $current_user->display_name . '" || "Guest";' . PHP_EOL;
echo 'var email = "' . $current_user->user_email . '" || "hugolibre@example.com";' . PHP_EOL;

echo 'var ajaxurl = "' . XAPIMOZWEBLIT_AJAX . 'ajaxhandler.php";' . PHP_EOL;
?>
</script>

<script src="<?php echo XAPIMOZWEBLIT_JS; ?>xapimozweblit.js"></script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>