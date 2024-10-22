// FS
const fullscreenBtn = document.getElementById("fullscreenBtn");
const logoutBtn = document.getElementById("logoutBtn");

// Fungsi untuk masuk/keluar mode fullscreen
function toggleFullscreen() {
  if (!document.fullscreenElement) {
    document.documentElement.requestFullscreen().catch((err) => {
      console.error(
        `Error trying to enable fullscreen mode: ${err.message} (${err.name})`
      );
    });
  } else {
    if (document.exitFullscreen) {
      document.exitFullscreen();
    }
  }
}

// Event listener untuk tombol fullscreen
fullscreenBtn.addEventListener("click", toggleFullscreen);

// Fungsi untuk mengupdate visibilitas logout button
function updateLogoutButtonVisibility() {
  if (document.fullscreenElement) {
    logoutBtn.style.display = "none"; // Sembunyikan tombol logout
  } else {
    logoutBtn.style.display = "block"; // Tampilkan tombol logout
  }
}

// Perubahan status fullscreen
document.addEventListener("fullscreenchange", updateLogoutButtonVisibility);
document.addEventListener(
  "webkitfullscreenchange",
  updateLogoutButtonVisibility
); // Untuk Safari
document.addEventListener("mozfullscreenchange", updateLogoutButtonVisibility); // Untuk Firefox
document.addEventListener("MSFullscreenChange", updateLogoutButtonVisibility); // Untuk IE/Edge


