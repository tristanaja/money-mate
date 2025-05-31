// public/js/mainAnimate.js
import { startBudgetAnimation } from "./initAnimateBudget.js";
import { startSavingGoalAnimation } from "./initAnimateSavingGoal.js";

document.addEventListener("DOMContentLoaded", () => {
  const errorModal = document.getElementById("errorModal");
  const successModal = document.getElementById("successModal");

  if (!errorModal && !successModal) {
    startBudgetAnimation();
    startSavingGoalAnimation();
  }

  window.closeModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add("opacity-0");
      setTimeout(() => {
        modal.remove();

        // After modal is removed, trigger animation
        startBudgetAnimation();
        startSavingGoalAnimation();
      }, 100); // wait a bit for animation (adjust if needed)
    }
  };
});
