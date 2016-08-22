//requires site.js
  
    var saveButtonFunction = function(e){
        var $button = $(this),
                $submission_form = $button.attr('data-form'),
                $modal_of_form = $button.attr('data-modal'),
                $request_url = $button.attr('data-action'),
                table = $button.attr('data-table'),
                $prefix = $($submission_form).attr('data-model');

                $data = $($submission_form).serialize();
                $method = $button.attr('data-method');

                $request_url += $method === "POST" ? '' : '/' + $($submission_form + ' .hidden-id-input').val();

        $button.prop('disabled', true);
        $button.html('saving...');

        sendAjaxRequest(
            $request_url, 
            $data, 
            $method, 
            compose(
                modifyTable($method, table),
                responseSuccessAlert($method)     
            )
        );


        $button.prop('disabled', false);
        $button.html('Save');

        $($modal_of_form).modal('hide');
        
    }

    $('.form-save-button').click(saveButtonFunction);

	/**
     *
     * Event: "User clicks a button to add a new record by showing a modal with a blank form"
     *
     * This event requires a modal that has only one form
     * and bound to an Add, Edit, and Save buttons
     *
     */
    var addButtonFunction = function(e){
        
        e.preventDefault();

        $button = $(this);
        $modal_to_show = $button.attr('data-modal');
        $submission_form = $button.attr('data-form');
        $save_button = $button.attr('data-save-button');

        if($($submission_form +' .hidden-id-input').val()){
            form_reset($submission_form);
        }

        $($modal_to_show).modal('show');

        $('.form-save-button[data-form="'+ $submission_form +'"]').attr('data-method', 'POST');
        $('.form-save-button[data-form="'+ $submission_form +'"]').attr('data-action', global.pageUrl);
    }

    $(".form-add-button").click(addButtonFunction);

    /**
     *
     * description: "User clicks a button to edit a record from a table by showing a modal and filling its form"
     *
     * This event requires a modal as the event of adding a 
     * record does, but it also needs a table where to derive
     * the id value of a record to be edited, through the "data-id" attribute of the
     * edit button which is aligned to a data row in a table. A GET HTTP request will be
     * made to show a modal which form is filled with the data from the HTTP Response to
     * the GET HTTP Request (sendGetRequestToFillForm)
     */

    var editButtonFunction = function(e){

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

    }

    $('body').on('click','.row-edit-button',editButtonFunction);

    /**
     *
     * description: "User clicks a button to delete a record from a table"
     *
     * This event requires a table like the function of editing a record when user clicks 
     * an button, instead, it sends a DELETE HTTP Request
     * using the value derived from the "data-id" attribute of the button.
     */

    var deleteButtonFunction = function (e) {

        e.preventDefault();
        
        var $data_id = $(this).attr('data-id');
        var $url = $(this).attr('data-action');
        var $method = $(this).attr('data-method');
        var table = $(this).attr('data-table');

        swal({
                    title: "Are you sure?",
                    text: "Do you confirm the deletion?",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it.",
                    cancelButtonText: "No, cancel it.",
                    closeOnConfirm: true,
                    closeOnCancel: true 
            },
            function (isConfirmed) {
                if (isConfirmed) {
                        sendAjaxRequest(
                            $url+'/'+$data_id, 
                            { id: $data_id }, 
                            $method, 
                            compose(
                                responseSuccessAlert($method), 
                                modifyTable($method, table) 
                            )
                        );
                } 
            }
        );
    }

    $('body').on('click','.row-delete-button',deleteButtonFunction);

    var refreshTable = function (table) {
        $(table + ' tbody tr').remove();
        sendAjaxRequest(global.pageUrl, null, 'GET', function (resp){
            for (var i = 0; i < resp.data.length; i++) {
                appendToTable(table, resp.data[i]);
            };
        }); 
        
    }

    $('body').on('click','.refresh-table-button', function (e){
        table = $(this).data('table');
        refreshTable (table);
    });

    $('body').on('click', '.form-clear-button', function (e){
        $submission_form = $(this).attr('data-form');
        form_reset($submission_form);
    });

    $('.dataTable').dataTable();
