function toggleEditBudget() {
  const modal = document.getElementById("editBudgetModal");
  modal.classList.toggle("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const editBtn = document.getElementById("editBudgetButton");
  editBtn.addEventListener("click", toggleEditBudget);
});

function toggleEditSavingGoal() {
  const modal = document.getElementById("editSavingGoalModal");
  modal.classList.toggle("hidden");
}

document.addEventListener("DOMContentLoaded", () => {
  const editBtn = document.getElementById("editSavingButton");
  editBtn.addEventListener("click", toggleEditSavingGoal);
});
