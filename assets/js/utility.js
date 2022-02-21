"use strict;";
/************************
 *  Log Messages to console start
 */
// logMessage arrow function accepts variable length arguments and logs to the console as message
const logMessage = (...args) => {
  console.log(...args);
};

// logError arrow function accepts variable length arguments and logs to the console as error
const logError = (...args) => {
  console.error(...args);
};

// logWarning arrow function accepts variable length arguments and logs to the console as warning
const logWarning = (...args) => {
  console.warn(...args);
};

/************************
 *  Log Messages to console end
 */

/************************
 *  string functions start
 */
// trimString receives an argument and removed spaces
const trimString = (str) => (str + "").trim();
/************************
 *  string functions end
 */

/************************
 *  number functions start
 */
// parseToNumber arrow function accepts variable length arguments and converts them number type
const parseToNumber = (...args) => {
  return args.map((value) => Number(value));
};

// sum arrow function accepts variable length arguments and return their sum
const sum = (...args) =>
  args.reduce(
    (previousValue, currentValue) => previousValue + Number(currentValue),
    0
  );

// hasNullOrUndefined verifies whether any null or undefined element exisits in the arguments
const hasNullOrUndefined = (...args) => {
  return args.some(
    (number) => typeof number === "undefined" || number === null
  );
};
// checkNumber arrow function accepts variable length arguments and check whether all are of number type
const checkNumber = (...args) => {
  return args.every((number) => typeof number == "number");
};

// checkNonEmpty arrow function accepts variable length arguments and verify whether they are non-empty
const checkNonEmpty = (...args) => {
  return (
    args.length > 0 &&
    args.every(
      (value) => !hasNullOrUndefined(value) && trimString(value) !== ""
    )
  );
};
// checkEmpty arrow function accepts variable length arguments and verify whether they are non-empty
const checkEmpty = (...args) => {
  return args.every(
    (value) => !hasNullOrUndefined(value) && trimString(value) === ""
  );
};

/************************
 *  number functions end
 */

/*****************
 *  Check field data entry starts
 */
const checkNumberEntry = function (event) {
  const keycode = event.which;
  if (
    !(
      event.shiftKey == false &&
      (keycode == 46 ||
        keycode == 8 ||
        keycode == 37 ||
        keycode == 39 ||
        (keycode >= 48 && keycode <= 57))
    )
  ) {
    event.preventDefault();
  }
  return true;
};

/****************************
 * Check field data entry ends
 */

/************************
 *  Element functions start
 */

const getFileNames = (elem) => {
  if (!elem || !elem.files || !elem.files.length) return [];
  return [...elem.files].map((file) =>
    (file.name ?? file.fileName ?? "").trim()
  );
};

// deleteElements removes errors from the page
const deleteElements = (selector) => {
  $all(`${selector}`).forEach((elem) => {
    // Remove element from HTML
    elem.remove();
  });
};

// updateAttribute modifies element property
const updateAttribute = (elem, attribute, value) => {
  try {
    elem[`${attribute}`] = value;
  } catch (err) {
    logError(err);
  }
};

// removeAttribute removes attribute from element
const removeAttribute = (elem, attribute) => {
  try {
    elem[`${attribute}`] = false;
  } catch (err) {
    logError(err);
  }
};

// getAttributeValue returns attribute value.
// In case attribute is not set then "" is returned by default
// if null or undefined as the default value is set then undefined is returned
const getAttributeValue = (elem, attribute, defaultValue = "") =>
  elem[`${attribute}`] ?? defaultValue ?? undefined;

// removeDataAttribute removes attribute from element
const removeDataAttribute = (elem, attribute) => {
  if (elem) delete elem.dataset[`${attribute}`];
};

// getDataAttributeValue returns attribute value.
// In case attribute is not set then "" is returned by default
// if null or undefined as the default value is set then undefined is returned
const getDataAttributeValue = (elem, attribute, defaultValue = "") =>
  elem?.dataset[`${attribute}`] ?? defaultValue ?? undefined;
/**
 * updateClass function adds/remove class from an element
 * @param {*} elem It holds the reference of the element
 * @param {*} operation It holds the add/remove operation for adding/ removing class
 * @param {*} className It contains truthy value when mask should start from the beginning of the datavalue
 */
const updateClass = (elem, operation = "add", className = "") => {
  if (elem) {
    elem?.classList[operation](className);
  }
};

/************************
 *  Element functions end
 */
