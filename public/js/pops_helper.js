function toggleEditBudget() {
  const modal = document.getElementById("editBudgetModal");
  modal.classList.toggle("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const editBtn = document.getElementById("editBudgetButton");
  editBtn.addEventListener("click", toggleEditBudget);
});
