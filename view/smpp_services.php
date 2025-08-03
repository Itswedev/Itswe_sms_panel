<?php
$action = $_POST["action"];
if ($action == "start_sqlbox")
{$output = shell_exec('sudo systemctl start sqlbox 2>&1');}

if ($action == "stop_sqlbox")
{  $output = shell_exec('sudo systemctl stop sqlbox 2>&1'); }


if ($action == "start_bearerbox")
{$output = shell_exec('sudo systemctl start bearerbox 2>&1');}

if ($action == "stop_bearerbox")
{$output = shell_exec('sudo systemctl stop bearerbox 2>&1');}

if ($action == "soft_restart")
echo("<div>".htmlspecialchars(implode("", file("http://localhost:13000/graceful-restart?password=" . urlencode('aaa') )))."</div>\n");
//curl "http://localhost:13000/graceful-restart?password=aaa"

?>



<script type="text/javascript">


function submit_form (action) {
  document.getElementById("action").value = action;
  document.getElementById("form").submit();
}

function start_sqlbox () {
  if (confirm("Are you sure you want to start sqlbox"))
      submit_form("start_sqlbox");
}

function start_bearerbox () {
  if (confirm("Are you sure you want to start bearerbox"))
      submit_form("start_bearerbox");
}

function stop_sqlbox () {
  if (confirm("Are you sure you want to stop sqlbox"))
  {

    submit_form("stop_sqlbox");
  }
      
}

function stop_bearerbox () {
  if (confirm("Are you sure you want to stop bearerbox"))
      submit_form("stop_bearerbox");
}

function soft_restart () {
  if (confirm("Are you sure you want to restart gateway"))
      submit_form("soft_restart");
}
</script>

<div class="page-body">
<div class="row">

<div class="col-xl-4">
                <div class="card">
                  <div class="card-header"> 
                    <h4 style="text-align: center">Sqlbox</h4>
                    <p class="f-m-light mt-1">
                       Use below buttons to stop OR start the <br>sqlbox </code>.</p>
                  </div>
                  <div class="card-body"> 
                    <!--Centered modal-->
                    <form method="post" id="form">
                    <input type="hidden" id="action" name="action" value=""/>
                    </form>
                    <button class="btn btn-success" type="button" onClick="start_sqlbox()">Start</button>
                    <button class="btn btn-danger btn-sm"" type="button" onClick="stop_sqlbox()">Stop</button>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="card">
                  <div class="card-header"> 
                    <h4 style="text-align: center">Bearerbox</h4>
                    <p class="f-m-light mt-1">
                    Use below buttons to stop OR start the Bearerbox</code>.</p>
                  </div>
                  <div class="card-body"> 
                    <!--Centered modal-->
                    <button class="btn btn-success" type="button" onClick="start_bearerbox()">Start</button>
                    <button class="btn btn-danger btn-sm"" type="button" onClick="stop_bearerbox()">Stop</button>
                  </div>
                </div>
              </div>

              <div class="col-xl-4">
                <div class="card">
                  <div class="card-header"> 
                    <h4 style="text-align: center">Soft-Restart</h4>
                    <p class="f-m-light mt-1">
                    Use below button in case you have made any modifications on gateway level</code>.</p>
                  </div>
                  <div class="card-body"> 
                    <!--Centered modal-->
                    <button class="btn btn-success" type="button" onClick="soft_restart()">Restart</button>
                  </div>
                </div>
              </div>

</div>
</div>
        


