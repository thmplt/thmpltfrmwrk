<?php 
/** 
 * Template Name: Homepage Variation
 * page template with no sidebar
 */		
 
global $thmplt;

$thmplt['nosidebar'] = true; 
 
get_header(); ?>
<style>
#main {padding: 0 !important;}
#main .container {padding: 0 !important; width: 100%; max-width: none;}
#main #breadcrumbs, #inside-banner {display: none;}
.caption-left .caption-wrapper .caption-box {text-align: center !important;}
</style>
	<?php
        // Check if post/s exist
        if (have_posts()) : 
        
			echo "<div "; thmplt_main_section_class( array('main_section') );  echo "> \n";
        
            // Start the loop.		 		
            while ( have_posts() ) : the_post(); ?>
    
    
                <article  id='post-<?php the_ID(); ?>' <?php post_class(); ?>  >    
                
                    <?php //the_title("<h1 class='topheader'>","</h1>"); ?>
                    <?php the_content(); ?>
                    
                </article>
    
    <?php 
            endwhile;  
            
			echo "</div>";
            
        endif;  
	?>
    
     
<?php get_footer(); ?>
<!-- Page -->
