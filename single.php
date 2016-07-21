<?php 
/** 
 * single.php 
 * Default template to load all page post types
 */		
get_header(); ?>
    
	<?php
        // Check if post/s exist
        if (have_posts()) : 
        
			echo "<div "; thmplt_main_section_class( array('main_section') );  echo "> \n";
        
            // Start the loop.		 		
            while ( have_posts() ) : the_post(); ?>
    
    
                <article  id='post-<?php the_ID(); ?>' <?php post_class(); ?>  >    
                
                    <?php the_title("<h1 class='topheader'>","</h1>"); ?>
                    
					<ul class="result_data" >
                        <li class="date">
	                        <strong>Posted on:</strong> <?php the_time('M j Y'); ?>
                        </li>
                        <li class="author">
                        	<strong>By:</strong> <?php the_author_posts_link() ?>
                        </li>
                        <?php if ( comments_open() ) { ?>
                       	<li class="comments-link">
	                        <?php comments_popup_link( '<span class="leave-reply">' . "Leave a response" . '</span>', "one response", "View all % responses" ); ?>
                        </li>
                        <?php } ?>
					</ul>                        
                    
                    <?php the_content(); ?>
					<?php 
					// The Tags and Categories for posts 
					if (has_tag()){ 
						the_tags( '<p>Tagged with: ', ', ', '</p>');
					}
					
					if (has_category()) { 
						echo  "<p>Posted in: "; the_category(', '); echo "</p>";
					}
					
					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();					
					endif;
					 ?>
                    
                </article>
    
    <?php 
            endwhile;  
            
			echo "</div>";
            
        endif;  
	?>
        
<?php get_sidebar(); ?>    
<?php get_footer(); ?>
<!-- single -->
