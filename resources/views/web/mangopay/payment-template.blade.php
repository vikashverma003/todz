@extends('web.layouts.app')
@section('title', __('messages.header_titles.HOME'))

@section('content')

<section class="categories-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12 offset-md-0">
                <div id="PaylineWidget" data-token="{{$_GET['token']}}" data-template="column" data-event-didshowstate="OnLoad" data-embeddedredirectionallowed="false"></div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('headerScript')
@parent
<link href="https://homologation-payment.payline.com/styles/widget-min.css" rel="stylesheet" />
{{-- <link href="https://payment.payline.com/styles/widget-min.css" rel="stylesheet"/> --}}

@endsection
@section('footerScript')
@parent
{{-- <script src="https://payment.payline.com/scripts/widget-min.js"> </script> --}}

<script src="https://homologation-payment.payline.com/scripts/widget-min.js"> </script>
<script type="text/javascript">
    // Pour charger le widget
    var urlToken = url_query('token');
    if (urlToken) {
        var element = document.getElementById('PaylineWidget');
        element.setAttribute('data-token', urlToken);
    }
    
    // Parse URL Queries
    function url_query( query ) {
        query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var expr = "[\\?&]"+query+"=([^&#]*)";
        var regex = new RegExp( expr );
        var results = regex.exec( window.location.href );
        if ( results !== null ) {
            return results[1];
        } else {
            return false;
        }
    }
    </script>
    
    <script type="text/javascript">
    // Pour charger le widget
    var urlToken = url_query('token');
    if (urlToken) {
        var element = document.getElementById('PaylineWidget');
        element.setAttribute('data-token', urlToken);
    }
    
    // Parse URL Queries
    function url_query( query ) {
        query = query.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
        var expr = "[\\?&]"+query+"=([^&#]*)";
        var regex = new RegExp( expr );
        var results = regex.exec( window.location.href );
        if ( results !== null ) {
            return results[1];
        } else {
            return false;
        }
    }
    function executeCancelAction() {
                var cancelUrl = Payline.Models.Contexts.ContextManager.getCurrentContext().getCancelUrl();

                //Execution du endToken
                Payline.Api.endToken(null, function () {
                    //Redirection
                    window.location.href = cancelUrl;
                }, null, false);
            }
            function OnLoad() {

Payline.jQuery('.pl-pmContainer .pl-pay-btn-container').after('<a class="cancelButton" style="display:block;cursor:pointer" title="Annuler le paiement">Annuler</a>');
Payline.jQuery('.cancelButton').click(executeCancelAction);
}
    </script>
@endsection