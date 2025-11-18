const loginPanel = document.getElementById("loginPanel");
const registerPanel = document.getElementById("registerPanel");
const loginTab = document.getElementById("loginTab");
const registerTab = document.getElementById("registerTab");
const url = "http://localhost:8000";

function switchTab(tab){
    if(tab === "login"){
        loginPanel.classList.add("visible");
        registerPanel.classList.remove("visible");
        loginTab.classList.add("active");
        registerTab.classList.remove("active");
    }
    else{
        loginPanel.classList.remove("visible");
        registerPanel.classList.add("visible");
        loginTab.classList.remove("active");
        registerTab.classList.add("active");
    }
}

// switch between login and signup tabs
loginTab.onclick = () => {
    switchTab("login");
};
registerTab.onclick = () => {
    switchTab("register");
};

document.getElementById("loginBtn").onclick = async () => {
    const email = document.getElementById("loginEmail").value.trim();
    const password = document.getElementById("loginPassword").value;
    const error = document.getElementById("loginError");

    if(!email || !password){
        error.textContent = "All fields are required"
        return;
    }

    try{
        const res = await axios.post(`${url}/auth/login`, {email, password});

        console.log(res);

        if(res.status !== 200 || !res.data.data){
            error.textContent = res.data?.error || "Login failed";
            return;
        }

        localStorage.setItem("User", JSON.stringify(res.data.data));
        window.location.href = "../HomePage/home-page.html";
    }
    catch(err){
        console.error("Login error:", err);
        error.textContent = err.response?.data?.message || "Server Error";
    }
};

document.getElementById("registerBtn").onclick = async () => {
    const name = document.getElementById("registerName").value;
    const email = document.getElementById("registerEmail").value.trim();
    const password = document.getElementById("registerPassword").value;
    const error = document.getElementById("registerError");

    if(!name || !email || !password){
        error.textContent = "All fields are required"
        return;
    }

    try{
        const res = await axios.post(`${url}/auth/register`, {name, email, password});
        console.log(res);

        if(res.status !== 200 || !res.data.data){
            error.textContent = res.data?.error || "Registration failed";
            return;
        }

        localStorage.setItem("User", JSON.stringify(res.data.data));
        window.location.href = "../HomePage/home-page.html";
    }
    catch(err){
        console.error("Register error:", err);
        error.textContent = err.response?.data?.message || "Server Error";
    }
};