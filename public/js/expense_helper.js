function toggleAddExpense() {
  const modal = document.getElementById("addExpenseModal");
  modal.classList.toggle("hidden");
}

function toggleExpenseDetails(id) {
  const details = document.getElementById(id);
  const arrow = document.querySelector(`#${id} ~ div img`);
  if (details.classList.contains("hidden")) {
    details.classList.remove("hidden");
    arrow.classList.add("rotate-180");
  } else {
    details.classList.add("hidden");
    arrow.classList.remove("rotate-180");
  }
}

function toggleEditExpense(id) {
  const modalId = `editExpenseModal_${id}`;
  const modal = document.getElementById(modalId);

  if (modal) {
    modal.classList.toggle("hidden");
  } else {
    console.warn(
      "Modal or input not found:",
      modalId,
      `editExpenseInput_${id}`
    );
  }
}
