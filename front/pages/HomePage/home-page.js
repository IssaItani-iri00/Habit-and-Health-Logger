function checkAuth() {
    const user = localStorage.getItem("User");
    
    if (!user) {
        // redirect to auth page if not logged in
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

async function submitEntry() {
    const entryInput = document.getElementById("entryInput");
    const entryError = document.getElementById("entryError");
    const submitBtn = document.getElementById("submitEntry");
    const url = "http://localhost:8000";
    
    const rawText = entryInput.value.trim();
    
    if (!rawText) {
        entryError.textContent = "Please enter your daily log";
        return;
    }
    
    const userData = JSON.parse(localStorage.getItem("User"));
    const userId = userData.data.user_id;
    
    try {
        submitBtn.disabled = true;
        submitBtn.textContent = "Logging...";
        entryError.textContent = "";
        
        const res = await axios.post(`${url}/entries/create`, {
            user_id: userId,
            raw_text: rawText
        });
        
        if (res.status === 200) {
            entryInput.value = "";
            entryError.style.color = "#44B144";
            entryError.textContent = "Entry logged successfully!";
            
            setTimeout(() => {
                entryError.textContent = "";
                entryError.style.color = "";
            }, 3000);
        }
    } catch (err) {
        console.error("Entry error:", err);
        entryError.textContent = err.response?.data?.message || "Failed to log entry";
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = "Log your Day";
    }
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
                toggleDropdown();
            });
        }

        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", logout);
        }

        const submitEntryBtn = document.getElementById("submitEntry");
        if (submitEntryBtn) {
            submitEntryBtn.addEventListener("click", submitEntry);
        }
    }
});
