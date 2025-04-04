document.getElementById("forgotPasswordForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent page reload

    const username = document.getElementById("username").value.trim();
    const email = document.getElementById("email").value.trim();
    const message = document.getElementById("message");

    if (validateInput(username, email)) {
        message.style.color = "green";
        message.textContent = "Password reset link has been sent to your email!";
    } else {
        message.style.color = "red";
        message.textContent = "Please enter a valid username and email.";
    }
});

// Function to validate username and email
function validateInput(username, email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return username.length > 3 && emailRegex.test(email);
}