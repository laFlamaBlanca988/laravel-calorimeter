<div class="chartCard">
    <form id="chart_filter_meal_form">
        <label for="from" class="form-label"> From Date
        <input class="form-control" id="chart_from_date" name="chartFromDate" type="date" value="2021-09-09">
           </label>
        <label for="to" class="form-label">To Date
        <input class="form-control" id="chart_to_date" name="chartToDate" type="date" value="2021-09-30">
        </label>
        <div class="chart-buttons">
            <div id="chart_submit_button" class="date-and-time-filter-submit-button btn btn-danger btn-sm">Submit</div>
            <div id="chart_clear_button" class="date-and-time-filter-clear-button btn btn-danger btn-sm">Clear</div>
        </div>
        <ul id="date_time_form_err_list" class="date-time-error-alert"></ul>
    </form>
    <div class="chartBox">
        <canvas id="my_chart"></canvas>
    </div>
</div>

