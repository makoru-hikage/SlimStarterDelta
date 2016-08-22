
	var form_reset = function (form){
        $(form + ' input').each(function(){
            $(this).val('');
        });

        $(form + ' select').each(function(){
            $(this).val('');
        });
    }

	/**
	 * Fetch the "data-column" values of each table header cells (th)
	 */
	var appendToTable = function (table, resp_data){

	    var prefix = $(table).attr("data-model");
        var url = $(table).attr("data-action");
        var modal = $(table).attr("data-modal");
        var form = $(table).attr("data-form");
	    var appended_row = '';
	    
	    $(table + ' th').each(function(){
	        var column_name = $(this).attr('data-column');
	        if(column_name){
	        	var value = resp_data[column_name] == null ? '' : resp_data[column_name];
	            appended_row += '<td data-column='+column_name+'>'+ value + '</td>';
	        }
	    });

	    $(table).append(
	        '<tr id="'+prefix+'-row-'+resp_data.id+'">'+
	            appended_row+
	            '<td class="text-center">'+
	                '<a data-modal="'+ modal +'" data-form="'+form +'" data-id="'+resp_data.id+'" data-action="'+url+'" data-method="PUT" class="btn btn-xs btn-primary row-edit-button" href="#">'
                        +'<i class="fa fa-edit fa-fw"></i>Edit</a> '+

	                '<a data-id="'+resp_data.id+'" data-action="'+url+'" data-method="DELETE" data-table="'+table+'" '
	                +'class="btn btn-xs btn-danger row-delete-button" href="#"><i class="fa fa-times fa-fw"></i>Remove</a>'+
	            '</td>'+
	        '</tr>'
	    );              
	}

	var modifyRowInTable = function (table, resp){

	   prefix = $(table).attr('data-model');
	    
	   $('#'+prefix+'-row-'+resp.data.id+' td').each(function(){
	       $(this).html(resp.data[$(this).attr('data-column')]);
	   });              
	}

	var deleteRowInTable = function(table, resp){
	   
       prefix = $(table).attr('data-model');
       $('#'+prefix+'-row-'+resp.data.id).remove();
	}

	var modifyTable = function (method, table){
		return function (resp){
			if(resp.success){
				switch (method) {
					case "POST":
						appendToTable(table, resp.data); 
						break;
					case "PUT":
						modifyRowInTable(table, resp); 
						break;
					case "DELETE":
						deleteRowInTable(table, resp); 
						break;
					default:
						alert("What? No Method given?");
				}
			} else {
				
			}
            return resp;
		} 
	}

    var responseSuccessAlert = function (method){
        return function (resp){
            if (resp.success){
                switch (method){
                        case "POST":
                        swal("Added", "A new record has been added.", "success");
                        break;
                        case "PUT":
                        swal("Edited", "A record has successfully been updated", "success");
                        break;
                        case "DELETE":
                        swal("Delete", "The record has been deleted.", "success");
                        break;
                        default:
                        swal("Success", "It is successful", "success");
                }
            } else {
                swal('Error: '+resp.code, resp.message, "error");
            }
            return resp;
        }
    }

    var compose = function (f_one, f_two){
        return function (x){
            return f_one(f_two(x));
        }
    }

    var curry = function (fx){
		return function (x){
			return function (y){
				return fx(x, y);
			}
		}
	} 

	var sendGetRequestToFillForm = function (request_url, form_to_fill, prefix_of_inputs){
        
        $.get(request_url, function(resp){
            
            if(resp.success){
                form_reset(form_to_fill);
                for(var name_attribute in resp.data){
                    
                    $('#'+prefix_of_inputs+'_'+name_attribute).val(resp.data[name_attribute]);
                }
            } else {
                if(resp.code == 401){
                    location.reload();
                }
                alert('Form failed to be filled');
            }
        });        
    }
    
	var sendAjaxRequest = function ($url, $data, $method, $callback){

		$.ajax({
			url: $url,
			data: $data,
			method: $method,
			success: $callback
		});
	}

    
