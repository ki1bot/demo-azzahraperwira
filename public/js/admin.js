(function () {
  const tema = localStorage.getItem("tema-admin-yayasan") || "light";
  document.documentElement.setAttribute("data-admin-theme", tema);
})();

document.addEventListener("DOMContentLoaded", function () {
  const html = document.documentElement;

  const tombolTema = document.getElementById("themeToggle");
  const teksTema = document.getElementById("themeText");
  const ikonTema = document.getElementById("themeIcon");

  const adminProfileButton = document.getElementById("adminProfileButton");
  const adminProfileDropdown = document.getElementById("adminProfileDropdown");

  function setTemaAdmin(tema) {
    html.setAttribute("data-admin-theme", tema);
    localStorage.setItem("tema-admin-yayasan", tema);

    if (teksTema && ikonTema) {
      if (tema === "dark") {
        teksTema.textContent = "Tema Gelap";
        ikonTema.textContent = "☾";
      } else {
        teksTema.textContent = "Tema Terang";
        ikonTema.textContent = "☀";
      }

      return;
    }

    if (tombolTema) {
      tombolTema.textContent = tema === "dark" ? "Tema Gelap" : "Tema Terang";
    }
  }

  setTemaAdmin(localStorage.getItem("tema-admin-yayasan") || "light");

  if (tombolTema) {
    tombolTema.addEventListener("click", function () {
      const temaAktif =
        html.getAttribute("data-admin-theme") === "dark" ? "light" : "dark";
      setTemaAdmin(temaAktif);
    });
  }

  if (adminProfileButton && adminProfileDropdown) {
    adminProfileButton.addEventListener("click", function (event) {
      event.stopPropagation();
      adminProfileDropdown.classList.toggle("show");
    });

    document.addEventListener("click", function (event) {
      if (
        !adminProfileDropdown.contains(event.target) &&
        !adminProfileButton.contains(event.target)
      ) {
        adminProfileDropdown.classList.remove("show");
      }
    });

    document.addEventListener("keydown", function (event) {
      if (event.key === "Escape") {
        adminProfileDropdown.classList.remove("show");
      }
    });
  }

  document
    .querySelectorAll("[data-toggle-password]")
    .forEach(function (button) {
      button.addEventListener("click", function () {
        const inputId = button.getAttribute("data-toggle-password");
        const input = document.getElementById(inputId);

        if (!input) {
          return;
        }

        const sedangPassword = input.getAttribute("type") === "password";

        input.setAttribute("type", sedangPassword ? "text" : "password");
        button.textContent = sedangPassword ? "Tutup" : "Lihat";
        button.setAttribute(
          "aria-label",
          sedangPassword ? "Sembunyikan password" : "Tampilkan password",
        );
      });
    });

  document
    .querySelectorAll("[data-editor-toolbar]")
    .forEach(function (toolbar) {
      const targetId = toolbar.getAttribute("data-editor-toolbar");
      const textarea = document.getElementById(targetId);

      if (!textarea) {
        return;
      }

      const formatMap = {
        bold: ["**", "**", "teks tebal"],
        italic: ["*", "*", "teks miring"],
        underline: ["__", "__", "teks garis bawah"],
        strike: ["~~", "~~", "teks dicoret"],
        code: ["`", "`", "kode"],
      };

      toolbar.querySelectorAll("[data-format]").forEach(function (button) {
        button.addEventListener("click", function () {
          const format = button.getAttribute("data-format");
          const config = formatMap[format];

          if (!config) {
            return;
          }

          const start = textarea.selectionStart;
          const end = textarea.selectionEnd;
          const selected = textarea.value.substring(start, end);
          const text = selected || config[2];
          const replacement = config[0] + text + config[1];

          textarea.value =
            textarea.value.substring(0, start) +
            replacement +
            textarea.value.substring(end);

          textarea.focus();
          textarea.selectionStart = start + config[0].length;
          textarea.selectionEnd = start + config[0].length + text.length;
        });
      });
    });
});
