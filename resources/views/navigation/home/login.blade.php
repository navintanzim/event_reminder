<div class="col-md-5 col-lg-6">
    <div class="signup-content flex-center @if(env('IS_MOBILE') == true) col-lg-start-50 col-md-start-50 col-sm-start-50 @endif" >
        <div class="signup-header">
            <h3>User Access</h3>
        </div>
        <form>
            <div class="signup-body">
            <a class="btn btn-primary ebs-login" href="<?php echo  (new \App\Http\Controllers\KeycloakController())->getRedirectUrl() ?>">Log In</a>
                <!-- <a class="fp-text" href="{{$forgetPassword_link}}">Forget Password ?</a> -->
                <!-- <div class="bdr-text"><span>or</span></div> -->
                <!-- <p><span style="font-size: 14px; font-family: poppins, sans-serif;">New User ?</span><a class="fp-text" style="display: inline;" href="{{$signUp_link}}"> Sign Up</a></p> -->
            </div>
        </form>
        <div class="signup-footer text-center mt-3">
            <span>Powered by <br>
                <a class="mt-2 d-block" href="https://batworld.com/ossp-one-stop-service-platform/">
                    <img src="/home/images/logo-ossp-prb.jpeg" alt="logo-ossp" style="max-width: 50%">
                </a>
            </span>
        </div>
    </div>
</div>