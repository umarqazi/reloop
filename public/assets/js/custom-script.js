/*================================================================================
	Item Name: Materialize - Material Design Admin Template
	Version: 4.0
	Author: PIXINVENT
	Author URL: https://themeforest.net/user/pixinvent/portfolio
================================================================================

NOTE:
------
PLACE HERE YOUR OWN JS CODES AND IF NEEDED.
WE WILL RELEASE FUTURE UPDATES SO IN ORDER TO NOT OVERWRITE YOUR CUSTOM SCRIPT IT'S BETTER LIKE THIS. */

/**
 * author: Abdullah
 */

$(document).ready(function() {

    let updateUserLinkClass = 'edit-user';
    let viewUserEventListner = '';
    bindUpdateUserEvent();
    //initialize all modals
    $('.modal').modal({
        dismissible: true
    });

    function bindUpdateUserEvent() {
        $('.' + updateUserLinkClass).click(function () {
            viewUserEventListner = $(this).data('action');
            updateUser(viewUserEventListner);
        });
    }

    function updateUser(action) {
        document.getElementById("user-update-form").reset();
        // $('input[name="id"]').empty();
        // $('input[name="reward_points"]').empty();
        $.ajax({
            type: "GET",
            url: action,
            success: function (msg) {
                let data = msg.response;
                $('#userUpdateModal').modal('open');
                $("#userUpdateModal form input[name='id']").val(data.id);
                $("#userUpdateModal form input[name='reward_points']").val(data.reward_points);
            }
        });
    }

    $('#user-update-form').submit(function(e) {
        e.preventDefault();
        let userId = $("#userUpdateModal form input[name='id']").val();
        let action = $("#userUpdateModal form").attr('action');
        let formData = $('#user-update-form').serialize();
        $.ajax({
            type: "PUT",
            url: action,
            data: formData,
            success: function( msg ) {
                console.log(msg);
                let userType = '';
                if(msg.result.user_type == 1){
                    userType = 'House Hold';
                }else if(msg.result.user_type == 2){
                    userType = 'Organization';
                }else if(msg.result.user_type == 3){
                    userType = 'Driver';
                }else if(msg.result.user_type == 4) {
                    userType = 'Supervisor';
                }
                let view = '<a href="javascript:void(0)" id="user-'+userId+'" class="edit-user btn btn-primary float-left" data-action="'+viewUserEventListner+'"><i class="fa fa-edit"></i></a>';
                let trHTML = '';
                trHTML += '<td>' + msg.result.id
                    + '</td><td>' + msg.result.first_name +' '+ msg.result.last_name
                    + '</td><td>' + userType
                    + '</td><td>' + msg.result.reward_points
                    + '</td><td>' + view +'</td>';
                $('#user-' + userId).closest('tr').html(trHTML);
                $('#userUpdateModal').modal('close');
                bindUpdateUserEvent();
            },
            error: function (msg) {

            }
        });
    });
});

