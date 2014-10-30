var car_list = [];
var car_list_txt = [];

function initCompareCar()
{
  // compare car function
  $('.compare-popover-dismiss').popover({trigger: 'click', html:true});
  $('.compare-popover-dismiss').on('show.bs.popover', function () {    
    var v = $(this).data('carid');
    var index = car_list.indexOf(v);
    if (index >= 0) {

    } else {
        car_list.push(v);
        car_list_txt.push($(this).data('cartitle') + ' <a href="javascript:popValueFromArray('+v+')" class="delete-car-item-from-compare-list">[x]</a>');
    }

    $(this).attr('data-content','').data('bs.popover').setContent();
    $(this).attr('data-content',car_list_txt.join('<hr>')+"<hr><a href='compare/"+car_list.join(',')+"'>Go to compare</a>").data('bs.popover').setContent();

    $('.compare-popover-dismiss').popover('hide');  
  });
}

function popValueFromArray(value){
    var index = car_list.indexOf(value);
    if (index >= 0) {
        car_list.splice(index, 1);    
        car_list_txt.splice(index, 1);
    }
    $('.compare-popover-dismiss').popover('hide');
}

$(function(){

  initCompareCar();

  $('.btn-report').click(function(){
    
    var container = $(this).parent().parent().parent();
    var img_src = container.find('.file-preview-image').attr('src');
    var title = container.find('header a').text().trim();
    var id = container.find('small').text().trim();
    var postId = container.find('#item-post-id').val();

    $('#report-id').text(id);
    $('#file-report-preview-image').attr('src', img_src);
    $('#report-title').text(title);

    $('#post-id').val(postId);

    $('#modal-report-form').modal('show');
    return false;
  });

  $('#modal-report-form').on('show.bs.modal', function (e) {
    $('input[name="report-reason"]').iCheck('uncheck');
    $('#report-email').val('');
    $('.thankyou-page').hide();
  })

  $('#btn-report-submit').click(function(){
    var $form = $('#report-form');
    var data = $form.serialize();

    if (!$form[0].checkValidity())
    {
      //console.log('no pass');
    } else {
      // cancels the form submission
      event.preventDefault();
      // console.log('pass');
      $.post( "/listing/save-report", data)
      .done(function( data ) {
          console.log(data);
          $('.thankyou-page').show();
      },"json");
    }
  });

});