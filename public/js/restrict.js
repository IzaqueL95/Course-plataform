$(function() {
	$('#btn_add_course').click(function() {
		clearErrors()
		$('#form_course').modal()[0].reset();
		$('#course_img_path').modal().attr("src", "")
		$('#modal_course').modal();
	})

	$('#btn_add_member').click(function() {
		$('#modal_member').modal();
	})

	$('#btn_add_user').click(function() {
		$('#modal_user').modal();
	})

	$('#btn_upload_course_img').change(function(){
		uploadImg($(this), $("#course_img_path"), $("#course_img"))
	});

	$('#btn_upload_member_photo').change(function(){
		uploadImg($(this), $("#member_photo_path"), $("member_photo"))
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
})
