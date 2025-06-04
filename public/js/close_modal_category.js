document.addEventListener("DOMContentLoaded", () => {
  window.closeModal = function (modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add("opacity-0");
      setTimeout(() => {
        modal.remove();
      }, 100);
    }
  };
});
