const pageDown = document.querySelectorAll(".page-down");

for (var i = 0; i < pageDown.length; i++) {
  pageDown[i].addEventListener("click", function (event) {
    siblingDiv = this.closest("section").nextElementSibling;
    if (siblingDiv) {
      siblingDiv.scrollIntoView();
    } else {
      return false;
    }
  });
}
