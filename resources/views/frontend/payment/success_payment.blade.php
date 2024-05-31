@extends('frontend.include.frontendapp')
@section('content')
        
 
         <div id="content-wrapper">
            <div class="container-fluid contact-us-details">
               <div class="row">
                 
                  <div class="col-lg-12">
                     <div class="form-box mar-0">
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                        <br/>
                        <h6 class="red">Transaction ID: </h6>
                        <span> <p>{{ Session::get('transaction_id') }}</p></span>
                        
                     </div>
                  </div>
               </div>     
            </div>
            <!-- /.container-fluid -->



@endsection