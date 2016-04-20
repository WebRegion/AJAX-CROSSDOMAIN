$(document).ready(function(){
$("#send").click(function(){	
$(document).ready(function () {
	var primer = $("#primer").val();
	$.ajax({
		type: "GET",
		url: "http://site2.test/backend.php",
		data: {PRIMER:primer},
		dataType: 'jsonp',
		success: function (data){
			$('#result').html(data.result);
		}
	});
});
})
});