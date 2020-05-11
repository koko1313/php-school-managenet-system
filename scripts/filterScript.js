function gradesFilterBy(parameter) {
  // Declare variables 
  var filter, table, tr, td, i;
  if ($('#gradesFilterBy'+parameter+'').val() != "") {
	filter = $('#gradesFilterBy'+parameter+' option:selected').text();
  } else {
	filter = "";
  }
  
  table = document.getElementById("filteredTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByClassName(parameter)[0];
    if (td) {
      if (td.innerHTML.indexOf(filter) > -1) {
		if(parameter=="Class_now") tr[i].classList.remove("hideByClass_now");
		if(parameter=="Term") tr[i].classList.remove("hideByTerm");
		if(parameter=="For_class") tr[i].classList.remove("hideByFor_class");
      } else {
        if(parameter=="Class_now") tr[i].classList.add("hideByClass_now");
        if(parameter=="Term") tr[i].classList.add("hideByTerm");
        if(parameter=="For_class") tr[i].classList.add("hideByFor_class");
      }
    } 
  }
  
  getGradesCount();
}

getGradesCount();

function getGradesCount() {
  table = document.getElementById("filteredTable");
  tr = table.getElementsByTagName("tr");
  count6 = 0;
  count5 = 0;
  count4 = 0;
  count3 = 0;
  count2 = 0;
  
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByClassName("grade")[0];
    if (td) {
	  grade = td.innerHTML.toUpperCase();
      if (grade.indexOf(6) > -1 && !tr[i].classList.contains("hideByClass_now") && !tr[i].classList.contains("hideByTerm") && !tr[i].classList.contains("hideByFor_class") ) {
        count6++;
      } else
	  if (grade.indexOf(5) > -1 && !tr[i].classList.contains("hideByClass_now") && !tr[i].classList.contains("hideByTerm") && !tr[i].classList.contains("hideByFor_class") ) {
        count5++;
      } else 
	  if (grade.indexOf(4) > -1 && !tr[i].classList.contains("hideByClass_now") && !tr[i].classList.contains("hideByTerm") && !tr[i].classList.contains("hideByFor_class") ) {
        count4++;
      } else 
	  if (grade.indexOf(3) > -1 && !tr[i].classList.contains("hideByClass_now") && !tr[i].classList.contains("hideByTerm") && !tr[i].classList.contains("hideByFor_class") ) {
        count3++;
      } else 
	  if (grade.indexOf(2) > -1 && !tr[i].classList.contains("hideByClass_now") && !tr[i].classList.contains("hideByTerm") && !tr[i].classList.contains("hideByFor_class") ) {
        count2++;
      }
    } 
  }
  
  $(".gradeStatistic6").html(count6);
  $(".gradeStatistic5").html(count5);
  $(".gradeStatistic4").html(count4);
  $(".gradeStatistic3").html(count3);
  $(".gradeStatistic2").html(count2);
}