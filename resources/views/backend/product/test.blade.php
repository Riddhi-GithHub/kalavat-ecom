
        
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




------------------------------------------------
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>


===============================================
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<title>GFG User Details</title>
		<!-- CSS FOR STYLING THE PAGE -->
		<style>
			table {
				margin: 0 auto;
				font-size: large;
				border: 1px solid black;
			}

			h1 {
				text-align: center;
				color: #006600;
				font-size: xx-large;
				font-family: "Gill Sans",
				"Gill Sans MT",
				" Calibri",
				"Trebuchet MS",
				"sans-serif";
			}

			td {
				background-color: #e4f5d4;
				border: 1px solid black;
			}

			th,
			td {
				font-weight: bold;
				border: 1px solid black;
				padding: 10px;
				text-align: center;
			}

			td {
				font-weight: lighter;
			}
		</style>
		<!-- BOOTSTRAP CSS AND PLUGINS-->
		<link rel="stylesheet"
			href=
"https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
			integrity=
"sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
			crossorigin="anonymous" />
		<script src=
"https://code.jquery.com/jquery-3.2.1.slim.min.js"
				integrity=
"sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
				crossorigin="anonymous">
	</script>
		<script src=
"https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
				integrity=
"sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
				crossorigin="anonymous">
	</script>
		<script src=
"https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
				integrity=
"sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
				crossorigin="anonymous">
	</script>
		<script src=
"https://code.jquery.com/jquery-3.5.1.js"
				integrity=
"sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
				crossorigin="anonymous">
	</script>
	</head>

	<body>
		<section>
			<h1>GeeksForGeeks</h1>
			<!-- TABLE CONSTRUCTION-->
			<table id="GFGtable">
				<tr>
					<!-- TABLE HEADING -->
					<th>GFG UserHandle</th>
					<th>Practice Problems</th>
					<th>Coding Score</th>
					<th>GFG Articles</th>
					<th>SELECT</th>
				</tr>
				<!-- TABLE DATA -->
				<tr>
					<td class="gfgusername">User-1</td>
					<td class="gfgpp">150</td>
					<td class="gfgscores">100</td>
					<td class="gfgarticles">30</td>
					<td><button class="gfgselect bg-secondary"
								data-toggle="modal"
								data-target="#gfgmodal">
					SELECT</button></td>
				</tr>
				<tr>
					<td class="gfgusername">User-2</td>
					<td class="gfgpp">100</td>
					<td class="gfgscores">75</td>
					<td class="gfgarticles">30</td>
					<td><button class="gfgselect bg-secondary"
								data-toggle="modal"
								data-target="#gfgmodal">
					SELECT</button></td>
				</tr>
				<tr>
					<td class="gfgusername">User-3</td>
					<td class="gfgpp">200</td>
					<td class="gfgscores">50</td>
					<td class="gfgarticles">10</td>
					<td><button class="gfgselect bg-secondary"
								data-toggle="modal"
								data-target="#gfgmodal">
					SELECT</button></td>
				</tr>
				<tr>
					<td class="gfgusername">User-4</td>
					<td class="gfgpp">50</td>
					<td class="gfgscores">5</td>
					<td class="gfgarticles">2</td>
					<td>
					<button class="gfgselect bg-secondary"
								data-toggle="modal"
								data-target="#gfgmodal">
					SELECT</button></td>
				</tr>
				<tr>
					<td class="gfgusername">User-5</td>
					<td class="gfgpp">0</td>
					<td class="gfgscores">0</td>
					<td class="gfgarticles">0</td>
					<td><button class="gfgselect bg-secondary"
								data-toggle="modal"
								data-target="#gfgmodal">
					SELECT</button></td>
				</tr>
			</table>
		</section>
		<script>
			$(function () {
				// ON SELECTING ROW
				$(".gfgselect").click(function () {
  			//FINDING ELEMENTS OF ROWS AND STORING THEM IN VARIABLES
					var a =
			$(this).parents("tr").find(".gfgusername").text();
					var c =
			$(this).parents("tr").find(".gfgpp").text();
					var d =
			$(this).parents("tr").find(".gfgscores").text();
					var e =
			$(this).parents("tr").find(".gfgarticles").text();
					var p = "";
					// CREATING DATA TO SHOW ON MODEL
					p +=
			"<p id='a' name='GFGusername' >GFG UserHandle: "
					+ a + " </p>";
					
					p +=
			"<p id='c' name='GFGpp'>Practice Problems: "
					+ c + "</p>";
					p +=
			"<p id='d' name='GFGscores' >Coding Score: "
					+ d + " </p>";
					p +=
			"<p id='e' name='GFGcoding' >GFG Article: "
					+ e + " </p>";
					//CLEARING THE PREFILLED DATA
					$("#divGFG").empty();
					//WRITING THE DATA ON MODEL
					$("#divGFG").append(p);
				});
			});
		</script>
		<!-- CREATING BOOTSTRAP MODEL -->
		<div class="modal fade"
			id="gfgmodal"
			tabindex="-1"
			role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<!-- MODEL TITLE -->
						<h2 class="modal-title"
							id="gfgmodallabel">
						Selected row</h2>
						<button type="button"
								class="close"
								data-dismiss="modal"
								aria-label="Close">
							<span aria-hidden="true">
							×</span>
						</button>
					</div>
					<!-- MODEL BODY -->
					<div class="modal-body">
						<div class="GFGclass"
							id="divGFG"></div>
						<div class="modal-footer">
		<!-- The close button in the bottom of the modal -->
							<button type="button"
									class="btn btn-secondary"
									data-dismiss="modal">
							Close</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>











<td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    View Product
  </button>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Order Items</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            {{-- <span aria-hidden="true">×</span> --}}
          </button>
        </div>
        <div class="modal-body">
                <div>Product Name :test 1</div>
                <div>Color</div>
                <div>Quantity</div>
                <div>Price</div>
        </div>
        <div class="modal-body">
            <div>Product Name :test 2</div>
            <div>Color</div>
            <div>Quantity</div>
            <div>Price</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
        </div>
      </div>
    </div>
  </div>
</td>















<td>
    {{-- <form method="get" action="{{ route('order.product', $value->order_detail_id) }}"> --}}
        <a href=""
            class="btn btn-primary btn-rounded btn-sm"><span
                class="fa fa-eye"></span></a>
       
        {{-- <button class="btn btn-danger btn-rounded btn-sm"><span
                class="fa fa-trash-o"></span></button> --}}
        {{-- <div class="field is-grouped py-1"> --}}
            <button type="submit" class="btn btn-danger btn-rounded btn-sm"
                onclick="return confirm('Sure Want Delete?')"><span
                    class="fa fa-trash-o"></span></button>
            <div class="modal" id="mdelete" role="dialog" aria-labelledby="moddelete">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="moddelete">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal"
                                aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete?</p>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="txtid" id="txtid" />
                            <input type="text" name="uid" id="uid" />
                            <button type="button" class="btn btn-danger "
                                data-dismiss="modal">No</button>
                            <span class="text-right">
                                <button type="button"
                                    class="btn btn-primary btndelete">Yes</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</td>
