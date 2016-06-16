var isBlank = function(string) {
	return (!string || $.trim(string) === "");
};

var isDateValid = function(day, month, year) {
	var isValid = false;
	var errorMessage = "";
	if ($inputDay.val() && $inputMonth.val() && $inputYear.val()) {
		var date = moment(day + "-" + month + "-" + year, "DD-MM-YYYY");
		if (!date.isValid()) {
			errorMessage = "Fecha inválida, vuelva a intentarlo.";
		}
		else if (moment().diff(date, 'years') < 18) {
			errorMessage = "Lo sentimos, debe ser mayor de 18 años.";
		}
		else {
			isValid = true;
		}
	}
	else {
		errorMessage = "Debe ingresar una fecha";
	}
	return {"success": isValid, "error": errorMessage};
};
