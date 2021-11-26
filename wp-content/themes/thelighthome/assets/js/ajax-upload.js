jQuery(document).ready(function ($) {

	$('form#post').attr('enctype','multipart/form-data');
    $('form#post').attr('encoding', 'multipart/form-data');    
	$("#userImage").change(function() {
		var that = $(this);
		var imgUpload = that.parents('.img-upload');
		$(".upload-msg").empty(); 
		var file = this.files[0];
		var imagefile = file.type;
		var imageTypes= ["image/jpeg","image/png","image/jpg","image/gif"];
		if(imageTypes.indexOf(imagefile) == -1){
			$(".upload-msg").html("<span class='msg-error'>Vui lòng chọn hình ảnh hợp lệ</span><br /><span>Chỉ cho phép jpeg, jpg, gif và png</span>");
			return false;
		}else{
			var reader = new FileReader();
			reader.onload = function(e){
				//$(".img-preview").html('<img class="img-responsive" src="' + e.target.result + '" />');				
				imgUpload.find('.img-preview').html('<div style="background-image:url('+ e.target.result +')"></div>');				
				//$('.img-preview').css('background-image','url(' + e.target.result + ')');
			};
			reader.readAsDataURL(this.files[0]);
		}
	});		
	$("#input-gallary").change(function(e) {
		var files = e.target.files;
		var result = $('#gallery-metabox-list');
		for(var i = 0; i< files.length; i++) {
            var file = files[i]; 
          	var imagefile = file.type;
			var imageTypes= ["image/jpeg","image/png","image/jpg","image/gif"];
			if(imageTypes.indexOf(imagefile) == -1){
				parentGallery.find('.upload-msg').html("<span class='msg-error'>Vui lòng chọn hình ảnh hợp lệ</span><br /><span>Chỉ cho phép jpeg, jpg, gif và png</span>");
				return false;
			}else{	            
	            var reader = new FileReader();
	            reader.onload = function(e){
	                //result.append('<li style="background-image:url('+ e.target.result +')"><a class="remove-image" href="#">Xóa hình</a></li>');
	                result.append('<li style="background-image:url('+ e.target.result +')"></li>');
	            };            
	             //Read the image
	            reader.readAsDataURL(file);
	        }
        }
	});		
});

// $(document).on('click', '.gallery-image a.remove-image', function(e) {
//    e.preventDefault();
//    $(this).parents('li').animate({ opacity: 0 }, 200, function() {
//      $(this).remove();
//       //resetIndex();
//     });
//  });

