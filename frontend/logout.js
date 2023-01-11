
function logout() {
    fetch(BASE_API_URL + 'auth/logout.php')
        .then(response => response.json())
        .then(data => {
            console.log(data);            
            window.location.href = '../login.html';
        }
    )
        .catch(error => {
            console.log(error);
        }
    );
}