// JavaScript for tab switching
        function showContent(section) {
            const sections = document.querySelectorAll('.content-section');
            const buttons = document.querySelectorAll('.sub_buttons button');

            // Hide all sections
            sections.forEach(sec => sec.style.display = 'none');
            document.getElementById(section).style.display = 'block';

            // Remove 'active' class from all buttons
            buttons.forEach(btn => btn.classList.remove('active'));
            document.getElementById(section + '-btn').classList.add('active');
        }

        // Initial load
        window.onload = function() {
            showContent('account');
        };

        