<table class="meals table table-dark">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Meal</th>
        <th scope="col">Calories</th>
        <th scope="col">Date</th>
        <th scope="col">Time</th>
        <th class="edit-header" scope="col"></th>
    </tr>
    </thead>
    <tbody>
    @foreach ($data as $key => $meal)
        <tr id="meal_{{$meal->id}}">
            <td class="item-id">{{$key + 1}}</td>
            <td class="item-title">{{ $meal->title }}</td>
            <td class="item-cal-num">{{ $meal->cal_num }}</td>
            <td class="item-date">{{ $meal->date }}</td>
            <td class="item-time">{{ $meal->time }}</td>
            <td class="edit-meals-buttons">
                <button data-id="{{$meal->id}}" onclick="editMeal({{$meal->id}})" class="edit-meal-open-btn btn btn-danger btn-sm" type="submit"
                >Edit meal
                </button>
                <button data-row="{{$key}}" onclick="deleteMeal({{$meal->id}})" data-id="{{$meal->id}}" class="delete-btn btn btn-danger btn-sm">Delete
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
    $(document).ready(function(){
        $('#pagination_buttons a').on('click', function(event){
            event.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            $.ajax({
                url:"/home/fetch_data?page="+page,
                success:function(data)
                {
                    $('#user_table_meals').html(data);
                }
            });
        });
    });
</script>
