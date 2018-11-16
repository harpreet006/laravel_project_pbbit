<html lang="en">
<head>
<meta charset="UTF-8">
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">
<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
</head>

<body>
    <div class="container">
        <div class='row'>
            <div class='col-md-4'></div>
            <div class='col-md-4'>
                <form accept-charset="UTF-8" action="{{route('payment_test')}}" id="payment-form" method="post">
                    {{ csrf_field() }}
                    <div class='form-row'>
                        <div class='col-xs-12 form-group required'>
                            <label class='control-label'>Name on Card</label> 
                            <input  class='form-control' name="name_on_card" size='4' type='text' class="form-control{{ $errors->has('card') ? ' is-invalid' : '' }}" >
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-12 form-group card required'>
                            <label class='control-label'>Card Number</label> 
                            <input autocomplete='off'  name="card_number"  size='20'  type='text' class="form-control{{ $errors->has('card') ? ' is-invalid' : '' }}" >
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-xs-4 form-group cvc required'>
                            <label class='control-label'>CVC</label> <input
                                autocomplete='off' name="cvc" class="form-control{{ $errors->has('cvc') ? ' is-invalid' : '' }}"
                                placeholder='ex. 311' size='4' type='text'>
                        </div>
                        <div class='col-xs-4 form-group expiration required'>
                            <label class='control-label'>Exp Month</label>
                            <input class="form-control{{ $errors->has('expiry_month') ? ' is-invalid' : '' }}" placeholder='MM' size='2' type='text' name="expiry_month" >
                        </div>
                        <div class='col-xs-4 form-group expiration required'>
                            <label class='control-label'>Exp Year </label> <input
                                class="form-control{{ $errors->has('expiry_year') ? ' is-invalid' : '' }}" placeholder='YYYY'
                                size='4' type='text' name="expiry_year">
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-md-12 form-group'>
                            <button class='form-control btn btn-primary submit-button'
                                type='submit' style="margin-top: 10px;">Pay »</button>
                        </div>
                    </div>
                    <div class='form-row'>
                        <div class='col-md-12 error form-group hide'>
                            <div class='alert-danger alert'>Please correct the errors and try
                                again.</div>
                        </div>
                    </div>
                </form>
                @if ((Session::has('success-message')))
                <div class="alert alert-success col-md-12">{{
                    Session::get('success-message') }}</div>
                @endif @if ((Session::has('fail-message')))
                <div class="alert alert-danger col-md-12">{{
                    Session::get('fail-message') }}</div>
                @endif
            </div>
            <div class='col-md-4'></div>
        </div>
    </div>
</body>
</html>