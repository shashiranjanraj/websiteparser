<!DOCTYPE html>
<html lang="en">
<head>
	<title>Company List</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
<!--===============================================================================================-->
</head>
<body>
	
<div class="container emp-profile">
    <form method="post">
        <div class="row">
         
            <div class="col-md-6">
                <div class="profile-head">
                            <h5>

                               {{$data->name}}

                            <b>{{$data->cin}}</b>
                               
                            </h5>
                            <h6>
                               {{$data->contact->address}}

                            <b>{{$data->contact->email}}</b>
                            </h6>

                </div>
            </div>
            
        </div>
      
            <div class="col-md-8">
                <div class="tab-content profile-tab" id="myTabContent">
                    <div class="tab-pane fade show active" id="home"  aria-labelledby="home-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Status </label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->status}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Age</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->age}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Registration Number</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->registration_number}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Phone</label>
                                    </div>
                                    <div class="col-md-6">
                                        <p>123 456 7890</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>category</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->category}}</p>
                                    </div>
                                </div>
                    </div>
                    <div class="tab-pane show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Class</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->class}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Roc_Code</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->Roc_Code}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>numbers_of_memmber</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->numbers_of_memmber}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Is Listed</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->is_listed}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>	last Agm</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->last_agm}}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Balance Sheet</label>
                                    </div>
                                    <div class="col-md-6">
                                    <p>{{$data->last_balance_sheet}}</p>
                                    </div>
                                </div>
                               
                               

                                <div class="row">
                                    <table class=" table ">
                                        <th>
                                            <td>Name</td>
                                            <td>DIN</td>
                                            <td>POST</td>
                                            <td>Date of Apponment</td>
                                        </th>
                                @foreach($data->directors as $director)
                                        
                                <tr>
                                <td>{{$director->name}}</td>
                                <td>{{$director->din}}</td>
                                <td>{{$director->designation}}</td>
                                <td>{{$director->dateofopinment}}</td>
                            </tr>

                                @endforeach
                            </table>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>           
</div>

<!--===============================================================================================-->	
<script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
	<script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/select2/select2.min.js')}}"></script>
<!--===============================================================================================-->
	<script src="{{asset('vendor/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
	<script>
		$('.js-pscroll').each(function(){
			var ps = new PerfectScrollbar(this);

			$(window).on('resize', function(){
				ps.update();
			})
		});
			
		
	</script>
<!--===============================================================================================-->
	<script src="{{asset('js/main.js')}}"></script>

</body>
</html>