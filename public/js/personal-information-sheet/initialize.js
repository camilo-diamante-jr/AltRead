$(document).ready(function () {
	// Save input values to localStorage on change
	$("input").on("input change", function () {
		if ($(this).attr("type") === "radio") {
			// Save the selected radio button's value
			const radioName = $(this).attr("name");
			const radioValue = $(`input[name='${radioName}']:checked`).val();
			localStorage.setItem(radioName, radioValue);
		} else {
			// Save text inputs
			const fieldName = $(this).attr("placeholder") || $(this).attr("id");
			const fieldValue = $(this).val();
			localStorage.setItem(fieldName, fieldValue);
		}
	});

	// Pre-fill text inputs with saved data from localStorage
	$("input[type='text']").each(function () {
		const fieldName = $(this).attr("placeholder") || $(this).attr("id");
		const savedValue = localStorage.getItem(fieldName);
		if (savedValue) {
			$(this).val(savedValue);
		}
	});

	// Pre-check radio buttons based on saved data
	$("input[type='radio']").each(function () {
		const radioName = $(this).attr("name");
		const savedValue = localStorage.getItem(radioName);
		if ($(this).val() === savedValue) {
			$(this).prop("checked", true);
		}
	});
});
