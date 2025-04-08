document.addEventListener("DOMContentLoaded", function () {
  const sidebar = document.querySelector(".sidebar");
  const navbar = document.querySelector(".navbar");
  const content = document.querySelector(".content");
  const trigger = document.querySelector(".sidebar-trigger");

  // Function to show the sidebar
  function showSidebar() {
    sidebar.classList.remove("hidden");
    navbar.classList.remove("collapsed");
    content.classList.remove("collapsed");
  }

  // Function to hide the sidebar
  function hideSidebar() {
    sidebar.classList.add("hidden");
    navbar.classList.add("collapsed");
    content.classList.add("collapsed");
  }

  // Show sidebar when hovering over the trigger area
  trigger.addEventListener("mouseenter", showSidebar);

  // Hide sidebar when mouse leaves the sidebar
  sidebar.addEventListener("mouseleave", hideSidebar);

  // Ensure sidebar stays visible when mouse is over it
  sidebar.addEventListener("mouseenter", showSidebar);
});
