@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">
                {{-- <h4>Add Card on MangoPay</h4> --}}
            <form method="post" id="addcardform" action="{{$cardregistrtion->CardRegistrationURL}}" >
                
            <input type="hidden" name="accessKeyRef" value="{{$cardregistrtion->AccessKey}}" required>
            <input type="hidden" name="data" value="{{$cardregistrtion->PreregistrationData}}" required>
            <input type="hidden" name="cardExpirationDate" id="cardExpirationDate" placeholder="mmyy" required>
            {{-- <input type="text" name="cardNumber" value="4242424242424242">
            <input type="text" name="cardExpirationDate" value="0222">
            <input type="text" name="cardCvx" value="123"> --}}
                <div class="credit-card-input no-js" id="skeuocard">
                    <p class="no-support-warning">
                      Either you have Javascript disabled, or you're using an unsupported browser, amigo! That's why you're seeing this old-school credit card input form instead of a fancy new Skeuocard. On the other hand, at least you know it gracefully degrades...
                    </p>
                    <label for="cc_type">Card Type</label>
                    <select name="cc_type">
                      <option value="">...</option>
                      <option value="visa">Visa</option>
                      <option value="discover">Discover</option>
                      <option value="mastercard">MasterCard</option>
                      <option value="maestro">Maestro</option>
                      <option value="jcb">JCB</option>
                      <option value="unionpay">China UnionPay</option>
                      <option value="amex">American Express</option>
                      <option value="dinersclubintl">Diners Club</option>
                    </select>
                    <label for="cc_number">Card Number</label>
                    <input type="text" name="cardNumber" id="cc_number" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" size="19" required>
                    <label for="cc_exp_month">Expiration Month</label>
                    <input type="text" name="cc_exp_month" id="cc_exp_month" placeholder="00">
                    <label for="cc_exp_year">Expiration Year</label>
                    <input type="text" name="cc_exp_year" id="cc_exp_year" placeholder="00">
                    <label for="cc_name">Cardholder's Name</label>
                    <input type="text" name="cc_name" id="cc_name" placeholder="John Doe">
                    <label for="cc_cvc">Card Validation Code</label>
                    <input type="text" name="cardCvx" id="cc_cvc" placeholder="123" maxlength="3" size="3" required>
                  </div>
                  <button type="submit" class="saveBtn active" id="submit"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><strong class="btn-content">Save Card</strong></button>
                </form>
            </div>
        </div>
    </div>
</section>
<style>
    .skeuocard.js{
        margin:auto;
    }
    .skeuocard.js .flip-tab.prompt.back p,.skeuocard.js .flip-tab.warn.back p,.skeuocard.js .flip-tab.warn.front p {
    font-size: 15px;
}
.skeuocard.js .flip-tab.prompt.front p {
    font-size: 15px;
}
.saveBtn {
    border-radius: 8px;
    background-color: #E2E2E2;
    color: #FFFFFF;
    font-family: Graphik;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0;
    line-height: 16px;
    height: 48px;
    padding: 10px 40px;
    border: none;
    margin: 20px 0px 10px;
}
form{
    text-align:center
}
    </style>

@endsection
@section('headerScript')
@parent
<link rel="stylesheet" href="{{asset('web/card/styles/skeuocard.reset.css')}}" />
   
<link rel="stylesheet" href="{{asset('web/card/styles/skeuocard.css')}}" />
<script src="{{asset('web/card/javascripts/vendor/cssua.min.js')}}"></script>@endsection
@section('footerScript')
@parent
<script src="{{asset('web/card/javascripts/vendor/jquery-2.0.3.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" src="{{asset('web/js/waitme.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/loader.js')}}"></script>

<script>
$(document).ready(function(){
    $(document).on("change",".cc-exp-field-m,.cc-exp-field-y",function($e){
        $expiredate=$(".cc-exp-field-m").val()+''+$(".cc-exp-field-y").val();
        $("#cardExpirationDate").val($expiredate);
    });
});
</script>
<script src="{{asset('web/card/javascripts/skeuocard.js')}}"></script>
<script>
$(document).ready(function(){
    var isBrowserCompatible = 
        $('html').hasClass('ua-ie-10') ||
        $('html').hasClass('ua-webkit') ||
        $('html').hasClass('ua-firefox') ||
        $('html').hasClass('ua-opera') ||
        $('html').hasClass('ua-chrome');

    if(isBrowserCompatible){
        window.card = new Skeuocard($("#skeuocard"), {
            debug: false
        });
    }
});

$(document).ready(function(){
	$(document).on("submit","#addcardform",function($e){
        $e.preventDefault();
        $(".loader-icon").show();
        $(".btn-content").hide();
       
        $.ajax({
            type:'POST',
            url:'{{$cardregistrtion->CardRegistrationURL}}',
            data:$(this).serialize(),
            success:function(response){
                $(".loader-icon").hide();
                $(".btn-content").show();
                console.log(response);
                $.ajax({
                    type:'POST',
                    url:'{{route("save_card")}}',
                    data:{ "_token": "{{ csrf_token() }}","card_id":"{{$cardregistrtion->Id}}","card_token":response},
                    beforeSend:function(){
                        startLoader('body');
                    },
                    complete:function(){
                        stopLoader('body');
                    },
                    success:function(response){
                        $(".loader-icon").hide();
                        $(".btn-content").show();
                        if(response.ResultMessage=='Success' && response.Status=='VALIDATED'){
                            swal({title: "Card Added Success", text: 'Card added to mangopay successfully', type: "success"}).then(function(){ 
                                    window.location.href = response.backUrl;
                                });
                        }else{
                            swal({title: "OOps", text: 'There is error to add card in mangopay', type: "error"}).then(function(){ 
                                location.reload();
                            });
                        }
                    },
                    error:function(){
                        stopLoader('body');
                    }
                });   
            }
        });
	});
});


</script>
@endsection        