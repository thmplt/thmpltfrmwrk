<?php 
/** 
 * author.php 
 * Default template to load the author information
 */		
get_header(); ?>

<div id="content" class="narrowcolumn">

<!-- This sets the $curauth variable -->

    <?php
	// the current author
    $curauth = ( isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata( intval($author) );

	echo "<div "; thmplt_main_section_class( array('main_section') );  echo "> \n";

    ?>

	<article  id='post-<?php the_ID(); ?>' <?php post_class(); ?>  >

        <h1 class='topheader'>About: <?php echo $curauth->display_name; ?></h1>
        
        <dl class='author_info'>
        	<?php if ( $curauth->user_url ) { ?>
            <dt class='author_website_label'>Website</dt>
            <dd class='author_website'><a href="<?php echo $curauth->user_url; ?>"><?php echo $curauth->user_url; ?></a></dd>
            <?php } ?> 
        	<?php if ( $curauth->user_description ) { ?>            
            <dt class='author_bio_label'>Bio</dt>
            <dd class='author_bio'><?php echo $curauth->user_description; ?></dd>
            <?php } ?>             
        </dl>

	</article>

    <h2>Posts by <?php echo $curauth->display_name; ?>:</h2>

	<?php
        // Check if post/s exist
        if (have_posts()) : 
        
            // Start the loop.		 		
            while ( have_posts() ) : the_post(); ?>
    
    
                <article  id='post-<?php the_ID(); ?>' <?php post_class(); ?>  >    
                
					<?php                
                        // If the post has a "featured image" AKA post thumbnail then show it
                        if ( has_post_thumbnail() ) {
                            echo "<div class='post_image'>";
                            echo "<a href='". get_permalink() ."' >";
                            echo get_the_post_thumbnail($post->ID, 'thumbnail');
                            echo "</a></div>";
                        }                 	
                    ?>
                    
	                <a href="<?php the_permalink(); ?>" rel="bookmark">
	                    <?php the_title("<h2 class='topheader resultheader'>","</h2>"); ?>
                    </a>

                    <?php the_excerpt(); ?>
                    
                    <ul class="result_data" >
                        <li class="date">
	                        <strong>Posted on:</strong> <?php the_time('M j Y'); ?>
                        </li>
                        <li class="author">
                        	<strong>By:</strong> <?php the_author_posts_link() ?>
                        </li>
                        <?php if ( comments_open() ) { ?>
                       	<li class="comments-link">
	                        <?php comments_popup_link( '<span class="leave-reply">' . "Leave a reponse" . '</span>', "one reponse", "View all % reponses" ); ?>
                        </li>
                        <?php } ?>
					</ul>                    
                    
                </article>
                
               <hr class='spacer' /> 
    
    <?php 
            endwhile;  
            
            thmplt_content_pagination();
            
        endif;  
		
	echo "</div>";		
		
	?>
<?php get_sidebar(); ?>
<?php get_footer(); ?>