// SURVEY
// Add Survey
$('#new-survey').click(function() { event.preventDefault(); self = $(this);
	const newOne = {newOne : {
		object: 'Survey'
	}}
	savetodb.run(newOne, self, function(result) {
		var res = jQuery.parseJSON(result)
		console.log(res)
		// window.location.href = '/surveys-page/show/' + res.newSurveyID

		var eTR = $('.empty-item').clone()
		eTR.find('td:eq(0)').text(res['newSurveyID'])
		eTR.find('td:eq(1)').text('New Survey')
		eTR.find('td:eq(4) a').attr('href','/surveys-page/results/' + res['newSurveyID'])
		eTR.find('td:eq(5) a').attr('href','/surveys-page/show/' + res['newSurveyID'])

		console.log(eTR)
		eTR.removeClass('empty-item').show(750)
		$('table.table').append(eTR)

	})
})

// $('#new-survey').click();

$('.del-survey').click(function() { event.preventDefault(); self = $(this);
	const delOne = {delOne:{
		object: 'Survey',
		id: self.val()
	}}
	savetodb.run(delOne, self.closest('tr'), function(){
		self.closest('tr').hide(500)
	})
})

/// QUESTION
// Add Question
$('.addQuestion').click(function(event){ event.preventDefault()
	let questionRow = $('.questions').first().clone(true)
	questionRow.find('.clear-val').val('');
	questionRow.find('.answers .item-option:not(:first)').remove()
	questionRow.find('.qIDv').text('')
	questionRow.attr('qid', '')
	questionRow.find('.answers span').text('')
	questionRow.find('.panel').addClass('new')
	questionRow.hide()
	$('.question-row-list').append( questionRow )
	questionRow.show(700)
	const newOne = {newOne : {
		object: 'Question', // Question, Option
		parentID: $('#surveyID').val(), // Parents ID
	}}
	console.log(newOne);

	savetodb.run(newOne, questionRow, function(result) {
		console.log(result);
		var res = jQuery.parseJSON(result)
		questionRow.find('.questionTitle').attr('name','Question--'+res.newQuestionID+'--Title')
		questionRow.find('.questionText').attr('name','Question--'+res.newQuestionID+'--Txt')
		questionRow.attr('qid', res.newQuestionID)
		questionRow.find('.qIDv').text('(ID: '+res.newQuestionID+')')

		questionRow.find('.answers input.optionText').attr('name','Option--'+res.newOptionID+'--Txt')
		questionRow.find('.answers span').text('(ID: '+ res.newOptionID +')')

		$(window).scrollTop( $(document).height()-650 )
	})
})
// Delete Question
$('.delete-question').click(function(event) {
	event.preventDefault(); const self = $(this);
	const rows = self.closest('.question-row-list').find('.questions:visible')
	if(rows.length > 1){
		const questionID = self.closest('.row').find('.questionTitle').attr('name').split('--')[1]
		// console.log(questionID);
		const delOne = {delOne:{
			object: 'Question',
			id: questionID
		}}
		savetodb.run(delOne, self.closest('.row'), function(){
			self.closest('.row').hide(500)
		})
	}
})

// OPTION
// Add Option
$('.addNewAnswer').click(function(){
	let answers = $(this).closest('.row').first().find('.answers');
	let item	= answers.find('.item-option').first().clone(true)
	let input = item.find('input').attr({value:'',name:''}).val('')
		item.find('span').text('')
		item.hide()
		answers.append( item )
		item.show(750)
		input.attr('disabled','')
	let parentID = $(this).closest('.questions').attr('qid')
	let newOne = {newOne: {
		object: 'Option', // Question, Option
		parentID: parentID, // Parents ID
	}}
	// console.log(newOne);
	// Ajax request
	savetodb.run(newOne, input, function(result) {
		let res = jQuery.parseJSON(result)
		input.removeAttr('disabled')
		input.attr('name','Option--'+res.newOptionID+'--Txt')
		item.find('span').text('(ID: '+ res.newOptionID +')')
	})

})
// Delete Option
$('.answers button.delete-option').click(function(e){
	e.preventDefault(); const self = $(this);
	const rows = self.closest('.answers').find('.item-option:visible')
	if(rows.length > 1){
		var optionID = self.parent().find('input.optionText').attr('name').split('--')[1]
		// console.log(optionID);
		var delOne = { delOne: {
			object: 'Option',
			id: optionID
		}}
		// console.log( delOne );
		savetodb.run( delOne, self.parent().find('input.optionText'), function() {
			self.parent().hide(500)
		} )
	} // if
}) // click

////////////////////
// Save on change //
////////////////////

// Select type of quesion
$('select.typeOfQuest').change(function() {

	console.log($(this).find('option:selected').text());

	var names = $(this).attr('name').split('--')
	console.log(names);
	var saveOne = { saveOne: {
		object: names[0],
		id: names[1],
		type: names[2],
		val: $(this).find('option:selected').text()
	}}
	savetodb.run(saveOne, $(this), function(d){
		console.log(d);
	} )

})
// Input change
$('.question-row-list input').blur(function(){
	const th = $(this)
	if( th.attr('value') != th.val() ){
		console.log('Value is changed');

		// Data from <input name=""> convert to array.
		// Exp: name="Survey--10--Title" to ['Survey', 10, 'Title']
		var data = th.serializeArray()[0];
		console.log(data);
		var names = data.name.split('--')

		// Objects: Survey, Question, Option
		// Types: Title, Txt, Select
		var saveOne = { saveOne: {
				object: names[0],
				id: names[1],
				type: names[2],
				val: data.value
		}}
		console.log(saveOne);
		savetodb.run(saveOne, th, function(d) {
			console.log(d);
		})
	}
})

/** Save to DataBase
 * @param data {Object} Ex.: {saveOne | addOne | delOne: {
																 object : 'Survey' | 'Question' | 'Option',
																 id: #
																 parentID: #
															} }
 * @param el {Object} Object for animation
 * @param fn {Function} Add function after success ajax request
 */
var savetodb = {
	sp: $('#circleG'), // Spinner
	run: function(data, el, fn = function() {}) {
		// fn = (fn) ? fn : function() {};
		const self = this;
		self.on( el );
		$.post(AbsoluteLink+'saveajax/', data)
		.done(function(result) {
			self.off( el )
			fn(result)
		})
	},
	on: function(el) {
		el.attr('disabled','') // Temporarily to block of an input element
		this.sp.offset({ // Set position on center of an element
			top: el.offset().top + (el.height() / 2) ,
			left: el.offset().left + (el.width() / 2)
		})
	}, // spinner ON
	off: function(el) { var self = this;
		setTimeout(function() {
			el.removeAttr('disabled') // Unblock of an input element
			self.sp.offset({top:-100,left:0})
		}, 0)

	} // spinner OFF
}
