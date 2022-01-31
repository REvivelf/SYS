<?php
const DS = '\\';
// const INPUT_IMG = __DIR__ . DS . "images" . DS . 'space2.jpg';
const INPUT_IMG = __DIR__ . DS . "images" . DS . 'dog.jpg';
const HEADER_TEMPLATE = __DIR__ . DS . 'header.html';
const PAGE_TEMPLATE = __DIR__ . DS . 'main.html';
const FOOTER_TEMPLATE = __DIR__ . DS . 'footer.html';

$page_header = file_get_contents(HEADER_TEMPLATE);
$page_footer = file_get_contents(FOOTER_TEMPLATE);

function converImg()
{
	$image_size = getimagesize(INPUT_IMG);
	$image = imagecreatefromjpeg(INPUT_IMG);
	$pixel_matrix = [];
	$pixel_data = [];

	for ($i = 0; $i < $image_size[0]; $i++) {
		for ($j = 0; $j < $image_size[1]; $j++) {
			$pixel_color_index = imagecolorat($image, $i, $j);
			$pixel_data[] = [
				'r' => ($pixel_color_index >> 16) & 0xFF,
				'g' => ($pixel_color_index >> 8) & 0xFF,
				'b' => $pixel_color_index & 0xFF
			];
			$pixel_matrix[$j][$i] = sprintf(
				"#%02x%02x%02x",
				($pixel_color_index >> 16) & 0xFF, 
				($pixel_color_index >> 8) & 0xFF, 
				$pixel_color_index & 0xFF,
			);
		}
	}

	return $pixel_matrix;
}

function middleColor($data){
	$all_color = [
		'red' => 0,
		'green' => 0,
		'blue' => 0,
	];

	foreach($data as $pixel){
		$all_color['red'] += $pixel['r'];
		$all_color['green'] += $pixel['g'];
		$all_color['blue'] += $pixel['b'];
	}

	$middle_color = [
		'red' => (int)$all_color['red'] / count($data),
		'green' => (int)$all_color['green'] / count($data),
		'blue' => (int)$all_color['blue'] / count($data),
	];

	return sprintf(
				"#%02x%02x%02x",
				$middle_color['red'], 
				$middle_color['green'], 
				$middle_color['blue'],
			);
}

function generateSVG($pixel_matrix)
{
	$width = count($pixel_matrix[0]);
	$height = count($pixel_matrix);

//var_dump($width, $height); die();

	$svg = '<svg width="' . $width . '" height="' . $height . '" viewBox="0 0 ' . $width . ' ' . $height . '" fill="none" xmlns="http://www.w3.org/2000/svg">';

	foreach($pixel_matrix as $row_key => $row){
		$y_val = $row_key > 0 ? 'y="' . $row_key . '"' : '';

		foreach($row as $pixel_key => $pixel){
			$x_val = $pixel_key > 0 ? 'x="' . $pixel_key . '"' : '';

			$svg .= '<rect ' . $x_val . ' ' . $y_val . ' width="1" height="1" fill="'.$pixel.'"/>';
		}
	}

	$svg .= '</svg>';

	return $svg;
}

$pixels_info = converImg();
//$middle_color = middleColor($pixel_data);
$render = $page_header;
$render .= generateSVG($pixels_info);
//$render .= '<div><img src="/images/dog.jpg"></div>';
$render .= $page_footer;

echo $render;
?>