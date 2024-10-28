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

