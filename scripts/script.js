$('#students_filter_by_class').on('change', function() {
	var now = new Date();
	now.setTime(now.getTime() + 1 * 10 * 1000);
	document.cookie = "students_filter_by_class=" + this.value + "; expires = " + now.toUTCString();
	location.reload();
});

if ( document.cookie.split("students_filter_by_class=")[1]!=undefined ) {
	var cookie = document.cookie.split("students_filter_by_class=")[1].split(";")[0];
	$('#students_filter_by_class').val(cookie);
}

// когато изберем ученик да се покажат само класовете, по-малки или равни на неговия
$('#session_grades_input_student').on('change', function() {
	var selectedStudentId = this.options[this.selectedIndex].id.split(" ")[0]; // взимаме класа на избрания ученик

	var selectedClass = $('#session_grades_input_class').val();
	
	// показваме всички опции
	for(var i=1; i <= 12; i++) {
		$("#"+i).css("display", "inline");
	}
	
	// ако имаме избран ученик
	if(selectedStudentId!="") {
		// обхождаме класовете наобратно и крием всички до неговия
		for(var i=12; i > selectedStudentId; i--) {
			//$("#"+i).hide();
			$("#"+i).css("display", "none");
		}
	}
	
	// проверка за случаите, в които сме избрали първо клас, след това ученик, за който това е невалиден клас
	if ($('#'+selectedClass).css('display') == "none") { // ако е скрит класа, който сме избрали
		$("#session_grades_input_class").val('0'); // рестартираме селекта за клас
	}
	
});
	
$('#session_grades_input_student').trigger('change'); // викаме събитието, за да се изълни функцията, когато сме в edit и ученика е автоматично избран