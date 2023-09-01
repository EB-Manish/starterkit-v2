/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
// import addIcon from "../images/add.svg";

(function () {
  /**
   * Sub menu mobile handle
   */

  function submenuToggle(item) {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      var currentDropDown = e.target.nextSibling;

      e.target.classList.toggle("open");
      if (!currentDropDown.classList.contains("open-menu")) {
        currentDropDown.classList.add("open-menu");
        currentDropDown.style.height = "auto";
        var height = currentDropDown.clientHeight + "px";

        currentDropDown.style.height = "0px";

        setTimeout(function () {
          currentDropDown.style.height = height;
        }, 0);
      } else {
        currentDropDown.classList.remove("open-menu");
        currentDropDown.style.height = "0px";
        // remove class only after completing the transition
        // currentDropDown.addEventListener('transitionend', function () {

        // }, {
        // 	once: true
        // });
      }
    });
  }

  function subOfSubToggle(item) {
    item.addEventListener("click", (e) => {
      e.preventDefault();

      var currentDropDown = e.target.nextSibling,
        parentEl = e.target.parentNode.parentNode;

      e.target.classList.toggle("open");
      if (!currentDropDown.classList.contains("open-menu")) {
        currentDropDown.classList.add("open-menu");
        currentDropDown.style.height = "auto";
        var height = currentDropDown.clientHeight + "px";
        // var menuHeight =
        //   Number(siteNavigation.clientHeight) +
        //   Number(currentDropDown.clientHeight);
        var parentHeight = Number(parentEl.clientHeight);
        var childHeight = Number(currentDropDown.clientHeight);
        var prHeight = parentHeight + childHeight;

        prHeight = parentHeight + childHeight;

        currentDropDown.style.height = "0px";
        // siteNavigation.style.height = menuHeight + "px";
        parentEl.style.height = prHeight + "px";

        setTimeout(function () {
          currentDropDown.style.height = height;
        }, 0);
      } else {
        // var menuHeight =
        //   Number(siteNavigation.clientHeight) -
        //   Number(currentDropDown.clientHeight);

        var parentHeight = Number(parentEl.clientHeight);
        var childHeight = Number(currentDropDown.clientHeight);
        var prHeight = parentHeight - childHeight;

        // siteNavigation.style.height = menuHeight - 1 + "px";
        currentDropDown.classList.remove("open-menu");
        currentDropDown.style.height = "0px";

        parentEl.style.height = prHeight + 1 + "px";

        // remove class only after completing the transition
        // currentDropDown.addEventListener('transitionend', function () {

        // }, {
        // 	once: true
        // });
      }
    });
  }

  var hasChildren = Array.from(
    document.querySelectorAll(".navigation-2 .menu-item-has-children")
  );

  hasChildren.map((item) => {
    var dropDown = item.querySelector("ul"),
      iconWrapper = document.createElement("SPAN");
    iconWrapper.classList.add("icon-wrapper");
    item.insertBefore(iconWrapper, dropDown);
  });

  const submenuIcon = Array.from(
    document.querySelectorAll(".navigation-2 .primary-menu > ul > .menu-item-has-children > .icon-wrapper")
  );
  submenuIcon.map((item) => {
    submenuToggle(item);
  });

  const subOfSubIcon = Array.from(
    document.querySelectorAll(
      ".navigation-2 .menu-item-has-children .menu-item-has-children > .icon-wrapper"
    )
  );
  subOfSubIcon.map((item) => {
    subOfSubToggle(item);
  });

})();
