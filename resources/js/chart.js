let chartFilterSubmitButton = document.getElementById('chart_submit_button');
let chartContainer = document.getElementById("chartContainer");
let startDate = document.getElementById('chart_from_date');
let endDate = document.getElementById('chart_to_date');

chartFilterSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'getMealsChartData', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    let data = {
        'startDate': startDate.value,
        'endDate': endDate.value,
    };

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let response = JSON.parse(xhr.responseText);
            let labels = response.result.map(res => {
                return res.date;
            });
            let calories = response.result.map(res => {
                return res.total;
            });

            chartContainer.innerHTML = '<canvas id="my_chart"></canvas>';
            let myChart = document.getElementById('my_chart').getContext('2d');

            let caloriesChart = new Chart(myChart, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Calories consumption',
                        data: calories,
                        backgroundColor: 'rgba(255, 26, 104, 0.2)',
                        borderColor: 'rgba(255, 26, 104, 1)',
                        borderWidth: 1
                    }],
                },
            });
        }
    }

    xhr.send(JSON.stringify(data));
});

endDate.addEventListener('change', function () {
    if (startDate.value > this.value) {
        let temp = startDate.value;
        startDate.value = endDate.value;
        endDate.value = temp;
    }
});

