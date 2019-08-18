$(function() {
    // init: change appearance of active side menu
    $('li#menu-members').addClass('menu-open active');
    $('li#menu-members').find('.treeview-menu').css('display','block');
    $('li#menu-members').find('.treeview-menu').find('.add-members a').addClass('sub-menu-active');


    // if click radio button for single select
    $('.single-selection').click(function() {
        $('input[data-id="' + $(this).data('id') + '"]').not(this).prop('checked', false);
        var field = $(this).attr('data-id');
        $('#' + field).val($(this).val());
        if ($('input[data-id="' + $(this).data('id') + '"]:checked').length < 1) {
            $('#' + field).val('');
        }
    });

    // set validation for each items
    $('#member-form').validationEngine('attach', {
      promptPosition:"inline",
      maxErrorsPerField: 1,
      showOneMessage : true ,
      scroll: true,
      scrollOffset: 200
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

    
    // init: show tooltip on hover
    $('[data-toggle="tooltip"]').tooltip({
        container: 'body'
    });

});

// if click back will show confirm text
jQuery(document).ready(function($) {
  var getId = $('input[name=id]').val();
  var newGetId;

  if (getId == ""){
    newGetId = "add";
  }else{
    newGetId = $('input[name=id]').val();
  }

  if (window.history && window.history.pushState) {
    $(window).on('popstate', function() {
        var hashLocation = location.hash;
        var hashSplit = hashLocation.split("#!/");
        var hashName = hashSplit[1];


        if (hashName !== '') {
        var hash = window.location.hash;
        if (hash === '') {
          if(confirm('このページから移動しますか？')) {
             window.history.go(-1);
          }
          else {
            window.history.pushState('forward', null, './'+newGetId);
          }
        }
        }
    });
    window.history.pushState('forward', null, './'+newGetId);
  }
});


function initialiseInstance(editor)
{
  console.log('AAAA: ' + editor.getContent());
  //Get the textarea
  var container = $('#' + editor.editorId);

  //Get the form submit buttons for the textarea
  $('#btn-admin-member-submit').click(function(event){
    console.log('AAAA: ' + editor.getContent());
    if(editor.getContent()==""){
      $('#ckview').validationEngine('showPrompt', '* 必須項目です', 'red', 'centerRight');
      return false;
    }else{
      $('#ckview').validationEngine('hide')
    }
  });

  //Get event when unfocused form
  editor.on('Blur', function () {
    console.log('AAAA: ' + editor.getContent());
    if(editor.getContent()==""){
      $('#ckview').validationEngine('showPrompt', '* 必須項目です', 'red', 'centerRight');
      return false;
    }else{
      $('#ckview').validationEngine('hide')
    }
  });
}
