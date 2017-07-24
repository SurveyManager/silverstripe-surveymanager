# silverstripe-surveymanager

## About project
EDENZ college Capstone project. Pluging for SilverStripe CMS to create and manipulate Surveys structure with API for 3rd party applications.

## Description
### Question types
 - `text` - text field
 - `one` - choose one of the item
 - `multi` - choose some of the items
### Question "Other" field
 - text field for one/multi question type

## API
### `auth` Get token (authorization by email and survey PIN)
Example `wget --post-data "email=email1@survey.example&pin=12345" http://site/pagename/API/auth`
### `questions` Get Survey data by token
Example `wget --post-data "token=4x1o7Rlou4iR..." http://site/pagename/API/questions`
### `save` Save survey result by question
 - d[SH]=sdfsddfs - SurveyHash - unique for survey to group questions (varchar(50)), generate by application
 - d[QH]=4352334534 - QuestionHash - unique for any question/option (varchar(128)), generate by application only for sync functions to prevent duplicates after offline sync
 - d[qid]=1 - Question ID, (int), get from `questions` result
 - d[oid]=2 - Option ID (int),for multi options multi request with unique QuestionsHash any time, get from `questions` result
 - d[ts]= - timestamp of result save
 - d[t]= - UTF-8 TEXT field for `text` type or "Other" field for `one` or `multi` question types (could be used for binary data in base64 in future updates)
Example `wget --post-data "token=4x1o7Rlou4iR...&d[SH]=...&d[QH]=..." http://site/pagename/API/save`


## Authors
 - Daniel Bykov - Design and Front-end developer
 - Gleb Devyatkin - Software and back-end developer