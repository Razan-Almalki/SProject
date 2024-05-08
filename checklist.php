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
<link rel="stylesheet" href="checklistStyle.css"></link>
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
