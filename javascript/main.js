
function addNewAnswerEvent(th){
		let answers = $(th).parents('.row:first').find('.answers');
		let input	= answers.find('input:last').clone()
		input.attr({value:'',name:'answer[]'})
		answers.append( input )
}
// add Event all of buttons
$('.addNewAnswer').click(function(){
	addNewAnswerEvent(this)
})

$('.addQuestion').click(function(){
	let questionRow = $('.questions:last').clone()
	questionRow.find('#questionTitle').attr({value:'', name:'questionTitle[]'})
	questionRow.find('#questionText').attr({name:'questionText[]'}).html('')
	// let tst =
	questionRow.find('select.typeOfQuest').val('')
	questionRow.find('.answers > input').attr({value:'', name:'answer[]'})
			// .removeAttr()
	questionRow.find('.addNewAnswer').click(function(){addNewAnswerEvent(this)})
	$('.question-row-list').append( questionRow )
	// console.log(tst);
})

// addButtons();
