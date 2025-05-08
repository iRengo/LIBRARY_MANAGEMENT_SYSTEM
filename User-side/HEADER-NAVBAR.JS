// Add hovered class to selected list item
let list = document.querySelectorAll(".navigation li");

function activeLink() {
  list.forEach((item) => {
    item.classList.remove("hovered");
  });
  this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover", activeLink));

// Menu Toggle
let toggle = document.querySelector(".toggle");
let navigation = document.querySelector(".navigation");
let main = document.querySelector(".main");
let topbar = document.querySelector(".topbar");  // Add reference to topbar

toggle.onclick = function () {
  navigation.classList.toggle("active");
  main.classList.toggle("active");
  topbar.classList.toggle("active"); // Toggle active class for topbar
};
document.getElementById('toggleNotifications').addEventListener('click', function (e) {
  e.preventDefault();
  const panel = document.getElementById('notificationPanel');

  // Toggle visibility
  if (panel.style.display === 'block') {
      panel.style.display = 'none';
      return;
  }

  // Fetch content from PHP
  fetch('USER_NOTIFICATION_PANEL.php')
      .then(res => res.text())
      .then(data => {
          panel.innerHTML = data;
          panel.style.display = 'block';

          // 🔁 Rebind view-more click event
          document.querySelectorAll('.view-more').forEach(item => {
              item.addEventListener('click', function () {
                  const title = this.dataset.title;
                  const status = this.dataset.status;
                  const contact = this.dataset.contact;
                  const date = this.dataset.date;
                  const updated = this.dataset.updated;

                  Swal.fire({
                      title: 'Borrowing Details',
                      html: `
                          <strong>Title:</strong> ${title}<br>
                          <strong>Status:</strong> ${status}<br>
                          <strong>Contact:</strong> ${contact}<br>
                          <strong>Preferred Date:</strong> ${date}<br>
                          <strong>Last Updated:</strong> ${updated}
                      `,
                      icon: 'info',
                      confirmButtonText: 'Close'
                  });
              });
          });
      });
});
