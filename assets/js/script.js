"use strict;";

const registerEvents = () => {
	// Event delegation model for handling show-modal button clicks
	elemRegisterEvent({
		element: document,
		eventName: clickEvent,
		appendEventAsAnArgument: 1,
		// Handle modal pop ups and form submissions
		funcs: [openModalEventHandler, formSubmitButtonClickedEventHandler],
	});

	document.addEventListener(keydownEvent, (event) => {
		if (event.key === "Enter") {
			event.preventDefault();
		}
		if (event.key == "Escape") {
			// Close the opened modal
			closeModal();
		}
	});
	registerFieldEvents($first(".form-submit"));
	if ($first(".searchTableBtn")) $first(".searchTableBtn").click();
};
setTimeout(registerEvents, 1000);
