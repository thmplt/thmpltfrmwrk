	<?php do_action('thmplt_main_section_end'); ?>

    </div></div></div>
    <!-- End main content -->
	<?php do_action('thmplt_after_main_section'); ?>    

	<?php 
    /**
     * load extra footer.php code/html here 
     */
    locate_template('/structure/footer.php', true); 
    
    ?>
	<?php do_action('thmplt_after_main_footer'); ?>   

	<?php wp_footer(); ?>

</div>
<!-- ./ pagewrapper --> 

</body>
<?php do_action('thmplt_after_body_tag'); ?>
</html>
<?php do_action('thmplt_after_html_tag'); ?>
<!-- Developed with thmpltfrmwrk <?php echo THMPLT_VERSION; ?> --> 