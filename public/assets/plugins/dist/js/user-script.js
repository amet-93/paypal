$(document).ready(function(){
	$('#edit-user').validate({
		submitHandler: function(form){
			var input_data = '';
			var user_id = $('#user_id').val();
			$('#edit-user input').each(function(key,input_val){
				if($(this).attr('name') != undefined){
					input_data += $(this).attr('name')+'='+$(this).val()+'&';
				}
			});
			
			$.ajax({
				type: "POST",
				url: base_url()+'user/update-user',
				data:input_data,
				success: function(response){
					response = JSON.parse(response);
					if(response.success == true){
						$('#first_name_'+user_id).html(response.data.first_name);
						$('#firstname-'+user_id).val(response.data.first_name);
						$('#last_name_'+user_id).html(response.data.last_name);
						$('#lastname-'+user_id).val(response.data.last_name);
						$('#email_'+user_id).html(response.data.email_id);
						$('#email-'+user_id).val(response.data.email_id);
						$('#company_name_'+user_id).html(response.data.company_name);
						$('#companyname-'+user_id).val(response.data.company_name);
						$('#edit-user span').show();
						$('#edit-user input').attr('type','hidden');
						$('.user-submit').hide();
						$('.user-cancel').hide();
						$('.flash-message').html(' <p class="alert alert-success">User information update successfully!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
					}else{
						$('.flash-message').html(' <p class="alert alert-danger">'+response.data+'<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>');
					}
				}
			});
   		}

	});
	$('.user-cancel').click(function(){
		var user_id = $(this).attr('id');
		var input_id = [];
		var span_id = [];
		$('#edit-user input').each(function(){
			input_id.push($(this).attr('id'));
		});
		$('#edit-user span').each(function(){
			span_id.push($(this).attr('id'));
		});
		create_field_editable(span_id,user_id,input_id,'cancel');
	});
});

function create_field_editable(span_id,user_id,field_id,type=null) {
	if(type == null){
		$('#'+span_id+'_'+user_id+'').hide();
		if(field_id == 'password'){
			$('#'+field_id+'-'+user_id+'').attr('type','password');
			$('#'+field_id+'-'+user_id+'').attr('name','password');
		}else{
			$('#'+field_id+'-'+user_id+'').attr('type','text');
		}
		$('.user-submit').show();
		$('.user-cancel').show();
	}else{
		$.each(span_id, function (key, span) {
	        $('#'+span+'').show();
	    });
	    $.each(field_id, function (key, field) {
	    	if(field == 'password-'+user_id){
	    		$('#'+field+'').removeAttr('name');
	    		$('#'+field+'').attr('type','hidden');
	    	}else{
	    		$('#'+field+'').attr('type','hidden');
	    	}
	    });
	    $('.user-submit').hide();
		$('.user-cancel').hide();
	}
	
}

function base_url() {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost') {
        var url = location.origin+'/'+pathparts[1].trim('/')+'/'; // http://localhost/myproject/
    }else{
        var url = location.origin+'/dashboard/'; // http://stackoverflow.com
    }
    return url;
}