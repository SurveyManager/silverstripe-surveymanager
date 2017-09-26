<header>
  <div class="container">
    <div class="row">
      <div class="col-md-5 col-sm-12">
        <div id="logo" class="center-block"><a href="$AbsoluteBaseURL" class=""><img src="SurveyManager/images/logo.png" alt=""></a></div>
      </div>
      <div class="col-md-4">
        <% include sNav %>
      </div>
      <div class="col-md-3">
        <div class="login-btns center-block">
          <% if $CurrentMember %>
          <span>Hi, $CurrentMember.FirstName</span>
          <a href="/login/" class="btn signup">Edit profile</a>
          <a href="/Security/logout" class="btn btn-default login">Log out</a>
          <% else %>
          <a href="/login/" class="btn signup">Sign in</a>
          <a href="/Security/login" class="btn btn-default login">Log in</a>
          <% end_if %>

        </div>
      </div>
    </div>
  </div>
</header>
