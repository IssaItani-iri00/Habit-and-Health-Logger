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
    }
});