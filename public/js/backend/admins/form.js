$(function () {
    // init: side menu for current page
    console.log($(location). attr("href"));
    $('li#menu-admins').addClass('menu-open active');
    $('li#menu-admins').find('.treeview-menu').css('display', 'block');
    $('li#menu-admins').find('.treeview-menu').find('.add-admins a').addClass('sub-menu-active');

    // if click back will show confirm text
    var getId = $('input[name=id]').val();
    var newGetId;

    if (getId == ""){
        newGetId = "add";
    }else{
        newGetId = $('input[name=id]').val();
    }

    // init: show tooltip on hover
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

    // show password field only after 'change password' is clicked
    $('#reset-button').click(function (e) {
        $('#reset-field').removeClass('hide');
        $('#show-password-check').removeClass('hide');
        // to always uncheck the checkbox after button click
        $('#show-password').prop('checked', false);
    });

    // toggle password in plaintext if checkbox is selected
    $("#show-password").click(function () {
        $(this).is(":checked") ? $("#password").prop("type", "text") : $("#password").prop("type", "password");
    });

    // set validation for each items
    $('#admin-form').validationEngine('attach', {
        promptPosition:"inline",
        maxErrorsPerField: 1,
        showOneMessage : true ,
        scroll: true,
        scrollOffset: 200
    });

    setTimeout(function(){
        console.log($(location). attr("href"));
    }, 3000);
});
