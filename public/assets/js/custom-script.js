$(document).ready(function () {

    /**
     * author: Bilal Saqib
     */

    //alert for inactive
    $("select[name='status']").on('change', function() {
        if($(this).val() == 0){
            var retVal = confirm("Do you want to continue ?");
            if( retVal == true ) {
                $(this).val(0);
                $(this).material_select();
            }
            if( retVal == false ) {
                $(this).val(1);
                $(this).material_select();
            }
        }
    });

    $("select[id='user_city_id']").on('change', function() {
       let city_id = $(this).val();
       let select = $('#user_district_id');
       select.empty();


        //ajax call to append related districts
        $.ajax({
            type: "get",
            url: "/get-related-districts/"+city_id,
            success: function (res) {
                if (res) {
                    select.append('<option value="" disabled selected >Choose District</option>');
                    $.each(res, function (key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                    select.material_select();
                }
            }
        });
    });




    $('#driver_id_div').append('<select name="driver_id"  id="driver_id"  required>\n' +
        '</select>\n');

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
                '                    <select name="district_id[]"  id="district' + x + '" required>\n' +
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

        //ajax call to append districts from backend
        $.ajax({
            type: "get",
            url: "/districts",
            success: function (res) {
                $('#' + district_name).append('<option value="" disabled selected >Choose District</option>');
                if (res) {
                    $.each(res, function (key, value) {
                        $('#' + district_name).append('<option value="' + key + '">' + value + '</option>');
                    });
                    $('#' + district_name).material_select();
                }
            }
        });
    });

    $(wrapper).on("click", ".remove-append", function (e) {
        e.preventDefault();
        $(this).parent('div').remove();
        x--;
    });

    $( "#subscription_category_id" ).change(function() {
        let subscription_category_value = $(this).val();
        if(subscription_category_value == 2){
            $('#subscription_request_allowed').remove();
            $('label[for=subscription_request_allowed]').remove();
            $('.subscription_request_allowed_input_field').append('' +
                '                    <select name="category_type"  id="subscription_category_type" required>\n' +
                '                        <option value="" disabled selected>Choose Subscription Category Type</option>\n' +
                '                        <option value="1">Same Day</option>\n' +
                '                        <option value="2">Next Day</option>\n' +
                '                        <option value="3">Single Collection</option>\n' +
                '                    </select>' +
                '                    <label for="subscription_category_type">Subscription Category Type</label>');
            $('#subscription_category_type').material_select();
        }
        else{
            $('.subscription_request_allowed_input_field').html('');
            $('.subscription_request_allowed_input_field').append('' +
                '                    <input id="subscription_request_allowed" type="number" name="request_allowed" required>\n' +
                '                    <label for="subscription_request_allowed">Request(s) Allowed</label>\n' +
                '                    ');
        }
    });

    $( ".getSubscription" ).click(function() {
        let subscription_id = $(this).attr('id');
        let route = 'subscription/'+ subscription_id;

        $("#userSubscriptionModal input[id='subscription-name']").empty();
        $("#userSubscriptionModal input[id='subscription-price']").empty();
        $("#userSubscriptionModal textarea[id='subscription-description']").empty();
        $("#userSubscriptionModal input[id='subscription-request-allowed']").empty();
        $("#userSubscriptionModal input[id='subscription-category']").empty();

        $.ajax({
            type: "GET",
            url:  route,
            success: function (data) {
                $("#userSubscriptionModal input[id='subscription-name']").val(data.name);
                $("#userSubscriptionModal input[id='subscription-price']").val(data.price);
                $("#userSubscriptionModal textarea[id='subscription-description']").text(data.description);
                $("#userSubscriptionModal input[id='subscription-request-allowed']").val(data.request_allowed);
                $("#userSubscriptionModal input[id='subscription-category']").val(data.category.name);

                $('#userSubscriptionModal').modal('open');
            }
        });
    });

    $( "#delivery_date" ).change(function() {
       let date      =  $(this).val() ;
       let order_id  =  $(this).closest("form").attr('id');
       let select    =  $('#driver_id');
       let route     =  '/drivers-availability/' + date + '/' + order_id;

        $.ajax({
            type: "GET",
            url:  route,
            success: function (res) {
                       select.html('');
                       select.append('<option value="" disabled selected >Choose Driver</option>');
                if (res) {
                    $.each(res, function (key, value) {
                        select.append('<option value="' + key + '">' + value + '</option>');
                    });
                    select.material_select();
                }
            }
        });

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
        $.ajax({
            type: "GET",
            url: action,
            success: function (msg) {
                let data = msg.response;
                $('#userUpdateModal').modal('open');
                $("#userUpdateModal form input[name='id']").val(data.id);
                $("#userUpdateModal form input[name='redeem_points']").attr('max', data.reward_points);
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
                $('div#card-alert').removeClass('hide');
                $('div#card-alert .card-content p').html('Reward Points Update Successfully');
                bindUpdateUserEvent();
            },
            error: function (msg) {

            }
        });
    });


});
