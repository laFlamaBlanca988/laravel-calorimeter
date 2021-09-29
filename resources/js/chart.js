let chartFilterSubmitButton = document.getElementById('chart_submit_button');
let myChart = document.getElementById('myChart').getContext('2d');

chartFilterSubmitButton.addEventListener('click', function (e) {
    e.preventDefault();
    let labels = [];

    let startDate = document.getElementById('chart_from_date').value;
    let endDate = document.getElementById('chart_to_date').value;

    const dateMove = new Date(startDate);
    let strDate = startDate;

    while (strDate < endDate) {
        strDate = dateMove.toISOString().slice(0, 10);
        labels.push(strDate);
        dateMove.setDate(dateMove.getDate() + 1);
    }

    let caloriesChart = new Chart(myChart, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Calories consumption',
                data: [
                    1200
                ],
                backgroundColor: 'rgba(255, 26, 104, 0.2)',
                borderColor: 'rgba(255, 26, 104, 1)',
                borderWidth: 1
            }],
        },
    });
})
