$(function() {
	$('#btn_add_course').click(function() {
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
})
