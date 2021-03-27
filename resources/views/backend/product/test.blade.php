
        
{{-- <input type="checkbox" value="first" checked>
<input type="checkbox" value="second" checked>
<input type="checkbox" value="third" checked>

<input type="submit" id="submit">
 
<script type="text/javascript">
var checkboxes = document.querySelectorAll("input[type=checkbox]");
var submit = document.getElementById("submit");

function getChecked() {
  var checked = [];

  for (var i = 0; i < checkboxes.length; i++) {
    var checkbox = checkboxes[i];
    if (checkbox.checked) checked.push(checkbox.value);
  }

  return checked;
}

submit.addEventListener("click", function() {
  var checked = getChecked();
  console.log(checked);
});
</script> --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

<body>
  <div class="radio-buttons-choice" id="container-3-radio-buttons-choice">
      <input type="radio" name="one" id="one-variable-equations" onclick="checkRadio(name)"><label>Only one</label><br>
      <input type="radio" name="multiple" id="multiple-variable-equations" onclick="checkRadio(name)"><label>I have multiple</label>
  </div>

<script>
function checkRadio(name) {
  if(name == "one"){
  console.log("Choice: ", name);
      document.getElementById("one-variable-equations").checked = true;
      document.getElementById("multiple-variable-equations").checked = false;

  } else if (name == "multiple"){
      console.log("Choice: ", name);
      document.getElementById("multiple-variable-equations").checked = true;
      document.getElementById("one-variable-equations").checked = false;
  }
}
</script>
<div class="form-group">
  <label class="col-md-2 col-xs-12 control-label">Select Category <span style="color:red">*</span></label>
  <div class="col-md-8 col-xs-12">
     <div class="">
        <select id="cat_id" name="cat_id" class="form-control">
           {{-- <select class="custom-select form-control" id="cat_id" name="cat_id"> --}}
           <option selected disabled>Select Category</option>
           <option value="1">1</option>
           <option value="3">3</option>
           <option value="2">2</option>
        </select>
     </div>
  </div>
</div>

</body>
<div id="selector" class="btn-group">
  <button type="button" class="btn active">Day</button>
  <button type="button" class="btn">Week</button>
  <button type="button" class="btn">Month</button>
  <button type="button" class="btn">Year</button>
</div>
<script>
$('#selector button').click(function() {
  $(this).addClass('active').siblings().removeClass('active');
  $(this).cat_id

  // TODO: insert whatever you want to do with $(this) here
});
</script>