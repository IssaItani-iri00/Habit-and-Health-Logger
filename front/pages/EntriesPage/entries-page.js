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

function createEntryCard(entry) {
    const card = document.createElement('div');
    card.className = 'entry-card';
    
    let nutrition = null;
    if (entry.nutrition) {
        try {
            nutrition = typeof entry.nutrition === 'string' ? JSON.parse(entry.nutrition) : entry.nutrition;
        } catch (error) {
            console.error('Failed to parse nutrition:', error);
        }
    }
    
    card.innerHTML = `
        <div class="entry-header">
            <div class="entry-date">${entry.entry_date}</div>
            <div class="entry-mood">Mood: ${entry.mood ?? "Neutral"}</div>
        </div>
        
        <div class="entry-text">${entry.raw_text}</div>
        
        <div class="entry-stats">
            ${entry.estimated_calories ? `
                <div class="stat-item">
                    <span class="stat-entries">Calories:</span>
                    <span class="stat-value">${entry.estimated_calories}</span> kcal
                </div>
            ` : ''}
            
            ${entry.workout_minutes ? `
                <div class="stat-item">
                    <span class="stat-entries">Workout-Time:</span>
                    <span class="stat-value">${entry.workout_minutes}</span> min
                </div>
            ` : ''}
            
            ${entry.sleep_duration_minutes ? `
                <div class="stat-item">
                    <span class="stat-entries">Sleep-duration:</span>
                    <span class="stat-value">${Math.round(entry.sleep_duration_minutes / 60)}</span> hrs
                </div>
            ` : ''}
            
            ${entry.water_cups ? `
                <div class="stat-item">
                    <span class="stat-entries">Water</span>
                    <span class="stat-value">${entry.water_cups}</span> cups
                </div>
            ` : ''}
            
            ${entry.coffee_cups ? `
                <div class="stat-item">
                    <span class="stat-entries">Coffee:</span>
                    <span class="stat-value">${entry.coffee_cups}</span> cups
                </div>
            ` : ''}
        </div>
        
        ${nutrition ? `
            <div class="nutrition-section">
                <div class="nutrition-title">Nutrition</div>
                <div class="nutrition-bars">
                    ${nutrition.protein ? `
                        <div class="nutrition-item">
                            <span class="nutrition-label">Protein</span>
                            <span class="nutrition-value">${nutrition.protein}g</span>
                        </div>
                    ` : ''}
                    ${nutrition.carbs ? `
                        <div class="nutrition-item">
                            <span class="nutrition-label">Carbs</span>
                            <span class="nutrition-value">${nutrition.carbs}g</span>
                        </div>
                    ` : ''}
                    ${nutrition.fat ? `
                        <div class="nutrition-item">
                            <span class="nutrition-label">Fat</span>
                            <span class="nutrition-value">${nutrition.fat}g</span>
                        </div>
                    ` : ''}
                </div>
            </div>
        ` : ''}
    `;
    
    return card;
}

async function loadAllEntries() {
    const url = "http://localhost:8000";
    const userData = JSON.parse(localStorage.getItem("User"));
    const userId = userData.user_id;
    const container = document.getElementById("entriesContainer");
    
    try {
        const res = await axios.post(`${url}/entries/all`, {
            user_id: userId
        });
        
        console.log("Entries response:", res.data);
        
        const entries_data = res.data.data.data.entries;
        if (res.status === 200 && entries_data) {
            const entries = entries_data;
            
            if (entries.length === 0) {
                container.innerHTML = `
                    <div class="no-entries">
                        <div>No entries yet. Start logging your daily activities!</div>
                    </div>
                `;
            } else {
                // sorting entries by date (newest first)
                entries.sort((a, b) => {
                    const dateCompare = new Date(b.entry_date) - new Date(a.entry_date);
                    if (dateCompare !== 0) return dateCompare;
                    // if dates are the same, sort by ID (higher ID = most recent)
                    return (b.id || 0) - (a.id || 0);
                });
                
                container.innerHTML = '';
                entries.forEach(entry => {
                    const card = createEntryCard(entry);
                    container.appendChild(card);
                });
            }
        }
    } catch (err) {
        console.error("Failed to load entries:", err);
    }
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
        
        loadAllEntries();
    }
});