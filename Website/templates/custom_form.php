<center>
    <div id="presethead" class="mainhead">
     Custom Effects
    </div>
</center>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST"  && $_POST['effect'] != "not")
  {
    echo("<div id = 'countdown'>
    <center>
        <h3 id='presethead' class='sechead'>Wait for the Effect to End</h3>
        <canvas id='circle' width='500' height='250'>
        </canvas>
        <h1><span id='count'>" . $sec . "</span></h1>
        <h1><span id='seconds'> Seconds </span></h1>

    </center>
    </div>
    <script type='text/javascript'>
    $( document ).ready(function(){
      $('#fcent').hide();
      $('.mainhead').hide();
    });
    var canvas = document.getElementById('circle');
    var ctr = canvas.getContext('2d');
    ctr.strokeStyle='#2a512a';
    ctr.lineWidth=5;
    ctr.beginPath();
    ctr.arc(250,125,110,0,2*Math.PI);
    ctr.stroke();
    var ctx = canvas.getContext('2d');
    ctx.strokeStyle='#62c462';
    ctx.lineWidth=5;
    ctx.beginPath();
    ctx.arc(250,125,110,1.5001*Math.PI,1.5*Math.PI);
    ctx.stroke();

    var totalSecs;
    var arcAngle;
    var futureAngle;
    var startArc;
    var b;

    function arcLength(){
    if(startArc+futureAngle >= 2 && b == 0){
      startArc = 0;
      futureAngle = futureAngle - 0.5;
      b = 1;
    }
    ctx.clearRect(0,0,canvas.width, canvas.height);
    ctr.strokeStyle='#2a512a';
    ctr.lineWidth=5;
    ctr.beginPath();
    ctr.arc(250,125,110,0,2*Math.PI);
    ctr.stroke();

    ctx.strokeStyle='#62c462';
    ctx.lineWidth=5;
    ctx.beginPath();
    ctx.arc(250,125,110,(startArc+futureAngle)*Math.PI,1.5*Math.PI);
    ctx.stroke();
    futureAngle = futureAngle + arcAngle;
    }

    window.onload = function(){
    (function(){
      var counter = " . $sec . ";
      totalSecs = counter;
      arcAngle = 2/totalSecs;
      futureAngle = arcAngle;
      startArc = 1.5001;
      setInterval(function() {
        if (counter > 0) {
          span = document.getElementById('count');
          span.innerHTML = counter;
          b = 0;
          arcLength();
          counter--;
        }
        // Display 'counter' wherever you want to display it.
        if (counter === 0) {
            $('.sechead').hide();
            $('#countdown').hide();
            clearInterval(counter);
            $('#fcent').show();
            $('.mainhead').show();
        }

      }, 1000);
    })();

    

    }

    </script>
    ");
  }
?>

<div id= "fcent" class="col-md-12">
<form id= "formc" class="form-horizontal" role="form" method ="post">
  <div class="form-group">
    <label class="control-label col-md-4 col-xs-4 custtext" for="effect">Select an Effect:</label>
    <div class="col-md-4 col-xs-4"> 
      <select name="effect" class="form-control" id="menu">
      <option value="not" selected> Select An Effect </option>
      <option value="cwp">Color Wipe</option>
      <option value="rnb">Rainbow</option>
      <option value="rbc">Rainbow Cycle</option>
      <option value="trc">Theater Chase</option>
      <option value="glo">Glow</option>
      <option value="kal">Kaleidoscope</option>
      <option value="cmt">Comet</option>
      </select>
    </div>
  </div>

  <div id = "colorb" class="form-group">
    <label class="control-label col-md-4 col-xs-4 custtext" for="color">Select a Color:</label>
    <div class="col-md-4 col-xs-4">
        <input id="color" name="color" type="color" value="<?php 
          if($_SERVER['REQUEST_METHOD'] == 'POST')
          {
            echo($_POST['color']);
          }
          elseif ($_SERVER['REQUEST_METHOD'] == 'GET')
          {
            echo("#62c462");
          }

          ?>">
    </div>
  </div>

  <div id= "delay" class="form-group">
    <div class="row">
      <label class="control-label col-md-4 col-xs-4 custtext" for="dly">Set Delay:</label>
      <div class="col-md-4 col-xs-4">
        <div class="range">
          <input type="range" name="dly" min="50" max="200" value="50" onchange="range1.value=value">
          <output id="range1">50</output>
        </div>
      </div>
    </div>
  </div>

  <div id = "repeat" class="form-group">
    <div class="row">
      <label class="control-label col-md-4 col-xs-4 custtext" for="rpt">Repeat Cycles:</label>
      <div class="col-md-4 col-xs-4">
        <div class="range">
          <input type="range" name="rpt" min="1" max="5" value="3" onchange="range2.value=value">
          <output id="range2">3</output>
        </div>
      </div>
    </div>
  </div>

  <div id = "length" class="form-group">
    <div class="row">
      <label class="control-label col-md-4 col-xs-4 custtext" for="len">LED Length:</label>
      <div class="col-md-4 col-xs-4">
        <div class="range">
          <input type="range" name="len" min="4" max="12" value="6" onchange="range3.value=value">
          <output id="range3">6</output>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-md-offset-3 col-xs-offset-3 col-md-5 col-xs-5">
      <button id="subbut" type="submit" class="btn btn-success btn-block">Start</button>
    </div>
  </div>
</form>
</div>

<?php
  if($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['effect'] != "not")
  {  echo("<script>
      var fewSeconds = " . $sec .";
      $(document).ready(function() {
        $('#subbut').prop('disabled', true);
        setTimeout(function(){
              $('#subbut').prop('disabled', false);
          }, fewSeconds*1000);
      }); </script>");
  }
?>