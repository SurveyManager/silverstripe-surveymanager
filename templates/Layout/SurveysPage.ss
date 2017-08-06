<section class="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
          <h1>$Title <small>DevMark: Layout "SurveyPage.ss"</small></h1>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

    <section class="content">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Panel heading</div>
              <!-- Table -->
              <table class="table">
                <!-- (tr>th{lorem2}*3)+(tr>lorem2*3)*3 -->
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>*</th>
                </tr>

<% loop $Surveys %>
    <tr>
        <td><a href="$Link">$Title</a></td>
        <td>$Description</td>
        <td>$PIN</td>
    </tr>
<% end_loop %>                
                
              </table>
<!-- <div>TestFields: $GridField</div> -->
            </div>

          </div>
        </div>
      </div>
    </section>
		
      </div>
    </div>
  </div>
</section>