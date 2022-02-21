/**
 * covertToTitleCase function capitalizes all the word initials
 * @param {*} words It holds string of words
 */
const covertToTitleCase = (words) =>
  (words + "")
    .trim()
    .toLowerCase()
    .split(" ")
    .map((word) => (word[0]?.toUpperCase() ?? "") + word.slice(1))
    .join(" ");
/**
 * formatName function accepts variable length arguments and converts them to title case
 * @param {*} names It holds an array of names
 */
const formatName = (...names) => names.map(covertToTitleCase);
/**
 * formatEmail function accepts variable length arguments and converts them to lower case
 * @param {*} emails It holds an array of emails
 */
const formatEmail = (...emails) =>
  emails.map((email) => (email + "").trim().toLowerCase());

/**
 * formatTitle function accepts variable length arguments and converts them to upper case
 * @param {*} titles It holds an array of titles
 */
const formatTitle = (...titles) =>
  titles.map((title) => (title + "").trim().toUpperCase() + ".");
/**
 * formatUpperCase function accepts variable length arguments and converts them to upper case
 * @param {*} words It holds an array of words
 */
const formatUpperCase = (...words) =>
  words.map((word) => (word + "").trim().toUpperCase());
/**
 * formatPhone function accepts variable length arguments and converts them to formatted phone
 * @param {*} phoneNumbers It holds an array of phoneNumbers
 */
const formatPhone = (...phoneNumbers) =>
  phoneNumbers.map(
    (phone) =>
      `${phone.slice(0, 4) + "-" + phone.slice(4, 7) + "-" + phone.slice(7)}`
  );
/**
 * formatValue function accepts format and variable length arguments and return formated values
 * @param {*} format It holds the format type, for instance, name, email etc
 * @param {*} values It holds an array of values to be formated
 */
const formatValue = (format, ...values) => {
  let formatedData = values;
  switch (format.toLowerCase().trim()) {
    case "name":
      formatedData = formatName(...values);
      break;
    case "email":
      formatedData = formatEmail(...values);
      break;
    case "title":
      formatedData = formatTitle(...values);
      break;
    case "phone":
      formatedData = formatPhone(...values);
      break;
    case "uppercase":
      formatedData = formatUpperCase(...values);
      break;
  }
  return formatedData;
};
/**
 * maskString function accepts an object and returns the string masked with the given characters
 * @param {*} dataValue It holds the value to be formatted
 * @param {*} mask It holds the string value that should be used as mask
 * @param {*} maskInBegining It contains truthy value when mask should start from the beginning of the datavalue
 * @param {*} displayStart It contains the start index of the datavalue that remains unmasked
 * @param {*} displayEnd It contains the last index of the datavalue that remains unmasked
 * @param {*} length It contains the length of datavalue string
 */
const maskString = ({
  dataValue,
  mask = "*",
  maskInBegining = 1,
  displayStart = 0,
  displayEnd = dataValue + "".length,
  length = dataValue.length,
}) =>
  (dataValue + "")
    .slice(displayStart, displayEnd)
    .padStart(maskInBegining ? length : 0, mask)
    .padEnd(!maskInBegining ? length : 0, mask);
