// Add Question
$('.addQuestion').click(function(event){ event.preventDefault()
	let questionRow = $('.questions').first().clone(true)
	questionRow.find('.questionTitle').attr({value:'', name:'questionTitle[]'})
	questionRow.find('.qIDv').html('')
	questionRow.find('.questionText').attr({name:'questionText[]'}).html('')
	questionRow.find('.questionID').attr({value:''})
	questionRow.find('select.typeOfQuest').val('')
	questionRow.find('.answers .item-option:not(:first)').remove()
	questionRow.find('.answers input.optionText').attr({value:'', name:'answer[]'})
	questionRow.find('.answers input.optionID').attr({value:''})
	questionRow.find('.answers span').html('')
	$('.question-row-list').append( questionRow )
})

// Delete Question
$('.delete-question').click(function(event) {
	event.preventDefault()
	let  rows = $(this).closest('.question-row-list').find('.questions:visible')
	if(rows.length > 1){
		// $(this).closest('.questions').remove()
		let questionID = $(this).closest('.row').find('.questionID')
		let newId = questionID.val()*-1
		if(newId < 0){
			questionID.val(newId);
			$(this).closest('.questions').hide()
		} else $(this).closest('.questions').remove()
	}
})

// Add Option
$('.addNewAnswer').click(function(){
	let answers = $(this).parents('.row').first().find('.answers');
	let item	= answers.find('.item-option').first().clone(true)
	item.find('input').attr({value:'',name:'answer[]'})
	answers.append( item )
})

// Delete Option
$('.answers button.delete-option').click(function(e){
	e.preventDefault()
	let  rows = $(this).closest('.answers').find('.item-option:visible')
	if(rows.length > 1){
		let optionID = $(this).parent().find('.optionID')
		let newId = optionID.val()*-1
		if(newId < 0){
			optionID.val(newId);
			$(this).parent().hide()
		} else $(this).parent().remove()
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

	$.ajax({
		url: 'http://silverstrip.loc/surveys-page/saveajax/',
		type: 'POST',
		data:	{saveData:saveData},
		success: function(result) {
			console.log(result);
		}
	})

	// $.ajax('http://silverstrip.loc/surveys-page/saveajax/')
	// 	.done(function(){
	//
	// 	})
	// 	.fail(function (xhr) {
	// 		alert('Error: ' + xhr.responseText);
	// 	})
})
