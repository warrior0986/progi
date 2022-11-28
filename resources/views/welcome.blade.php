<!DOCTYPE html>
<html>
<head>
    <title>Progi Test</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
  <div class="card">
    <div class="card-header text-center font-weight-bold">
      Progi Budget Calculation
    </div>
    <div class="card-body">
      <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{url('calculate')}}">
       @csrf
        <div class="form-group">
          <label for="budget">Budget</label>
          <input type="number" id="budget" name="budget" class="form-control" value="" onkeyup="calculate(event)">
        </div>
      </form>
    </div>
  </div>
</div>  
</body>
<script src="{{ asset('js/app.js') }}" defer></script>
<script>
function calculate(event) {
    let url = "{{ route('calculate') }}";
    axios.pots(url, {
        budget: event.target.value
    }).then(response => {
        console.log(response);
    })
}
</script>
</html>