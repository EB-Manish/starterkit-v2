/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
// import addIcon from "../images/add.svg";

(function () {
  const siteNavigation = document.getElementById("menu-container");

  // Return early if the navigation doesn't exist.
  if (!siteNavigation) {
    return;
  }

  const button = document.getElementById("site-header-menu-toggle");

  // Return early if the button doesn't exist.
  if (!button) {
    return;
  }

  const menu = siteNavigation.getElementsByTagName("ul")[0];

  // Hide menu toggle button if menu is empty and return early.
  if ("undefined" === typeof menu) {
    button.style.display = "none";
    return;
  }

  if (!menu.classList.contains("nav-menu")) {
    menu.classList.add("nav-menu");
  }
  // Toggle the .toggled class and the aria-expanded value each time the button is clicked.
  button.addEventListener("click", function (e) {
    e.preventDefault();

    button.classList.toggle("open");
    if (!siteNavigation.classList.contains("open-menu")) {
      siteNavigation.classList.add("open-menu");
      siteNavigation.style.height = "auto";
      var height = siteNavigation.clientHeight + "px";
      siteNavigation.style.height = "0px";
      setTimeout(function () {
        siteNavigation.style.height = height;
      }, 0);
    } else {
      siteNavigation.style.height = "0px";

      siteNavigation.classList.remove("open-menu");
      // remove class only after completing the transition
      // siteNavigation.addEventListener('transitionend', function () {
      // }, {
      // 	once: true
      // });
    }
  });

  // Remove the .toggled class and set aria-expanded to false when the user clicks outside the navigation.
  document.addEventListener("click", function (event) {
    const isClickInside = siteNavigation.contains(event.target);

    if (!isClickInside) {
      siteNavigation.classList.remove("toggled");
      button.setAttribute("aria-expanded", "false");
    }
  });

  // Get all the link elements within the menu.
  const links = menu.getElementsByTagName("a");

  // Get all the link elements with children within the menu.
  const linksWithChildren = menu.querySelectorAll(
    ".menu-item-has-children > a, .page_item_has_children > a"
  );

  // Toggle focus each time a menu link is focused or blurred.
  for (const link of links) {
    link.addEventListener("focus", toggleFocus, true);
    link.addEventListener("blur", toggleFocus, true);
  }

  // Toggle focus each time a menu link with children receive a touch event.
  for (const link of linksWithChildren) {
    link.addEventListener("touchstart", toggleFocus, false);
  }

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    if (event.type === "focus" || event.type === "blur") {
      let self = this;
      // Move up through the ancestors of the current link until we hit .nav-menu.
      while (!self.classList.contains("nav-menu")) {
        // On li elements toggle the class .focus.
        if ("li" === self.tagName.toLowerCase()) {
          self.classList.toggle("focus");
        }
        self = self.parentNode;
      }
    }

    if (event.type === "touchstart") {
      const menuItem = this.parentNode;
      event.preventDefault();
      for (const link of menuItem.parentNode.children) {
        if (menuItem !== link) {
          link.classList.remove("focus");
        }
      }
      menuItem.classList.toggle("focus");
    }
  }

  /**
   * Sub menu mobile handle
   */

  function submenuToggle(item) {    
    item.addEventListener("click", (e) => {
      e.preventDefault();
      // alert(1);
      console.log('test', e.target);
      var currentDropDown = e.target.nextSibling,
      parentEl = e.target.parentNode.parentNode;

      e.target.classList.toggle("open");
      if (!currentDropDown.classList.contains("open-menu")) {
        currentDropDown.classList.add("open-menu");
        currentDropDown.style.height = "auto";
        var height = currentDropDown.clientHeight + "px";
        var menuHeight =
          Number(siteNavigation.clientHeight) +
          Number(currentDropDown.clientHeight);
        currentDropDown.style.height = "0px";
        siteNavigation.style.height = menuHeight + "px";

        setTimeout(function () {
          currentDropDown.style.height = height;
        }, 0);
      } else {
        var menuHeight =
          Number(siteNavigation.clientHeight) -
          Number(currentDropDown.clientHeight);
        siteNavigation.style.height = menuHeight - 1 + "px";
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
        var menuHeight =
          Number(siteNavigation.clientHeight) +
          Number(currentDropDown.clientHeight);
        var parentHeight = Number(parentEl.clientHeight);
        var childHeight = Number(currentDropDown.clientHeight);
        var prHeight = parentHeight + childHeight;

        prHeight = parentHeight + childHeight;

        currentDropDown.style.height = "0px";
        siteNavigation.style.height = menuHeight + "px";
        parentEl.style.height = prHeight + "px";

        setTimeout(function () {
          currentDropDown.style.height = height;
        }, 0);
      } else {
        var menuHeight =
          Number(siteNavigation.clientHeight) -
          Number(currentDropDown.clientHeight);

        var parentHeight = Number(parentEl.clientHeight);
        var childHeight = Number(currentDropDown.clientHeight);
        var prHeight = parentHeight - childHeight;

        siteNavigation.style.height = menuHeight - 1 + "px";
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
    document.querySelectorAll(".menu-item-has-children")
  );

  hasChildren.map((item) => {
    var dropDown = item.querySelector("ul"),
      iconWrapper = document.createElement("SPAN");
    iconWrapper.classList.add("icon-wrapper", "d-lg-none");
    item.insertBefore(iconWrapper, dropDown);
  });

  const submenuIcon = Array.from(
    document.querySelectorAll(
      ".primary-menu > ul > .menu-item-has-children > .icon-wrapper"
    )
  );
  submenuIcon.map((item) => {
    submenuToggle(item);
  });

  const subOfSubIcon = Array.from(
    document.querySelectorAll(
      ".menu-item-has-children .menu-item-has-children > .icon-wrapper"
    )
  );
  subOfSubIcon.map((item) => {
    subOfSubToggle(item);
  });



})();
// on scroll event add class 
let scrollpos = window.scrollY;

var header = document.getElementById("site-header");
var scrollChange = 30;
var mainDiv = document.getElementById("page");
window.addEventListener('scroll', function() { 
  scrollpos = window.scrollY;

  if (scrollpos >= scrollChange && mainDiv.classList.contains('page-with-fixed-header' )) { 
    header.classList.add("scrolled");
  }
  else { 
    header.classList.remove("scrolled");
   }
  
})
