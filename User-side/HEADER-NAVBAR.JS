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
document.getElementById('notificationPanel').addEventListener('click', function (e) {
    let notificationItem = e.target.closest('.notification-item');
    if (!notificationItem) return;

    const notifId = notificationItem.getAttribute('data-notif-id');

    if (notifId) {
        fetch('../homepage/mark_notification_read.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'notif_id=' + encodeURIComponent(notifId)
        }).then(res => res.text()).then(console.log).catch(console.error);
    }

    const bookCover = notificationItem.getAttribute('data-book-cover');
    const bookTitle = notificationItem.getAttribute('data-book-title') || 'No Title';
    const message = notificationItem.getAttribute('data-message') || '';
    const createdAt = notificationItem.getAttribute('data-created-at') || '';
    const bookId = notificationItem.getAttribute('data-book-id');
    const type = notificationItem.getAttribute('data-type');
    const proof = notificationItem.getAttribute('data-proof');
    const fineId = notificationItem.getAttribute('data-fine-id');
    const fineName = notificationItem.getAttribute('data-fine-name');
    const finePrice = notificationItem.getAttribute('data-fine-price');


    const dateStr = new Date(createdAt).toLocaleString();

    let statusClass = 'status-other';
    if (type === 'approved') statusClass = 'status-approved';
    else if (type === 'rejected') statusClass = 'status-rejected';
    else if (type === 'overdue') statusClass = 'status-overdue';
    else if (type === 'due_today') statusClass = 'status-due-today';

    let htmlContent = `
${bookCover ? `<img src="${bookCover}" alt="Book Cover" class="swal-book-cover" />` : ''}
<div class="swal-book-title">${bookTitle}</div>
<div class="swal-status ${statusClass}">${type.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())}</div>
<div class="swal-message">${message}</div>
`;

    if (type === 'pending_fine' && fineId && finePrice) {
        htmlContent += `
    <div class="swal-fine-info">
        <strong>Fine Name:</strong> ${fineName || 'N/A'}<br>
        <strong>Damage Price:</strong> ₱${finePrice}
    </div>
    `;
    }

    htmlContent += `<div class="swal-time">Sent on: ${dateStr}</div>`;

    if (type === 'rejected' && bookId) {
        htmlContent += `<a href="BOOK-DETAILS.php?book_id=${encodeURIComponent(bookId)}" class="resubmit-btn">Resubmit</a>`;
    }

    if (type === 'pending_fine' && proof) {
        htmlContent += `<br><button class="view-proof-btn" onclick="viewProofImage('${proof}', '${fineName}', '${finePrice}')">View Proof</button>`;
    }


    Swal.fire({
        title: 'Notification Details',
        html: htmlContent,
        icon: (type === 'approved' ? 'success' : (type === 'rejected' ? 'error' : 'info')),
        showCloseButton: true,
        showConfirmButton: false,
        focusConfirm: false,
        width: '400px',
        allowOutsideClick: true,
    });
});
function viewProofImage(imageUrl, fineName, finePrice) {
    if (imageUrl) {
        Swal.fire({
            title: `Proof for ${fineName} - ₱${finePrice}`,
            imageUrl: imageUrl,
            imageAlt: 'Proof Image',
            width: 600,
            imageWidth: 500,
            imageHeight: 400,
            confirmButtonText: 'Close'
        });
    } else {
        Swal.fire({
            icon: 'info',
            title: 'No proof available',
            text: 'There is no proof image uploaded for this fine.'
        });
    }
}
