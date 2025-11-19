function checkAuth() {
    const user = localStorage.getItem("User");
    
    if (!user) {
        // redirecting to auth page if not logged in
        window.location.href = "../AuthPage/auth-page.html";
        return;
    }
    return JSON.parse(user);
}

function toggleDropdown() {
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.classList.toggle("show");
}

function logout() {
    localStorage.removeItem("User");
    window.location.href = "../AuthPage/auth-page.html";
}

document.addEventListener("DOMContentLoaded", () => {
    const userData = checkAuth();
    
    if (userData) {
        const userAvatar = document.getElementById("userAvatar");
        if (userAvatar) {
            userAvatar.addEventListener("click", toggleDropdown); 
        }

        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", logout);
        }
    }
});