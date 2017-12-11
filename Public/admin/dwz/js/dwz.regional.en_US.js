/**
 * @author xiangjun@daxiangclass.com
 */
(function($){
	// jQuery validate
	$.extend($.validator.messages, {
		required: "required field",
		remote: "please correct the field",
		email: "please enter a valid email format",
		url: "please enter a valid address",
		date: "please enter a valid date",
		dateISO: "please enter a valid date (ISO).",
		number: "please enter a valid number",
		digits: "enter only integer",
		creditcard: "please enter a valid credit card number",
		equalTo: "please re-enter the same value",
		accept: "please enter a string with a legitimate extension",
		maxlength: $.validator.format("maximum string length is {0}"),
		minlength: $.validator.format("minimum string length is {0}"),
		rangelength: $.validator.format("{0} and {1} string length between"),
		range: $.validator.format("please enter a {0} and {1} range of values"),
		max: $.validator.format("please enter a maximum value of {0}"),
		min: $.validator.format("Please enter a minimum value of {0}"),
		
		alphanumeric: "Only letter, number, underscore",
		lettersonly: "must be a letter",
		phone: "Only number, space, parentheses"
	});
	
	// DWZ regional
	$.setRegional("datepicker", {
		dayNames: ['sun', 'mon', 'tues', 'wednes', 'thurs', 'fri', 'satur'],
		monthNames: ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december']
	});
	$.setRegional("alertMsg", {
		title:{error:"error", info:"tips", warn:"warning", correct:"success", confirm:"Confirmation tips"},
		butMsg:{ok:"confirm", yes:"yes", no:"no", cancel:"cancel"}
	});
})(jQuery);