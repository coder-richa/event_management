// scrollToView scrolls the element's parent container such that the element on which
/**
 * scrollToView function accepts an element and brings the element into view
 * @param {*} elem It holds the element reference
 */
// scrollIntoView() is called is visible to the user
const scrollToView = ({ elem, block = "start", inline = "nearest" }) => {
  // block Optional
  //     Defines vertical alignment.
  //     One of start, center, end, or nearest. Defaults to start.
  // inline Optional
  //     Defines horizontal alignment.
  //     One of start, center, end, or nearest. Defaults to nearest.
  elem.scrollIntoView({ behavior: "smooth", block, inline });
};
