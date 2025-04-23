document.getElementById('admin-login').addEventListener('click', function() {
    document.getElementById('login-modal').style.display = 'block';
});

document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    // Simulate an AJAX request to the server for authentication
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ username, password })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = 'administrator.html'; // Redirect to admin page
        } else {
            document.getElementById('error-message').innerText = data.message; // Show error message
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});