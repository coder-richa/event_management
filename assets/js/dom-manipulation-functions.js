/*********************
 * DOM manipulation functions start
 */
// removeElement removes all selected element from the DOM
const removeElement = (selector) => {
  $all(`${selector}`)?.forEach((element) => {
    element?.remove();
  });
};

// appendElement adds element in the DOM
const appendElement = (elem, position, content) => {
  elem?.insertAdjacentHTML(position, content);
};

// appendToParentElement appends HTML to the element
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

// jsonToHTML returns html view of passed json object
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
