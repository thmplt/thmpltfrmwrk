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
		'atagpos' => '',
		'link' => 'verb', // verb, inside, outside, wrapall, verb
		'linktext' => 'learn more',
	), $atts ) );
	
	$html = "<figure ";
	$html .= (!empty($id)) ? "id='".$id."' ": "";
	$html .= " class='tpf-fig-caption ".$class."' >";

	
	if ($link=='wrapall') { 
			$html .= (!empty($href)) ? "<a href='".$href."' >": ""; 
	} 	

	#$html .= "<div class='spinner' ></div>";
	
	$html .= (!empty($imgsrc)) ? "<div class='tpf-fig-caption-img-wrap'><img src='".$imgsrc."' alt='".$title."' class=' tpf-fig-caption-img ".$imgclass."' ".$datahvr." /></div>": "";
	$html .= "<figcaption class='tpf-fig-caption-text'><div class='tpf-fig-caption-text-inner'>";
	$html .= "<strong class='tpf-fig-caption-title'>".$title."</strong>";
	
	if ($link == "verb" || $link == "verbiage") {
		$html .= (!empty($content)) ?  "<div class='tpf-fig-caption-verb'><a href='".$href."' >".$content."</a></div>":"";
	} else {
		$html .= (!empty($content)) ?  "<div class='tpf-fig-caption-verb'>".$content."</div>":"";		
	}
	
	if ($link=='inside') { 
			$html .= (!empty($href)) ? "<a href='".$href."' >".$linktext."</a>": ""; 
	}  
	
	$thml .= "</div></figcaption>";

	if ($link=='outside') { 
			$html .= (!empty($href)) ? "<a href='".$href."' >".$linktext."</a>": ""; 
	}  
	
	if ($link=='wrap') { 
			$html .= (!empty($href)) ? "</a>": ""; 
	} 		
	
	$html .= "</figure>";
	
	
	
	return $html;
	
} #thmplt_caption
add_shortcode('thmplt_fig_caption', 'thmplt_fig_caption');

