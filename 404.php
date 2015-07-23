<?php 
/** 
 * 404.php 
 * Default template for 404 errors
 */		
get_header(); ?>
    
	<?php
        
			echo "<section "; thmplt_main_section_class( array('main_section') );  echo "> \n";

	?>        
    
                <article  id='post-<?php the_ID(); ?>' <?php post_class(); ?>  >    
                
					<h1 class='topheader'>404 Not Found!</h1>
                    
                    <p>What you were looking for is not here. Please go back and try again</p>
                    
                    
                </article>
    
    <?php 
			echo "</section>";
            
	?>
        
    
<?php get_footer(); ?>
<!-- 404 -->