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
	$portrait_minwidth = $aci_all_post_data['portrait_minwidth'];
	$portrait_minheight = $aci_all_post_data['portrait_minheight'];
	$portrait_maxwidth = $aci_all_post_data['portrait_maxwidth'];
	$portrait_maxheight = $aci_all_post_data['portrait_maxheight'];
	$landscape_minwidth = $aci_all_post_data['landscape_minwidth'];
	$landscape_minheight = $aci_all_post_data['landscape_minheight'];
	$landscape_maxwidth = $aci_all_post_data['landscape_maxwidth'];
	$landscape_maxheight = $aci_all_post_data['landscape_maxheight'];
	$file_size = $aci_all_post_data['file_size'];
}
$effect = '';
$image = $_POST['image'];
$temp_image="";
if(isset($_POST['temp_image']) && $_POST['temp_image'] != ''){
	$temp_image = $_POST['temp_image'];
	/*if (($pos = strpos($temp_image, "/")) !== FALSE) { 
		$temp_image_name = substr($temp_image, $pos+1); 
	}*/
	$random_img_name = time();
	$file_with_ext = save_base64_image($temp_image, $random_img_name, 'upload/');
	echo "<div> Your file saved successfully </div>";
	echo '<img src="upload/'.$file_with_ext.'">';
	exit;
	$real_path = __DIR__ . '/upload/'. $file_with_ext;
	$result_path = __DIR__ . '/upload/' .$file_with_ext;
	$output_path = 'upload/' .$file_with_ext;
}else{
	$path = "upload/";
	$real_path = __DIR__ . '/upload/'.$image;
	$result_path = __DIR__ . '/upload/next_image.tiff';
	$output_path = 'upload/next_image.tiff';
}
//use imagick
$image = new Imagick();
$image->readImage($real_path);

if($min_dpi != '' || $max_dpi != ''){
	$resolutions = $image->getImageResolution();
	if(($resolutions['x'] < $min_dpi)){
		$image->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
		$image->setImageResolution($min_dpi, $min_dpi);		
	
	}else if(($resolutions['x'] > $max_dpi)){
		$image->setImageUnits(imagick::RESOLUTION_PIXELSPERINCH);
		$image->setImageResolution($max_dpi, $max_dpi);		
	}
}
$image->writeImage($result_path);
echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
exit;
function imagick_effects_and_image_coversion($effect, $real_path, $result_path, $output_path){
	     
	if($effect == 'grayscale'){
		// this is for Grayscale color mode
		$image = new Imagick();
		$image->readImage($real_path);
		$image->setImageColorspace(2);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
		
	}else if($effect == 'rgb'){
		// this is for RGB color mode 
		$image = new Imagick();
		$image->readImage($real_path);
		$image->setImageColorspace(1);
		//$image->setImageDepth(16);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
	
	}else if($effect == 'bitonal'){
		// this for bitonal color mode
		$image = new Imagick();
		$image->readImage($real_path);
		$image->quantizeImage(256,Imagick::COLORSPACE_RGB,0,false,false);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';		
	
	}else if($effect == 'cmyk'){
		// This is for CMYK color mode
		$image = new Imagick();
		$image->readImage($real_path);
		$image->setImageColorspace(12);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
	
	}else if($effect == 'lab'){
		//this is for LAB color mode
		$image = new Imagick();
		$image->readImage($real_path);
		$image->setImageColorspace(5);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
	
	}else if($effect == 'indexed'){
		//this code is used for index image color code
		$image = new Imagick();
		$image->readImage($real_path);
		$image->setImageColorspace(5);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';
	
	}else if($effect == 1 || $effect == 8 || $effect == 16 || $effect == 24 || $effect == 32){
		//this code for bit depth of the image
		$image = new Imagick();
		$image->readImage($real_path);
		//$image->setImageFormat('tiff');
		$image->setImageDepth($effect);
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
	
	}else if($effect == 'yes' || $effect == 'no'){
		//this code for alpha channel of the image
		$image = new Imagick();
		$image->readImage($real_path);
		$image->
		$image->writeImage($result_path);
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	

	}else if($effect == 'none' || $effect == 'lzw' || $effect == 'zip' || $effect == 'jpeg'){
		//this code for alpha channel of the image
		$image = new Imagick(); 
		$image->readImage($real_path); 
		if($effect == 'lzw'){
			$image->setImageCompression(imagick::COMPRESSION_LZW );
		}else if($effect == 'zip'){
			$image->setImageCompression(imagick::COMPRESSION_ZIP);
		}else if($effect == 'jpeg'){
			$image->setImageCompression(imagick::COMPRESSION_JPEG);
		}
		$image->setImageCompressionQuality(50); 
		$image->writeImage($result_path); 
		echo '<img src="' .$output_path .'" id="imgdis" class="img-responsive">';
		echo '<input type="hidden" id="tempimage" value="' . $output_path . '">';	
	}
}

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

