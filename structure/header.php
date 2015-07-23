<?php
/**
 * Header Template file 
 */
 ?><header class='wrapper'><div class='container'><div class='content'>


	<div class='row'>
    	<div class='col-md-6'>

            <div id='logo'>
            	<?php 
					if ( thmplt_logo_url() ) { 
						echo "<a href='".get_bloginfo('url')."'>";
						echo "<img class='logoimg' src='".thmplt_logo_url()."' />";
						echo "</a>";
					} else { 
				?>
            
                <h1>
                    <a href="<?php bloginfo('url'); ?>">                    
	                    <?php bloginfo( 'name' ); ?>
                    </a>                    
                </h1>

                <h2 class='subtitle'>
                    <?php bloginfo('description'); ?>
                </h2>
                
               <?php } ?> 
            </div>

            
		</div>
        <div class='col-md-6'>

            <nav id="mainmenu" class='navbar navbar-defaultx'>
            	<div class='navbar-header'>
                    <button id='menutoggle' type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>                 
                </div>           
                <?php
                    wp_nav_menu( array(
                        'menu'              => 'mainmenu',
                        'theme_location'    => 'mainmenu',
                        'depth'             => 2,
                        'container'         => 'div',
                        'container_class'   => 'collapse navbar-collapse navbar-right-custom',
                        'container_id'      => 'navbarCollapse',
                        'menu_class'        => 'nav navbar-nav',
                        'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                        'walker'            => new wp_bootstrap_navwalker())
                    );
                ?>
            </nav>
        
        </div>
        
	</div>

</div></div></header>

<?php if (is_front_page()) { ?>

	<?php 
    
        /**
         * Show the carousel if the slides are set up 
         */
        thmplt_do_carousel_slides('thmplt_front_page_carousel');
    ?>

<?php } ?>