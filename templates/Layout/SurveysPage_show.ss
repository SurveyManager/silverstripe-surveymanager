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
                    <label for="surveyTitle">Survey Title: <sub>(ID:$ID)</sub></label>
                  </div>
                  <div class="col-md-9">
                    <input id="Survey--$ID--Title" type="text" name="Survey--$ID--Title" class="form-control" value="$Title" />
                    <input id="surveyID" type="hidden" value="$ID" name="surveyID"/>
                  </div>
                  <div class="col-md-3">
                    <label for="description">Survey Description:</label>
                  </div>
                  <div class="col-md-9">
                    <input id="Survey--$ID--Txt" type="text" name="Survey--$ID--Txt" class="form-control" value="$Description" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <% end_with %>

      <% loop $Questions %>
      <div class="row questions" qid="$ID">
        <div class="col-md-7 ">
          <button class="btn btn-danger delete-question" title="Delete Question">x</button>
          <div class="panel panel-default">
            <div class="panel-body">
              <div class="row">
                <div class="col-xs-3">
                  <label for="questionTitle">Question Title:<sup class="qIDv"> (ID:$ID)</sup></label>
                </div>
                <div class="col-xs-9">
                  <input class="form-control questionTitle clear-val" value="$Title" name="Question--$ID--Title">
                  <input type="hidden" value="$ID" class="questionID" />
                </div>
                <div class="col-xs-3">
                  <label for="questionTitle">Question Description:</label>

                </div>
                <div class="col-xs-9">
                  <input class="form-control questionText clear-val" rows="2" name="Question--$ID--Txt" value="$Description" />
                </div>
              </div>
            </div>
            <ul class="list-group">
              <li class="list-group-item">
                <div class="row">
                  <div class="col-xs-3">
                    <label for="">Type of question:</label>
                    <select class="form-control typeOfQuest clear-val" name="Question--$ID--Select">
                        <option<% if $Type == 'text' %> selected <% end_if %>> text</option>
                        <option<% if $Type == 'one' %> selected <% end_if %>> one</option>
                        <option<% if $Type == 'multi' %> selected <% end_if %>> multi</option>
                    </select>
                    <a class="btn btn-success addNewAnswer" title="">New Option</a>
                  </div>
                  <div class="col-xs-9">
                    <div class="answers">
                      <% loop $QuestionOptions %>
                      <div class="item-option">
                        <span style="position: absolute;font-size: 10px;right: 60px;">(ID:$ID)</span>
                        <input type="text" class="form-control optionText clear-val" value="$Option" name="Option--$ID--Txt" />
                        <!-- <input type="hidden" value="$ID" class="optionID" /> -->
                        <button class="btn btn-danger delete-option" title="Delete Option">x</button>
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
    </form>
    <button class="btn btn-success addQuestion fixedButton">+</button>

    <nav style="display:none" class="survey-control-panel navbar navbar-default navbar-fixed-bottom">
      <div class="container">
        <!-- <button class="btn btn-primary saveSurvey fixedButton">Save Survey</button> -->
        <p class="alert" role="alert">...</p>
      </div>
    </nav>
    <div id="circleG" class="spinner">
      <div class="save-msg">Ajax request...</div>
      <div id="circleG_1" class="circleG"></div>
      <div id="circleG_2" class="circleG"></div>
      <div id="circleG_3" class="circleG"></div>
    </div>
  </div>
</section>
