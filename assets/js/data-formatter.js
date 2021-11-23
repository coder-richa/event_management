const covertToTitleCase = (words) =>
  (words + "")
    .trim()
    .toLowerCase()
    .split(" ")
    .map((word) => (word[0]?.toUpperCase() ?? "") + word.slice(1))
    .join(" ");
// formatName arrow function accepts variable length arguments and convets them in title case
const formatName = (...args) => args.map(covertToTitleCase);

// formatEmail arrow function accepts variable length arguments and convets them in title case
const formatEmail = (...args) =>
  args.map((str) => (str + "").trim().toLowerCase());

const formatTitle = (...args) =>
  args.map((str) => (str + "").trim().toUpperCase() + ".");

const formatUpperCase = (...args) =>
  args.map((str) => (str + "").trim().toUpperCase());
const formatPhone = (...args) =>
  args.map(
    (phone) =>
      `${phone.slice(0, 4) + "-" + phone.slice(4, 7) + "-" + phone.slice(7)}`
  );

const formatValue = (format, ...args) => {
  let formatedData = args;
  switch (format.toLowerCase().trim()) {
    case "name":
      formatedData = formatName(...args);
      break;
    case "email":
      formatedData = formatEmail(...args);
      break;
    case "title":
      formatedData = formatTitle(...args);
      break;
    case "phone":
      formatedData = formatPhone(...args);
      break;
    case "uppercase":
      formatedData = formatUpperCase(...args);
      break;
  }
  return formatedData;
};

// maskString accepts an object and returns the string masked with the given characters
const maskString = ({
  value,
  mask,
  maskInBegining = 1,
  displayStart = 0,
  displayEnd = value + "".length,
  length = value.length,
}) =>
  (value + "")
    .slice(displayStart, displayEnd)
    .padStart(maskInBegining ? length : 0, mask)
    .padEnd(!maskInBegining ? length : 0, mask);
