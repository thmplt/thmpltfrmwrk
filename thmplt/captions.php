<?php
/**
 * Captions with extra functionality BOOM!
 * Since Version 1.6
 */
 
 
 
 /**
 * Shortcode that crates responsive captions
 */
function thmplt_caption($atts, $content){

	extract( shortcode_atts( array(
		'id' => '', // 
		'class' => '',
		'imgclass' => '',
		'imgsrc' => '',
		'hvr' => '',
		'href' => '',
		'title' => '',
	), $atts ) );
	
	$html = "<div ";
	$html .= (!empty($id)) ? "id='".$id."' ": "";
	$html .= " class='tpf-caption ".$class."' >";
	$html .= (!empty($href)) ? "<a href='".$href."' >": "";
	$datahvr = (!empty($hvr)) ? "data-hvr='".$hrv."'":"";
	$html .= (!empty($imgsrc)) ? "<div class='tpf-caption-img'><img src='".$imgsrc."' alt='".$title."' class='img-responsive ".$imgclass."' ".$datahvr." /></div>": "";
	$html .= "<div class='tpf-caption-content'>";
	$html .= "<strong class='tpf-caption-title'>".$title."</strong>";
	$html .= (!empty($content)) ? "<div class='tpf-caption-text'>".$content."</div>": "";
	$html .= "</div>";
	$html .= (!empty($href)) ? "</a>": "";
	$html .= "</div>";
	
	return $html;
	
} #thmplt_caption
add_shortcode('thmplt_caption', 'thmplt_caption');




 /**
 * Shortcode that crates responsive captions using "figure" semantics
 */
function thmplt_fig_caption($atts, $content){

	extract( shortcode_atts( array(
		'id' => '', // 
		'class' => '',
		'imgclass' => '',
		'imgsrc' => '',
		'hvr' => '',
		'href' => '',
		'title' => '',
		'atagpos' => 'outside',
	), $atts ) );
	
	$html = "<figure ";
	$html .= (!empty($id)) ? "id='".$id."' ": "";
	$html .= " class='tpf-fig-caption ".$class."' >";
	//$html .= "<figure class='".$figclass."' >";
	
	$html .= (!empty($imgsrc)) ? "<img src='".$imgsrc."' alt='".$title."' class=' tpf-fig-caption-img ".$imgclass."' ".$datahvr." />": "";
	$html .= "<figcaption class='tpf-fig-caption-text'>";
	$html .= "<strong class='tpf-fig-caption-title'>".$title."</strong>";
	$html .= (!empty($content)) ?  $content:"";
	
	if ($atagpos='inside') { 
			$html .= (!empty($href)) ? "<a href='".$href."' ></a>": ""; 
	}  
	
	$thml .= "</figcaption>";

	if ($atagpos='outside') { 
			$html .= (!empty($href)) ? "<a href='".$href."' ></a>": ""; 
	}  
	
	$html .= "</figure>";
	
	return $html;
	
} #thmplt_caption
add_shortcode('thmplt_fig_caption', 'thmplt_fig_caption');

