@section("footer")
  <footer>
  <div class="row">
  <hr>
  <div class="col-lg-4 col-lg-offset-4">
      <p class="text-center">Click <a href="http://support.storybook.cjtinc.org">this link</a> for help.</p>
      <p class="text-center">Please consider donating to support the program.</p>
      <p class="text-center"><a href="" class="btn btn-success" id="customButton">Donate</a></p>
      <meta id="token" name="token" content="{ { csrf_token() } }">

<script src="https://checkout.stripe.com/checkout.js"></script>

<script>
  var handler = StripeCheckout.configure({
    key: 'pk_test_tpCUmLyILXNuWAJbs0sqOIpO',
    image: '/images/logo.gif',
    locale: 'auto',
    token: function(token) {
      // Use the token to create the charge with a server-side script.
      // You can access the token ID with `token.id`
      console.log(token)

      $.ajax({
          beforeSend: function(xhr){xhr.setRequestHeader('X-CSRF-TOKEN', $("#token").attr('content'));},
          url: 'donate',
          type: 'post',
          data: {tokenid: token.id, email: token.email},
          success: function(data) {
            if (data == 'success') {
                console.log("Card successfully charged!");
            }
            else {
                console.log("Success Error!");
            }

          },
          error: function(data) {
            console.log("Ajax Error!");
            console.log(data);
          }
        }); // end ajax call
    }
  });

  $('#customButton').on('click', function(e) {
    // Open Checkout with further options
    handler.open({
      name: 'storybook.cjtinc.org',
      description: 'Donation',
      amount: 2000
    });
    e.preventDefault();
  });

  // Close Checkout on page navigation
  $(window).on('popstate', function() {
    handler.close();
  });
</script>



  </div>
  </div>
  </footer>
  
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
  
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-60409601-1', 'auto');
  ga('send', 'pageview');

	</script>
  
@show