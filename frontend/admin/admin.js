// Select the create buttons
const createTeacherButton = document.querySelector('#create-teacher-btn');
const createStudentButton = document.querySelector('#create-student-btn');
const createSubjectButton = document.querySelector('#create-subject-btn');

// Add click event listeners to the create buttons
createTeacherButton.addEventListener('click', toggleForm);
createStudentButton.addEventListener('click', toggleForm);
createSubjectButton.addEventListener('click', toggleForm);
createSubjectButton.addEventListener('click', updateTeachersSelector);

function updateTeachersSelector() {
    const teacherSelector = document.getElementById('select-teacher');
    teacherSelector.innerHTML = '';
    fetch(BASE_API_URL + 'admin/teachers/listTeachers.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            const teachers = data.result;
            teachers.forEach(teacher => {
                const option = document.createElement('option');
                option.value = teacher.id;
                option.textContent = teacher.name;
                teacherSelector.appendChild(option);
            });
        })
        .catch(error => {
            console.log(error);
        });
}

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

const addTeacherButton = document.getElementById('submit-teacher');
const addStudentButton = document.getElementById('submit-student');
const addSubjectButton = document.getElementById('submit-subject');


// Add a click event listener to the button
addTeacherButton.addEventListener('click', event => {
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


    fetch(BASE_API_URL + 'admin/teachers/addTeacher.php?' + params)
        .then(response => response.json())
        .then(data => {
            // Add the new teacher to the table
            if (!data.ok) {
                console.log(data);
                return;
            }
            // create an assotiative array for teacher
            const teacher = {
                id: data.result.id,
                email: data.result.email,
                name: data.result.name
            };
            // Add the new teacher to the table
            createTeacherRow([teacher]);
        })
        .catch(error => {
            console.log(error);
        });
});

// Add a click event listener to the button
addStudentButton.addEventListener('click', event => {
    // Prevent the default form submission
    event.preventDefault();

    // Get the form element
    const form = event.target.form;

    // Get the input elements from the form
    const emailInput = form.elements.email;
    const passwordInput = form.elements.password;
    const nameInput = form.elements.name;
    const gradeInput = form.elements.grade;


    // Get the values from the input elements
    const email = emailInput.value;
    const password = passwordInput.value;
    const name = nameInput.value;
    const grade = gradeInput.value;
    // Validate the input values

    // If the input is valid, create the new teacher
    const params = new URLSearchParams();
    params.append('email', email);
    params.append('password', password);
    params.append('name', name);
    params.append('grade', grade);


    fetch(BASE_API_URL + 'admin/students/addStudent.php?' + params)
        .then(response => response.json())
        .then(data => {
            // Add the new teacher to the table
            if (!data.ok) {
                console.log(data);
                return;
            }
            // create an assotiative array for student
            const student = {
                id: data.result.id,
                email: data.result.email,
                name: data.result.name,
                grade: data.result.grade
            };
            // Add the new student to the table
            createStudentRow([student]);
        })
        .catch(error => {
            console.log(error);
        });
});

// Add a click event listener to the button
addSubjectButton.addEventListener('click', event => {
    // Prevent the default form submission
    event.preventDefault();

    // Get the form element
    const form = event.target.form;

    // Get the input elements from the form
    const nameInput = form.elements.name;
    const gradeInput = form.elements.grade;
    const teacherInput = form.elements.teacher;


    // Get the values from the input elements
    const name = nameInput.value;
    const grade = gradeInput.value;
    const teacher = teacherInput.value;
    // Validate the input values

    // If the input is valid, create the new teacher
    const params = new URLSearchParams();
    params.append('teacher', teacher);
    params.append('name', name);
    params.append('grade', grade);


    fetch(BASE_API_URL + 'admin/subjects/addSubject.php?' + params)
        .then(response => response.json())
        .then(data => {
            // Add the new teacher to the table
            if (!data.ok) {
                console.log(data);
                return;
            }
            // create an assotiative array for subject
            const subject = {
                id: data.result.id,
                name: data.result.name,
                grade: data.result.grade,
                teacher: data.result.teacher
            };
            // Add the new subject to the table
            createSubjectRow([subject]);
        })
        .catch(error => {
            console.log(error);
        });
});

function deleteRow(id, url, table) {
    fetch(BASE_API_URL + 'admin/' + url + '?id=' + id)
        .then(response => response.json())
        .then(data => {
            // Add the new teacher to the table
            if (!data.ok) {
                console.log(data);
                return;
            }
            const tableBody = document.getElementById(table + '-table');
            const row = document.getElementById(table + '-' + id);
            tableBody.removeChild(row);


        })
        .catch(error => {
            console.log(error);
        });
}

function createTeacherRow(teachers){
    const tableBody = document.getElementById('teacher-table');
    teachers.forEach(teacher => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'teacher-'+teacher.id);
        newRow.innerHTML = `
        <td class="border px-4 py-2 w-1/3">${teacher.name}</td>
        <td class="border px-4 py-2 w-1/3">${teacher.email}</td>
        <td class="border px-4 py-2 w-1/3">
        <button id="delete-teacher" onclick="deleteRow(${teacher.id}, 'teachers/deleteTeacher.php', 'teacher');" class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none focus:shadow-outline-gray active:bg-red-600">Delete</button>
        </td>
      `;
        tableBody.appendChild(newRow);
    });
}

function createStudentRow(students){
    const tableBody = document.getElementById('student-table');
    students.forEach(student => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'student-'+student.id);
        newRow.innerHTML = `
        <td class="border px-4 py-2 w-1/4">${student.name}</td>
        <td class="border px-4 py-2 w-1/4">${student.email}</td>
        <td class="border px-4 py-2 w-1/4">${student.grade}</td>
        <td class="border px-4 py-2 w-1/4">
        <button id="delete-student" onclick="deleteRow(${student.id}, 'students/deleteStudent.php', 'student');" class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none focus:shadow-outline-gray active:bg-red-600">Delete</button>
        </td>
      `;
        tableBody.appendChild(newRow);
    });
}

function createSubjectRow(subjects){
    const tableBody = document.getElementById('subject-table');
    subjects.forEach(subject => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'subject-'+subject.id);
        newRow.innerHTML = `
        <td class="border px-4 py-2 w-1/4">${subject.name}</td>
        <td class="border px-4 py-2 w-1/4">${subject.grade}</td>
        <td class="border px-4 py-2 w-1/4">${subject.teacher}</td>
        <td class="border px-4 py-2 w-1/4">
        <button id="delete-subject" onclick="deleteRow(${subject.id}, 'subjects/deleteSubject.php', 'subject');" class="px-4 py-2 bg-red-500 text-gray-200 hover:bg-red-600 hover:text-white rounded-full focus:outline-none focus:shadow-outline-gray active:bg-red-600">Delete</button>
        </td>
      `;
        tableBody.appendChild(newRow);
    });
}

function getTeachers() {
    fetch(BASE_API_URL + 'admin/teachers/listTeachers.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createTeacherRow(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

function getStudents() {
    fetch(BASE_API_URL + 'admin/students/listStudents.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createStudentRow(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}


function getSubjects() {
    fetch(BASE_API_URL + 'admin/subjects/listSubjects.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createSubjectRow(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

getTeachers();
getStudents();
getSubjects();