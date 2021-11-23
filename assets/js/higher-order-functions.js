/****************************
 *  Higher order functions start
 */

// Call function from string (function name)
const callFunc = ({ func, thisRef = null, args }) => {
  // return undefined when func is not a string value
  if (typeof func !== "string") return undefined;
  // get function object from string name
  const fn = eval(`${func}`);
  if (typeof fn !== "function") return undefined;
  return (
    // It maps thisRef with this keyword in called function

    fn.call(thisRef, ...args)
  );
};

// callFunctionsOnElement runs function by passing element as an attribute
const callFunctionsOnElement = ({ elem, thisRef = elem, funcs, args = [] }) => {
  // returns array of functions results
  return funcs.map((func) =>
    // When user has passed a function reference then call it directly.
    // Otherwise, call 'callFunc' method
    typeof func === "function"
      ? func.call(thisRef, ...args)
      : callFunc({ func, thisRef, args })
  );
};
// callFunctionsOnElements runs function by passing element as an attribute on every element
const callFunctionsOnElements = ({
  elementNodes = [],
  thisRefs = elementNodes,
  funcs = [],
  valueArray = elementNodes, // Passes element nodes as an argument,
}) =>
  // returns array of functions result
  elementNodes.map((element, i) => {
    // Call all functions on the element
    callFunctionsOnElement({
      elem: element,
      funcs,
      thisRef: thisRefs[i],
      // In case of 1-D array pass ith element as an array value
      // In case of 2-D array pass ith Array as function argument
      args: Array.isArray(valueArray[i]) ? valueArray[i] : [valueArray[i]],
    });
  });

/****************************
 *  Higher order functions ends
 */
