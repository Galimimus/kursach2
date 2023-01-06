// Select the create buttons
const createTeacherButton = document.querySelector('#create-teacher-btn');
const createStudentButton = document.querySelector('#create-student-btn');
const createSubjectButton = document.querySelector('#create-subject-btn');

// Add click event listeners to the create buttons
createTeacherButton.addEventListener('click', toggleForm);
createStudentButton.addEventListener('click', toggleForm);
createSubjectButton.addEventListener('click', toggleForm);

function toggleForm(event) {
  // Prevent the default button behavior
  event.preventDefault();
  // Get the button that was clicked
  const button = event.target;
  // Get the form element that corresponds to the button
  const formId = button.id.replace('-btn', '-form');
  console.log(formId);
  const form = document.querySelector(`#${formId}`);
  // Toggle the display property of the form
  if (form.style.display === 'block') {
    form.style.display = 'none';
  } else {
    form.style.display = 'block';
  }
  
  // Select the close button
  const closeButton = form.querySelector('.close-btn');

  closeButton.addEventListener('click', event => {
       form.style.display = 'none';
  });
}

const createButton = document.getElementById('submit-teacher');

// Add a click event listener to the button
createButton.addEventListener('click', event => {
  // Prevent the default form submission
  event.preventDefault();

  // Get the form element
  const form = event.target.form;

  // Get the input elements from the form
  const emailInput = form.elements.email;
  const passwordInput = form.elements.password;
  const nameInput = form.elements.name;

  // Get the values from the input elements
  const email = emailInput.value;
  const password = passwordInput.value;
  const name = nameInput.value;
  // Validate the input values

  // If the input is valid, create the new teacher
  const params = new URLSearchParams();
  params.append('email', email);
  params.append('password', password);
  params.append('name', name);


  fetch(BASE_API_URL+'admin/teachers/addTeacher.php?'+params)
    .then(response => response.json())
    .then(data => {
      // Add the new teacher to the table
      if(!data.ok){
        console.log(data);
        return;
      }
      const tableBody = document.getElementById('teacher-table');
      const newRow = document.createElement('tr');
      newRow.innerHTML = `
        <td class="border px-4 py-2 w-1/3">${name}</td>
        <td class="border px-4 py-2 w-1/3">${email}</td>
        <td class="border px-4 py-2 w-1/3">
        <button class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none focus:shadow-outline-gray active:bg-red-600">Delete</button>
        </td>
      `;
      tableBody.appendChild(newRow);
      

    })
    .catch(error => {
        console.log(error);
        });
});

