function createSubjectCard(subjects) {
    const leftColumnBody = document.getElementById('subjects-cards');
    subjects.forEach(subject => {
        const newCard = document.createElement('div');
        newCard.setAttribute('id', 'subject-' + subject.id);
        newCard.setAttribute('class', "p-4 bg-gray-800 dark:bg-gray-700 rounded-lg mb-4 flex justify-between");
        newCard.innerHTML = `
        <h3 class="text-xl font-bold mb-2 text-gray-100 dark:text-gray-800">${subject.name}</h3>
        <button class="bg-gray-600 dark:bg-gray-500 rounded-lg px-4 py-2 text-gray-100 dark:text-gray-800 font-bold" onclick="getExercises(${subject.id})">View</button>
      `;
        leftColumnBody.insertAdjacentElement("afterbegin", newCard);
    });
}

function createExerciseCard(exercises) {
    const middleColumnBody = document.getElementById('exercises-cards');
    middleColumnBody.innerHTML = "";

    exercises.forEach(exercise => {
        const newCard = document.createElement('div');
        newCard.setAttribute('id', 'exercise-' + exercise.id);
        newCard.setAttribute('class', "p-4 bg-gray-800 dark:bg-gray-700 rounded-lg mb-4 flex justify-between");
        newCard.innerHTML = `
        <h3 class="text-xl font-bold mb-2 text-gray-100 dark:text-gray-800">${exercise.name}</h3>
        <p class="text-gray-100 dark:text-gray-800">${exercise.text}</p>
        <button class="bg-gray-600 dark:bg-gray-500 rounded-lg px-4 py-2 text-gray-100 dark:text-gray-800 font-bold" onclick="getTaskGrades(${exercise.id}, '${exercise.grade}')">View</button>
      `;
        middleColumnBody.insertAdjacentElement("afterbegin", newCard);
    });
}

function getSubjects() {

    fetch(BASE_API_URL + 'teacher/getSubjects.php')
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createSubjectCard(data.result);
        })
        .catch(error => {
            console.log(error);
        });
}

function getExercises(subject_id) {
    const rightColumn = document.getElementById('right-column');
    rightColumn.style.display = 'none';

    const middleColumn = document.getElementById('middle-column');
    middleColumn.style.display = 'block';

    fetch(BASE_API_URL + 'teacher/getExercises.php?subject_id=' + subject_id)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createExerciseCard(data.result);
        })
        .catch(error => {
            console.log(error);
        });

}

function getTaskGrades(exercise_id, grade_name) {
    const rightColumn = document.getElementById('right-column');
    rightColumn.style.display = 'block';

    fetch(BASE_API_URL + 'teacher/getTasksGrades.php?exercise_id=' + exercise_id + '&grade_name=' + grade_name)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createStudentRow(data.result, exercise_id);
        })
        .catch(error => {
            console.log(error);
        });
}

function changeTaskGrades(student_id, exercise_id, task_grade) {
    fetch(BASE_API_URL + 'teacher/changeTasksGrades.php?exercise_id=' + exercise_id + '&student_id='+student_id+'&task_grade='+task_grade)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
        })
        .catch(error => {
            console.log(error);
        });
}

function createStudentRow(students, exercise_id) {
    const tableBody = document.getElementById('student-table');
    tableBody.innerHTML = "";

    students.forEach(student => {
        const newRow = document.createElement('tr');
        newRow.setAttribute('id', 'student-' + student.student_id);
        newRow.innerHTML = `
        <td class="p-4 border border-gray-600 dark:border-gray-200 bg-gray-700 dark:bg-gray-800 text-gray-100 dark:text-gray-800">${student.student_name}</td>
        <td class="text-center p-4 border border-gray-600 dark:border-gray-200 bg-gray-700 dark:bg-gray-800 text-gray-100 dark:text-gray-800">
            <select id="select-${student.student_id}" class="text-center p-2 border border-gray-600 dark:border-gray-200 bg-gray-700 dark:bg-gray-800 text-gray-100 dark:text-gray-800 rounded-lg" onchange="changeTaskGrades(${student.student_id}, ${exercise_id}, this.value);">
                <option value="">${student.task_grade}</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </td>
      `;
        tableBody.appendChild(newRow);
    });
}

getSubjects();