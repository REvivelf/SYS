<?php
const UPLOAD_DIR = __DIR__ . DS . "images" . DS;

function converImg()
{
	if(isset($_FILES['image']) && $_FILES['image']['type'] == 'image/jpeg'){
		$uploadfile = UPLOAD_DIR . basename($_FILES['userfile']['name']);
var_dump($uploadfile); die();
		if(move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)){
			return true;
		}

		return false;
	}

	/*$page_header = file_get_contents(HEADER_TEMPLATE);
	$page_template = file_get_contents(PAGE_TEMPLATE);
	$page_footer = file_get_contents(FOOTER_TEMPLATE);

	$image_size = getimagesize(INPUT_IMG);
	$image = imagecreatefromjpeg(INPUT_IMG);
	$pixel_matrix = [];

	for ($i = 0; $i < $image_size[0]; $i++) {
		for ($j = 0; $j < $image_size[1]; $j++) {
			$pixel_color_index = imagecolorat($image, $j, $i);
			$pixel_matrix[$i][$j] = sprintf(
				"#%02x%02x%02x",
				($pixel_color_index >> 16) & 0xFF, 
				($pixel_color_index >> 8) & 0xFF, 
				$pixel_color_index & 0xFF,
			);
		}
	}

	$page_template .= '<div class="image_container">';

	foreach ($pixel_matrix as $row_key => $pixel_row) {
		$page_template .= '<div class="row row-'.$row_key.'">';
		foreach($pixel_row as $pixel_key => $pixel){
			$page_template .= '<div class="pixel pixel-'.$row_key.'-'.$pixel_key.'" style="background: '.$pixel.';"></div>';
		}
		$page_template .= '</div>';
	}
	$page_template .= '</div>';*/
}
?>