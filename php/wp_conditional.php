<?php
/**
 * Wp Conditional shortcodes 
 */
 

add_shortcode('show_on_page', 'thmplt_is_page');
add_shortcode('thmplt_show_on_page', 'thmplt_is_page');
add_shortcode('thmplt_is_page', 'thmplt_is_page');


/**
 * Checks if it's a page, page ID or not on a page 
 */
function thmplt_is_page($atts, $content = NULL ){

	global $post;
	
    $a = shortcode_atts( array(
		'is' => '',
		'ifis' => '',
        'pids' => '',
		'not' => '',
		'ifnot' => ''		 
    ), $atts );	

	
	$pids = !empty($a['pids']) ? $a['pids']: "" ;
	$pids = !empty($a['is']) ? $a['is']: $pids ;
	$pids = !empty($a['ifis']) ? $a['ifis']: $pids ;	
	$pids = !empty($pids) ? explode(",", $pids): "";

	$nids = !empty($a['not']) ? $a['not']: "" ;
	$nids = !empty($a['ifnot']) ? $a['ifnot']: $nids ;
	$nids = !empty($nids) ? explode(",", $nids): "";	

	$pids = thmplt_convert_numeric($pids);
	$nids = thmplt_convert_numeric($nids);	
	
	$showonpage = false;	

	$ifis = is_page($pids)? true : ( is_single($pids) ? true : false );
	$ifnot = is_page($nids)? true : ( is_single($nids) ? true : false );


	if ( is_array($pids) && $ifis ){
		$showonpage = true;
	} elseif ( is_array($nids) && !$ifnot ){
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