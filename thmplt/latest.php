<?php
/**
 * Latest post type functions
 */
 
 
/**
 * Grab the lastet post types and build HTML around it 
 */
function thmplt_latest_post_type($atts){

	extract( shortcode_atts( array(
		'post_type' => 'post', // 
		'posts_per_page' => '3', //
		'post_status' => 'publish',
		'cat' => '',
		'cat_name' => '',
		'id' => '',
		'class' => 'row',		
		'item_class' => 'col-md-4 col-sm-12 col-xs-12',	//
		'date_format' => 'M d, Y',
		'thumbnail' => 'thumbnail',
		'more' => "... read more",
		'more_class' => '',
		'words' => 55,
		'tax' => '',
		'field' => 'slug',
		'term' => '',
		'operator' => 'IN',
		'seperate' => '0',
		'sep_class' => 'spacer visible-md visible-lg '
		//'excerpt' => ''
	), $atts ) );


	$args = array ( 
		"post_type" => explode( ",", $post_type ),
		"posts_per_page" => $posts_per_page,
		"post_status" => explode( ",",$post_status),
		"cat" => $cat,
		"category_name" => $cat_name
	);	

	// Add support for custom taxonomies 
	if(!empty($tax)){
		
		$args['tax_query'] = array(
			array( 
				"taxonomy"	=> $tax,
				"field"		=> $field,
				"terms"		=> explode( ",",$term),
				"operator" => $operator
		));
	}
	//echo "<pre>";var_dump($args);echo"</pre>";
	
	$the_query = new WP_Query( $args );


	// If we have posts start the build of the HTML
	if ( $the_query->have_posts() ) :
		
	
		$html = "<div ";
		$html .= !empty($id) ? " id='". $id ."' " : NULL;
		$html .= " class='tpf-latest-post ".$class."' >";	
		
		// loop through the items 
		while ( $the_query->have_posts() ) : $the_query->the_post();
		
			$sep_count++;
		
			$authorlink = sprintf(
				'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
				esc_url( get_author_posts_url( $authordata->ID, $authordata->user_nicename ) ),
				esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
				get_the_author()
			);		
			
			$html .= "<div class='tpf-latest-post-item ".$item_class."' >";
			
				$html .= "<h3 class='title'>";
				$html .= "<a href='". get_permalink() ."' >" . get_the_title() ."</a>"; 
				$html .= "</h3>";

				if ( has_post_thumbnail() && $thumbnail != "none" ) { 
					$html .= "<div class='post_image'>";
					$html .= "<a href='". get_permalink() ."' >";
					$html .= get_the_post_thumbnail ( $post->ID ,$thumbnail);
					$html .= "</a></div>";					
				}
			
			
				$eargs = array ( 'more' => $more, 'moreclass' => $more_class, "words" => $words );
				$html .= tpf_excerpt( $eargs);
				
				$html .= "
				<ul class='result_data' >
					<li class='date'>
						<strong>Posted on </strong>". get_the_date($date_format) ."
					</li>
					<li class='author'>
						<strong>By:</strong> " . $authorlink . "
					</li>
				</ul>"; 				
			
			$html .= "</div>";
			
			if ($sep_count % $seperate == 0 && $seperate != 0 ) { $html .= "<hr class='".$sep_class."' />"; }	
		
		endwhile;
		
		$html .= "</div>";
	
		
	
	
		return  $html ;
		
	endif;

}
add_shortcode('tpf_latest','thmplt_latest_post_type');
 
  
 
/**
 * Support for cutom escrpts 
 */
function tpf_excerpt ($args = NULL){
	global $post;

	if (is_array($args)){
		$attr = $args;
	}else{
		parse_str($args, $attr); //parses the query($arg) into an array 
	}

	$default_args = array (
		"words" => 55,
		"more" => "... read more",
		"moreclass" => '',
		"echo" => false,
		"link_all" => false,
		"length" => 0
	);

	$args = array_merge($default_args, $attr);

	
	if 	(!empty($attr['ID'])) { $post = get_post($attr['ID']); } // if an ID is passed, then use that post's excerpt 

	// if there is an exerpt from the editor then output this
	if(!empty($post->post_excerpt)){
		
		$excerpt = $post->post_excerpt;
	} else{
		
		// Proccess the shortcode before stripping out the tags
		$content = strip_tags(  do_shortcode( $post->post_content) ); 
		
		// Strip out the tags to the default amount of words
		preg_match('/^\s*+(?:\S++\s*+){1,' . $args['words'] . '}/', $content, $matches);
		$excerpt = $matches[0];
	} 


	$words_count = str_word_count($post->post_content);
	if ( $words_count <= $args['words'] ) { $args['more'] = false; } 


	// If length is set then cut the excerpt to that amount of characters
	if ( $args['length'] ) { $excerpt = substr($excerpt,0,$length); }
	
	$excerpt = "<span class='tpf-excerpt'>".$excerpt."</span>";
	
	if ($args['link_all'] === true) {
		$excerpt = 	'<a href="'. get_permalink($post->ID) . '">' . $excerpt;	

		if ( $args['more'] ) {
			$excerpt .=  ' <span class="more '.$args['moreclass'].'">' . $args['more'] . '</span>'; 
		}
		$excerpt .= "</a>";	
		
	} else {
		
		if ( $args['more']  ) {
			$excerpt .=  '<a href="'. get_permalink($post->ID) . '" class="more '.$args['moreclass'].'">' . $args['more'] . '</a>'; 
		}
	}
	
	if ($args['echo']){
		echo $excerpt;		
	}else{
		return $excerpt;
	}	
}//END FUNCTION 












	$html = "<ul class='tpf-clone-list ".$class."'" ; // opening of the UL 
	if (!empty($clone)){
		$html .= " data-clone='". $clone ."'";
	}
	if (!empty($contains)){
		$html .= " data-li-contains='". $contains ."'";
	}	
	if (!empty($target)){
		$html .= " data-target='". $target ."'";
	}	
	$html .= "><!-- Auto Generated --></ul>"; // Close the UL


