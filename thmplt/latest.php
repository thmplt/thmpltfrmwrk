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
		'title_class' => '',
		'date_format' => 'M d, Y',
		'thumbnail' => 'thumbnail',
		'move_thumb' => '', //before , after
		'thumb_class' => '',
		'more' => "read more",
		'more_class' => '',
		'words' => 55,
		'tax' => '',
		'field' => 'slug',
		'term' => '',
		'operator' => 'IN',
		'seperate' => '0',
		'sep_class' => 'spacer visible-md visible-lg ',
		//'result_data' => 'bottom',
		"force_more" => false,
		"elipsis" => "on",
		//'excerpt' => 'normal',
		//"title" => "first",
		"markup" => "title, data, thumbnail, excerpt",
		"carousel" => 'false',
		"indicators" => 'true',
		"controls" => 'true',
		"interval" => "5000",
		"carousel_class" => '', //carousel-fade
		"carousel_markup" => "indicators,slides,controls"
	), $atts ) );


	$args = array ( 
		"post_type" => explode( ",", $post_type ),
		"posts_per_page" => $posts_per_page,
		//'nopaging' => true,
		//'ignore_sticky_posts'=> true,
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

	//echo "<pre>";var_dump($the_query);echo"</pre>";
	$query_count = $the_query->post_count;
	
	//echo "COUNT:".$query_count;
	
	// If we have posts start the build of the HTML
	if ( $the_query->have_posts() ) :
		$sep_count = 0;
		$item_count = 0;
		$eargs = array ( 
			'more' => $more,
			'moreclass' => $more_class, 
			"words" => $words, 
			"force_more" => $force_more, 
			"elipsis" => $elipsis 
		);
	
		$id = !empty($id)?$id: "tpf-latest-auto-id-".rand(1,9999);
	
		$html ="";
		$item_class .= ($carousel == "true")? " item ":"";
		$class .= ($carousel == "true")? " carousel-inner ":"";
	
	
		if ($carousel == "true"){
			$html .= "<div id='".$id."-carousel' class='tpf-latest-carousel carousel slide ".$carousel_class."' data-ride='carousel' data-interval='".$interval."'>";	

			if ($indicators == "true") {
			  $html .= "<ol class='carousel-indicators'>";
				for ($s=0;$s<=($query_count-1);$s++){
					$liclass = ($s==0)?"active":"";
					$html .= "<li data-target='#".$id."-carousel' data-slide-to='".$s."' class='".$liclass."'></li>";
				}
			  $html .= "</ol>";
			}	
		}
	
		$html .= "<div ";
		$html .= !empty($id) ? " id='". $id ."' " : NULL;
		$html .= " class='tpf-latest-post ".$class."' >";	
		
		$markup = explode(",", $markup);
	
		// loop through the items 
		while ( $the_query->have_posts() ) : $the_query->the_post();
		
			$sep_count++;
			$car_class = ($carousel == "true" && $sep_count == 1)? " active slide-". $sep_count:" slide-".$sep_count;
	
		
			$authorlink = sprintf(
				'<a href="%1$s" title="%2$s" rel="author">%3$s</a>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) , get_the_author_meta( 'user_nicename' ) ) ),
				esc_attr( sprintf( __( 'Posts by %s' ), get_the_author() ) ),
				get_the_author()
			);	
			
	
			$html .= "<div class='tpf-latest-post-item ".$item_class.$car_class."' >";
	
	
			if ( $move_thumb == "before"){

				if ( has_post_thumbnail() && $thumbnail != "none" ) { 
					$html .= "<div class='post_image tpf-lastest-image'>";
					$html .= "<a href='". get_permalink() ."' >";
					$html .= get_the_post_thumbnail ( @$post->ID ,$thumbnail, array("class"=> $thumb_class));
					$html .= "</a></div>";					
				}				
			}
	
			$html .= "<div class='tpf-latest-markup'>";
	
				foreach ($markup as $m){
					$m = trim($m);
					
					if ($m == "title"){
						$html .= "<h3 class='title ".$title_class."'>";
						$html .= "<a href='". get_permalink() ."' >" . get_the_title() ."</a>"; 
						$html .= "</h3>";
					}
					if ($m == "data"){
						$html .= "
						<ul class='result_data tpf-latest-result-data' >
							<li class='date'>
								<strong>Posted on </strong>". get_the_date($date_format) ."
							</li>
							<li class='author'>
								<strong>By:</strong> " . $authorlink . "
							</li>
						</ul>"; 
					}					
					if ($m == "thumbnail"){
						if ( has_post_thumbnail() && $thumbnail != "none" ) { 
							$html .= "<div class='post_image tpf-lastest-image'>";
							$html .= "<a href='". get_permalink() ."' >";
							$html .= get_the_post_thumbnail ( @$post->ID ,$thumbnail, array("class"=> $thumb_class));
							$html .= "</a></div>";					
						}
					}
					
					
					if ($m == "figure"){
						
						$imgurl = get_the_post_thumbnail_url($post->ID ,$thumbnail );
						$html .= do_shortcode("[thmplt_fig_caption class='".$thumb_class."' imgsrc='".$imgurl."' href='".get_permalink($post->ID)."'  title='']".$more."[/thmplt_fig_caption]");
						
					}
					
					if ($m == "excerpt"){
						$html .= tpf_excerpt( $eargs);
					}		
					
					
					if ($m == "content"){
						$html .= tpf_excerpt( $eargs);
					}							
					
					
				}
			$html .= "</div>";	
	
			if ( $move_thumb == "after"){

				if ( has_post_thumbnail() && $thumbnail != "none" ) { 
					$html .= "<div class='post_image tpf-lastest-image'>";
					$html .= "<a href='". get_permalink() ."' >";
					$html .= get_the_post_thumbnail ( @$post->ID ,$thumbnail, array("class"=> $thumb_class));
					$html .= "</a></div>";					
				}				
			}	
	
	
			$html .= "</div>";
			
			if ($seperate != 0 ){
				if ($sep_count % $seperate == 0 ) { $html .= "<hr class='".$sep_class."' />"; }	
			}
		
		endwhile;
		
		$html .= "</div>";

		if ($carousel == "true"){
		
			if ($controls == "true"){
				$html .= "<a class='left carousel-control' href='#".$id."-carousel' data-slide='prev'>
				<span class='glyphicon glyphicon-chevron-left'></span>
				<span class='sr-only'>Previous</span>
				</a>
				<a class='right carousel-control' href='#".$id."-carousel' data-slide='next'>
				<span class='glyphicon glyphicon-chevron-right'></span>
				<span class='sr-only'>Next</span>
				</a>";			
			}
			
			$html .= "</div>";	
		}	
	
		wp_reset_postdata();
	
	
		return  $html ;
		
	endif;

}
add_shortcode('tpf_latest','thmplt_latest_post_type');
add_shortcode('thmplt_latest','thmplt_latest_post_type'); // Use the latter 
 
  
 
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
		"length" => 0,
		"force_more" => false,
		"elipsis" => "on"
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
	if ( $words_count <= $args['words']  && $args['force_more'] == false ) { $args['more'] = false; } 


	// If length is set then cut the excerpt to that amount of characters
	if ( $args['length'] ) { $excerpt = substr($excerpt,0,$length); }
	
	if ($args['elipsis'] == "on" && $words_count >= $args['words'] ) { $excerpt = $excerpt . "..."; }
	
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







