// Function to set the theme based on the current state
function setTheme(isDarkMode) {
    const themeStyle = document.getElementById("theme-style");
    if (themeStyle) {
        themeStyle.href = isDarkMode ? "https://cdn.jsdelivr.net/npm/water.css@2/out/dark.css" : "https://cdn.jsdelivr.net/npm/water.css@2/out/light.css";
        // Save the current state to localStorage
        localStorage.setItem("isDarkMode", isDarkMode);
    } else {
        console.error("Theme style link element not found");
    }
}

// Function to toggle dark mode on/off
function toggleDarkMode() {
    const isDarkMode = localStorage.getItem("isDarkMode") === "true";
    setTheme(!isDarkMode); // Invert the current state
}

// Set initial theme based on localStorage or default to light mode
const isDarkMode = localStorage.getItem("isDarkMode") === "true";
setTheme(isDarkMode);
