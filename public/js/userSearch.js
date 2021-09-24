let searchButton = document.querySelector('.search-btn');
let searchForm = document.getElementById('user_search_form');
searchButton.addEventListener('click', function (e) {
    e.preventDefault();
    let name = document.getElementById('search_value').value;
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'userSearch', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', document.getElementsByName('csrf-token')[0].getAttribute('content'));
    let data = {
        'name': name
    };
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let res = xhr.responseText;
            let response = JSON.parse(res);

            if (response.status === 200) {
                let user = response.user[0];
                console.log(response)
            }
        }
    }
    xhr.send(JSON.stringify(data));
});
