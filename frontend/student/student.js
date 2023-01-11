
function getSubjects() {

    fetch(BASE_API_URL + 'student/getSubjects.php')
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

function getExercises(subject_id) {
    
    const middleColumn = document.getElementById('middle-column');
    middleColumn.style.visibility = 'visible';

    const taskGradeTable = document.getElementById('task-grade-table');
    taskGradeTable.innerHTML = "";


    fetch(BASE_API_URL + 'student/listTasksGrades.php?subject_id=' + subject_id)
        .then(response => response.json())
        .then(data => {
            if (!data.ok) {
                console.log(data);
                return;
            }
            createTaskGradeRow(data.result);
        }
        )
        .catch(error => {
            console.log(error);
        }
        );
}

function createTaskGradeRow(tasks) {
    const taskGradeTable = document.getElementById('task-grade-table');
    tasks.forEach(task => {
        const newTaskGradeRow = document.createElement('tr');
        newTaskGradeRow.setAttribute('id', 'task-grade-' + task.id);
        newTaskGradeRow.innerHTML = `
        <td class="p-4 border border-gray-600 dark:border-gray-200 bg-gray-700 dark:bg-gray-800 text-gray-100 dark:text-gray-800">${task.exercise_name}</td>
        <td class="p-4 border border-gray-600 dark:border-gray-200 bg-gray-700 dark:bg-gray-800 text-gray-100 dark:text-gray-800">${task.exercise_text}</td>
        <td class="p-4 border border-gray-600 dark:border-gray-200 bg-gray-700 dark:bg-gray-800 text-gray-100 dark:text-gray-800">${task.task_grade}</td>
        `;

        taskGradeTable.insertAdjacentElement("afterbegin", newTaskGradeRow);
    });
}

getSubjects();