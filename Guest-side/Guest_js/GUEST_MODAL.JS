document.getElementById("logoutIcon").addEventListener("click", function(event) {event.preventDefault();
    document.getElementById("logoutModal").style.display = "block";});
    
    document.querySelector(".close").addEventListener("click", function() {
    document.getElementById("logoutModal").style.display = "none";});
    
    document.getElementById("cancelLogout").addEventListener("click", function() {
    document.getElementById("logoutModal").style.display = "none";});
    
            // Close modal if user clicks outside it
    window.onclick = function(event) {
        if (event.target == document.getElementById("logoutModal")) {
            document.getElementById("logoutModal").style.display = "none";
                }
        };