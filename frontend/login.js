const form = document.querySelector('form');
const errorBox = document.querySelector('.error-box');



form.addEventListener('submit', e => {
  e.preventDefault();

  const email = form.email.value;
  const password = form.password.value;
  const role = form.role.value;

 

  const params = new URLSearchParams();
  params.append('email', email);
  params.append('password', password);
  params.append('role', role);


  fetch(`${BASE_API_URL}auth/login.php?${params}`)
    .then(response => {
      if (response.ok) {
        return response.json();
      }
      throw new Error('Request failed.');
    })
    .then(data => {
      if (data.ok) {
        // Redirect to the personal account page
        // selector for the role
        if (role === 'student') {
          window.location.href = '../frontend/student/student.html';
        } else if (role === 'teacher') {
          window.location.href = '../frontend/teacher/teacher.html';
        } else if (role === 'admin') {
        window.location.href = '../frontend/admin/admin.html';
        }
      } else {
        // Display an error message
        errorBox.textContent = 'Invalid email or password.';
        errorBox.style.display = 'block';
      }
    })
    .catch(error => {
      errorBox.textContent = 'Server not responding :(';
      errorBox.style.display = 'block';
      console.log(error);
    });
});

