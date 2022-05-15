$(function() {
	$('#btn_add_course').click(function() {
		clearErrors()
		$('#form_course').modal()[0].reset();
		$('#course_img_path').modal().attr("src", "")
		$('#modal_course').modal();
	})

	$('#btn_add_member').click(function() {
		clearErrors()
		$('#form_member').modal()[0].reset();
		$('#member_photo_path').modal().attr("src", "")
		$('#modal_member').modal();
	})

	$('#btn_add_user').click(function() {
		clearErrors()
		$('#form_user').modal()[0].reset();
		$('#modal_user').modal();
	})

	$('#btn_upload_course_img').change(function(){
		uploadImg($(this), $("#course_img_path"), $("#course_img"))
	});

	$('#btn_upload_member_photo').change(function(){
		uploadImg($(this), $("#member_photo_path"), $("#member_photo"))
	});

	$('#form_course').submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_course",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function(){
				clearErrors();
				$("#btn_save_course").siblings(".help-block").html(loadImg("Verificando..."))
			},
			success: function(response){ 
				clearErrors()
				if(response["status"]){
					$('#modal_course').modal("hide");
				}else{
					
					showErrorsModal(response["error_list"])
				}
			}
		})


		return false

	})

	$('#form_member').submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_member",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function(){
				clearErrors();
				$("#btn_save_member").siblings(".help-block").html(loadImg("Verificando..."))
			},
			success: function(response){ 
				clearErrors()
				if(response["status"]){
					$('#modal_member').modal("hide");
				}else{
					
					showErrorsModal(response["error_list"])
				}
			}
		})


		return false

	});


	$('#form_user').submit(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_save_user",
			dataType: "json",
			data: $(this).serialize(),
			beforeSend: function(){
				clearErrors();
				$("#btn_save_user").siblings(".help-block").html(loadImg("Verificando..."))
			},
			success: function(response){ 
				clearErrors()
				if(response["status"]){
					$('#modal_user').modal("hide");
				}else{
					
					showErrorsModal(response["error_list"])
				}
			}
		})


		return false

	})


	$('#btn_your_user').click(function() {

		$.ajax({
			type: "POST",
			url: BASE_URL + "restrict/ajax_get_user_data",
			dataType: "json",
			data: {"user_id": $(this).attr("user_id")},	
			success: function(response){ 
				clearErrors()
				$('#form_user').modal()[0].reset();
				$.each(response["input"], function(id, value){
					$("#"+id).val(value)
				});
				$('#modal_user').modal();
			}
		})


		return false

	})
})
