<div class="modal hide fade" id="login_modal">
  <div class="modal-header">
    <a class="close" data-dismiss="modal">×</a>
    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" data-target="#login_tab">Login</a></li>
      <li><a data-toggle="tab" class='btn-primary' style='color:#fff;' data-target="#signup_tab">Sign Up</a></li>
    </ul>
  </div>
  <div class="modal-body tab-content">
    <div class="tab-pane active" id="login_tab">
      <div id="alert_area_login"></div>
      <form class="form-horizontal" id="login_form">
        <fieldset>
        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="email">E-mail</label>
          <div class="controls">
            <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
          </div>
        </div>
     
        <div class="control-group">
          <!-- Password-->
          <label class="control-label" for="password">Password</label>
          <div class="controls">
            <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
          </div>
        </div>
        </fieldset>
        <button type="submit" class="btn btn-success btn-block" >Log In</button>
      </form>
    </div>
    <div class="tab-pane" id="signup_tab">
      <div id="alert_area_signup"></div>
      <form class="form-horizontal" id="signup_form">
        <fieldset>
        <div class="control-group">
          <!-- First Name -->
          <label class="control-label" for="first_name">First Name</label>
          <div class="controls">
            <input type="text" id="first_name" name="first_name" placeholder="" class="input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <!-- Last Name -->
          <label class="control-label" for="last_name">Last Name</label>
          <div class="controls">
            <input type="text" id="last_name" name="last_name" placeholder="" class="input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <!-- E-mail -->
          <label class="control-label" for="email">E-mail</label>
          <div class="controls">
            <input type="text" id="email" name="email" placeholder="" class="input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <!-- Date of Birth -->
          <label class="control-label" for="dob">Date of Birth</label>
          <div class="controls">
            <input type="text" value="01/01/1999" data-date-format="mm/dd/yyyy" id="dob" name="dob" >
          </div>
        </div>

        <div class="control-group">
          <!-- Gender -->
          <label class="control-label" for="gender">Gender</label>
          <div class="controls">
            <select name="gender" id="gender" >
              <option value="">Gender</option>
              <option value="male">Male</option>
              <option value="female">Female</option>
            </select>
          </div>
        </div>
     
        <div class="control-group">
          <!-- Password-->
          <label class="control-label" for="password">Password</label>
          <div class="controls">
            <input type="password" id="password" name="password" placeholder="" class="input-xlarge">
          </div>
        </div>

        <div class="control-group">
          <!-- TOS -->
          <div class="controls">
            <label class="checkbox">
                <input type="checkbox" value="checked" id="tos"> I have read & agree to the following <a href="<?=URL.'guidelines'?>">Guidelines</a> & <a href="<?=URL.'privacy_policy'?>">Privacy Policy</a>
            </label>
          </div>
        </div>
        </fieldset>
        <button type="submit" class="btn btn-success btn-block" >Sign Up</button>
      </form>
    </div>
  </div>
</div>