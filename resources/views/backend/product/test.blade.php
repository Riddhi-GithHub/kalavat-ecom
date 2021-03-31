
        
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


<select id="s">
  <option>aaaaa</option>
  <option>bbbbb</option>
  <option>ccccc</option>
</select>

<button id="ddl">button</button>
<script>
$("#ddl").click(function () {
  var size = $('#s option').size();
  if (size != $("#s").prop('size')) {
      $("#s").prop('size', size);
  } else {
      $("#s").prop('size', 1);
  }
})
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<div class="container-fluid text-center bg-black" id="services">
<div class="services">
<h2>SERVICES</h2>
<br>
<div class="row">
<div class="col-sm-3 iconpad-even">
  <button class="icon-btn" data-button="btnData">DATA</button>
  <ul class="showData">
    <li>Design</li>
    <li>Cable Installation</li>
    <li>Testing</li>
    <li>CAT5e, CAT6, CAT6A</li>
    </ul>
</div>

<div class="col-sm-3 iconpad-odd">
  <button class="icon-btn" data-button="btnFiber">FIBER</button>
  <ul class="showData1">
    <li>Consultancy</li>
    <li>Building to Building</li>
    <li>Network Backbone</li>
    <li>Testing</li>
    </ul>
</div>

<script>
  $('.icon-btn').on('click', function() {
    $('.showData li').toggle();    
 });
 $(function() {
 $('.icon-btn').on('click', function() {
    //$('.showData li').toggle();  
    $(this).next('.showData1').find('li').toggle();
 });
});
// $(document).ready(function() {
//     $('.icon-btn').click(function() {
//             // $('.showData1').$("li").hide();
//             $('.showData li').show("li");
//     });
// });
// $(document).ready(function() {
//     $('.icon-btn').click(function() {
//         //  $('.showData').$("li").hide();
//          $('.showData1 li').show("li");
//     });
// });


//   $(function() {
//  $('.icon-btn').click('click', function() {
//     // $('.showData li').toggle();  
//     $(this).next('.showData').find('li').toggle();
//  });
// });

//   $('.icon-btn').click('click', function() {
//     $(this).next('.showData1').find('li').toggle();
//     // $('.showData1 li').toggle();    
//  });



</script>


<body>
  <h1>Hello Plunker!</h1>
  <div id="aBtnGroup" class="btn-group">
    <button type="button" value="L" class="btn btn-default">Left</button>
    <button type="button" value="M" class="btn btn-default">Middle</button>
    <button type="button" value="R" class="btn btn-default">Right</button>
  </div>
  <p>
  <div>Selected Val:  <span id="selectedVal"></span></div>
</body>

<script>
  
$(document).ready(function() {
  // Get click event, assign button to var, and get values from that var
  $('#aBtnGroup button').on('click', function() {
    var thisBtn = $(this);
    
    thisBtn.addClass('active').siblings().removeClass('active');
    var btnText = thisBtn.text();
    var btnValue = thisBtn.val();
    console.log(btnText + ' - ' + btnValue);
    
    $('#selectedVal').text(btnValue);
  });
  
  // You can use this to set default value
  // It will fire above click event which will do the updates for you
  $('#aBtnGroup button[value="M"]').click();
});
</script>





<form name="myForm">
  <input type="radio" name="myRadios"  value="1" />
  <input type="radio" name="myRadios"  value="2" />
</form>
<script>
var rad = document.myForm.myRadios;
var prev = null;
for (var i = 0; i < rad.length; i++) {
    rad[i].addEventListener('change', function() {
        (prev) ? console.log(prev.value): null;
        if (this !== prev) {
            prev = this;
        }
        console.log(this.value)
    });
}
</script>





<label>Radio 1</label>
<input type="radio" name="group" value="1" checked />
<label>Radio 2</label>
<input type="radio" name="group" value="2" />
<label>Radio 3</label>
<input type="radio" name="group" value="3" />

<div>
  <select id="drop1">
    <option>DropDown 1</option>
    <option>DropDown 1</option>
    <option>DropDown 1</option>
  </select>
  <select id="drop2" class="no-display">
    <option>DropDown 2</option>
    <option>DropDown 2</option>
    <option>DropDown 2</option>
  </select>
  <select id="drop3" class="no-display">
    <option>DropDown 3</option>
    <option>DropDown 3</option>
    <option>DropDown 3</option>
  </select>
</div>

<script>
  var dropdowns = document.getElementsByTagName("select");
function setDropDownsForNoDisplay() {
    for (var i = 0; i < dropdowns.length; i++) {
        dropdowns[i].classList.add("no-display");
    }
}
function setDropDownForDisplay(x) {
    if (x === "1") {
        document.getElementById("drop1").classList.remove("no-display");
    } else if (x === "2") {
        document.getElementById("drop2").classList.remove("no-display");
    } else if (x === "3") {
        document.getElementById("drop3").classList.remove("no-display");
    }
}
</script>









<div id="myRadioGroup">
    
  2 Cars<input type="radio" name="cars" checked="checked" value="2"  />
  
  3 Cars<input type="radio" name="cars" value="3" />
  
  <div id="Cars2" class="desc">
      2 Cars Selected
  </div>
  <div id="Cars3" class="desc" style="display: none;">
      3 Cars
  </div>
</div>

<script>
  $(document).ready(function() {
    $("input[name$='cars']").click(function() {
        var test = $(this).val();

        $("div.desc").hide();
        $("#Cars" + test).show();
    });
});
</script>