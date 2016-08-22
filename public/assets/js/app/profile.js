//requires site.js

function updateProfile (profile_to_update){
	return function(resp){
        $data_id = $(profile_to_update).attr('data-id');
        $model = $(profile_to_update).attr('data-model');

        if(resp.success){
                for(var name_attribute in resp.data){
                    $('#profile-'+$model+'_'+name_attribute).html(resp.data[name_attribute]);
                }
            } else {
                if(resp.code == 401){
                    location.reload();
                }
                alert('Update failed to be done');
            }
    }
}

$(function(){
	
	$('.form-save-button').click(function(e){
		var $button = $(this),
	            $submission_form = $button.attr('data-form'),
	            $modal_of_form = $button.attr('data-modal'),
	            $request_url = $button.attr('data-action'),
	            $prefix = $($submission_form).attr('data-model');

	            $data = $($submission_form).serialize();
	            $method = $button.attr('data-method');

                $request_url += $method === "POST" ? '' : '/' + $($submission_form + ' .hidden-id-input').val();

	   	$button.prop('disabled', true);
        $button.html('saving...');
        
	    sendAjaxRequest($request_url, $data, $method, compose(updateProfile('#'+$prefix+'-profile'), responseSuccessAlert($method)));

        $button.prop('disabled', false);
        $button.html('Save');

        $($modal_of_form).modal('hide');
        
	}).click(function(e){
    		var $data_id = $('#profile-user_full_name').attr('data-id');
    		

    		$.get(global.pageUrl +'/fullname/'+ $data_id, function(resp){
	    		if(resp.success){                   
	                $('#profile-user_full_name').html(resp.data.first_name 
	                	+ " " 
	                	+ resp.data.middle_name.substring(0,1)
	                	+ ". "
	                	+ resp.data.last_name );
	            } else {
	                if(resp.code == 401){
	                    location.reload();
	                }
	                alert('Form failed to be filled');
	            }
        	});
    	});

	    $('.row-edit-button').click(function(e){

	        var $button = $(this);
	        var $data_id = $button.attr('data-id');
	        var $modal_to_show = $button.attr('data-modal');
	        var $submission_form = $button.attr('data-form');
	        var prefix = $($submission_form).attr('data-model');

	        var $method = $button.attr('data-method');
	        var $url = $button.attr('data-action');

	        e.preventDefault();

	        sendGetRequestToFillForm($url+ '/' +$data_id, $submission_form, prefix);
	            
	        $('.form-save-button[data-form="'+ $submission_form +'"]').attr('data-method', 'PUT');
	        $('.form-save-button[data-form="'+ $submission_form +'"]').attr('data-action', $url);
	        $($modal_to_show).modal('show');        

    	});
    	

});