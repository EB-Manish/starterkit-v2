import counterUp from "counterup2";

// const counterUp = window.counterUp.default;

const handleCounter = (entries) => {
  entries.forEach((entry) => {
    var el = entry.target;
    if (entry.isIntersecting && !el.classList.contains("is-visible")) {
      counterUp(el, {
        duration: 1000,
        // delay: 0,
      });
      el.classList.add("is-visible");
    }
  });
};
document.addEventListener("DOMContentLoaded", function () {
  const couterItem = document.querySelectorAll(".stats, .counter-num");
  const observer = new IntersectionObserver(handleCounter, { threshold: 1 });
  couterItem.forEach((item) => observer.observe(item));
});
