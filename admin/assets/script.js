// Toggle Sidebar for Mobile
document.addEventListener("DOMContentLoaded", () => {
  const header = document.querySelector(".dashboard-gssecurity-header");
  const sidebar = document.querySelector(".dashboard-gssecurity-sidebar");

  // Add toggle button dynamical    ly
  const toggleBtn = document.createElement("button");
  toggleBtn.textContent = "☰ Menu";
  toggleBtn.style.background = "#00adb5";
  toggleBtn.style.color = "#fff";
  toggleBtn.style.border = "none";
  toggleBtn.style.padding = "8px 15px";
  toggleBtn.style.cursor = "pointer";
  toggleBtn.style.borderRadius = "5px";
  toggleBtn.style.marginLeft = "10px";

  header.prepend(toggleBtn);

  toggleBtn.addEventListener("click", () => {
    sidebar.classList.toggle("dashboard-gssecurity-show");
  });
});
