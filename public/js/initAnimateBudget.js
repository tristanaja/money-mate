// assets/js/initAnimateSavingGoal.js

import { animateAmount } from "./animateAmount.js";

export function startBudgetAnimation() {
  animateAmount({
    id: "budgetAmount",
    start: 0,
    end: parseInt(document.getElementById("budgetAmount").dataset.amount),
    duration: 700,
  });
}
