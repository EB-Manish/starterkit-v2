/**
 * File navigation.js.
 *
 * Handles toggling the Search form on mobile
 */

(function () {
  /**
   * Sub menu mobile handle
   */
  const searchForm = document.querySelector(".site-header-search");

  // Return early if the navigation doesn't exist.
  if (!searchForm) {
    return;
  }

  const headerSearchButton = document.getElementById(
    "site-header-search-toggle"
  );

  // Return early if the button doesn't exist.
  if (!headerSearchButton) {
    return;
  }

  // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
  headerSearchButton.addEventListener("click", function (e) {
    e.preventDefault();

    headerSearchButton.classList.toggle("open");
    if (!searchForm.classList.contains("open-search")) {
      searchForm.classList.add("open-search");
      searchForm.style.height = "auto";
      var height = searchForm.clientHeight + "px";
      searchForm.style.height = "0px";
      setTimeout(function () {
        searchForm.style.height = height;
      }, 0);
    } else {
      searchForm.style.height = "0px";

      searchForm.classList.remove("open-search");
      // remove class only after completing the transition
      // searchForm.addEventListener('transitionend', function () {
      // }, {
      // 	once: true
      // });
    }
  });
})();
