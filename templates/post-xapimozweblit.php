<?php
/*
 * Template Name: CKEditor Template
 * Template to replace <textarea class="ckeditor"></textarea> with the ckeditor
 */


get_header(); ?>
<!-- post-xapimozbadge.php -->
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
                                <input id="mozweblitsubmit" type="button" value="Get Editor Contents (XHTML)">
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

<script>
var MyAjax = MyAjax || {};
MyAjax.postID = <?php echo the_ID(); ?>;
</script>

<?php get_sidebar(); ?>
<?php get_footer(); ?>