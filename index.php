<!--
/*
*	!!! THIS IS JUST AN EXAMPLE !!! It doesnt have any validation or coding standard
*/-->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <!-- This file has been downloaded from Bootsnipp.com. Enjoy! -->
        <title>Image Editor</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="assets/ac_style.css">
		
        <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
		<script src="croppic.js"></script>
		<script src="assets/myscript.js"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        Image Editor
                    </a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">			
                    <form class="navbar-form navbar-left" method="GET" role="search">
                        <button type="button" class="btn btn-primary" id="uploadimg">Upload</button>
                    </form>
                    <form class="navbar-form navbar-right" method="GET" role="search">
                        <button type="button" id="saveimage" class="btn btn-primary">Save Image</button>
						<button type="button" class="btn btn-info btn-block save_temp">save temp</button>
                    </form>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <div class="container-fluid main-container">
            <div class="col-md-4">
                <div class="panel with-nav-tabs panel-success">
                    <div class="panel-heading">
						<h2>Tif Image Specification</h2>
                    </div>
					<form class="aci_all_form_data" id="aci_post_all_data" action="" method="post">
						<div class="panel-body" id="panel-body" >
							<div class="slider-row">
								<div>	
									  <label for="sel1">Color Mode</label>
									  <select class="form-control" id="aci_color_mode" name="color_mode" >
										<option value="">select color mode</option>
										<option value="grayscales">Grayscale</option>
										<option value="rgb">RGB</option>
										<option value="bitonal">Bitonal</option>
										<option value="indexed">Indexed</option>
										<option value="cmyk">CMYK</option>
										<option value="lab">LAB</option>
									  </select>									
								</div>
								<div>
									  <label for="sel1">Bit Depth</label>
									  <select class="form-control" id="aci_bit_depth" name="bit_depth" >
										<option value="">Select bit depth</option>
										<option value="eight">8</option>
										<option value="sixteen">16</option>
									  </select>									
								</div>
								<div>
									  <label for="sel1">Alpha Channels</label>
									  <select class="form-control" id="aci_alpha_channel" name="alpha_channel" >
										<option value="no">No</option>
										<option value="lzw">Yes</option>
									  </select>									
								</div>
								<div>
									  <label for="sel1">File Compression</label>
									  <select class="form-control" id="aci_file_comp" name="file_comp" >
										<option value="none">None</option>
										<option value="lzw">LZW</option>
										<option value="zip">ZIP</option>
										<option value="jpeg">JPEG</option>
									  </select>		  
								</div>						
								<div>
										<label for="inputlg">DPI (min)</label>
										<input class="form-control input-lg" id="aci_min_dpi" type="text" name="min_dpi">
								</div>						
								<div>
										<label for="inputlg">DPI (max)</label>
										<input class="form-control input-lg" id="aci_max_dpi" type="text" name="max_dpi">
								</div>
								<div>
									  <label for="sel1">Layers</label>
									  <select class="form-control" id="aci_layers" name="layers">
											<option value="">Select Layers</option>
											<option value="flattened">Flattened</option>
											<option value="multi-channel">Multi Channel</option>
									  </select>		  
								</div>								
								<div>
									  <label for="sel1">Multi Page</label>
									  <select class="form-control" id="aci_multi_page" name="mult_page" >
										<option value="no">No</option>
										<option value="yes">Yes</option>
									  </select>		  
								</div>
								<div>
										<label for="inputlg">Portrait Min (Inches)</label>
										<input class="form-control input-lg aci_two_input_box" name="portrait_minwidth" type="text">
										<span class="aci_two_input_box1">In. X</span>
										<input class="form-control input-lg aci_two_input_box" name="portrait_minheight" type="text">
										<span class="aci_two_input_box1">In.</span>
								</div>							
								<div>
										<label for="inputlg">Portrait Max (Inches)</label>
										<input class="form-control input-lg aci_two_input_box" name="portrait_maxwidth" type="text">
										<span class="aci_two_input_box1">In. X</span>
										<input class="form-control input-lg aci_two_input_box" name="portrait_maxheight" type="text">
										<span class="aci_two_input_box1">In.</span>
								</div>							
								<div>
										<label for="inputlg">Landscape Min (Inches)</label>
										<input class="form-control input-lg aci_two_input_box" name="landscape_minwidth" type="text">
										<span class="aci_two_input_box1">In. X</span>
										<input class="form-control input-lg aci_two_input_box" name="landscape_minheight" type="text">
										<span class="aci_two_input_box1">In.</span>
								</div>							
								<div>
										<label for="inputlg">Landscape Max (Inches)</label>
										<input class="form-control input-lg aci_two_input_box" name="landscape_maxwidth" type="text">
										<span class="aci_two_input_box1">In. X</span>
										<input class="form-control input-lg aci_two_input_box" name="landscape_maxheight" type="text">
										<span class="aci_two_input_box1">In.</span>
								</div>							
								<div>
										<label for="inputlg">File Size</label>
										<input class="form-control input-lg" name="file_size" type="text">
								</div>	
							</div>
						</div>
						<div class="aci_submit_buttonn">
							<input type="button" name="submit" value="submit" id="aci_submit_button" class="btn-lg">
						</div>
					</form>
                </div>
            </div>
            <div class="col-md-8 content">
                <!-- For Loading......-->
                <div class="preloader" id="preloader" style="display:none;">
                    <img src="thumb/ajax_loader.gif" class="img-responsive center-block">
                    <p class="text-center loadText">Loading...</p>
                </div>
                <div class="panel panel-default ac_image_space">
                    <div class="panel-heading" >
                        Image
                               
                    </div>
                    <div class="panel-body" id="resultImage">
						<input type="hidden" id="outputimg" value="126.jpg">
                        <img src="upload/126.jpg" id="imgdis" class="img-responsive"> 
                        <input type="hidden" id="tempimage" value="">
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>