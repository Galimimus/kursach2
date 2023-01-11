
function logout() {
    fetch(BASE_API_URL + 'auth/logout.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            window.location.href = '../login.html';
        }
    )
        .catch(error => {
            console.log(error);
        }
    );
}