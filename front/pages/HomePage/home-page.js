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

async function loadTodayNutrition() {
    const url = "http://localhost:8000";
    const userData = JSON.parse(localStorage.getItem("User"));
    const userId = userData.user_id;
    // getting today's date and trimming it to get a date that matches the backend layout
    const today = new Date().toISOString().split('T')[0];
    // const today = "2025-11-19";
    
    try {
        const res = await axios.post(`${url}/entries/date`, {
            user_id: userId,
            entry_date: today
        });
        
        console.log("Nutrition response:", res.data);

        const entries =res.data?.data?.data?.entries;

        if (res.status === 200 && Array.isArray(entries) && entries.length > 0) {
            const entry = entries[entries.length - 1];
            console.log("Entry data:", entry);
            updateNutritionDisplay(entry);
        } else {
            console.log("No entries found for today");
        }
    } catch (err) {
        console.error("Failed to load nutrition data:", err);
    }
}

function updateNutritionDisplay(entry) {
    const calories = entry.estimated_calories || 0;
    const calorieDisplay = document.getElementById("calorieDisplay");
    calorieDisplay.textContent = `${calories} / 1850 kcal`;
    
    if (entry.nutrition) {
        let nutrition;
        try {
            nutrition = typeof entry.nutrition === 'string' ? JSON.parse(entry.nutrition) : entry.nutrition;
        } catch (e) {
            console.error("Failed to parse nutrition data:", e);
            return;
        }
        
        const proteinValue = document.getElementById("proteinValue");
        const carbsValue = document.getElementById("carbsValue");
        const fatValue = document.getElementById("fatValue");
        const suggestionText = document.getElementById("suggestionText");
        
        const protein = nutrition.protein || 0;
        const carbs = nutrition.carbs || 0;
        const fat = nutrition.fat || 0;
        const suggestion = entry.meal_suggestion
        
        proteinValue.textContent = `${protein} / 120g`;
        carbsValue.textContent = `${carbs} / 180g`;
        fatValue.textContent = `${fat} / 60g`;
        suggestionText.textContent = suggestion;
    }
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
    const userId = userData.user_id;
    
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
            
            // reloading nutrition data user logging an entry
            await loadTodayNutrition();
            
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
            const userName = userData.user_name || "User";
            greetingElement.textContent = `Hello, ${userName}!`;
        }

        const userAvatar = document.getElementById("userAvatar");
        if (userAvatar) {
            userAvatar.addEventListener("click", toggleDropdown()); 
        }

        const logoutBtn = document.getElementById("logoutBtn");
        if (logoutBtn) {
            logoutBtn.addEventListener("click", logout);
        }

        const submitEntryBtn = document.getElementById("submitEntry");
        if (submitEntryBtn) {
            submitEntryBtn.addEventListener("click", submitEntry);
        }
        
        // loding today's nutrition data on page load
        loadTodayNutrition();
    }
});
