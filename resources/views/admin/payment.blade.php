<!DOCTYPE html>
<html>
<head>
    <title>Inline Paystack Payment</title>
    <script src="https://js.paystack.co/v1/inline.js"></script>
</head>
<body>
    <h2>Admin - Initiate Payment</h2>

    <button onclick="payWithPaystack()">Pay ₦5,000</button>

    <script>
        function payWithPaystack(){
            var handler = PaystackPop.setup({
                key: '{{ env('PAYSTACK_PUBLIC_KEY') }}',
                email: 'user@example.com', // Replace with actual user email
                amount: 500000, // In kobo (₦5000 = 500000)
                currency: "NGN",
                ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                callback: function(response){
                    alert('Payment complete! Reference: ' + response.reference);

                    // Optionally send to your server for verification
                    window.location.href = "/payment/callback?reference=" + response.reference;
                },
                onClose: function(){
                    alert('Payment window closed');
                }
            });
            handler.openIframe();
        }
    </script>
</body>
</html>
