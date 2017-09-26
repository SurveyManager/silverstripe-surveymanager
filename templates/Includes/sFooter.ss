<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-3 col-sm-6">
        <div class="logoFooter"><img src="SurveyManager/images/logo-footer.png" alt=""></div>
      </div>
      <div class="col-md-4 col-sm-6">
        <div class="navFooter">
          <ul>
            <!-- <li class="current"><a href="#">Home</a></li>
            <li><a href="#">Page1</a></li>
            <li><a href="#">Page2</a></li> -->
            <% loop $Menu(1) %>
              <li class="$LinkingMode">
                <a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
              </li>
            <% end_loop %>
          </ul>
        </div>
      </div>
      <div class="col-md-5 col-sm-12">
        <form class="subscribe" action="#" method="post">
          <span>@</span>
          <input type="text" name="" value="">
          <button class="btn" type="button" name="">Subscibe</button>
        </form>
      </div>
    </div>
  </div>
</footer>
<div id="copyright">Copyright 2017 Survey Manager</div>
