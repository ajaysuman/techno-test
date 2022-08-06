<!DOCTYPE html>
<html>
<head>
    <title>Practical Task</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
   	 
   	  <style type="text/css">
    	
   	  #booking_data {
		    display: none;
		    width: 62%;
		    margin-left: 16%;
		    margin-top: 6%;
		  }
		  .errors{
		      color: red;
		  };
		  div#formBooking {
		    background: burlywood;
		  }

		  button.addBooking.btn-primary {
		      margin-left: 87%;
		      margin-bottom: 2%;
		  }
		  a#softdelete {
		      width: 54%;
		  }
		  a#edit {
		      width: 42%;
		  }

		  img#filesize {
		      width: 100px;
		      height: 70px;
		      margin-top: 5px;
		  }
	 
        a#edit {
            width: 41%;
            margin-left: -6px;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <br>
        <h1> Booking Show Record </h1>
        <br>
          <button type="submit" class="addBooking btn-primary"> Add Booking </button>
        <div id="slide-table">
         <table class="table table-bordered data-table">
            <thead>
                <tr>
                	<th>No</th>
                    <th>Name</th>
	                <th>Email</th>
	                <th>bookingtype</th>
	                <th>bookingdate</th>
	                <th>bookingslot</th>
	                <th>bookingtime</th>
	                <th>Action</th>
	            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    </div>
</body>
    

  <!-- For Booking Form -->
     <div id="formBooking">
     
        <form id="booking_data" class="form-horizontal" enctype="multipart/form-data">
           {{ csrf_field() }}
           <h2> Bookings Form </h2><br></br>
           <div class="row">
                 <input type="hidden" class="bookingId form-control" name="id" id="bookingId">
                <div class="col-auto">
                    <label class="visually-hidden" for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="Fill Name">
                    <span id="name_err" class="errors"> </span>
                </div>
                 <div class="col-auto">
                    <label class="visually-hidden" for="name">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="Fill Email">
                    <span id="email_err" class="errors"> </span>
                </div>

                <div class="col-auto">
                    <label class="visually-hidden" for="name">Booking Type</label>
                    <SELECT class="form-control" name="bookingtype" id="bookingtype">
                    	<OPTION Value="">Select Booking Type</OPTION>
 						<OPTION Value="fullday">Full Day</OPTION>
						<OPTION Value="halfday">Half Day</OPTION>
					</SELECT>
                    <span id="bookingtype_err" class="errors"> </span>
                </div><br><br></br></br>

                <div class="col-auto">
                    <label class="visually-hidden" for="name">Booking Date</label>
                    <input type="date" class="form-control" name="bookingdate" id="bookingdate">
                    <span id="bookingdate_err" class="errors"> </span>
                </div>

                <div class="col-auto">
                    <label class="visually-hidden" for="name">Booking Slot</label>
                     <SELECT  class="form-control" name="bookingslot" id="bookingslot">
                     	<OPTION Value="">Select Booking Slot</OPTION>
 						<OPTION Value="morning">Morning</OPTION>
						<OPTION Value="evening">Evening</OPTION>
					</SELECT>
                    <span id="bookingslot_err" class="errors"> </span>
                </div>

                <div class="col-auto">
                    <label class="visually-hidden" for="name">Booking Time</label>
                    <input type="time" class="form-control" name="bookingtime" id="bookingtime">  
                    <span id="bookingtime_err" class="errors"> </span>
                </div>
            </div><br>
            <button type="submit" class="btn btn-primary" name="submit">Create Booking</button>
        </form>
    </div>




<script type="text/javascript">
  $(function () {
  	// For DataTable
  	 var token = $("meta[name='csrf-token']").attr("content");
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('bookings.index') }}",
        columns: [
        	{data: 'id', name: 'id'},
         	{data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'bookingtype', name: 'bookingtype'},
            {data: 'bookingdate', name: 'bookingdate'},
            {data: 'bookingslot', name: 'bookingslot'},
            {data: 'bookingtime', name: 'bookingtime'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
 	 

 // Show Form 
    $(".addBooking").on("click",function(e) { 
        var bookingId  = $('#bookingId').val(''); 
        $("#booking_data").show();
        $('.data-table').DataTable().ajax.reload();
        $('#booking_data')[0].reset();
        $('#name_err').text('');
        $('#email_err').text('');
        $('#bookingtype_err').text('');
        $('#bookingdate_err').text('');
        $('#bookingslot_err').text('');
        $('#bookingtime_err').text('');
    });

	// Add New Booking
    $('#booking_data').submit(function(e) {
        e.preventDefault(); 
        var bookingId  = $('#bookingId').val();
        var name  = $('#name').val();
        var email= $('#email').val();
        var bookingtype = $('#bookingtype').val();
        var bookingdate = $('#bookingdate').val();
        var bookingslot = $('#bookingslot').val();
        var bookingtime = $('#bookingtime').val();
        var datas = new FormData(this);
	    if(name ==""){
            $('#name_err').text('Field Is Required');
        }if(email ==""){
            $('#email_err').text('Email Is Required');
        }
        if(bookingtype ==""){
            $('#bookingtype_err').text('Field Is Required');
        }
        if(bookingdate ==""){
            $('#bookingdate_err').text('Field Is Required');
        }
        if(bookingslot ==""){
            $('#bookingslot_err').text('Field Is Required');
        }
        if(bookingtime ==""){
            $('#bookingtime_err').text('Field Is Required');
        }
        // ++++++++++++++ For Update +++++++++++
        if(bookingId != ""){
        	$.ajax({
        		 headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
           		url: 'bookingsUpdate',
                type: 'post',
                data:  new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                 success: function(response){ console.log(response.status);
                 	$('.data-table').DataTable().ajax.reload();
                    $("#booking_data").fadeOut();
                    $('#booking_data')[0].reset();
                    // $('#name_err').text('');
                    $('#email_err').text('');
                    $('#bookingtype_err').text('');
                    $('#bookingdate_err').text('');
                    $('#bookingslot_err').text('');
                    $('#bookingtime_err').text('');
                    if(response.status == '200'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Update Booking..!!!!");
                        return false;	
                    } 
                }
            });
        }
        else{  
            $.ajax({
                url: "{{ route('bookings.store') }}",
                type: 'post',
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                 success: function(response){ 
                    $('.data-table').DataTable().ajax.reload();
                    $("#booking_data").fadeOut();
                    $('#booking_data')[0].reset();
                    $('#name_err').text('');
                    $('#email_err').text('');
                    $('#bookingtype_err').text('');
                    $('#bookingdate_err').text('');
                    $('#bookingslot_err').text('');
                    $('#bookingtime_err').text('');
                    if(response.status == '1'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Insert New Booking..!!!!");
                        return false;	
                    } 
                    if(response.status == '2'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Not Booking Available This Date..!!!!");
                        return false;	
                    } 
                    if(response.status == '3'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error("Available Only Evening halfday Bookings..!!!!");
                        return false;	
                    } 
                    if(response.status == '4'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Insert halfday Evening Bookings..!!!!");
                        return false;	
                    } 
                    if(response.status == '5'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error("Available Only Morning halfday Bookings..!!!!");
                        return false;	
                    } 
                     if(response.status == '4'){
                    	toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Insert halfday Morning Bookings..!!!!");
                        return false;	
                    } 
                }
            });
        }
    });
 	
	// For Edit
	$(".data-table").on("click", ".edit", function () {  
        $("#booking_data").show();
        $('#name_err').text('');
        $('#email_err').text('');
        $('#bookingtype_err').text('');
        $('#bookingdate_err').text('');
        $('#bookingslot_err').text('');
        $('#bookingtime_err').text('');

        var id = $(this).closest('tr').find('td:eq(0)').text();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: "bookings/"+id,
            type: 'post',
            data: {"_token": token,id: id},
            success: function(response){ console.log(response);
                var len = response.length;
                for(var i = 0 ; i < len; i++ ){
                    $('#bookingId').val(response[i].id);
                    $('#name').val(response[i].name);
                    $('#email').val(response[i].email);
                    $('#bookingtype').val(response[i].bookingtype);
                    $('#bookingdate').val(response[i].bookingdate);
                    $('#bookingslot').val(response[i].bookingslot);
                    $('#bookingtime').val(response[i].bookingtime);
                }
            }
        });
    });


	
	// For Delete 
	$(".data-table").on("click", ".delete", function (e) {  
     var del_id = $(this).closest('tr').find('td:eq(0)').text();  
    
        if (confirm("Are you sure Delete Items?")) {
            $.ajax({
                url: "bookings/"+del_id,
                type: 'DELETE',
                data: {
                    'id':del_id , "_token": token, },
                success: function(response){
                	console.log(response);
                    $('.data-table').DataTable().ajax.reload();
                        toastr.options =
                        {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success("Delete Data Success..!!!!");
                }
            });
        } else{
          toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
            toastr.warning("Cancle Delete..!!!!");
        }
    });

 });
</script>

</html>