<table class="admin-meals-table table table-dark">
    <thead>
    <tr>
        <th scope="col">User</th>
        <th scope="col">Meal</th>
        <th scope="col">Calories</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th class="edit-meals-table-header" scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($meals as $key => $meal)
        <div class="edit-meal-success-message" id="edit_meals_success_message"></div>
        <tr class="admin-table-row-meals" id="meal_{{$meal->id}}">
            <td class="item-user-name">{{$meal->name}}</td>
            <td class="item-title">{{ $meal->title }}</td>
            <td class="item-cal-num">{{ $meal->cal_num }}</td>
            <td class="item-date">{{ $meal->date }}</td>
            <td class="item-time">{{ $meal->time }}</td>
            <td class="edit-meals-buttons">
                <button data-id="{{$meal->id}}" onclick="editMeal({{$meal->id}})" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                >Edit meal
                </button>
                <button data-row ="{{$key}}" onclick="deleteMeal({{$meal->id}})" data-id="{{$meal->id}}" class="delete-meal-open-btn-btn btn btn-danger btn-sm">Delete</button>
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
