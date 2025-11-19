function checkAuth(){
    const user = localStorage.getItem("User");

    if(!user){
        window.location.href = "../AuthPage/auth-page.html";
        return;
    }

    const userData = JSON.parse(user);
    
    if(userData.user_role !== "admin"){
        alert("Access denied. Admin privileges required.");
        window.location.href = "../HomePage/home-page.html";
        return;
    }

    return userData;
}

function toggleDropdown(){
    const dropdown = document.getElementById("dropdownMenu");
    dropdown.classList.toggle("show");
}

function logout () {
    localStorage.removeItem("User");
    window.location.href = "../AuthPage/auth-page.html";
}

const url = "http://localhost:8000";

function displayUsers(users, currentAdminId) {
    const tableBody = document.getElementById("usersTableBody");
    
    if (users.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="5" style="text-align: center;">No users found</td></tr>';
        return;
    }

    tableBody.innerHTML = users.map(user => {
        // checks which user is the admin so he doesnt delete his account
        const isCurrentAdmin = parseInt(user.id) === parseInt(currentAdminId);
        const row = `
            <tr>
                <td>${user.id}</td>
                <td>${user.name}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td>
                    <button 
                        class="delete-btn" 
                        onclick="deleteUser(${user.id})"
                        ${isCurrentAdmin ? 'disabled' : ''}>
                        ${isCurrentAdmin ? 'You' : 'Delete'}
                    </button>
                </td>
            </tr>`;
            
        return row;
    }).join('');
}

async function fetchUsers() {
    const userData = JSON.parse(localStorage.getItem("User"));
    const tableBody = document.getElementById("usersTableBody");
    const user_id = userData.user_id;

    try {
        const res = await axios.post(`${url}/admin/all`, {
            admin_user_id: user_id
        });

        console.log("Response:", res);

        if (res.status === 200 && res.data.data?.data?.users) {
            displayUsers(res.data.data.data.users, user_id);
        } else {
            tableBody.innerHTML = '<tr><td colspan="5">Failed to load users</td></tr>';
        }
    } catch (error) {
        console.error("Error fetching users:", error);
        tableBody.innerHTML = '<tr><td colspan="5">Error loading users</td></tr>';
    }
}

async function deleteUser(userId) {
    const userData = JSON.parse(localStorage.getItem("User"));
    const admin_id = userData.user_id;
    
    if (!confirm("Are you sure you want to delete this user?")) {
        return;
    }

    try {
        const response = await axios.post(`${url}/admin/deleteUser`, {
            admin_user_id: admin_id,
            user_id: userId
        });

        if (response.status === 200) {
            alert("User deleted successfully");
            fetchUsers();
        } else {
            alert("Failed to delete user: " + (response.data.error || "Unknown error"));
        }
    } catch (error) {
        console.error("Error deleting user:", error);
        alert("Error deleting user: " + (error.response?.data?.error || error.message));
    }
}

document.addEventListener("DOMContentLoaded", () =>{
    const userData = checkAuth();

    if(userData){
        const userAvatar = document.getElementById("userAvatar");
        if(userAvatar){
            userAvatar.addEventListener("click", toggleDropdown);
        }

        const logoutBtn = document.getElementById("logoutBtn");
        if(logoutBtn){
            logoutBtn.addEventListener("click", logout);
        }
        
        fetchUsers();
    }
});