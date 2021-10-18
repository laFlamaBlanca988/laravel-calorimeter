<div class="chart-card">
    <form id="chart_filter_meal_form" class="chart-form">
        <label for="from" class="form-label"> From Date
        <input class="form-control" id="chart_from_date" name="chartFromDate" type="date">
           </label>
        <label for="to" class="form-label">To Date
        <input class="form-control" id="chart_to_date" name="chartToDate" type="date">
        </label>
        <div class="chart-buttons">
            <div id="chart_submit_button" class="date-and-time-filter-submit-button btn btn-danger btn-sm">Submit</div>
            <div id="chart_clear_button" class="date-and-time-filter-clear-button btn btn-danger btn-sm">Clear</div>
        </div>
        <ul id="date_time_form_err_list" class="date-time-error-alert"></ul>
    </form>
    <div id="chartContainer" class="chartBox">
        <canvas id="my_chart"></canvas>
    </div>
</div>

