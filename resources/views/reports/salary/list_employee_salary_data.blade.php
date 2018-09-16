<div class="row">
  <div class="form-group col-xs-4 red">
    <label class="control-label requiredField" for="customer_id">
    Total : {{$total_salary}}
    </label>
  </div>
</div>
<div class="card-box table-responsive">
  <table id="data-list" class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Name</th>
        <th>Date</th>
        <th>Salary</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($salary as $salary)
      <tr>
        <td>{{$salary->emp_name}}</td>
        <td>{{dmy($salary->salary_paid_date)}}</td>
        <td>{{$salary->salary_amount}}</td>
      </tr>
      @endforeach
      <tr><td></td><td></td><td>{{str_replace(',','',$total_salary)}}</td></tr>
    </tbody>
    
  </table>
</div>