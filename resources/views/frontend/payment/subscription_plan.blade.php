<div id="paypal-button-container-P-37333612WD519653UMVTB4RI"></div>
<script src="https://www.paypal.com/sdk/js?client-id=Abn3eQielj87T84iTlxYP9nDp1EodxEUXsirm9yrDCJ2eK6bvytSeoYWru0rhkr0Y4wWuDUYdM813pxg&vault=true&intent=subscription" data-sdk-integration-source="button-factory"></script>
<script>
    paypal.Buttons({
        style: {
            shape: 'rect',
            color: 'gold',
            layout: 'vertical',
            label: 'subscribe'
        },
        createSubscription: function(data, actions) {
            return actions.subscription.create({
                /* Creates the subscription */
                plan_id: 'P-37333612WD519653UMVTB4RI'
            });
        },
        onApprove: function(data, actions) {
            console.log(data);
            // Replace alert with a message on the page or other action
            //document.getElementById('subscription-message').innerText = 'Thank you for your subscription!';
            
            // You can also perform any post-approval actions here
        }
    }).render('#paypal-button-container-P-37333612WD519653UMVTB4RI'); // Renders the PayPal button
</script>
