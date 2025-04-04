// Script to handle login form behavior (just an example)
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const rememberMe = document.getElementById('rememberMe').checked;
    
    // You can handle login logic here, e.g., checking credentials or sending a request to a server.
    console.log(`Username: ${username}`);
    console.log(`Password: ${password}`);
    console.log(`Remember me: ${rememberMe}`);

    // For now, simulate successful login (this part should be replaced with real authentication)
    alert("Login successful!");
});

// Script for "Forgot password" link (you can customize this to show a modal or redirect to a password reset page)
document.getElementById('forgotPassword').addEventListener('click', function() {
    alert("Redirect to forgot password page...");
});