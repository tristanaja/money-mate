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
