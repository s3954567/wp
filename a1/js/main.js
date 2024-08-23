// Function to navigate to a selected page based on the dropdown menu's value
function navigate(url) {
    if (url) {
        window.location.href = url;
    }
}

// Optional: Add event listener to ensure the script runs after the DOM is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    // Get the dropdown menu
    const dropdown = document.querySelector('nav select');

    // Add event listener to the dropdown menu
    if (dropdown) {
        dropdown.addEventListener('change', function() {
            navigate(this.value);
        });
    }
});
