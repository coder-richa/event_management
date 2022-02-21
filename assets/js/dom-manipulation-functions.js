/*********************
 * DOM manipulation functions start
 */
/**
 * removeElement function removes all the elements with the given selector
 * @param {*} selector It holds class, id or tag name selector
 */
const removeElement = (selector) => {
  $all(`${selector}`)?.forEach((element) => {
    element?.remove();
  });
};
/**
 * appendElement function adds the content at the given position of the element
 * @param {*} elem It holds the reference to the element
 * @param {*} position It holds the position (For instance: beforeend) where the content is appended
 * @param {*} content It holds the content that needs to be appended to the element
 */
const appendElement = (elem, position, content) => {
  elem?.insertAdjacentHTML(position, content);
};

/**
 * appendToParentElement function adds the content at the given position of the closet parent element
 * @param {*} elem It holds the reference to the element
 * @param {*} parentNodeselector It holds the selector of the parent element
 * @param {*} position It holds the position (For instance: beforeend) where the content is appended
 * @param {*} tag It holds the tag that needs to be appended to the element
 * @param {*} tagClass It holds the class name of the tag
 * @param {*} content It holds the content that needs to be listed in the tag
 */

const appendToParentElement = ({
  elem,
  parentNodeselector,
  position,
  tag,
  tagClass,
  content,
}) =>
  appendElement(
    elem?.closest(`${parentNodeselector}`),
    position,
    `<${tag} class="${tagClass}">${content}</${tag}>`
  );

/**
 * jsonToHTML function returns html view of passed json object
 * @param {*} tag It holds the name of root HTML tag
 * @param {*} content It holds the content of the root element
 * @param {*} attributeList It holds the attribute name and value pair object list of the root HTML element
 * @param {*} childrenList It holds the list of child elements
 */
const jsonToHTML = ({
  tag,
  content = "",
  attributeList = [],
  childrenList = [],
}) => {
  let html = `<${tag} ${attributeList
    .map((attribute) => `${attribute.name + " = '" + attribute.value + "'"}`)
    .join(" ")}>${content} ${childrenList
    .map((childObj) => `${jsonToHTML(childObj)}`)
    .join(" ")}</${tag}>`;

  return html;
};

/****************************
 * DOM manipulation function end
 */
