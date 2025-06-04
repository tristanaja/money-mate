function toggleEditCategory(id) {
  const modalId = `editCategoryModal_${id}`;
  const modal = document.getElementById(modalId);

  if (modal) {
    modal.classList.toggle("hidden");
  } else {
    console.warn(
      "Modal or input not found:",
      modalId,
      `editCategoryInput_${id}`
    );
  }
}
