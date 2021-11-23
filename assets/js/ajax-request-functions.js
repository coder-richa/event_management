// https://developers.google.com/web/updates/2015/03/introduction-to-fetch
// https://developer.mozilla.org/en-US/docs/Web/API/Request/mode

// createRequest retuns promise of requested url
const createRequest = ({
  url,
  body = new FormData(),
  method = "get",
  mode = "cors",
}) =>
  // GET and HEAD method does not have request body
  fetch(
    url,
    ["get", "head"].includes(method.toLowerCase())
      ? { method, mode }
      : { body, method, mode }
  );

// processRequestStatus rejects error in case something went wrong
// otherwise, returns response as a promise
const processRequestStatus = (response) => {
  if (response.status >= 200 && response.status < 300) {
    return Promise.resolve(response);
  } else {
    return Promise.reject(new Error(response.statusText));
  }
};

//processRequestJSON returns json from response
const processRequestJSON = async (response) => {
  const js = response.json();
  return js;
};

// getResponseMetaData returns map of response headers
const getResponseMetaData = (response) =>
  new Map()
    .set("Content-Type", response.headers.get("Content-Type"))
    .set("Date", response.headers.get("Date"))
    .set("Status", response.status)
    .set("Status-Text", response.statusText)
    .set("Type", response.type)
    .set("URL", response.url);

// getResponseJSON returns response json
const getResponseJSON = async ({
  url,
  body = new FormData(),
  method = "get",
  mode = "cors",
}) => {
  let responseJson;
  try {
    let response = await createRequest({ url, body, method, mode });
    response = await processRequestStatus(response);
    console.log("Response",response);
    responseJson = await processRequestJSON(response);
    console.log("responseJson",responseJson);
  } catch (err) {
    renderError(err);
    responseJson = {
      success: 0,
      message: "Something went wrong",
    };
  }
  return responseJson;
};
const renderError = (err) => {
  console.warn(err.message);
};

// getResponseJSON({url: 'https://api.country.is'}).then(data=>console.log(data))
// getResponseJSON({url: 'http://localhost/practice/api/login/signup.php'}).then(data=>console.log(data)).catch(renderError)

// getResponseJSON({url: 'http://localhost/event_management/api/state/get.php'}).then(data=>jsonToHTML({
//     tag: data.tag,
//     attributeList: [],
//     childrenList:data.childrenList,
//   })).then(data=>console.log(data))
