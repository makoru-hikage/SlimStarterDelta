
$(function(){

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $('a[data-toggle="tab"]').removeClass('btn-primary');
        $('a[data-toggle="tab"]').addClass('btn-default');
        $(this).removeClass('btn-default');
        $(this).addClass('btn-primary');
    })

    $('.next').click(function(){
        var nextId = $(this).parents('.tab-pane').next().attr("id");
        $('[href=#'+nextId+']').tab('show');
    })

    $('.prev').click(function(){
        var prevId = $(this).parents('.tab-pane').prev().attr("id");
        $('[href=#'+prevId+']').tab('show');
    })

    /* Update the data in the Confirmation Step when the following buttons are clicked */
    $('a[data-toggle="tab"], .prev, .next').click(function (e){

        var datastring = $("#student-form-data").serializeArray();

        for (var i = 0; i <= datastring.length -1; i++) {
                $('#confirm-user_'+datastring[i].name).html(datastring[i].value);
                $('#confirm-student_'+datastring[i].name).html(datastring[i].value);
        }

        var dateNow = (new Date()).getFullYear()
                    +'-'+((new Date()).getMonth()+1)
                    +'-'+(new Date()).getDate();
                $('#confirm-student_date_of_enrollment').html(dateNow);
    })

    $('.submitWizard').click(function(e){

        e.preventDefault();

        var approve = $(".approveCheck").is(':checked');
        if(approve) {

            // Serialize data to post method
            var $data = $("#student-form-data").serializeArray();

            sendAjaxRequest(
                global.baseUrl + 'registerstudent', 
                $data, 
                'POST', 
                compose(responseSuccessAlert('POST'), function (resp){
                    if (resp.success){
                        $('#confirm-user_username').html(resp.data.username);
                        return resp;
                    }
                })
            );
        } else {
            // Show notification
            swal({
                title: "Error!",
                text: "You have to approve form checkbox.",
                type: "error"
            });
        }
       
    });

    $('#user_birthdate').datepicker({
        format : 'yyyy-mm-dd'
    });

});