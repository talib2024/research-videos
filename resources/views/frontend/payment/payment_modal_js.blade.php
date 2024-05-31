
<script>
$(document).ready(function(){

$(".tabs").click(function(){
    
    $(".tabs").removeClass("active");
    $(".tabs h6").removeClass("font-weight-bold");    
    $(".tabs h6").addClass("text-muted");    
    $(this).children("h6").removeClass("text-muted");
    $(this).children("h6").addClass("font-weight-bold");
    $(this).addClass("active");

    current_fs = $(".active");

    next_fs = $(this).attr('id');
    next_fs = "#" + next_fs + "1";

    $("fieldset").removeClass("show");
    $(next_fs).addClass("show");

    current_fs.animate({}, {
        step: function() {
            current_fs.css({
                'display': 'none',
                'position': 'relative'
            });
            next_fs.css({
                'display': 'block'
            });
        }
    });
});

$(document).on("click", ".paymentButton", function () {
     const paypal_video_id = $(this).data('paypal_video_id');
     const paypal_video_price = $(this).data('paypal_video_price');
     const video_amount_RVcoins = $(this).data('video_amount_rvcoins');    
    let user_total_coins = '';
    @auth
        // Set user_total_coins if the user is authenticated
        user_total_coins = "{{ $loggedIn_user_details->total_rv_coins }}";
    @endauth
     $('#video_price_wire_transfer').val(paypal_video_price);
     $('#video_id_wire_transfer').val(paypal_video_id);
     $('#paypal_video_id').val(paypal_video_id);
     $('#video_price_RVcoins').val(video_amount_RVcoins);
     $('#video_id_RVcoins').val(paypal_video_id);
     if(video_amount_RVcoins != '')
     {
        //$('.price_section').html(paypal_video_price+' '+'USD or '+video_amount_RVcoins+' RVcoins');
        $('.price_section').html(paypal_video_price+' '+'USD');
        $('.RVCoinsValue').html(user_total_coins);
        if(user_total_coins < video_amount_RVcoins)
        {
            $('.rvcoinsDivForNoPayment').show();
            $('.rvcoinsDiv').hide();
        }
        else
        {
            $('.rvcoinsDivForNoPayment').hide();
            $('.rvcoinsDiv').show();
        }
     }
     else
     {
        $('.price_section').html(paypal_video_price+' '+'USD');
     }
     

     $('#paypal_video_id_smart').val(paypal_video_id);
     $('#paypal_video_amount').val(paypal_video_price);
     $('#video_amount_RVcoins').val(video_amount_RVcoins);
     $('#paymentModal').modal('show');
});

$(document).on("click", ".wireTransferClick", function () {
     const paypal_video_id = $('#video_id_wire_transfer').val();
     const paypal_video_price = $('#video_price_wire_transfer').val();
     $('#paypal_video_id_wire_transfer').val(paypal_video_id);
     $('.price_section').html(paypal_video_price+' '+'USD');
     $('#paymentModal').modal('hide');
     $('#modalWireTransfer').modal('show');
});

$("#modalWireTransfer").on('hide.bs.modal', function(){
     $('#paymentModal').modal('show');
});

$(document).on("click", ".payByRVcoinsClick", function () {
     const RVcoins_video_id = $('#video_id_RVcoins').val();
     const video_amount_RVcoins_amount = $('#video_amount_RVcoins').val();
     $('#paypal_video_id_wire_transfer').val(RVcoins_video_id);
     $('.RVCoins_price_section').html(video_amount_RVcoins_amount);
     $('#paymentModal').modal('hide');
     $('#modalRVcoins').modal('show');
});

$("#modalRVcoins").on('hide.bs.modal', function(){
     $('#paymentModal').modal('show');
});

});
</script>

<script
    src="https://www.paypal.com/sdk/js?client-id=AYmQ3p4m_LUfHob58WCLGV5XgHPs3kPBtGJRw1cqNUkysjh88kTTS3dsaYufPvEYIOZ0nKiJ_FNSDILA&intent=capture&vault=true">
</script>

<script>
  // Render the PayPal button into #paypal-button-container-video
    	paypal.Buttons({
          	// Set up the transaction
        	createOrder: function(data, actions) {
                var video_amount = $('#paypal_video_amount').val();
            	return actions.order.create({
                	purchase_units: [{
                    	amount: {
                        	value: video_amount
                    	}
                	}]
            	});
        	},

        	// Finalize the transaction
        	onApprove: function(data, actions) {
            	return actions.order.capture().then(function(orderData) {
                	// Successful capture! For demo purposes:
                	//console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                	var transaction = orderData.purchase_units[0].payments.captures[0];
                	/*alert('Transaction '+ transaction.status + ': ' + transaction.id 
                                       + '\n\nSee console for all available details');*/
                    const video_id = $('#paypal_video_id_smart').val();
                    var video_amount = $('#paypal_video_amount').val();
                	var transactionId = transaction.id;
                    var postData = {
                        transaction_id: transactionId,
                        video_id: video_id,
                        video_amount: video_amount
                    };

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: "{{ route('update.paypal.payment.for.single.video') }}",
                        method: 'POST',
                        contentType: 'application/json',
                        data: JSON.stringify(postData),
                        success: function(response) {
                            //console.log('Subscription data sent to server successfully:', response);
                            window.location.href = response.redirect;
                        },
                        error: function(error) {
                            console.error('Error sending data to server:', error);
                        }
                    });
            	});
        	}
    	}).render('#paypal-button-container-video');
</script>