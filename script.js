document.addEventListener("DOMContentLoaded", function() {
    const hamburgerButton = document.querySelector(".hamburger-button");
    const sideNav = document.querySelector("#sidebar");
    const sideNavOverlay = document.querySelector("#sideNavOverlay");

    hamburgerButton.addEventListener("mouseenter", function() {
        sideNav.style.width = "300px"; // Open the side nav
        sideNav.style.left = "0"; // Move the side nav to the visible area
        sideNavOverlay.style.display = "block"; // Display the overlay
    });

    sideNav.addEventListener("mouseleave", function() {
        sideNav.style.width = "0"; // Close the side nav
        sideNav.style.left = "-250px"; // Move the side nav off the screen
        sideNavOverlay.style.display = "none"; // Hide the overlay
    });
});
