const button = document.querySelector("#applyTheme");

if (!button) {
  console.error("button not found");
}

document.addEventListener("DOMContentLoaded", async () => {
  const select = document.querySelector("#themeSelect");

  try {
    select.innerHTML = "";

    const themes = await fetch(
      "https://api.wintertech.xyz/getTheme.php?theme=get"
    ).catch((err) => console.error(err));

    console.log(JSON.stringify(themes));

    const json = await themes.json();
    if (!json) {
      console.error("json not found");
      return;
    }

    chrome.storage.local.get("theme", (data) => {
      for (const theme in json) {
        const option = document.createElement("option");
        option.value = theme;
        option.innerHTML = theme.charAt(0).toUpperCase() + theme.slice(1);

        if (theme === data.theme) {
          option.selected = true;
        }

        select.appendChild(option);
      }
    });
  } catch (error) {
    console.error(error);
  }
});

button.addEventListener("click", () => {
  const select = document.getElementById("themeSelect");
  const selectedTheme = select.value;

  chrome.storage.local.set({ theme: selectedTheme }, (tabs) => {
    console.log(`theme set to ${selectedTheme}`);
    const confirm = document.createElement("p");
    confirm.innerHTML = `Set theme to ${selectedTheme}`;
    document.body.append(confirm);
    setTimeout(() => {
      confirm.remove();
    }, 2000);
  });

  chrome.tabs.query({ active: true, currentWindow: true }, (tabs) => {
    chrome.tabs.sendMessage(tabs[0].id, {
      action: "applyTheme",
      theme: selectedTheme,
    });
  });
});
