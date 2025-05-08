document.addEventListener("DOMContentLoaded", function () {
    // Get all navigation links and content sections
    const navLinks = document.querySelectorAll(".sidebar a");
    const sections = document.querySelectorAll(".content-section");

    // Show only the default section
    sections.forEach(section => section.classList.remove("active"));
    document.getElementById("clockin").classList.add("active");

    // Handle sidebar clicks
    navLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent default link behavior

            // Get the target section's ID from href
            const targetId = this.getAttribute("href").substring(1);

            // Hide all sections
            sections.forEach(section => section.classList.remove("active"));

            // Show the clicked section
            document.getElementById(targetId).classList.add("active");
        });
    });

    // Add functionality to "Home" button (redirects to login page)
    const homeButton = document.querySelector('.home-btn');  // Get the existing Home button

    // Add event listener for the "Home" button
    if (homeButton) {
        homeButton.addEventListener("click", function () {
            window.location.href = 'index.html';  // Redirect to login page
        });
    }
});
