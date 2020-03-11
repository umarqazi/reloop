$(document).ready(function () {

    /**
     * author: Bilal Saqib
     */

    var max_fields = 5; //maximum input boxes allowed
    var wrapper = $("#input_fields_wrap"); //Fields wrapper
    var add_button = $(".add-more-filed"); //Add button ID
    var x = 1;
    $(add_button).click(function (e) {
        e.preventDefault();
        if (x < max_fields) {
            x++;
            var district_name = 'district' + x;
            var type_name = 'type' + x;
            var city_name = 'city' + x;
            $(wrapper).append('<div class="appendable-filed top-bordered"><a href="javascript:void(0);" class="remove-append"><i class="fa fa-minus" aria-hidden="true"></i></a><div class="input-field col s3">\n' +
                '              <select name="type[]"  id="type' + x + '" required>\n' +
                '                            <option value="" disabled selected>Choose Type</option>\n' +
                '                            <option value="1">Villa</option>\n' +
                '                            <option value="2">Apartment</option>\n' +
                '              </select>  ' +
                '                             <label>Type</label></div>\n' +
                '                <div class="input-field col s3">\n' +
                '                    <input id="bedrooms[]" type="number" name="bedrooms[]" required>\n' +
                '                    <label for="bedrooms">No of Bedrooms</label>\n' +
                '                </div>\n' +
                '                <div class="input-field col s3">\n' +
                '                    <input id="occupants[]" type="number" name="occupants[]" required>\n' +
                '                    <label for="occupants">No of Occupants</label>\n' +
                '                </div>\n' +
                '                <div class=" input-field col s3">\n' +
                '                    <select name="city_id[]"  id="city' + x + '" required>\n' +
                '                    </select>\n' +
                '                    <label>City</label>\n' +
                '                </div>\n' +
                '                <div class="input-field col s3">\n' +
                '                    <select name="district[]"  id="district' + x + '" required>\n' +
                '                        <option value="" disabled selected>Choose District</option>\n' +
                '                        <option value="Qasur">Qasur</option>\n' +
                '                        <option value="Okarda">Okarda</option>\n' +
                '                    </select>\n' +
                '                    <label>District</label>\n' +
                '                </div>\n' +
                '                <div class="input-field col s3">\n' +
                '                    <input id="street[]" type="text" name="street[]" required>\n' +
                '                    <label for="street[]">Street</label>\n' +
                '                </div>\n' +
                '                <div class="input-field col s3">\n' +
                '                    <input id="floor[]" type="text" name="floor[]" required>\n' +
                '                    <label for="floor[]">Floor</label>\n' +
                '                </div>\n' +
                '                <div class="input-field col s3">\n' +
                '                    <input id="unit-number[]" type="text" name="unit-number[]" required>\n' +
                '                    <label for="unit-number[]">Unit Number</label>\n' +
                '                </div>' +
                '                <div class="input-field col s12">\n' +
                '                    <input id="location[]" type="text" name="location[]" required>\n' +
                '                    <label for="location[]">Location</label>\n' +
                '                </div>' +
                '                </div>' +
                '<div> ');
        }
        $('#' + district_name).material_select();
        $('#' + type_name).material_select();
        var select = $('#' + city_name);

        //ajax call to append cities from backend
        $.ajax({
            type: "get",
            url: "/cities",
            success: function (res) {
                $('#' + city_name).append('<option value="" disabled selected >Choose City</option>');
                if (res) {
                    $.each(res, function (key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#' + city_name).material_select();
                }
            }
        });
    });
    $(wrapper).on("click", ".remove-append", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    /**
     * author: Abdullah Wazir
    */

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
