<?php
/**
 * Wp Conditional shortcodes 
 * 
 * @version 2
 * @updated 08/09/16
 */
 

add_shortcode('show_on_page', 'thmplt_is_page');
add_shortcode('thmplt_show_on_page', 'thmplt_is_page');
add_shortcode('thmplt_is_page', 'thmplt_is_page');


/**
 * Checks if it's a page, page ID or not on a page 
 */
function thmplt_is_page($atts, $content = NULL ){

	global $post;

	$showonpage = false;	
	
    $a = shortcode_atts( array(
		'is' => '',
		'ifis' => '',
        'pids' => '',
		'not' => '',
		'ifnot' => '',
		'ifispt' => '',
		'ifnotpt' => '',
		'ifisarchive' => '',
		'ifnotarchive' => '',
    ), $atts );	

	$pt = !empty($a['ifispt']) ? $a['ifispt']: "" ;
	$pt = !empty($pt) ? explode(",", $pt): "";
		
	$npt = !empty($a['ifnotpt']) ? $a['ifnotpt']: "" ;	
	$npt = !empty($npt) ? explode(",", $npt): "";	
	
	$ifispt = (is_array($pt) &&  in_array($post->post_type, $pt )) ? true : false;
	$ifnotpt = (is_array($npt) &&  in_array($post->post_type, $npt )) ? true : false;	
	
	
	$archive = !empty($a['ifisarchive']) ? $a['ifisarchive']: "" ;
	$archive = !empty($archive) ? explode(",", $archive): "";
		
	$narchive = !empty($a['ifnotarchive']) ? $a['ifnotarchive']: "" ;	
	$narchive = !empty($narchive) ? explode(",", $narchive): "";	
	
	$ifisarchive = (is_array($archive) &&  in_array($post->post_type, $archive )) ? true : false;
	$ifnotarchive = (is_array($ifnotarchive) &&  in_array($post->post_type, $narchive )) ? true : false;		
	
	
	$pids = !empty($a['pids']) ? $a['pids']: "" ;
	$pids = !empty($a['is']) ? $a['is']: $pids ;
	$pids = !empty($a['ifis']) ? $a['ifis']: $pids ;	
	$pids = !empty($pids) ? explode(",", $pids): "";

	$nids = !empty($a['not']) ? $a['not']: "" ;
	$nids = !empty($a['ifnot']) ? $a['ifnot']: $nids ;
	$nids = !empty($nids) ? explode(",", $nids): "";	

	$pids = thmplt_convert_numeric($pids);
	$nids = thmplt_convert_numeric($nids);	
	

	$ifis = is_page($pids)? true : ( is_single($pids) ? true : false );
	$ifnot = is_page($nids)? true : ( is_single($nids) ? true : false );




	if ( is_array($pids) && $ifis ){
		$showonpage = true;
	} elseif ( is_array($nids) && !$ifnot ){
		$showonpage = true;
	}

	// Logic for post-types
	if ( is_array($pt) && $ifispt ){
		$showonpage = true;
	} elseif ( is_array($npt) && !$ifnotpt ){
		$showonpage = true;
	}


	// Logic for archives
	if ( is_array($archive) && $ifisarchive ){
		$showonpage = true;
	} elseif ( is_array($narchive) && !$ifnotarchive ){
		$showonpage = true;
	}

	
	if ( $showonpage === true ){
		return do_shortcode($content);		
	}
	
}#End function 



/**
 * Converts numeric values to intergers 
 */
function thmplt_convert_numeric($arr){
	$nummeric = array();
	
	if (!empty($arr) && !is_array( $arr ) ){ 
		$arr = array($arr);
	}
	
	if ( is_array($arr) ){ 
		foreach ($arr as $n) {
			if (is_numeric($n)) {
				$nummeric[] = (int)$n;
			} else {
				$nummeric[] = $n;
			}
		}
		return $nummeric;		
	}
	return "-";
}#End Function 