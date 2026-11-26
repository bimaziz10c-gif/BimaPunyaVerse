
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

 //<form action="index.php#tentang" method="GET" class="greet-form">
            //<label for="namaPengunjung">Sapa saya:</label>
            //<input type="text" id="namaPengunjung" name="nama" placeholder="Masukkan nama Anda"
                //value="<?= e($namaPengunjung) ?>">
            //<button type="submit" class="btn btn-primary">Kirim</button>
        //</form>
        //<?php if (isset($_GET['nama']) && $namaPengunjung !== ''): ?>
            //<p class="greet-result">Halo, <?= e($namaPengunjung) ?>! Selamat datang di portfolio saya.</p>
        //<?php endif; ?>