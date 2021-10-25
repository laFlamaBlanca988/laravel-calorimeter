<table>
    <thead>
    <tr>
        <th class="id-table-home-header"><label>ID</label></th>
        <th><label>Meal</label></th>
        <th><label>Calories</label></th>
        <th><label>Date</label></th>
        <th><label>Time</label></th>
        <th><label>Actions</label></th>
    </tr>
    </thead>
    <tbody>
    <div class="edit-meal-success-message" id="edit_meals_success_message"></div>
    @foreach($data as $key => $meal)

        <tr id="meal_{{$meal->id}}">
            <td class="id-table-home-header" data-label="ID">{{$meal->id}}</td>
            <td data-label="Meal">{{$meal->title}}</td>
            <td data-label="Calories">{{$meal->cal_num}}</td>
            <td data-label="Date">{{$meal->date}}</td>
            <td data-label="Time">{{$meal->time}}</td>
            <td class="home-edit-meals-buttons">
                <button data-id="{{$meal->id}}" onclick="editMeal({{$meal->id}})"
                        class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                >Edit meal
                </button>
                <button data-row="{{$key}}" onclick="deleteMeal({{$meal->id}})" data-id="{{$meal->id}}"
                        class="delete-meal-open-btn btn btn-danger btn-sm">Delete
                </button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div id="pagination_buttons" class="d-flex justify-content-center">
    {!! $data->links() !!}
</div>
<script>
    $('#pagination_buttons a').on('click', function (event) {
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        $.ajax({
            url: "/home/fetch_data?page=" + page,
            success: function (data) {
                $('#user_table_meals').html(data);
            }
        });
    });
</script>

