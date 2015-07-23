<?php 
global $thmplt;

if ( $thmplt['nosidebar'] != true ) { 

?><aside <?php thmplt_sidebar_class(array('main_aside')); ?> >
	<div class='aside_inner'>

	<?php 
    /**
     * load extra sidebar.php code/html here 
     */
    locate_template('/structure/sidebar.php', true); 
    
    ?>

	</div>
</aside>
<?php } ?>