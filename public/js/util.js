const BASE_URL = "http://localhost/codeigniter/index.php/";

function clearErrors(){
	$('.has-error').removeClass("has-error");
	$('.help-block').html("");
}

function showErrors(error_list){
	clearErrors();

	$.each(error_list, function(id, message) {
		$(id).parent().parent().addClass("has-error");
		$(id).parent().siblings(".help-block").html(message)
	})

}

function loadImg(message=""){
	return "<i class='fa fa-circle-o-notch fa-spin'></i>&nbsp;" + message
}

function uploadImg(input_file, img, input_path){
	src_before = img.attr("src")
	img_file = input_file[0].files[0]
	form_data = new FormData()

	form_data.append("image_file", img_file);

	$.ajax({
		url: BASE_URL + "restrict/ajax_import_image",
		dataType: "json",
		cache: false,
		contentType: false,
		processData: false,
		data: form_data,
		type: "POST",
		beforeSend: function(){
			clearErrors();
			input_path.siblings(".help-block").html(loadImg("Carregando imagem..."))
		},
		success: function(response){
			// console.log(response)
			clearErrors()
			// console.log(response[""])
			if(response["status"]){
				img.attr("src", response["img_path"])
				input_path.val(response["img_size_return"])
				

			}else{
				
				img.attr("src", src_before)
				input_path.siblings(".help-block").html(response["error"])
				
			}
		},
		error: function(){
			
			img.attr("src", src_before)
		}
	})
}
