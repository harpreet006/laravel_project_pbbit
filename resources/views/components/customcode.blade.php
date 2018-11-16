  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <!-- login_page  -->
      <div class="modal-content">
       <div class="login-section">
        <div class="modal-header">
                    <h2 class="frm_heading">{{Lang::get('messages.login_top_msg')}} </h2>
          <button type="button" class="close cross_img" data-dismiss="modal">&times;</button>          
        </div>
        <div class="modal-body">.


        <div class="login_page" id="login_page">
            <div class="frm">
                @csrf        
        
                <div class="login_frm">
                  <div class="form-group">
                    <span class="frm-icon"><i class="fas fa-envelope"></i></span>
              
                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}"  placeholder="{{ __('E-Mail Address') }}">
                      <span id="pnit-id-email-error"></span>
                  </div>
                  <div class="form-group">
                    <span class="frm-icon"><i class="fas fa-lock"></i></span>
                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}">
                     <span id="pnit-id-password-error"></span>
                  </div>
				   <div class="form-group">
				     <div class="form-control g-recaptcha" data-sitekey="6Le6KXcUAAAAANOLATBPdYKU6PINCK4Oatw99_7Q"></div>
              <span id="pnit-id-captcha-error"></span>             
				   </div>
				  
                                   
                  <button type="submit" class="btn btn-primary login" id="ajaxSubmit">{{Lang::get('messages.login_btn')}}</button>
                  <div id="pbt-result-login"></div>
                   <div class="checkbox checkbox-primary checked">
                        <input id="checkbox1" type="checkbox">
                        <label for="checkbox1">
                           <span class="check-span"> {{Lang::get('messages.login_remember_msg')}}</span>
                        </label>
                    </div>
                  
                    <i href="#" class="forgot_paswrd" id="pbit-fgt-pass">{{Lang::get('messages.forget_password_msg')}}</i>
                    <div class="inner-line">
                    <div class="or">{{Lang::get('messages.or_msg')}}
                    </div>
                    <div class="hr_line1"></div>
                    </div>               
                  
                    <p class="account-text">{{Lang::get('messages.dont_have_account_msg')}} <i href="#" class="sign-up" id="pbit-opn-signup">{{Lang::get('messages.signup_btn')}} </i></p>
                        <div class="hr_line"></div>
                    <p class="frm_pargh">{{Lang::get('messages.by_signup_agree_msg')}}</p>

                </div>
            </div>
        </div>  
    

        </div>

        </div>
        <!--Login  section  -->
<!--Signup  section  -->
 <div class="signup-section" style="display: none">
                <div class="login_page">
            <div class="frm">
               @csrf  
     <!--        <a href="#" class="cross_img">X</a> -->
               <button type="button" class="close cross_img" data-dismiss="modal">&times;</button>  
            <h2 class="frm_heading">{{Lang::get('messages.signup_start_learn_msg')}} </h2>
                
            <div class="login_frm">
                
    
                 <div class="form-group">
                    <span class="frm-icon"><i class="fas fa-user"></i></span>
                    <input type="name" class="form-control" id="exampleInputname" aria-describedby="emailHelp" placeholder="Full Name">
                    <span class="error name"></span>
                  </div>
                  <div class="form-group">
                    <span class="frm-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email">                      
                       <span class="error email"></span>
                  </div>
                  <div class="form-group">
                    <span class="frm-icon"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                       <span class="error password"></span>
                  </div>
                  <div class="checkbox checkbox-primary checkeds">
                        <input id="checkbox2" value="" name="rcheckbox" type="checkbox">
                        <label for="checkbox2">
                           <span class="check-span"> {{Lang::get('messages.personal_recomm_msg')}}</span>
                        </label>
                    </div>
				  <div class="form-group">
				<!--   <div class="form-control g-recaptcha" data-sitekey="6LfcOnUUAAAAAJT6m2XaeucFtgnreajcLJBOwDE1"></div> -->
               <span id="pnit-sig-captcha-error"></span>   
				  </div>
				  
                  <button type="submit" class="btn btn-primary  signup">{{Lang::get('messages.signup_btn')}}</button>  
                    <p class="account-text">{{Lang::get('messages.already_account_msg')}} <i href="#" class="sign-up"  id="pbit-opn-login"> {{Lang::get('messages.login_btn')}} </i></p>
                        <div class="hr_line"></div>
                    <p class="frm_pargh">{{Lang::get('messages.by_signup_agree_msg')}} </p>
                </div>
                
            </div>
        </div>
    </div>
     <!--Signup  section  -->
      
 <div class="forgetpass-section" id="pbit-forget-pass-sect" style="display: none">
    <!--forgot password  -->
     @csrf  
        <div class="login_page">
            <div class="frm">
                    <button type="button" class="close cross_img" data-dismiss="modal">&times;</button>  
                <h2 class="frm_heading">{{Lang::get('messages.forget_password_msg')}}</h2>
                <div class="login_frm">
                  <div class="form-group">
                    <span class="frm-icon"><i class="fas fa-envelope"></i></span>
                    <input type="email" class="form-control" id="forgetpswdEmail" aria-describedby="emailHelp" placeholder="Email"> 
                    <span id="pnit-id-frgt-password-error"></span> 
                  </div>
                  <button type="submit" class="btn btn-primary login reset-btnn">{{Lang::get('messages.reset_password_msg')}}</button>
                   <p class="account-text">{{Lang::get('messages.or_msg')}} <a href="#" class="sign-up" id="pbit-forget-login">{{Lang::get('messages.login_btn')}}</a></p>
                </div>
            </div>
        </div>
        <!--forgot password end -->
    </div>

      </div>
      
    </div>
  </div>