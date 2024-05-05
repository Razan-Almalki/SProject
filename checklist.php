<?php
session_start();
// Check if user is authenticated
if (isset($_SESSION['user_id'])) {
  // User is logged in, display authenticated content
  // ...
} else {
  // User is not logged in, redirect to the login page
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
<style>
button {
      cursor: pointer;
        border-radius: 5em;
        color: #fff;
        background: linear-gradient(to right, #c79ede, #f7adc6);
        border: 0;
        padding-left: 40px;
        padding-right: 40px;
        padding-bottom: 10px;
        padding-top: 10px;
        font-family: 'Ubuntu', sans-serif;
        margin-left: 30%;
        font-size: 13px;
        box-shadow: 0 0 20px 1px rgba(0, 0, 0, 0.04);
    }
@use postcss-preset-env {
  stage: 0
}

body {
  min-height: 100vh;
  display: grid;
  align-items: center;
}

form {
  display: flex;
  flex-wrap: wrap;
  
  & > input {
    flex: 1 1 10ch;
    margin: .5rem;
    
    &[type="email"] {
      flex: 3 1 30ch;
    }
  }
}

input {
  border: none;
  background: hsl(0 0% 93%);
  border-radius: .25rem;
  padding: .75rem 1rem;
  
  &[type="submit"] {
    background: hotpink;
    color: white;
    box-shadow: 0 .75rem .5rem -.5rem hsl(0 50% 80%);
  }
}

body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: linear-gradient(to bottom right, #c2dcf2, #f7adc6);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
background-image: url("bg.jpg");
      background-size: cover;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      background: #fff;
      border-radius: 10px;
    }

    /*dark-mode styling*/
    body.dark-mode {
      background: #333;
      color: #fff;
    }

    body.dark-mode .container {
      background: #444;
      box-shadow: 0 2px 4px rgba(255, 255, 255, 0.1);
    }

    body.dark-mode li {
      background-color: #444;
    }

    .due-date-input {
      flex: 1;
      padding: 8px;
    }

    body.dark-mode .modal-content {
      background-color: #444;
      color: white;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    .input-container {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }

    #taskInput {
      flex: 1;
      padding: 8px;
    }
button{
padding: 5px 15px;
      background-color: #f7adc6;
      color: #fff;
      border: none;
      cursor: pointer;
      margin-left: 10px;}

    button:hover {
      background-color: #0056b3;
    }

    ul {
      list-style: none;
      padding: 0;
      max-height: 40vh;
      overflow-y: auto;
    }

    li {
      display: flex;
      align-items: flex-start;
      justify-content: space-between;
      margin-bottom: 10px;
      padding: 12px;
      margin-right: 10px;
      background-color: #f8f8f8;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.363);
    }

    li.completed {
      text-decoration: line-through;
      opacity: 0.7;
    }

    .delete-btn {
      background-color: #dc3545;
      color: #fff;
      padding: 5px 10px;
      border: none;
      cursor: pointer;
    }

    /* Adding space after checkbox */
    li input[type="checkbox"] {
      margin-right: 10px;
    }


    /* Adding space between task item and delete button */
    li span {
      flex: 1;
      margin-right: 10px;
      font-weight: 600;
    }

    /* Filter and Sort Buttons Styling */

    .filter-container,
    .sort-container {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .filter-container button,
    .sort-container button {
      background-color: #f7adc6;
    }

    .filter-container button:hover,
    .sort-container button:hover {
      background-color: #138496;
    }

    /* Active Button Styling */

    .filter-container button.active,
    .sort-container button.active {
      background-color: #0056b3;
    }

    /* Edit Task Modal Styling */
    .modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      display: flex;
      flex-direction: column;
      gap: 10px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: #fff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Responsive Styling */

    @media (max-width: 558px) {
      .input-container {
        flex-direction: column;
        align-items: center;
      }

      #taskInput {
        width: 100%;
      }

      #dueDateInput{
        width: 100%;
      }

      .filter-container,
      .sort-container {
        flex-wrap: wrap;
      }

      .filter-container button,
      .sort-container button {
        width: 100%;
      }
    }

    @media screen and (max-width:433px) {

      #taskInput {
        width: 280px;
      }

      #dueDateInput{
        width: 280px;
      }

      .filter-container,
      .sort-container {
        flex-wrap: wrap;
      }

      .filter-container button,
      .sort-container button {
        width: 280px;
      }
      .dark-mode-switch{
        margin-left: 40px;
      }
    }

</style>
</head>
<body>
    <a href="logout.php">logout</a>
    <!--container div starts here-->
  <div class="container">

    <!-- switch for Dark/Light Mode -->
    <div class="dark-mode-switch">
      <label for="darkModeToggle">الوضع الداكن</label>
      <input type="checkbox" id="darkModeToggle">
    </div>

    <h1>قائمة المهام</h1>
<div>
<form id="taskForm" method="post" action="save_task.php">
    <!--input-container div starts here-->
    <div class="input-container">
<input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
        <input type="text" id="taskInput" name="taskName" placeholder="أدخل المهمة ! ما الذي تريد تحقيقه اليوم؟">
        <input type="date" id="dueDateInput" name="dueDate" class="due-date-input">
    </div>
    <button type="submit" onclick="addTask(event)">إضافة</button>
</form>
</div>
<br>
    <!--filter-container div starts here-->
    <div class="filter-container">
      <button onclick="filterTasks('all')">جميع المهام</button>
      <button onclick="filterTasks('active')">المهام النشطة</button>
      <button onclick="filterTasks('completed')">المهام المكتملة</button>
<button onclick="sortTasksByName()">الترتيب حسب الاسم</button>
  <button onclick="sortTasksByDate()">الترتيب حسب التاريخ</button>
    </div>

    <!--all task item are saved here-->
    <ul id="taskList"></ul>
  </div>
  <!--container div ends here-->

    <script>
// Function to render tasks fetched from the database
function renderTasks() {
    const taskList = document.getElementById('taskList');
    taskList.innerHTML = ''; // Clear existing tasks

    // Fetch tasks from the database
    fetch('fetch_tasks.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(tasks => {
            tasks.forEach(task => renderTask(task));
        })
        .catch(error => {
            console.error('Error fetching tasks:', error);
        });
}

// Function to add a new task
function addTask(event) {
    event.preventDefault();

    const taskInput = document.getElementById('taskInput');
    const dueDateInput = document.getElementById('dueDateInput');

    const taskName = taskInput.value.trim();
    const dueDate = dueDateInput.value;

    if (taskName === '') {
        alert('Task name cannot be empty!');
        return;
    }

    if (confirm('هل أنت متأكد أنك تريد إضافة هذه المهمة؟')) {
        // Send a POST request to save the new task in the database
        fetch('save_task.php', {
    method: 'POST',
    headers: {
        'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `user_id=${encodeURIComponent(<?php echo $_SESSION['user_id']; ?>)}&taskName=${encodeURIComponent(taskName)}&dueDate=${encodeURIComponent(dueDate)}`
})

        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(taskId => {
            const task = {
                id: taskId,
                name: taskName,
                dueDate: dueDate,
                completed: false
            };
            renderTask(task);
            taskInput.value = '';
            dueDateInput.value = '';
        })
        .catch(error => {
            console.error('Error saving task:', error);
        });
    }
}

// Function to render a single task
function renderTask(task) {
    console.log("Rendering task:", task);
    const taskList = document.getElementById('taskList');
    const taskItem = document.createElement('li');
    
    // Determine whether the checkbox should be checked
    const isChecked = task.completed === "1"; // Check if completed is "1" (true)
    
    taskItem.innerHTML = `
        <form action="update_task.php" method="post" onsubmit="return confirm('هل أنت متأكد أنك تريد حفظ هذه المهمة؟')">
        <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
            <input type="hidden" name="taskId" value="${task.id}">
            <input type="text" name="taskName" value="${task.name}">
            <input type="date" name="dueDate" value="${task.dueDate}">
            <label><input type="checkbox" name="completed" ${isChecked ? 'checked' : ''}>اكتملت المهمة</label>
            <button type="submit">حفظ التغييرات</button>
            <button type="button" onclick="deleteTask(${task.id})">حذف المهمة</button>
        </form>
    `;
    
    console.log("Rendered HTML:", taskItem.innerHTML);
    taskList.appendChild(taskItem);
}

// Function to delete a task
function deleteTask(id) {
    if (confirm('هل أنت متأكد أنك تريد حذف هذه المهمة؟')) {
        const formData = new URLSearchParams();
        formData.append('user_id', <?php echo $_SESSION['user_id']; ?>);
        formData.append('taskId', id);

        fetch('delete_task.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            const taskItem = document.querySelector(`li[data-task-id="${id}"]`);
            taskItem.remove();
        })
        .catch(error => {
            console.error('Error deleting task:', error);
        });
    }
}


// Function to toggle the completion status of a task
function toggleComplete(id) {
    // Send a POST request to update the completion status of the task in the database
    fetch('update_task.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `taskId=${encodeURIComponent(id)}`
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const taskItem = document.querySelector(`li[data-task-id="${id}"]`);
        taskItem.classList.toggle('completed');
    })
    .catch(error => {
        console.error('Error updating task:', error);
    });
}

// Function to sort tasks by name
function sortTasksByName() {
    const taskList = document.getElementById('taskList');
    const tasks = Array.from(taskList.children);

    tasks.sort((a, b) => {
        const taskNameA = a.querySelector('input[name="taskName"]').value.toLowerCase();
        const taskNameB = b.querySelector('input[name="taskName"]').value.toLowerCase();
        return taskNameA.localeCompare(taskNameB);
    });

    taskList.innerHTML = ''; // Clear existing task list

    tasks.forEach(task => {
        taskList.appendChild(task);
    });
}

// Function to sort tasks by date
function sortTasksByDate() {
    const taskList = document.getElementById('taskList');
    const tasks = Array.from(taskList.children);

    tasks.sort((a, b) => {
        const taskDueDateA = new Date(a.querySelector('input[name="dueDate"]').value);
        const taskDueDateB = new Date(b.querySelector('input[name="dueDate"]').value);
        return taskDueDateA - taskDueDateB;
    });

    taskList.innerHTML = ''; // Clear existing task list

    tasks.forEach(task => {
        taskList.appendChild(task);
    });
}


// Function to handle dark mode toggle
function toggleDarkMode() {
      const body = document.body;
      body.classList.toggle('dark-mode');
      const isDarkMode = body.classList.contains('dark-mode');
      localStorage.setItem('darkMode', isDarkMode);
    }

    const darkModeToggle = document.getElementById('darkModeToggle');
    darkModeToggle.addEventListener('change', toggleDarkMode);

    function applyDarkModePreference() {
      const isDarkMode = localStorage.getItem('darkMode') === 'true';
      const body = document.body;
      body.classList.toggle('dark-mode', isDarkMode);
      darkModeToggle.checked = isDarkMode;
    }
    applyDarkModePreference();
// Event listeners
document.getElementById('darkModeToggle').addEventListener('change', toggleDarkMode);
document.addEventListener('DOMContentLoaded', () => {
    renderTasks();
    applyDarkModePreference();
});
// Function to filter tasks based on completion status
function filterTasks(filter) {
    const taskList = document.getElementById('taskList');
    const tasks = taskList.querySelectorAll('li');

    tasks.forEach(task => {
        const completed = task.querySelector('input[name="completed"]').checked;

        if (filter === 'all') {
            task.style.display = 'flex';
        } else if (filter === 'active' && !completed) {
            task.style.display = 'flex';
        } else if (filter === 'completed' && completed) {
            task.style.display = 'flex';
        } else {
            task.style.display = 'none';
        }
    });
}

</script>
</body>
</html>
