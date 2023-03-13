@if($payment == 'cod') 
                                <input type="hidden" name="method" value="Cash On Delivery">


@endif
@if($payment == 'paypal')
                                <input type="hidden" name="method" value="Paypal">
                                <input type="hidden" name="cmd" value="_xclick">
                                <input type="hidden" name="no_note" value="1">
                                <input type="hidden" name="lc" value="USA">
                                <input type="hidden" name="currency_code" value="{{$curr->name}}">
                                <input type="hidden" name="bn" value="FLAVORsb-dzrii24937800_MP">

@endif
@if($payment == 'squareup')
<script
type="text/javascript"
src="https://sandbox.web.squarecdn.com/v1/square.js"
></script>
  <div>
    {{-- <form id="payment-form"> --}}
      <div id="card-container"></div>
      {{-- <button id="card-button" type="button">Pay $1.00</button>
  </form> --}}
    <div class="square-payment">
      <input type="text" name="token" id="token">
      <input type="text" name="location" id="location-input">
      <input type="text" name="amount" id="amount" value="">
    </div>
  </div>
{{-- @csrf --}}

       
<script>
    const appId = 'sandbox-sq0idb-e38ui8XLKdoICmR4hT9LIA';
    const locationId = 'LA7TWHG3575JT';

    document.getElementById('location-input').value = locationId;

    async function initializeCard(payments) {
      const card = await payments.card();
      await card.attach('#card-container');

      return card;
    }

    async function createPayment(token) {
      const body = JSON.stringify({
        locationId,
        sourceId: token,
      });

      const paymentResponse = await fetch('https://dealsondrives.com/payment', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body,
      });

      if (paymentResponse.ok) {
        return paymentResponse.json();
      }

      const errorBody = await paymentResponse.text();
      throw new Error(errorBody);
    }

    async function tokenize(paymentMethod) {
      const tokenResult = await paymentMethod.tokenize();
      if (tokenResult.status === 'OK') {
        return tokenResult.token;
      } else {
        let errorMessage = `Tokenization failed with status: ${tokenResult.status}`;
        if (tokenResult.errors) {
          errorMessage += ` and errors: ${JSON.stringify(
            tokenResult.errors
          )}`;
        }

        throw new Error(errorMessage);
      }
    }

    // status is either SUCCESS or FAILURE;
    function displayPaymentResults(status) {
      const statusContainer = document.getElementById(
        'payment-status-container'
      );
      if (status === 'SUCCESS') {
        statusContainer.classList.remove('is-failure');
        statusContainer.classList.add('is-success');
      } else {
        statusContainer.classList.remove('is-success');
        statusContainer.classList.add('is-failure');
      }

      statusContainer.style.visibility = 'visible';
    }

      document.addEventListener('DOMContentLoaded', async function () {
        if (!window.Square) {
          throw new Error('Square.js failed to load properly');
        }

        let payments;
        try {
          payments = window.Square.payments(appId, locationId);
        } catch {
          const statusContainer = document.getElementById(
            'payment-status-container'
          );
          statusContainer.className = 'missing-credentials';
          statusContainer.style.visibility = 'visible';
          return;
        }

        let card;
        try {
          card = await initializeCard(payments);
        } catch (e) {
          console.error('Initializing Card failed', e);
          return;
        }

          // Checkpoint 2.
          async function handlePaymentMethodSubmission(event, paymentMethod) {
            event.preventDefault();

            try {
              // disable the submit button as we await tokenization and make a payment request.
              cardButton.disabled = true;
              const token = await tokenize(paymentMethod);
              document.getElementById('token').value = token;
              const paymentResults = await createPayment(token);
              displayPaymentResults('SUCCESS');

              console.debug('Payment Success', paymentResults);
            } catch (e) {
              cardButton.disabled = false;
              displayPaymentResults('FAILURE');
              console.error(e.message);
            }
          }

          const cardButton = document.getElementById('card-button');
          cardButton.addEventListener('click', async function (event) {
          await handlePaymentMethodSubmission(event, card);
      });
    });
</script>
@endif

                                {{-- @if($payment == 'stripe')

                                <div>
                                  <input type="hidden" name="method" value="Stripe">
                                  <div class="row mt-2 stripe-payment" >
                                    <div class="col-lg-6">
                                      <input class="form-control card-elements" required name="cardNumber" type="text" placeholder="{{ $langg->lang163 }}" autocomplete="off" value="{{ old('cardNumber') }}"  autofocus oninput="validateCard(this.value);" />
                                      <span id="errCard"></span>
                                    </div>
                                    <div class="col-lg-6">
                                      <input class="form-control card-elements" required name="cardCVC" type="text" placeholder="{{ $langg->lang164 }}" autocomplete="off" value="{{ old('cardCVC') }}"  oninput="validateCVC(this.value);" />
                                      <span id="errCVC"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control card-elements" required name="month">
                                            <option value="01" {{ old('month') == "01" ? 'selected': '' }}>01</option>
                                            <option value="02" {{ old('month') == "02" ? 'selected': '' }}>02</option>
                                            <option value="03" {{ old('month') == "03" ? 'selected': '' }}>03</option>
                                            <option value="04" {{ old('month') == "04" ? 'selected': '' }}>04</option>
                                            <option value="05" {{ old('month') == "05" ? 'selected': '' }}>05</option>
                                            <option value="06" {{ old('month') == "06" ? 'selected': '' }}>06</option>
                                            <option value="07" {{ old('month') == "07" ? 'selected': '' }}>07</option>
                                            <option value="08" {{ old('month') == "08" ? 'selected': '' }}>08</option>
                                            <option value="09" {{ old('month') == "09" ? 'selected': '' }}>09</option>
                                            <option value="10" {{ old('month') == "10" ? 'selected': '' }}>10</option>
                                            <option value="11" {{ old('month') == "11" ? 'selected': '' }}>11</option>
                                            <option value="12" {{ old('month') == "12" ? 'selected': '' }}>12</option>
                                        </select>
                                      <!--<input class="form-control card-elements" name="month" type="text" placeholder="{{ $langg->lang165 }}"  />-->
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control card-elements" required name="year">
                                            <option value="2021" {{ old('year') == "2021" ? 'selected': '' }}>2021</option>
                                            <option value="2022" {{ old('year') == "2022" ? 'selected': '' }}>2022</option>
                                            <option value="2023" {{ old('year') == "2023" ? 'selected': '' }}>2023</option>
                                            <option value="2024" {{ old('year') == "2024" ? 'selected': '' }}>2024</option>
                                            <option value="2025" {{ old('year') == "2025" ? 'selected': '' }}>2025</option>
                                            <option value="2026" {{ old('year') == "2026" ? 'selected': '' }}>2026</option>
                                            <option value="2027" {{ old('year') == "2027" ? 'selected': '' }}>2027</option>
                                            <option value="2028" {{ old('year') == "2028" ? 'selected': '' }}>2028</option>
                                            <option value="2029" {{ old('year') == "2029" ? 'selected': '' }}>2029</option>
                                            <option value="2030" {{ old('year') == "2030" ? 'selected': '' }}>2030</option>
                                        </select>
                                      <!--<input class="form-control card-elements" name="year" type="text" placeholder="{{ $langg->lang166 }}"  />-->
                                    </div>
                                  </div>
                                  <div style="margin-top: 10px;">
                                    <img style="display: flex; width: 60%; height: 50px; object-fit: contain; margin:auto;" src="{{asset('assets/images/checkout/Powered_By_Stripe_edt.png')}}" width="100" height="10" alt="">
                                  </div>
                                <div>


                                  <script type="text/javascript" src="{{ asset('assets/front/js/payvalid.js') }}"></script>
                                  <script type="text/javascript" src="{{ asset('assets/front/js/paymin.js') }}"></script>
                                  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                                  <script type="text/javascript" src="{{ asset('assets/front/js/payform.js') }}"></script>


                                  <script type="text/javascript">
                                      var cnstatus = false;
                                      var dateStatus = false;
                                      var cvcStatus = false;
                                  
                                      function validateCard(cn) {
                                        cnstatus = Stripe.card.validateCardNumber(cn);
                                        if (!cnstatus) {
                                          $("#errCard").html('{{ $langg->lang781 }}');
                                        } else {
                                          $("#errCard").html('');
                                        }
                                      }
                                  
                                      function validateCVC(cvc) {
                                        cvcStatus = Stripe.card.validateCVC(cvc);
                                        if (!cvcStatus) {
                                          $("#errCVC").html('{{ $langg->lang782 }}');
                                        } else {
                                          $("#errCVC").html('');
                                        }
                                      }
                                
                                  </script>

                                @endif --}}

                                {{-- Square Payment  --}}
                                @if($payment == 'stripe')

                                <div>
                                  <input type="hidden" name="method" value="Stripe">
                                  <div class="row mt-2 stripe-payment" >
                                    <div class="col-lg-6">
                                      <input class="form-control card-elements" required name="cardNumber" type="text" placeholder="{{ $langg->lang163 }}" autocomplete="off" value="{{ old('cardNumber') }}"  autofocus oninput="validateCard(this.value);" />
                                      <span id="errCard"></span>
                                    </div>
                                    <div class="col-lg-6">
                                      <input class="form-control card-elements" required name="cardCVC" type="text" placeholder="{{ $langg->lang164 }}" autocomplete="off" value="{{ old('cardCVC') }}"  oninput="validateCVC(this.value);" />
                                      <span id="errCVC"></span>
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control card-elements" required name="month">
                                            <option value="01" {{ old('month') == "01" ? 'selected': '' }}>01</option>
                                            <option value="02" {{ old('month') == "02" ? 'selected': '' }}>02</option>
                                            <option value="03" {{ old('month') == "03" ? 'selected': '' }}>03</option>
                                            <option value="04" {{ old('month') == "04" ? 'selected': '' }}>04</option>
                                            <option value="05" {{ old('month') == "05" ? 'selected': '' }}>05</option>
                                            <option value="06" {{ old('month') == "06" ? 'selected': '' }}>06</option>
                                            <option value="07" {{ old('month') == "07" ? 'selected': '' }}>07</option>
                                            <option value="08" {{ old('month') == "08" ? 'selected': '' }}>08</option>
                                            <option value="09" {{ old('month') == "09" ? 'selected': '' }}>09</option>
                                            <option value="10" {{ old('month') == "10" ? 'selected': '' }}>10</option>
                                            <option value="11" {{ old('month') == "11" ? 'selected': '' }}>11</option>
                                            <option value="12" {{ old('month') == "12" ? 'selected': '' }}>12</option>
                                        </select>
                                      <!--<input class="form-control card-elements" name="month" type="text" placeholder="{{ $langg->lang165 }}"  />-->
                                    </div>
                                    <div class="col-lg-6">
                                        <select class="form-control card-elements" required name="year">
                                            <option value="2021" {{ old('year') == "2021" ? 'selected': '' }}>2021</option>
                                            <option value="2022" {{ old('year') == "2022" ? 'selected': '' }}>2022</option>
                                            <option value="2023" {{ old('year') == "2023" ? 'selected': '' }}>2023</option>
                                            <option value="2024" {{ old('year') == "2024" ? 'selected': '' }}>2024</option>
                                            <option value="2025" {{ old('year') == "2025" ? 'selected': '' }}>2025</option>
                                            <option value="2026" {{ old('year') == "2026" ? 'selected': '' }}>2026</option>
                                            <option value="2027" {{ old('year') == "2027" ? 'selected': '' }}>2027</option>
                                            <option value="2028" {{ old('year') == "2028" ? 'selected': '' }}>2028</option>
                                            <option value="2029" {{ old('year') == "2029" ? 'selected': '' }}>2029</option>
                                            <option value="2030" {{ old('year') == "2030" ? 'selected': '' }}>2030</option>
                                        </select>
                                      <!--<input class="form-control card-elements" name="year" type="text" placeholder="{{ $langg->lang166 }}"  />-->
                                    </div>
                                  </div>
                                  <div style="margin-top: 10px;">
                                    <img style="display: flex; width: 60%; height: 50px; object-fit: contain; margin:auto;" src="{{asset('assets/images/checkout/Powered_By_Stripe_edt.png')}}" width="100" height="10" alt="">
                                  </div>
                                <div>


                                  <script type="text/javascript" src="{{ asset('assets/front/js/payvalid.js') }}"></script>
                                  <script type="text/javascript" src="{{ asset('assets/front/js/paymin.js') }}"></script>
                                  <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
                                  <script type="text/javascript" src="{{ asset('assets/front/js/payform.js') }}"></script>


                                  <script type="text/javascript">
                                      var cnstatus = false;
                                      var dateStatus = false;
                                      var cvcStatus = false;
                                  
                                      function validateCard(cn) {
                                        cnstatus = Stripe.card.validateCardNumber(cn);
                                        if (!cnstatus) {
                                          $("#errCard").html('{{ $langg->lang781 }}');
                                        } else {
                                          $("#errCard").html('');
                                        }
                                      }
                                  
                                      function validateCVC(cvc) {
                                        cvcStatus = Stripe.card.validateCVC(cvc);
                                        if (!cvcStatus) {
                                          $("#errCVC").html('{{ $langg->lang782 }}');
                                        } else {
                                          $("#errCVC").html('');
                                        }
                                      }
                                
                                  </script>

                                @endif

                                {{-- End Square Payment  --}}


@if($payment == 'instamojo') 
                                	<input type="hidden" name="method" value="Instamojo">

@endif


@if($payment == 'paystack') 
                              
        <input type="hidden" name="ref_id" id="ref_id" value="">
        <input type="hidden" name="sub" id="sub" value="0">
		    <input type="hidden" name="method" value="Paystack">





@endif

@if($payment == 'razorpay') 

                                  <input type="hidden" name="method" value="Razorpay">

@endif

@if($payment == 'molly') 
                                  <input type="hidden" name="method" value="Molly">

@endif


@if($payment == 'other') 

                                <input type="hidden" name="method" value="{{ $gateway->title }}">

                                  <div class="row" >

<div class="col-lg-12 pb-2">
	
	{!! $gateway->details !!}

</div>


<div class="col-lg-6">
	<label>{{ $langg->lang167 }} *</label>
	<input class="form-control" name="txn_id4" type="text" placeholder="{{ $langg->lang167 }}"  />
</div>


  </div>
@endif