function toggleDeleteCategory(id) {
  const modalId = `deleteCategoryModal_${id}`;
  const modal = document.getElementById(modalId);

  if (modal) {
    modal.classList.toggle("hidden");
  } else {
    console.warn(
      "Modal or input not found:",
      modalId,
      `deleteCategoryInput_${id}`
    );
  }
}
