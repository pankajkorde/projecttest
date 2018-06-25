$(document).ready(function () {
        //Upload Plugin support for upload Image using Ajax
        var Options = {
            uploadUrl: 'img_save_to_file.php',
            loaderHtml: '<i class="fa fa-spin fa-spinner"></i>',
            OutputText: 'outputimg',
            OutputDisplay: 'resultImage',
            onAfterImgUpload: function () {
                console.log("image uploaded");
            },
        }
        var upload = new Croppic('uploadimg', Options);	
		
		// Here is validation of bit depth according to the color mode...
		$(document).on("change", "#aci_color_mode", function (e) {
			if (document.getElementById('aci_color_mode').value == "grayscales") {
				$("#aci_bit_depth").html('<option value="">Select bit depth</option>');
				$("#aci_bit_depth").append('<option value="eight">8</option>');
				$("#aci_bit_depth").append('<option value="sixteen">16</option>');
			}
			if (document.getElementById('aci_color_mode').value == "rgb") {
				$("#aci_bit_depth").html('<option value="">Select bit depth</option>');
				$("#aci_bit_depth").append('<option value="twenty-four">24</option>');
				$("#aci_bit_depth").append('<option value="thirty-two">32</option>');
			}				
			if (document.getElementById('aci_color_mode').value == "bitonal") {
				$("#aci_bit_depth").html('<option value="">Select bit depth</option>');
				$("#aci_bit_depth").append('<option value="one">1</option>');
			}				
			if (document.getElementById('aci_color_mode').value == "indexed") {
				$("#aci_bit_depth").html('<option value="">Select bit depth</option>');
				$("#aci_bit_depth").append('<option value="eight">8</option>');
				$("#aci_bit_depth").append('<option value="sixteen">16</option>');
				$("#aci_bit_depth").append('<option value="twenty-four">24</option>');
				$("#aci_bit_depth").append('<option value="thirty-two">32</option>');
			}				
			if (document.getElementById('aci_color_mode').value == "cmyk") {
				$("#aci_bit_depth").html('<option value="">Select bit depth</option>');
				$("#aci_bit_depth").append('<option value="thirty-two">32</option>');
			}				
			if (document.getElementById('aci_color_mode').value == "lab") {
				$("#aci_bit_depth").html('<option value="">Select bit depth</option>');
				$("#aci_bit_depth").append('<option value="sixteen">16</option>');
				$("#aci_bit_depth").append('<option value="twenty-four">24</option>');
				$("#aci_bit_depth").append('<option value="thirty-two">32</option>');
			}				
		});

        //this request for color mode changing...
/*        $(document).on("change", "#aci_color_mode", function (e) {
			aci_all_ajx_call_function(e);
        });	
*/
		// this code for changing the bit depth of the image .. 
        $(document).on("change", "#aci_bit_depth", function (e) {
			aci_all_ajx_call_function(e);
        });	
 
		// this code for changing the alpha channel of the image .. 
		$(document).on("change", "#aci_alpha_channel", function (e) {
			aci_all_ajx_call_function(e);
        });	

		// this code changing the file compression of the image.
		$(document).on("change", "#aci_file_comp", function (e) {
			aci_all_ajx_call_function(e);
        });	
 
		// this code for changing the layers of the image.
		$(document).on("change", "#aci_layers", function (e) {
			aci_all_ajx_call_function(e);
        });	
		
		// this is for when we have to covert into the pdf file then we convert into the .pdf file using multipage...
		$(document).on("change", "#aci_multi_page", function (e) {
			aci_all_ajx_call_function(e);
        });	
	
        //Simple effects passing the values -------------code for final submission of image.
        $(document).on("click", "#aci_submit_button", function (e) {
			e.preventDefault();
		    var min_dpi = parseInt($('#aci_min_dpi').val()); 
		    var max_dpi = parseInt($('#aci_max_dpi').val()); 			
		   if(min_dpi > max_dpi){
				alert("DPI(min) should not be greater than DPI(max) Please correct!");
				return false;
		   }	   
			//aci_validate_form();
            $("#preloader").show();
            $('.ac_image_space').hide();
           // var effect = $(this).data('effect');
            var image = $("#outputimg").val();
            temp_image = "";
            var temp_image = $("#tempimage").val();
            $.ajax({
                url: "ajax_effect.php",
                type: "post", //send it through get method
                ContentType: "application/json",
                data: {
					   form_data:$("#aci_post_all_data").serialize(),
				       image:image,
					   temp_image:temp_image
				},
                success: function (response_source) {
					console.log(response_source);
					$("#preloader").hide();
					$('.ac_image_space').show();	
					$("#resultImage").html('');
					setTimeout(function(){
						$("#resultImage").html(response_source);
					}, 500);
				
                },
                error: function (xhr) {
                    //Do Something to handle error
					$("#preloader").hide();
					$('.ac_image_space').show();					
                    alert("some error found");
                }
            }).complete(function () {
                $("#preloader").hide();
            });
        });
		
// validation of all form data here proper or not...\\\\\\by pankaj k
	function aci_validate_form(){
	alert("please enter number !");
	return false;
	}
	
	// function for all ajax call here    .... \\\\\\\ by Pankaj k
	function aci_all_ajx_call_function(e){
			e.preventDefault();
            $("#preloader").show();
            $('.ac_image_space').hide();
           // var effect = $(this).data('effect');
            var image = $("#outputimg").val();
            temp_image = "";
            var temp_image = $("#tempimage").val();
            $.ajax({
                url: "color_mode.php",
                type: "post", //send it through get method
                ContentType: "application/json",
                data: {
					   form_data:$("#aci_post_all_data").serialize(),
				       image:image,
					   temp_image:temp_image
				},
                success: function (response_source) {
				    console.log(response_source);
					$("#preloader").hide();
					$('.ac_image_space').show();	
					$("#resultImage").html('');
					setTimeout(function(){
						$("#resultImage").html('<input type="hidden" id="tempimage" value="data:image/pdf;base64,'+ response_source +'">');
						$("#resultImage").append('<img src="data:image/pdf;base64,'+ response_source +'" id="imgdis" class="img-responsive" />');
					}, 1000);
                },
                error: function (xhr) {
                    //Do Something to handle error
					$("#preloader").hide();				
					$('.ac_image_space').show();					
                    alert("some error found");
                }
            }).complete(function () {
                $("#preloader").hide();
            });
	}
  
        //Advanced effects passing the values
        $("body").on("click", ".advanced", function (e) {
            e.preventDefault();

            var effect = $(this).data('advanced');
            $(".submit_values").data("effect", effect);
            $(".model_types").hide();
            if (effect == "rotate") {
                $("#rotate_model").show();
                $('#myModal').modal('show');
            } else if (effect == "border") {
                $("#border_model").show();
                $('#myModal').modal('show');
            } else if (effect == "text") {
                $("#text_model").show();
                $('#myModal').modal('show');
            } else if (effect == "textAdvanced") {
                $("#text_adv_model").show();
                $('#myModal').modal('show');
            } else if (effect == "caption") {
                $("#caption_model").show();
                $('#myModal').modal('show');
            } else if (effect == "resize") {
                $("#resize_model").show();
                $('#myModal').modal('show');
            }

        });

        //Model submit for advanced effects
        $("body").on("click", ".submit_values", function (e) {
            $("#preloader").show();
            var effect = $(this).data('effect');
            var image = $("#outputimg").val();
            temp_image = "";
            var temp_image = $("#tempimage").val();


            var r_degree = $("#r_degree").val();
            var r_color = $("#r_color").val();
            var b_width = $("#b_width").val();
            var b_color = $("#b_color").val();
            var t_text = $("#t_text").val();
            var t_position = $("#t_position").val();
            var ta_text = $("#ta_text").val();
            var ta_size = $("#ta_size").val();
            var ta_color = $("#ta_color").val();
            var ta_position = $("#ta_position").val();
            var c_position = $("#c_position").val();
            var c_width = $("#c_width").val();
            var c_color = $("#c_color").val();
            var c_text = $("#c_text").val();
            var c_size = $("#c_size").val();
            var ct_color = $("#ct_color").val();
            var r_width = $("#r_width").val();
            var r_height = $("#r_height").val();


            $.ajax({
                url: "ajax_advanced.php",
                type: "get", //send it through get method
                data: {
                    effect: effect,
                    image: image,
                    temp_image: temp_image,
                    r_degree: r_degree,
                    r_color: r_color,
                    b_width: b_width,
                    b_color: b_color,
                    t_text: t_text,
                    t_position: t_position,
                    ta_text: ta_text,
                    ta_size: ta_size,
                    ta_color: ta_color,
                    ta_position: ta_position,
                    c_position: c_position,
                    c_width: c_width,
                    c_color: c_color,
                    c_text: c_text,
                    c_size: c_size,
                    ct_color: ct_color,
                    r_width: r_width,
                    r_height: r_height,

                },
                success: function (response) {
                    $("#resultImage").html(response);
                    $('#myModal').modal('hide');
                },
                error: function (xhr) {
                    //Do Something to handle error
                    alert("some error found");
                }
            }).complete(function () {
                $("#preloader").hide();
            });
        });
        
        //Save the effect

        $("body").on("click", ".save_temp", function (e) {
            var temp = $("#tempimage").val();
			console.log(temp);
            res = temp.split("/");
            $("#outputimg").val(temp);
            $("#tempimage").val('');
            alert("saved");
        });
        
        //Cancel the effect

        $("body").on("click", ".cancel_temp", function (e) {
            var image = $("#outputimg").val();
            var url = "upload/" + image;
            $("#imgdis").attr("src", url);
            $("#tempimage").val('');
            alert("cancelled");
        });
        
        //Download the Image

        $("body").on("click", "#saveimage", function (e) {
            var image = $("#outputimg").val();
            var url = "upload/" + image;
            e.preventDefault();//prevent the normal click action from occuring
            window.location = 'save_file.php?file=' + encodeURIComponent(url);
        });

});