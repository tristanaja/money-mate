function goToPage(element) {
  const url = element.getAttribute("data-url");
  if (url) {
    window.location.href = url;
  }
}

function toggleMobileMenu() {
  const menu = document.getElementById("mobileMenu");
  const isOpen = menu.classList.contains("translate-x-0");

  if (isOpen) {
    menu.classList.add("translate-x-full", "opacity-0", "pointer-events-none");
    menu.classList.remove(
      "translate-x-0",
      "opacity-100",
      "pointer-events-auto"
    );
  } else {
    menu.classList.add("translate-x-0", "opacity-100", "pointer-events-auto");
    menu.classList.remove(
      "translate-x-full",
      "opacity-0",
      "pointer-events-none"
    );
  }
}

function closeModal(modalId) {
  const modal = document.getElementById(modalId);
  if (modal) modal.remove();

  // Only start animation after closing success modal
  // You can customize per modal type here
  if (modalId === "successModal" || modalId === "errorModal") {
    const budgetEl = document.getElementById("budgetAmount");
    if (budgetEl) {
      animateBudgetAmount(0, window.currentBudget || 0);
    }
  }
}

function animateBudgetAmount(start, end, duration = 500) {
  const el = document.getElementById("budgetAmount");
  if (!el) return;

  const startTime = performance.now();

  function formatRupiah(value) {
    return "Rp " + value.toLocaleString("id-ID");
  }

  function update(timestamp) {
    const progress = Math.min((timestamp - startTime) / duration, 1);
    const current = Math.floor(progress * (end - start) + start);
    el.textContent = formatRupiah(current);

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}
