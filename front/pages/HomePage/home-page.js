function checkAuth() {
    const user = localStorage.getItem("User");
    
    if (!user) {
        // redirect to auth page if not logged in
        window.location.href = "../AuthPage/auth-page.html";
        return null;
    }
    
    try {
        return JSON.parse(user);
    } catch (err) {
        console.error("Error parsing user data:", err);
        localStorage.removeItem("User");
        window.location.href = "../AuthPage/auth-page.html";
        return null;
    }
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
        const greetingElement = document.getElementById("userGreeting");
        if (greetingElement) {
            const userName = userData.data.user_name || "User";
            greetingElement.textContent = `Hello, ${userName}!`;
        }

        const userAvatar = document.getElementById("userAvatar");
        if (userAvatar) {
            userAvatar.addEventListener("click", (e) => {
                e.stopPropagation();
                toggleDropdown();
            });
        }

        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", logout);
        }
    }
});
