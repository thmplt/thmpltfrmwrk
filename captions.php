<?php
/**
 * Captions with extra functionality BOOM!
 * Since Version 
 */
 
 
 
 /**
 * Grab the lastet post types and build HTML around it 
 */
function thmplt_caption($atts, $content){

	extract( shortcode_atts( array(
		'id' => '', // 
		'class' => '',
		'imgclass' => '',
		'src' => '',
		'hvr' => '',
		'href' => '',
		'title' => '',
	), $atts ) );
	
	$html = "<div ";
	$html .= (!empty($id)) ? "id='".$id."' ": "";
	$html .= " class='tpf-caption ".$class."' >";
	$html .= (!empty($href)) ? "<a href='".$href."' >": "";
	$datahvr = (!empty($hvr)) ? "data-hvr='".$hrv."'":"";
	$html .= (!empty($src)) ? "<div class='tpf-caption-img'><img src='".$src."' alt='".$title."' class='img-responsive ".$imgclass."' ".$datahvr." /></div>": "";
	$html .= "<div class='tpf-caption-content'>";
	$html .= "<strong class='tpf-caption-title'>".$title."</strong>";
	$html .= (!empty($content)) ? "<div class='tpf-caption-text'>".$content."</div>": "";
	$html .= "</div>";
	$html .= (!empty($href)) ? "</a>": "";
	$html .= "</div>";
	
	return $html;
	
} #thmplt_caption
add_shortcode('thmplt_caption', 'thmplt_caption');