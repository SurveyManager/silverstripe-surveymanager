
function addAnswer(){
	let i = 2,
			firstInsert = $('#answers > input').first()
	;
	$('#addAnswer').click(function() {
		$('#answers')	.append( firstInsert.clone()
										.attr('name',`answer[${i}]`)
										.attr('placeholder',`Answer#${i}`)
									);
		// $('#answers::last insert').attr('name',`answer[${i}]`);
		i++;
	})
}
let a = addAnswer();
// xfb
