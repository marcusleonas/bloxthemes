const apiUrl = "https://api.wintertech.xyz/getTheme.php?theme=";

/**
 * Apply the provided theme
 * @param {string} theme
 * @returns void
 */
function applyTheme(theme) {
  // Return if theme is null
  if (!theme) return;

  // Remove existing iframe
  const existing = document.querySelector("#bloxthemesframe");

  if (!existing) {
    const container = document.querySelector("#container-main");

    // Check if container exists
    if (!container) return;

    const iframe = document.createElement("iframe");
    iframe.id = "bloxthemesframe";
    iframe.src = apiUrl + theme;
    iframe.style.top = "0";
    iframe.style.left = "0";
    iframe.style.position = "absolute";
    iframe.style.width = "100%";
    iframe.style.height = "100%";
    iframe.style.zIndex = "-1";
    iframe.frameBorder = "0";

    container.appendChild(iframe);
    return;
  }

  existing.src = apiUrl + theme;
}

/**
 * Load the theme from storage and apply if it exists
 */
function loadTheme() {
  chrome.storage.local.get("theme", (data) => {
    const theme = data.theme;
    if (theme) {
      applyTheme(theme);
    }
  });
}

// Apply provided theme on "applyTheme" message
chrome.runtime.onMessage.addListener((req, sender, res) => {
  if (req.action === "applyTheme") {
    applyTheme(req.theme);
  }
});

window.addEventListener("load", loadTheme);
