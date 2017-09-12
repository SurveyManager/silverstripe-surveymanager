<section class="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
          <h1>$Title <!-- <small>DevMark: Layout "SurveyPage.ss"</small></h1> -->
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
              <div class="panel-heading"><span>Surveys list</span>
                <button id="new-survey" class="btn btn-success">Add new Survey</button>
              </div>
              <!-- Table -->
              <table class="table">
                <!-- (tr>th{lorem2}*3)+(tr>lorem2*3)*3 -->
                <tr>
                  <th>Title</th>
                  <th>Description</th>
                  <th>Pin Code</th>
                  <th>Edit</th>
                  <th>Del</th>
                </tr>

<% loop $Surveys %>
    <tr>
        <td><a href="$Link">$Title</a></td>
        <td>$Description</td>
        <td>$PIN</td>
        <td><a href="$Link" class="btn btn-primary">Edit</button></a>
        <td><button class="btn btn-danger del-survey" value="$ID">Delete</button></td>
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
