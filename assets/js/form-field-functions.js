/****************************
 *  Form Field Operations start
 **/
// getFormElementType returns form element type
const getFormElementType = (elem) => {
	let elemType = elem.nodeName.toLowerCase();
	switch (elemType) {
		case "input":
			let type = getAttributeValue(elem, "type", elemType);
			if (!type) logWarning(elem, type);
			else type = (type + "").toLowerCase();
			switch (type) {
				default:
					return type;
			}
			break;
		default:
	}
	return elemType;
};

// getFieldDetails returns form field details
const getFieldDetails = (elem) => {
	let value = "";
	let valueArray = [];
	const type = getFormElementType(elem);
	const name = getAttributeValue(elem, "name");
	const id = getAttributeValue(elem, "id");
	const validatorString = getDataAttributeValue(elem, "validator", "").trim();
	const validator = validatorString == "" ? [] : validatorString.split(",");

	const validatorType = getDataAttributeValue(elem, "validationtype", "");
	switch (type) {
		case "text":
		case "email":
		case "password":
		case "tel":
		case "number":
			value = getAttributeValue(
				$first(`input[name="${name}"]`, elem.closest(`form`)),
				"value",
				""
			);
			valueArray.push(value);
			break;
		case "textarea":
			value = getAttributeValue(
				$first(`textarea[name="${name}"]`, elem.closest(`form`)),
				"value",
				""
			);
			valueArray.push(value);
			break;
		case "file":
			valueArray = getFileNames(
				$first(`input[name="${name}"]`, elem.closest(`form`))
			);
			value = valueArray.join(",");
			break;
		case "checkbox":
		case "radio":
			valueArray = [
				...$all(`input[name="${name}"]:checked`, elem.closest(`form`)),
			].map((elem) => (elem.value + "").trim());
			value = valueArray.join(",");
			break;
		case "select":
			valueArray = [
				...[
					...$first(`select[name="${name}"]`, elem.closest(`form`))
						.selectedOptions,
				],
			].map((elem) => elem.value.trim());
			value = valueArray.join(",");
			break;
	}
	return {
		id,
		validator,
		value,
		valueArray,
		type,
		name,
		validatorType,
	};
};

// getFormElementLabel returns element label
const getFormElementLabel = ({
	elem,
	parentNodeselector = ".form-group",
	elementLabelSelector = "label",
}) =>
	elem
		?.closest(`${parentNodeselector}`)
		?.parentElement.querySelector(`${elementLabelSelector}`)?.innerHTML ??
	getAttributeValue(elem.name);
// getFieldErrorMessage returns the error message
const getFieldErrorMessage = (elem, failedValidatorName) => {
	// Fetch field name
	const label = getFormElementLabel({ elem });
	let message = "";
	// Get message from pre-defined formats
	switch (failedValidatorName) {
		case "checkNonEmpty":
			message = `${label} field is mandatory`;
			break;
		case "checkEmpty":
			message = `Invalid ${label}`;
			break;
		case "checkNumber":
			message = `${label} should contain only numeric values`;
			break;
		case "checkURL":
		case "checkPincode":
		case "checkPhone":
		case "checkEmail":
			message = `Enter valid ${label}`;
			break;
		case "checkAlphaSpace":
		case "checkName":
			message = `${label} should contain only alphabets or spaces`;
			break;
		case "checkDocumentFiles":
			message = `Select valid document file(s)`;
			break;
		case "checkImageFiles":
			message = `Select valid image file(s)`;
			break;
		default:
			message = `Add validation error message for ${failedValidatorName} validator in function: getFieldErrorMessage`;
	}
	// Return message
	return message;
};

// validateFieldData data with mutiple validator calls
const validateFieldData = ({
	thisRef,
	valueArray,
	validatorArray,
	validatorType,
}) => {
	// return true when no validator functions are defined
	if (validatorArray.length == 0) return true;

	// return false when validators relation does not belong to allowed types
	// every will check wether all validators are satisfied
	// some/any would return true when at least one validation rule is satisfied
	if (!["every", "some", "any"].includes((validatorType + "").toLowerCase()))
		return false;
	// Returns validation result
	return validatorType.toLowerCase() === "every"
		? validatorArray.every((func) =>
				callFunc({
					func,
					thisRef,
					args: valueArray,
				})
		  )
		: validatorArray.some((func) =>
				callFunc({
					func,
					thisRef,
					args: valueArray,
				})
		  );
};

// validateField verifies whether form field satisfies associated validations
const validateField = ({
	elem,
	displayErrorMessage = 0,
	errorParentNodeselector = ".form-group",
	errorNodePosition = "beforeend",
	errorTag = "span",
	tagClass = "error",
}) => {
	let validatorArray, valueArray, validatorType;
	// Fetch elem data details
	({
		validator: validatorArray,
		validatorType,
		valueArray,
	} = getFieldDetails(elem));
	// validate details
	let isCorrect = validateFieldData({
		thisRef: elem,
		valueArray,
		validatorArray,
		validatorType,
	});
	if (!isCorrect) {
		// when user has entered incorrect data, get which validator failed and print error message
		// Here Array(size_of_array).fills(elements_at_ith_position) creates an array of size n and add elements at each index
		const failedValidationIndex = callFunctionsOnElement({
			elem,
			funcs: validatorArray,
			args: Array(validatorArray.length).fill(...valueArray), // Passes field value as an argument for each validator function
		}).findIndex((element) => element == false);
		// Fetch error message of the first failed validation
		const errorMsg = getFieldErrorMessage(
			elem,
			validatorArray[failedValidationIndex]
		);
		if (displayErrorMessage) {
			// display error message on screen
			appendToParentElement({
				elem,
				content: errorMsg,
				parentNodeselector: errorParentNodeselector,
				position: errorNodePosition,
				tag: errorTag,
				tagClass,
			});
		}
		// Display the error field
		//    scrollToView({ elem });
	}
	// return data validation status
	return isCorrect;
};

// trimAttribute removes spaces from the element attribute
const trimAttribute = ({ elem, attribute }) => {
	updateAttribute(
		elem,
		attribute,
		trimString(getAttributeValue(elem, attribute, ""))
	);
};

// modifyElementAttribute calls fn by passing element and attribute as a bunction
const modifyElementAttribute = (elem, attribute, fn) => {
	fn({ elem, attribute });
};

// trimValueAttribute removes spaces from the element
const trimValueAttribute = (elem) =>
	getFormElementType(elem) === "file"
		? ""
		: modifyElementAttribute(elem, "value", trimAttribute);

// updateFieldPlaceholder adds placeholder with the nearest label content
const updateFieldPlaceholder = (elem) => {
	if (elem?.closest(`.form-group`)?.parentElement.querySelector(`label`)) {
		updateAttribute(
			elem,
			"placeholder",
			"Enter " + getFormElementLabel({ elem })
		);
	}
};

// turnOffAutocomplete turns off autocompleter of form field
const turnOffAutocomplete = (elem) => {
	const value = navigator.userAgent.indexOf("Chrome") != -1 ? "no-fill" : "off";
	updateAttribute(elem, "autocomplete", value);
};

// turnOnAutocomplete turns on autocompleter of form field
const turnOnAutocomplete = (elem) => {
	removeAttribute(elem, "autocomplete");
};

// getFormQueryString returns query string from Form elements
const getFormQueryString = (formSelector) =>
	JSON.stringify(Object.fromEntries(getFormDataObject(formSelector)));

// getFormDataObject returns FormData object
const getFormDataObject = (formSelector) => new FormData($first(formSelector));

// getFormData returns FormData object
const getFormData = (formElem) => new FormData(formElem);

// getAllFormFieldValues returns key value pair of form elements
const getAllFormFieldValues = (formSelector) => {
	//  Get Form
	const myForm = $first(formSelector);
	// Get All Form Elements
	const elems = [...myForm.elements]
		.map((elem) => {
			// retrieve label and values
			let id, validator, value, valueArray, type, name, validatorType;
			const label = getFormElementLabel({ elem });
			// Extract data from object
			({ id, validator, value, valueArray, type, name, validatorType } =
				getFieldDetails(elem));
			// check format
			const format = elem?.dataset?.format ?? "";
			// return object of element data values
			return {
				id,
				validator,
				value,
				valueArray,
				type,
				name,
				validatorType,
				label,
				format,
			};
		})
		// Filter out buttons and file elements
		.filter((elem) => !["file", "submit", "button"].includes(elem.type));
	// Get unique names of elements
	const elemNames = [...new Set([...elems.map((elem) => elem.name)])];
	// Get Unique elements
	const uniqueElementsData = elemNames
		.map((name) => elems.find((elem) => elem.name == name))
		// return label and value pair
		.map((elem) => ({
			label: elem.label,
			value: elem.value,
			valueArray: elem.valueArray,
			format: elem.format,
		}));
	return uniqueElementsData;
};

// getFormDataInTable returns table html of form data
const getFormDataInTable = (formSelector, tableAttributeList = []) => {
	let formData = getAllFormFieldValues(formSelector);
	let childrenList = formData.map((elem) => ({
		tag: "tr",
		childrenList: [
			{ tag: "th", content: elem.label },
			{ tag: "td", content: elem.value },
			{ tag: "td", content: `${formatValue(elem.format, ...elem.valueArray)}` },
		],
	}));
	return jsonToHTML({
		tag: "table",
		attributeList: tableAttributeList,
		childrenList,
	});
};

// formSubmissionHandler validates form data and prints its result.
const formSubmissionHandler = async function (buttonElem) {
	const form = buttonElem.closest("form");
	const showmodal = getDataAttributeValue(buttonElem, "showmodal", 0);
	const targetElement = getDataAttributeValue(buttonElem, "target", "");
	const title = getDataAttributeValue(buttonElem, "title", "");
	const successtargetbtn = getDataAttributeValue(
		buttonElem,
		"successtargetbtn",
		""
	);
	// Form Success/ Failure status
	const successAlert = $first(".form-alert-success", form);
	const failureAlert = $first(".form-alert-failure", form);
	// Hide Form Alerts
	if (successAlert) updateClass(successAlert, "add", "hidden");

	if (failureAlert) updateClass(failureAlert, "add", "hidden");

	updateAttribute(buttonElem, "disabled", "disabled");
	deleteElements(".error");
	// Get all form fields
	const formElements = [...form.elements];
	// Validate field data
	const hasValidData = formElements.every((elem) => {
		return validateField({
			elem,
			displayErrorMessage: 1,
			errorParentNodeselector: ".form-group",
			errorNodePosition: "beforeend",
			errorTag: "span",
			tagClass: "error",
		});
	});

	if (hasValidData) {
		// Submit Ajax Request
		const url = getAttributeValue(form, "action");
		const method = getAttributeValue(form, "method");
		const response = await getResponseJSON({
			url,
			body: getFormData(form),
			method,
			mode: "cors",
		});
		const success = response?.success ?? 0;
		const message = response?.message ?? "Something went wrong";
		const redirect = response?.redirect ?? 0;
		const redirect_link = response?.redirect_link ?? "";
		if (targetElement != "") {
			// get content HTML
			let content = jsonToHTML({
				tag: response.tag,
				attributeList: response.attributeList,
				childrenList: response.childrenList,
			});
			const target = $first(targetElement);
			if (target) {
				if (showmodal == 1) {
					updateModelContent({
						model: target,
						title,
						hasNewBodyContent: 1,
						content,
					});
					// Open modal
					openModal(target);
				} else {
					target.innerHTML = content;
				}
			}
		} else {
			// Form submission status update
			if (success == 1) {
				if (successAlert) {
					$first(".col-sm-12", successAlert).innerHTML = message;
					updateClass(successAlert, "remove", "hidden");
				}
				if (successtargetbtn != "") {
					$first(successtargetbtn).click();
				}
			} else {
				if (failureAlert) {
					$first(".col-sm-12", failureAlert).innerHTML = message;
					updateClass(failureAlert, "remove", "hidden");
				}
			}
			// Redirect user to the given link when required
			if (redirect == 1 && redirect_link != "") {
				window.location.href = redirect_link;
				return;
			}
		}
	}
	// Enable submit button
	removeAttribute(buttonElem, "disabled");
};

// formSubmitButtonClickedEventHandler Handles form button click event
const formSubmitButtonClickedEventHandler = (event) => {
	const submitButton = event.target?.closest(".form-submit");
	if (submitButton) formSubmissionHandler(event.target);
};

const registerFieldEvents = (form) => {
	// Select elements available on page load
	const selectboxSelector = $all("select", form);
	const inputSelector = $all("input", form);
	const inputWithDataTypeSelector = $all("input[data-type]", form);
	const textAreaSelector = $all("textarea", form);
	// Event Listeners
	elemListRegisterEvent({
		elementNodes: [...inputSelector, ...selectboxSelector, ...textAreaSelector],
		eventName: blurEvent,
		funcs: [trimValueAttribute, updateFieldPlaceholder, turnOnAutocomplete],
	});
	elemListRegisterEvent({
		elementNodes: [...inputSelector, ...selectboxSelector, ...textAreaSelector],
		eventName: focusEvent,
		funcs: [turnOffAutocomplete],
	});
	elemListRegisterEvent({
		elementNodes: [...inputWithDataTypeSelector],
		eventName: keydownEvent,
		appendEventAsAnArgument: 1,
		funcs: [validateKey],
		args: undefined,
	});

	// Since callFunctionsOnElements contain functions array that accepts element as an argument
	// I am not specifing args propery as this function defines element as an argument by default
	callFunctionsOnElements({
		elementNodes: [...inputSelector, ...selectboxSelector, ...textAreaSelector],
		funcs: ["updateFieldPlaceholder"],
	});
};

const unregisterFieldEvents = (form) => {
	// Select elements available on page load
	const selectboxSelector = $all("select", form);
	const inputSelector = $all("input", form);
	const inputWithDataTypeSelector = $all("input[data-type]", form);
	const textAreaSelector = $all("textarea", form);
	// Event Listeners
	elemListUnregisterEvent({
		elementNodes: [...inputSelector, ...selectboxSelector, ...textAreaSelector],
		eventName: blurEvent,
		funcs: [trimValueAttribute, updateFieldPlaceholder, turnOnAutocomplete],
	});
	elemListUnregisterEvent({
		elementNodes: [...inputSelector, ...selectboxSelector, ...textAreaSelector],
		eventName: focusEvent,
		funcs: [turnOffAutocomplete],
	});
	elemListUnregisterEvent({
		elementNodes: [...inputWithDataTypeSelector],
		eventName: keydownEvent,
		appendEventAsAnArgument: 1,
		funcs: [validateKey],
		args: undefined,
	});
};

/****************************
 *  Form Field Operations end
 **/
