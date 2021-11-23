/************************
 *  validations functions start
 */

// checkEmail receives an argument and validates whether it is a valid e-mail id
const checkEmail = (...args) =>
  args.every((str) =>
    /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/.test(
      trimString(str)
    )
  );

// checkPhone receives an argument and validates whether it is a valid phone number
const checkPhone = (...args) =>
  args.every((str) => /^([0-9]{10})$/.test(trimString(str)));

// checkPincode receives an argument and validates whether it is a valid pin code
const checkPincode = (...args) =>
  args.every((str) => /^([0-9]{6})$/.test(trimString(str)));

// checkAlphaSpace receives an argument and validates whether it is contains only aphabets and spaces
const checkAlphaSpace = (...args) =>
  args.every((str) => /^[A-z ]+$/.test(trimString(str)));

// checkAlphaSpace receives an argument and validates whether it is a valid url
const checkURL = (...args) =>
  args.every((str) =>
    /^(((ht|f){1}(tp:[/][/]){1})|((www.){1}))[-a-zA-Z0-9@:%_\+.~#?&//=]+$/.test(
      trimString(str)
    )
  );
// checkFileExtensions verifies whether all the files belongs to allowed size limit
// By default 15MB file size is allowed
const checkFileSize = function (sizeLimit = 15 * 1000000) {
  if (!this || !this.files || !this.files.length) return false;
  const files = [...this.files];
  return files.every((file) => file.size <= sizeLimit);
};

// checkFileExtensions verifies whether all the files belongs to allowed extentions
// It is defined using function expression to allow passing this keyword reference
const checkFileExtensions = function (allowedExtentions = []) {
  if (!this || !this.files || !this.files.length) return false;
  const fileNames = getFileNames(this);
  return fileNames.every(
    (fileName) =>
      fileName.length &&
      allowedExtentions.includes(
        fileName.toLowerCase().slice(fileName.lastIndexOf(".") + 1)
      ) &&
      fileName.lastIndexOf(".") > -1
  );
};

// checkDocumentFiles verifies whether the element contains only docs files
// It is defined using function expression to allow passing this keyword reference
const checkDocumentFiles = function () {
  return checkFileExtensions.call(this, ["doc", "docx", "ppt", "pptx", "pdf"]);
};

// checkImageFiles verifies whether the element contains only image files
// It is defined using function expression to allow passing this keyword reference
const checkImageFiles = function () {
  // Bind this keyword of checkImageFiles function with checkFileExtensions function
  return checkFileExtensions.call(this, ["png", "jpeg", "jpg", "gif"]);
};
const checkName = checkAlphaSpace;

/************************
 *  validations functions end
 */
const allowOnlyDigits = (event) => {
  const keyCode = event.which;
  if (
    [46, 8, 9, 27, 13].includes(event.which) ||
    // Allow: Ctrl+A, Command+A
    (event.which === 65 &&
      (event.ctrlKey === true || event.metaKey === true)) ||
    // Allow: home, end, left, right, down, up
    (event.which >= 35 && event.which <= 40)
  ) {
    // let it happen, don't do anything
    return;
  }
  // Ensure that it is a number and stop the keypress
  if (
    ((event.shiftKey || keyCode < 48 || keyCode > 57) &&
      (keyCode < 96 || keyCode > 105)) ||
    keyCode == 110 ||
    keyCode == 190
  ) {
    event.preventDefault();
  }

  return true;
};

const allowOnlyDigitsAndDecimals = (event) => {
  if (event.shiftKey == true) {
    event.preventDefault();
  }

  if (
    (event.keyCode >= 48 && event.keyCode <= 57) ||
    (event.keyCode >= 96 && event.keyCode <= 105) ||
    event.keyCode == 8 ||
    event.keyCode == 9 ||
    event.keyCode == 37 ||
    event.keyCode == 39 ||
    event.keyCode == 46 ||
    event.keyCode == 190
  ) {
  } else {
    event.preventDefault();
  }

  if (
    getAttributeValue(event.target, "value", "").indexOf(".") !== -1 &&
    event.keyCode == 190
  )
    event.preventDefault();
  //if a decimal has been added, disable the "."-button
};

// allowEmail checks input value contains only letters and spaces
const allowOnlyLettersAndSpaces = (event) => {
  if (!checkAlphaSpace(event.key === " " ? "a" : event.key)) {
    event.preventDefault();
  }
};

// allowEmail checks input email pattern
const allowEmail = function (event) {
  if (
    !/^[A-z0-9 @.]+$/.test(
      getAttributeValue(event.target, "value", "") + event.key
    )
  )
    event.preventDefault();
};

// allowPhone verifies whether user entered allowed phone-number
const allowPhone = function (event) {
  if (
    !isFinite(event.key) ||
    (getAttributeValue(event.target, "value", "") + event.key).length > 10
  )
    event.preventDefault();
};

// validateKey verifies whether user entered allowed keycode
const validateKey = function (event) {
  const dataType = getDataAttributeValue(this, "type", "");
  switch (dataType) {
    case "lettersAndSpaces":
      allowOnlyLettersAndSpaces(event);
      break;
    case "phone":
      allowPhone.call(this, event);
      break;
    case "email":
      allowEmail(event);
      break;
  }
};
