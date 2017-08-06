<!DOCTYPE html>
<html lang="en">
  <head><% base_tag %>
    <% base_tag %>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    $MetaTags(false)

    <title>Survey Manager</title>

    <link href="SurveyManager/css/lib.css" rel="stylesheet">      <!-- Bootstrap -->
    <link href="SurveyManager/css/main.css" rel="stylesheet">     <!-- Main CSS  -->
    <!-- HTML5NG: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<!-- Emmet	 -->
<!-- div.row>div.col-md*3
div+p
(div>p)+div>ul>li
h1{заголовок}
a[src="linlk $"]*5
Lorem
-->
<% include sHeader %>

$Layout

<% include sFooter %>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="SurveyManager/javascript/libs.min.js"></script>
    <script src="SurveyManager/javascript/main.js"></script>
  </body>
</html>
