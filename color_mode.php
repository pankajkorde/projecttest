<?php
if(isset($_POST['form_data'])){
	parse_str($_POST['form_data'], $aci_all_post_data);
	$color_mode = $aci_all_post_data['color_mode'];
	$bit_depth = $aci_all_post_data['bit_depth'];
	$alpha_channel = $aci_all_post_data['alpha_channel'];
	$file_comp = $aci_all_post_data['file_comp'];
	$min_dpi = $aci_all_post_data['min_dpi'];
	$max_dpi = $aci_all_post_data['max_dpi'];	
	$layers = $aci_all_post_data['layers'];
	$mult_page = $aci_all_post_data['mult_page'];
}
$image = $_POST['image'];
$temp_image="";
if(isset($_POST['temp_image']) && $_POST['temp_image'] != ''){
	$temp_image = $_POST['temp_image'];
	$temp_img_name = 'sample';
	$save_filename_with_ext = save_base64_image($temp_image, $temp_img_name, 'upload/');	
	/*if (($pos = strpos($temp_image, "/")) !== FALSE) { 
		$temp_image_name = substr($temp_image, $pos+1); 
	}*/
	$real_path = __DIR__ . '/upload/'.$save_filename_with_ext;
}else{
	$path = "upload/";
	$real_path = __DIR__ . '/upload/'.$image;
}
//use imagick
$image = new Imagick();
$image->readImage($real_path);

if($color_mode != ''){
	if($color_mode == 'grayscales' && $bit_depth == 'eight'){
		$image->setImageColorspace(2);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'grayscales' && $bit_depth == 'sixteen'){
		$image->setImageDepth(16);
		$image->setImageColorspace(2);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'rgb' && $bit_depth == 'twenty-four'){
		//$image->setImageDepth(24);
		$image->setImageColorspace(1);
	}else if($color_mode == 'rgb' && $bit_depth == 'thirty-two'){
		$image->setImageDepth(32);
		//$image->setImageColorspace(13);
		$image->setImageFormat('jpg');		
	}else if($color_mode == 'bitonal'){
		//$image->setImageColorspace(2);
		$image->setImageFormat('bmp');
	}else if($color_mode == 'indexed' && $bit_depth == 'eight'){
		$image->setImageDepth(8);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'indexed' && $bit_depth == 'sixteen'){
		$image->setImageDepth(16);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'indexed' && $bit_depth == 'twenty-four'){
		$image->setImageDepth(24);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'indexed' && $bit_depth == 'thirty-two'){
		$image->setImageDepth(32);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'cmyk'){
		$image->setImageColorspace(12);
	}else if($color_mode == 'lab' && $bit_depth == 'sixteen'){
		$image->setImageDepth(16);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');
	}else if($color_mode == 'lab' && $bit_depth == 'twenty-four'){
		$image->setImageDepth(24);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');		
	}else if($color_mode == 'lab' && $bit_depth == 'thirty-two'){
		$image->setImageDepth(32);
		$image->setImageColorspace(5);
		$image->setImageFormat('jpg');		
	}
}

if($alpha_channel == 'yes'){
	$image->setImageAlphaChannel(Imagick::ALPHACHANNEL_ACTIVATE);
	$image->setImageOpacity(0.5);
	$image->setImageFormat('tiff');
}

if($file_comp != ''){
	if($file_comp == 'lzw'){
		$image->setImageCompression(imagick::COMPRESSION_LZW );
		$image->setCompressionQuality(50); 
	}else if($file_comp == 'zip'){
		$image->setImageCompression(imagick::COMPRESSION_ZIP);
		$image->setCompressionQuality(100); 
	}else if($file_comp == 'jpeg'){
		$image->setImageCompression(imagick::COMPRESSION_JPEG);
		$image -> gaussianBlurImage(0.8, 10); 
		$image->setCompressionQuality(85); 	
	}
}

if($layers != ''){
	if($layers == 'flattened'){
		$image->setImageBackgroundColor('white');
		$image->setImageAlphaChannel(imagick::ALPHACHANNEL_REMOVE);
		$image->mergeImageLayers(imagick::LAYERMETHOD_FLATTEN);
		$image->setImageFormat('tiff');
	
	}else if($layers == 'multi-channel'){
		$image->mergeImageLayers(Imagick::LAYERMETHOD_COALESCE);
		$image->setImageFormat('tiff');
	}
}

if($mult_page != ''){
	if($mult_page == 'yes'){
		$combined = new Imagick();
		$combined->newImage(100, 100, new ImagickPixel('red'));
		$combined->setImageFormat('png');
		$combined->addImage($image);
		$combined->setImageFormat("pdf");
		$thumbnail = $combined->getImageBlob();
		$thumbnail = base64_encode($thumbnail);
		echo $thumbnail;
		exit;
	}
}

$thumbnail = $image->getImageBlob();
$thumbnail = base64_encode($thumbnail);
echo $thumbnail;
//echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
//echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';

//function for saving base 64 bit image
function save_base64_image($base64_image_string, $output_file_without_extension, $path_with_end_slash="" ) {
    //usage:  if( substr( $img_src, 0, 5 ) === "data:" ) {  $filename=save_base64_image($base64_image_string, $output_file_without_extentnion, getcwd() . "/application/assets/pins/$user_id/"); }      
    //
    //data is like:    data:image/png;base64,asdfasdfasdf
    $splited = explode(',', substr( $base64_image_string , 5 ) , 2);
    $mime=$splited[0];
    $data=$splited[1];

    $mime_split_without_base64=explode(';', $mime,2);
    $mime_split=explode('/', $mime_split_without_base64[0],2);
    if(count($mime_split)==2)
    {
        $extension=$mime_split[1];
        if($extension=='jpeg')$extension='jpg';
        //if($extension=='javascript')$extension='js';
        //if($extension=='text')$extension='txt';
        $output_file_with_extension=$output_file_without_extension.'.'.$extension;
    }
    file_put_contents( $path_with_end_slash . $output_file_with_extension, base64_decode($data) );
    return $output_file_with_extension;
}

exit;