function Validation()
{
  this.validate = function(formID, Crud)
  {
    $(formID).validate({
      errorClass: 'help-block animation-pullUp',
      errorElement: 'div',
      errorPlacement: function(error, e)
      {
        e.parents('.form-group > div').append(error);
      },
      highlight: function(e)
      {
        $(e).closest('.form-group').removeClass('has-success has-error').addClass('has-error');
        $(e).closest('.help-block').remove();
      },
      success: function(e)
      {
        e.closest('.form-group').removeClass('has-success has-error');
        e.closest('.help-block').remove();
      }      
    });
  }
}
