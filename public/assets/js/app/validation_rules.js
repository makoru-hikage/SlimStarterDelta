
/**
 * Returns an Object that tells about a validated data that might be extracted 
 * from a field or an HTTP Response. Such Object must have a "name" and "value"
 * where the "name" is an attribute "name"; See what jQuery "serializeArray()"
 * returns as an example. Supply a function that returns a boolean value. 
 * 
 * @param Object input_data 
 * @param boolean required 
 * @param function condition 
 * 
 * @return Object validationResult
 */
var validateField = function(input_data, required, condition){

	var validationResult = {
		name: input_data.name,
		value: input_data.value,
		is_invalid: !condition(input_data.value),
		is_empty: input_data.value == null || input_data == '',
		is_required: required
	}

	return validated_data;
}

/**
 * Checks if the validated data has just an null or empty input
 */
var indicateValidation = function (validated_data, msg_when_null, msg_when_invalid){
	var d = validated_data;
	var message = null;
	var is_invalid = false;

	if(d.is_required & !d.is_empty){
		if (d.is_invalid){
			m = msg_when_invalid
		}
	} else {
		message = msg_when_null;
	}

	return {
		is_empty: d.is_empty
		is_invalid: d.is_invalid
		message: message
	}

}
/**
 * Checks if an input's amount or length is valid. Make the min greater than max
 * if no limit is set
 * 
 * @param String or int input
 * @param int min  
 * @param int max
 *
 * @return bool  
 */
var validateMagnitude = function (input, min, max = 0){
	if (min > max){
		return input >= min; 
	} else {
		return input >= min && input <= max;
	}
}

var confirmStrings = function (str1, str2){
	return str1 === str2;
}

var match = curry(function (what, str){
	return str.match(what);
});

var isEmail = match('^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,6})$');


var validate_password = indicateValidation (validateField(data, true, passwordValidation), 
	"Password is required",
	"Password must be 8-50 charaters long");


