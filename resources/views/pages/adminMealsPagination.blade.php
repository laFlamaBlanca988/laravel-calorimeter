<table class="admin-meals-table">
    <thead>
    <thead>
    <tr>
        <th><label>User</label></th>
        <th><label>Meal</label></th>
        <th><label>Calories</label></th>
        <th><label>Date</label></th>
        <th><label>Time</label></th>
        <th class="add-meal-table-header"><span>Actions</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach ($meals as $key => $meal)
        <div class="edit-meal-success-message" id="edit_meals_success_message"></div>
        <tr class="admin-table-row-meals" id="meal_{{$meal->id}}">
            <td data-label="User">{{$meal->name}}</td>
            <td data-label="Meal">{{ $meal->title }}</td>
            <td data-label="Calories">{{ $meal->cal_num }}</td>
            <td data-label="Date">{{ $meal->date }}</td>
            <td data-label="Time">{{ $meal->time }}</td>
            <td class="home-edit-meals-buttons">
                <button data-id="{{$meal->id}}" onclick="editMeal({{$meal->id}})" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                >Edit meal
                </button>
                <button data-row ="{{$key}}" onclick="deleteMeal({{$meal->id}})" data-id="{{$meal->id}}" class="delete-meal-open-btn btn btn-danger btn-sm">Delete</button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<div id="admin_meals_pagination" class="d-flex justify-content-center">
    {!! $meals->links() !!}
</div>

<script>
$(document).ready(function (){
    $('#admin_meals_pagination a').on('click', function(event){
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        $.ajax({
            url:"/admin/meals?page="+page,
            success:function(data)
            {
                $('#meals_table').html(data);
            }
        });
    });
})
</script>
