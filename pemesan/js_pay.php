<script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-X8ojNGiJG9fbNr7I"></script>
<script>
    // For example trigger on button clicked, or any time you need
    
    const payment = (token) => {
        // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
        window.snap.pay(token, {
            onSuccess: function(result){
                /* You may add your own implementation here */
                window.location.reload(true);
            },
            onPending: function(result){
                /* You may add your own implementation here */
                window.location.reload(true);           
            },
            onError: function(result){
                /* You may add your own implementation here */
                alert("payment failed!"); console.log(result);
            },
            onClose: function(){
                /* You may add your own implementation here */
                window.location.reload(true);           
            }
        });
        // customer will be redirected after completing payment pop-up
    }
</script>