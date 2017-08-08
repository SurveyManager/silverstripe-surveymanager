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
    <form method="get"class="question-row-list">
      <% with Survey %>
      <div class="row">
          <div class="col-md-7 ">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <label for="surveyTitle">Survey Title:</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="surveyTitle" value="$Title">
                  </div>
                  <div class="col-md-3">
                    <label for="description">Survey Description:</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" class="form-control" id="description" value="$Description">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <% end_with %>

      <% loop $Questions %>
      <div class="row questions">
        <div class="col-md-7 ">
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3">
                  <label for="questionTitle">Question Title:</label>
                </div>
                <div class="col-md-9">
                  <input class="form-control" id="questionTitle" value="$Title" name="questionTitle[$ID]">
                </div>
                <div class="col-md-3">
                  <label for="questionTitle">Question Description:</label>
                </div>
                <div class="col-md-9">
                  <textarea class="form-control" rows="3" id="questionText" name="questionText[$ID]">$Description</textarea>
                </div>
              </div>
            </div>
            <ul class="list-group">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-md-3">
                    <label for="">Type of question:</label>
                    <select class="form-control typeOfQuest">
                        <option<% if $Type == 'text' %> selected <% end_if %>> text</option>
                        <option<% if $Type == 'one' %> selected <% end_if %>> one</option>
                        <option<% if $Type == 'multi' %> selected <% end_if %>> multi</option>
                    </select>
                    <a class="btn btn-success addNewAnswer">Add answer</a>
                  </div>
                  <div class="col-md-9">
                    <div class="answers">
                      <% loop $QuestionOptions %>
                        <input type="text" class="form-control" value="$Option" name="answer[$ID]">
                      <% end_loop %>

                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <% end_loop %>
      <a class="btn btn-success addQuestion" style="">Add Question</a>
    </form>
  </div>
</section>
