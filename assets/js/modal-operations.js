let overlay = $first(".overlay");
let closeButton = $first(".close-modal");
const modalClassesUpdate = (modal, operation) => {
	if (modal) {
		updateClass(modal, operation, "hidden");
		updateClass(overlay, operation, "hidden");
	}
};

const openModal = (modal) => {
	modalClassesUpdate(modal, "remove");
};
const closeModal = () => {
	const modal = [...$all(".modal")].find(
		(elem) => !elem.classList.contains("hidden")
	);
	const forms = [...$all("form", modal)];
	if (forms) {
		forms.forEach(unregisterFieldEvents);
	}
	swapModalContent(modal);
	modalClassesUpdate(modal, "add");
};

const swapModalContent = (modal) => {
	const contentSelector = getDataAttributeValue(modal, "content", "");
	if (contentSelector != "" && $first(contentSelector)) {
		[
			$first(".modal-body", modal).innerHTML,
			$first(contentSelector).innerHTML,
		] = [
			$first(contentSelector).innerHTML,
			$first(".modal-body", modal).innerHTML,
		];
	}
};

const openModalEventHandler = (event) => {
	// Get targeted Button
	const modalElem = event.target?.closest(".show-modal");
	if (modalElem) {
		// When Button with show-modal class is clicked
		// Read target modal and content data attributes
		const modalSelector = getDataAttributeValue(modalElem, "modal", ".modal");
		const modal = $first(modalSelector);

		const contentSelector = getDataAttributeValue(modalElem, "content");
		const title = getDataAttributeValue(modalElem, "title");
		if ($first(contentSelector)) {
			modal.dataset.content = contentSelector;
			// Update modal content
			swapModalContent(modal, contentSelector);
			updateModelContent({ modal, title });
			// Open modal
			openModal(modal);
		}
	}
};

const updateModelContent = ({
	modal,
	title,
	hasNewBodyContent = false,
	content = "",
}) => {
	$first(".modal-title", modal).innerHTML = title;
	if (hasNewBodyContent) $first(".modal-body", modal).innerHTML = content;
	const forms = [...$all("form", modal)];
	if (forms) {
		forms.forEach(registerFieldEvents);
	}
};

// Register event listeners to close modal
elemListRegisterEvent({
	elementNodes: [closeButton, overlay],
	eventName: clickEvent,
	funcs: [closeModal],
});
