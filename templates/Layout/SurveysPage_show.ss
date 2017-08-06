<section class="header">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="page-header">
          <h1>Edit Survey <small>DevMark: Layout "SurveyPage_show.ss"</small></h1>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="content">
  <div class="container">
    <form method="get">

      <div class="row">
        <div class="col-md-12">

<% with Survey %>

            <div class="form-inline">
              <div class="form-group">
                <label for="surveyTitle">Survey Title:</label>
                <input type="text" class="form-control" id="surveyTitle" placeholder="$Title">
              </div>
              <div class="form-group">
                <label for="description">Survey Description:</label>
                <input type="text" class="form-control" id="description" placeholder="$Description">
              </div>
            </div>
        </div>
      </div>

<% end_with %>

<% loop $Questions %>
      <div class="row">
        <div class="col-md-5">

          <div class="form-group">
            <label for="questionTitle">Question Title:</label>
            <input class="form-control" id="questionTitle" placeholder="$Title">
          </div>
          <div class="form-group">
            <label for="questionText">Question Description:</label>
            <textarea class="form-control" rows="3" id="questionText">$Description</textarea>
          </div>
        </div>
        <div class="col-md-3">
          <label for="">Type of question:</label>

          <select class="form-control">
            <option>Multiple choice</option>
            <option>Checkboxes</option>
            <option>Text</option>
            <option>Liner scale</option>
          </select>

        </div>
      </div>

            <!-- div.row>col-md-6 -->
      <div class="row">
        <div class="col-md-5">
          <div id="answers">
            <input type="text" class="form-control" id=""
              placeholder="Answer#1" name="answer[1]">
          </div>
          <a id="addAnswer" class="btn btn-success">Add answer</a>
        </div>
      </div>
<% end_loop %> 


    </form>
  </div>
</section>
