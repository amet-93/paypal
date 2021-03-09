$(document).ready(function() {
	var id = $('#segment_id').html();
	var token = $('#token').val();
    $('#ip-info').DataTable( {
        "scrollX": true,
		'searching' : true,
        "processing": true,
        "serverSide": true,
        "ajax": {
        	type: 'POST',
        	url:base_url()+"user/getIpData/"+id,
        	data:{"_token": token}
    	},
        "columns": [
            {data: 'sr_no', name: 'sr_no'},
            {data: 'ip_address', name: 'ip_address'},
            {data: 'visit_date', name: 'visit_date'},
        ]
    } );
} );

function base_url() {
    var pathparts = location.pathname.split('/');
    if (location.host == 'localhost') {
        var url = location.origin+'/'+pathparts[1].trim('/')+'/'; // http://localhost/myproject/
    }else{
        var url = location.origin+'/dashboard/'; // http://stackoverflow.com
    }
    return url;
}