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
      <div class="row survey-title">
          <div class="col-md-7 ">
            <div class="panel panel-default">
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-3">
                    <label for="surveyTitle">Survey Title: (ID:$ID)</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="surveyTitle" class="form-control" id="surveyTitle" value="$Title" />
                    <input type="hidden" value="$ID" id="surveyID" />
                  </div>
                  <div class="col-md-3">
                    <label for="description">Survey Description:</label>
                  </div>
                  <div class="col-md-9">
                    <input type="text" name="description" class="form-control" id="description" value="$Description" />
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
                  <label for="questionTitle">Question Title:<sup class="qIDv"> (ID:$ID)</sup></label>
                </div>
                <div class="col-md-9">
                  <input class="form-control questionTitle" value="$Title" name="questionTitle[$ID]">
                  <input type="hidden" value="$ID" class="questionID" />
                </div>
                <div class="col-md-3">
                  <label for="questionTitle">Question Description:</label>
                  <button class="btn btn-danger delete-question">Delete Question</button>
                </div>
                <div class="col-md-9">
                  <textarea class="form-control questionText" rows="3" id="" name="questionText[$ID]">$Description</textarea>
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
                    <a class="btn btn-success addNewAnswer">New Option</a>
                  </div>
                  <div class="col-md-9">
                    <div class="answers">
                      <% loop $QuestionOptions %>
                      <div class="item-option">
                        <span style="position: absolute;font-size: 10px;right: 60px;">(ID:$ID)</span>
                        <input type="text" class="form-control optionText" value="$Option" name="answer[$ID]" />
                        <input type="hidden" value="$ID" class="optionID" />
                        <button class="btn btn-danger delete-option">x</button>
                      </div>
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
      <button class="btn btn-success addQuestion fixedButton">New Question</button>
      <button class="btn btn-primary saveSurvey fixedButton">Save Survey</button>
    </form>
  </div>
</section>
