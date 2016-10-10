@section('head')
@parent
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@stop

<div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
    <label for="g-recaptcha-response" class="col-md-4 control-label">Captcha</label>

    <div class="col-md-6">
        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY', '') }}"></div>

        @if ($errors->has('g-recaptcha-response'))
            <span class="help-block">
                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
            </span>
        @endif
    </div>
</div>