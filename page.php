<?php 
/** 
 * page.php 
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
                    <?php the_content(); ?>
                    
                </article>
    
    <?php 
            endwhile;  
            
			echo "</div>";
            
        endif;  
	?>
        
<?php get_sidebar(); ?>       
<?php get_footer(); ?>
<!-- Page -->
