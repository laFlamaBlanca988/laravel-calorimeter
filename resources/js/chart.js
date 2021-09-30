
let chartFilterSubmitButton = document.getElementById('chart_submit_button');

chartFilterSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    let myChart = document.getElementById('my_chart').getContext('2d');

    let startDate = document.getElementById('chart_from_date').value;
    let endDate = document.getElementById('chart_to_date').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'getMealsChartData', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    let data = {
        'startDate': startDate,
        'endDate': endDate,
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
            // document.getElementById('my_chart').remove();

        }

    }

    xhr.send(JSON.stringify(data));
});

