export function animateAmount({ id, start = 0, end, duration = 500 }) {
  const el = document.getElementById(id);
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
