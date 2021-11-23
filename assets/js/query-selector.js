/************************
 *  querySelector functions start
 */
// Defining jquery style query selector
// selects single element
const $first = (selector, elem = document) => elem.querySelector(selector);
// selects all element
const $all = (selector, elem = document) => elem.querySelectorAll(selector);

/************************
 *  querySelector functions end
 */
