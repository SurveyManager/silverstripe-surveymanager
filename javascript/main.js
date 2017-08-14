// Add new Question
$('.addQuestion').click(function(event){ event.preventDefault()
	let questionRow = $('.questions').first().clone(true)
	questionRow.find('#questionTitle').attr({value:'', name:'questionTitle[]'})
	questionRow.find('#questionText').attr({name:'questionText[]'}).html('')
	questionRow.find('select.typeOfQuest').val('')
	questionRow.find('.answers input').attr({value:'', name:'answer[]'})
	$('.question-row-list').append( questionRow )
})

$('.delete-question').click(function(event) {
	event.preventDefault()
	let  rows = $(this).closest('.question-row-list').find('.questions')
	if(rows.length > 1){
		$(this).closest('.questions').remove()
	}
})

// add Event all of addNewAnswer buttons
$('.addNewAnswer').click(function(){
	let answers = $(this).parents('.row').first().find('.answers');
	let item	= answers.find('.item-option').first().clone(true)
	item.find('input').attr({value:'',name:'answer[]'})
	answers.append( item )
})

// add Event all Delete buttons
$('.answers button.delete-option').click(function(e){
	e.preventDefault()
	let  rows = $(this).closest('.answers').find('.item-option')
	if(rows.length > 1){
		$(this).parent().remove()
	}
})

$('.saveSurvey').click(function(event) { event.preventDefault()
	let saveData = {
		surveyID: $('#surveyID').val(),
		surveyTitle: $('#surveyTitle').val(),
		surveyDescription: $('#description').val(),
		questions:
			[
				{
					questionID: 'questionID',
					questionTitle: 'questionTitle',
					questionDescription: 'questionText',
					questionsType: '',
					options: [
						{optionID: '1', optionText: 'text'},
						{optionID: '1', optionText: 'text'}
					]
				}
			]
	}
	let Qs = [], Q = {}, Ops = [], Op = {}
	$('.questions').each(function() {
		Q = {}
		Q.questionID 					= $(this).find('.questionID').val()
		Q.questionTitle 			= $(this).find('.questionTitle').val()
		Q.questionDescription = $(this).find('.questionText').val()
		Q.questionsType 			= $(this).find('.typeOfQuest > option:selected').val()
		Ops = []
		$(this).find('.answers .item-option').each(function(){
			Op = {}
			Op.optionID 				= $(this).find('.optionID').val()
			Op.optionText 			= $(this).find('.optionText').val()
			Ops.push(Op)
		})
		Q.options = Ops

		Qs.push(Q)
	})
	saveData.questions = Qs
	console.log(saveData)

	let ddata = {ddd: 'ssddd'}

	$.ajax({
		url: 'http://silverstrip.loc/surveys-page/saveajax/',
		type: 'POST',
		data: ddata,
		success: function(result) {
			console.log(result);
		}
	})
})
