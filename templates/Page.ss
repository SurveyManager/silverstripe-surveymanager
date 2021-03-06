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
    <link href="SurveyManager/css/second.css" rel="stylesheet">     <!-- Second CSS  -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<% include sHeader %>

$Layout

<% include sFooter %>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> -->
    <script src="SurveyManager/javascript/libs.min.js"></script>
    <script>var AbsoluteLink = '$AbsoluteLink'</script>
    <script src="SurveyManager/javascript/main.js"></script>
  </body>
</html>
