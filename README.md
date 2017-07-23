# silverstripe-surveymanager

## About project
EDENZ college Capstone project. Pluging for SilverStripe CMS to create and manipulate Surveys structure with API for 3rd party applications.

## Description
### Question types
 - `text` - text field
 - `one` - choose one of the item
 - `multi` - choose some of the items
### Question `Other` field


## API
### Get token (authorization by email and survey PIN)
Example `wget --post-data "email=email1@survey.example&pin=12345" http://site/pagename/API/auth`
### Get Survey data by token
Example `wget --post-data "token=4x1o7Rlou4iR..." http://site/pagename/API/questions`
### Save survey results
TODO

## Authors
 - Daniel Bykov - Design and Front-end developer
 - Gleb Devyatkin - Software and back-end developer