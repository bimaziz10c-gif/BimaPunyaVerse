
const root = document.documentElement;
const tombolTema = document.getElementById("themeToggle");

function temaSaatIni() {
    return root.getAttribute("data-theme") === "dark" ? "dark" : "light";
}

function terapkanTema(tema) {
    root.setAttribute("data-theme", tema);

    if (tombolTema) {
        const gelap = tema === "dark";
        tombolTema.setAttribute("aria-pressed", String(gelap));
        tombolTema.setAttribute(
            "aria-label",
            gelap ? "Ganti ke mode terang" : "Ganti ke mode gelap"
        );
    }
}

function simpanTema(tema) {
    try {
        localStorage.setItem("tema", tema);
    } catch (e) {
        
    }
}


terapkanTema(temaSaatIni());

if (tombolTema) {
    tombolTema.addEventListener("click", function () {
        const baru = temaSaatIni() === "dark" ? "light" : "dark";
        terapkanTema(baru);
        simpanTema(baru);
    });
}


const queryGelap = window.matchMedia("(prefers-color-scheme: dark)");
queryGelap.addEventListener("change", function (event) {
    let sudahMemilih = false;
    try {
        sudahMemilih = localStorage.getItem("tema") !== null;
    } catch (e) { }

    if (!sudahMemilih) {
        terapkanTema(event.matches ? "dark" : "light");
    }
});

    window.addEventListener("load", function () {
        var varHero = getComputedStyle(document.documentElement).getPropertyValue("--hero-bg");
        if (varHero.trim() !== "") return;

        var banner = document.createElement("div");
        banner.setAttribute("role", "alert");
        banner.style.cssText = "position:fixed;left:0;right:0;bottom:0;z-index:9999;padding:12px 16px;" +
            "background:#7A2623;color:#fff;font:14px/1.5 sans-serif;text-align:center;";
        banner.textContent = "Fitur tema belum aktif: style.css masih versi lama. " +
            "Timpa public/css/style.css dengan versi terbaru, lalu tekan Ctrl+F5.";
        document.body.appendChild(banner);
    });