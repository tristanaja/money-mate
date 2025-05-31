// assets/js/initAnimateSavingGoal.js

import { animateAmount } from "./animateAmount.js";

export function startSavingGoalAnimation() {
  animateAmount({
    id: "savingGoalAmount",
    start: 0,
    end: parseInt(document.getElementById("savingGoalAmount").dataset.amount),
    duration: 700,
  });
}
