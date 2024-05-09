<?php
session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wedding Planner</title>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
    body {
         
    background-image: url("bg.jpg");
          background-size: cover;
        }
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
    
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        form {
            text-align: left;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        input[type="checkbox"] {
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }

        label {
        display: block;
        margin-bottom: 5px;
        direction: rtl;
        text-align: right;
    }
    input[type="number"] {
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        direction: rtl;
        text-align: right;
    }
    </style>
</head>
<body>
    <div class="container">
        <h1>منظم ميزانية حفلات الزفاف</h1>
        <form action="fetch_services.php" method="post">
            <label for="budget">الميزانية الكلية التقديرية:</label>
            <input type="number" min="5000" value="5000" id="budget" name="budget" placeholder="ادخل الميزانية الكلية" required><br>

            <label for="theme">اختر نوع حفل الزفاف:</label>
            <br>
            <label><input type="radio" name="theme" value="hotel"> فندق</label><br>
            <label><input type="radio" name="theme" value="venue"> قاعة</label><br>
            <label><input type="radio" name="theme" value="Chalet"> استراحه</label><br>


            <label>اختر خدمات حفل الزفاف:</label>
            <br>
            <label><input type="checkbox" name="services" value="venue"> قاعة</label><br>
            <label><input type="checkbox" name="services" value="catering"> تقديم الطعام</label><br>
            <label><input type="checkbox" name="services" value="musician"> موسيقى</label><br>
            <label><input type="checkbox" name="services" value="decor"> ديكور</label><br>
            <label><input type="checkbox" name="services" value="photography"> التصوير الفوتوغرافي</label><br>
            <input type="hidden" id="venue_budget" name="venue_budget">
            <input type="hidden" id="catering_budget" name="catering_budget">
            <input type="hidden" id="musician_budget" name="musician_budget">        
            <button id="button" type="button">الحصول على النسب المئوية</button>
            <br><br>
            <div id="Response"></div>
        <div id="chart_div" style="width: 100%; height: 300px;"></div>
        <div id="budgets"></div>
            <button id="submit" type="submit">الحصول على الخدمات</button>
        </form>
        
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.7/axios.min.js"></script>
    <script> 
    document.getElementById("button").addEventListener("click", function() {
        let prompt = "As a wedding planner, distribute the percentages of the budget based on these services:";
        sendToChatGPT(prompt);
    });

    function sendToChatGPT(prompt){
        let selectedServices = [];
        document.querySelectorAll('input[name="services"]:checked').forEach(function(checkbox) {
            selectedServices.push(checkbox.value);
        });
        let value = selectedServices.join(', ');
        let body ={
            "model":"gpt-3.5-turbo",
            "messages":[{"role": "system", "content": prompt}, {"role": "user", "content": value}],
        };
        let headers ={Authorization:"Bearer key",};
        axios.post("https://api.openai.com/v1/chat/completions", body, {headers:headers})
        .then((Response)=>{
            let reply = Response.data.choices[0].message.content;
            document.getElementById("Response").innerHTML=reply;
            splitResponse(reply, selectedServices);
        });
    }
    
    function splitResponse(response, selectedServices) {
    let matches = response.match(/([a-zA-Z]+): (\d+(?:\.\d+)?)%/g);

    if (matches) {
        let budget = parseFloat(document.getElementById("budget").value);
        let data = [['Service', 'Percentage', 'Budget']];
        matches.forEach(match => {
            let parts = match.split(': ');
            let serviceName = parts[0].trim();
            let percentage = parseFloat(parts[1]);
            let serviceBudget = (budget * percentage) / 100;
            if (selectedServices.includes(serviceName.toLowerCase())) {
                data.push([serviceName, percentage, serviceBudget]);
            }
        });

        // Load Google Charts API
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(function() {
            drawChart(data);
            displayBudgets(data);
        });

        // Now, we'll set the hidden input fields with the calculated budgets
        document.getElementById("venue_budget").value = getServiceBudget(data, "venue");
        document.getElementById("catering_budget").value = getServiceBudget(data, "catering");
        document.getElementById("musician_budget").value = getServiceBudget(data, "musician");
    }
}

function getServiceBudget(data, serviceType) {
    for (let i = 1; i < data.length; i++) {
        if (data[i][0].toLowerCase() === serviceType.toLowerCase()) {
            return data[i][2];
        }
    }
    return 0;
}

function drawChart(data) {
    var chartData = google.visualization.arrayToDataTable(data);

    var options = {
        title: 'Percentage of Each Service and Corresponding Budget',
        is3D: false,
colors: ['#c79ede', '#a4de9e', '#f7adc6', '#b0d4eb', '#1eeb24']
    };

    var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
    chart.draw(chartData, options);
}

function displayBudgets(data) {
    let budgetsHtml = "<h2>Budgets for Selected Services:</h2>";
    for (let i = 1; i < data.length; i++) {
        budgetsHtml += "<p>" + data[i][0] + ": $" + data[i][2].toFixed(2) + "</p>";
    }
    document.getElementById("budgets").innerHTML = budgetsHtml;
}
    </script>
</body>
</html>