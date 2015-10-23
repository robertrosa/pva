/*
* Change the highlighted option on the menu when clicked
* - Identify the option clicked
* - Clear the 'active' class from all other menu items
* - Add the 'active' class to the option clicked
*/

// Get NodeLists of the first level (header) list items and the second level list items
var nav_list_items = document.querySelectorAll("ul#side-menu > li");
var nav_secondlevel_list_items = document.querySelectorAll("ul.nav-second-level > li");

function UpdateMenuDisplay () {
// remove the class attribute from all list elements, first & second level
  for (i=0; i<nav_list_items.length; i++) {
    nav_list_items[i].removeAttribute("class");
  }
  for (i=0; i<nav_secondlevel_list_items.length; i++) {
    nav_secondlevel_list_items[i].removeAttribute("class");
  }
  
// Set the parent list item class to 'active' and the clicked list item class to active
  this.parent.parent.setAttribute("class", "active");
  this.setAttribute("class", "active");
}

for (i=0; i<nav_secondlevel_list_items.length; i++) {
  nav_secondlevel_list_items[i].onclick = UpdateMenuDisplay;
}