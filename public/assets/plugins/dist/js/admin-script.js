jQuery(document).ready(function(){
	$('.company_approve_calander').datetimepicker({format: 'MMM DD YYYY hh:mm:ss'});
  // $('.company_approve_calander').datetimepicker({format: 'YYYY-MM-DD hh:mm:ss'});
	$('#ClientPasswordExpiration').datepicker({
	    autoclose: true,
	    todayHighlight: true
	});
  $('.datatable-table').DataTable({
    'paging'      : true,
    'lengthChange': true,
    'searching'   : true,
    'ordering'    : true,
    'info'        : true,
    "scrollX"     : true,
    'autoWidth'   : true
  });
  $('#editpassword').click(function(){
    $('#EditClientPassword').attr('name','password');
    $('#EditClientPassword').val('');
    $('#EditClientPassword').attr('disabled',false);
  });
  $('.client-form').validate({ // initialize the plugin
    rules: {
      company_name: {
          required: true,
      },
      certification_level: {
          required: true
      },
      first_name: {
        required: true
      },
      last_name: {
        required: true
      },
      email_provider: {
        required: true
      },
      email_id: {
        required: true
      },
      'password': {
        required: true,
        minlength: 8,
      }
    }
  }); 
  $('#edit-client').validate({ // initialize the plugin
    rules: {
      company_name: {
          required: true,
      },
      certification_level: {
          required: true
      },
      first_name: {
        required: true
      },
      last_name: {
        required: true
      },
      password: {
        required: true,
        minlength: 8,
      }
    }
  });
});
// $(function () {
    
// });