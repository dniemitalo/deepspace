<!DOCTYPE HTML>
<html>
<head>
    <title>Report</title>
    <link rel='stylesheet' href="w3.css">
    <link rel='stylesheet' href="w3-theme-red.css">
    <link rel='stylesheet' href="style.css">
    <meta name=viewport content="width=device-width">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="teamData.js"></script>
    <!-- <script src="report.js"></script> -->
    <style type="text/css">

        td, th{
            text-align:center;
            padding-left:3px;
            padding-right:3px;
    }

    </style>
</head>
<body class="w3-theme-d3">
<?php require_once 'navmenu.php'; ?>
<div id="linknum" style="display:none;"><?php echo $_GET['team']; ?></div>
<div class="w3-panel w3-theme-l3 w3-padding-large w3-round-xxlarge w3-border w3-border-black w3-text-white">
    <h4>Team Reports</h4>
    <p class="status"></p>
    <label for="team">Team Number</label><br>
    <select id="team" value = "167" name="team">
        <option value="167">167</option>
        <option value="525">525</option>
        <option value="967">967</option>
    </select><br>

    <p><img src="" alt="No picture" id="robot_picture" style='max-width: 300px'></p>

    <p>
    <!--
    <strong>General:</strong>
    <span id="height"></span>
    <span id="weight"></span>
    <br>
    -->
    <strong>Drive: </strong>
    <span id="drivetype"></span>
    <span id="transmission"></span>
    <span id="driveMotors"></span>
    <span id="speed"></span>
    <span id="motors_type"></span>
    <br>
    <strong>Hatch Manipulator: </strong><span id="hatch_type">?</span><br>
    <strong>Hatch Floor pickup:</strong><span id="hatch_floor">?</span><br>
    <strong>Cargo Manipulator: </strong><span id="cargo_type">?</span><br>
    <strong>Cargo Floor pickup: </strong><span id="cargo_floor">?</span><br>
    <strong>Scoring Height: </strong><span id="level">?</span><br>
    <strong>Climber: </strong><span id="climb_level"></span>&nbsp;<span id="climb_type">?</span><br>
    <strong>Sandstorm: </strong><span id="sandstorm">?</span><br>
    <strong>Language: </strong><span id="language">?</span><br>

    <p id='comments'></p>
    </p>
  
    <p>
    <strong>Matches Played: </strong><span id="numberOfMatches">?</span><br>
    <strong>Sandstorm Gamepiece Scoring:</strong> <span id="sandstorm_pct"></span><br>
    <strong>Min/Avg/Max Hatches:</strong> 
    <span id="min_hatches">?</span> / <span id="avg_hatches">?</span> / <span id="max_hatches">?</span><br>
    <strong>Min/Avg/Max Cargo:</strong> 
    <span id="min_cargo">?</span> / <span id="avg_cargo">?</span> / <span id="max_cargo">?</span><br>
    <strong>Climbs:</strong> <span id="climb_pct"></span><br>
    </p>

    <div id="mtable">Match Info Table</div>
    <div id="mcomments">Match Comments Table</div>

    </div>
<script>

function lookupMatchData(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 & this.status == 200){
            matches = JSON.parse(xhr.responseText);
            document.getElementById('numberOfMatches').innerHTML = matches.length;

            var sandstorm_made = 0;
            var sandstorm_tries = 0;
            var climbs = 0;
            var climb_fail = 0;
            var hatches = [];
            var cargo = [];
            var all_matches_hatch = 0;
            var all_matches_cargo = 0;
            var c = 0;
            var h = 0;
            //Loop 1st time for overall stats
            for (i=0; i < matches.length; i++){
                if (matches[i]['sandstorm_success']) {sandstorm_tries += 1;}
                if (matches[i]['sandstorm_success']=="1") {sandstorm_made += 1;}
                if (matches[i]['climb'].includes('F')){climb_fail += 1};
                if (matches[i]['climb'].includes('S')){climbs += 1};
                h = parseInt(matches[i]['hatch_made']);
                c = parseInt(matches[i]['cargo_made']);

                all_matches_hatch += h;
                hatches.push(h);
                all_matches_cargo += c;
                cargo.push(c);

            }
            var hmin = Math.min.apply(null,hatches);
            var hmax = Math.max.apply(null,hatches);
            var havg = Math.round(10*all_matches_hatch/matches.length)/10;
            var cmin = Math.min.apply(null,cargo);
            var cmax = Math.max.apply(null,cargo);
            var cavg = Math.round(10*all_matches_cargo/matches.length)/10;

            document.getElementById('min_hatches').innerHTML = hmin;
            document.getElementById('avg_hatches').innerHTML = havg;
            document.getElementById('max_hatches').innerHTML = hmax;
            document.getElementById('min_cargo').innerHTML = cmin;
            document.getElementById('avg_cargo').innerHTML = cavg;
            document.getElementById('max_cargo').innerHTML = cmax;


            document.getElementById('sandstorm_pct').innerHTML = sandstorm_made+" of "+sandstorm_tries;
            document.getElementById('climb_pct').innerHTML = climbs +" of "+ (climbs + climb_fail);

            //Loop 2nd time for each match stats
            var t = "";
            var HATCH = "";
            var CARGO = "";
            var Foul = 0;
            t += "<table>";
            t += '<tr><td></td><td colspan="4" style="text-align: left;">Sandstorm</td><td colspan="4" style="text-align: left;">Teleoperated</td></tr>';
            t += "<tr><th>M#</th><th>Hab</th><th>Pre</th><th>Loc</th><th>Suc</th><th>Hat</th><th>Car</th><th>Lv</th><th>CL</th></tr>";
            for(i = 0; i < matches.length; i++){
                t += "<tr>";
                t += "<td>"+matches[i]['matchnum']+"</td>";
                t += "<td>"+matches[i]['habline']+"</td>";
                t += "<td>"+matches[i]['sandstorm_preload']+"</td>";
                t += "<td>"+matches[i]['sandstorm_action']+"</td>";
                t += "<td>"+matches[i]['sandstorm_success']+"</td>";
                HATCH = matches[i]['hatch_made']+"/"+(parseInt(matches[i]['hatch_made']) + parseInt(matches[i]['hatch_missed']));
                CARGO = matches[i]['cargo_made']+"/"+(parseInt(matches[i]['cargo_made']) + parseInt(matches[i]['cargo_missed']));
                HATCH = (HATCH == "0/0") ? "-" : HATCH;
                CARGO = (CARGO == "0/0") ? "-" : CARGO;
                t += "<td>"+HATCH+"</td>";
                t += "<td>"+CARGO+"</td>";
                t += "<td>"+matches[i]['difficulty']+"</td>";
                t += "<td>"+matches[i]['climb']+"</td>";
                Foul = parseInt(matches[i]['foul']);
                Foul = (Foul == 0) ? "-" : Foul;
                t += "<td>"+Foul+"</td>";
                
                t += "</tr>";
            }
            t += "</table>";
            document.getElementById('mtable').innerHTML = t;

            //3rd loop for comments and other categories
            var ct = "";
            ct += "<table><tr><th>M#</th><th>Comments</th></tr>\n";
            for (i=0;i<parseInt(matches.length);i++){
                other = "";
                if(matches[i]["comments"].length>0){
                    other = "";
                    if (matches[i]['tele_incap'] == 1){other += "Incapacitated. ";}
                    if (matches[i]['defense'] == 1){other += "Played Defense. ";}
                    ct+= "<td>"+matches[i]["matchnum"]+"</td>";
                    ct+= "<td style='text-align:left;'>"+other.trim()+matches[i]["comments"]+" -"+matches[i]["scout_name"]+"</td>";
                    ct+= "</tr>";
                }
            }
            ct+="</table>";
            document.getElementById('mcomments').innerHTML = ct;
        }
    }
    xhr.open('GET', 'get_team_matches.php?team=' + document.getElementById('team').value);
    xhr.send();

}

function lookupTeamData(){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 & this.status == 200){
            if (xhr.responseText != 'null'){
                status("Data found for team " + document.getElementById('team').value);
                var data = JSON.parse(xhr.responseText);
                document.getElementById('drivetype').innerHTML = data['drivetype'];
                document.getElementById('transmission').innerHTML = data['transmission'];
                document.getElementById('driveMotors').innerHTML = data['driveMotors'];
                document.getElementById('motors_type').innerHTML = data['motors_type'];
                document.getElementById('level').innerHTML = data['level'];
                document.getElementById('hatch_type').innerHTML = data['hatch_type'];
                document.getElementById('hatch_floor').innerHTML = data['hatch_floor'];
                document.getElementById('cargo_type').innerHTML = data['cargo_type'];
                document.getElementById('cargo_floor').innerHTML = data['cargo_floor'];
                document.getElementById('climb_type').innerHTML = data['climb_type'];
                document.getElementById('climb_level').innerHTML = data['climb_level'];
                document.getElementById('sandstorm').innerHTML = data['sandstorm'];
                document.getElementById('language').innerHTML = data['language'];
                if(data['comments'].length >0){
                    document.getElementById('comments').innerHTML = '<strong>Pit comments: </strong>'+data['comments'];                
                }
                else {
                    document.getElementById('comments').innerHTML = "";                   
                }
            }
            else {
                status("No data found.");
                document.getElementById('drivetype').innerHTML = "";
                document.getElementById('transmission').innerHTML = "";
                document.getElementById('driveMotors').innerHTML = "";
                document.getElementById('motors_type').innerHTML = "";
                document.getElementById('level').innerHTML = "";
                document.getElementById('hatch_type').innerHTML = "";
                document.getElementById('hatch_floor').innerHTML = "";
                document.getElementById('cargo_type').innerHTML = "";
                document.getElementById('cargo_floor').innerHTML = "";
                document.getElementById('climb_type').innerHTML = "";
                document.getElementById('climb_level').innerHTML = "";
                document.getElementById('sandstorm').innerHTML = "";
                document.getElementById('comments').innerHTML = "";
            }
        }
        else {
            status("Looking for team " + document.getElementById('team').value + " data...");
        }
    };

    xhr.open('GET', 'pit_team_get.php?team=' + document.getElementById('team').value);
    xhr.send();
}

function lookupPicture(){
    var xhr = new XMLHttpRequest();
    var params = 'team=' + document.getElementById('team').value;
    console.log(params);
    xhr.onreadystatechange = function(){
        if(this.readyState == 4 & this.status == 200){
        document.getElementById('robot_picture').src = xhr.responseText.trim();
        }
    }
    
    xhr.open("POST", "get_pic_name.php", true); 
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send(encodeURI(params));
}

function updateTeams(arr){
    var teamList = [];
    for (i = 0; i < teamData.length; i++){
        teamList.push({num: parseInt(teamData[i]["team_number"]), nick: teamData[i]["nickname"]});
    }

    teamList.sort(function comp(a, b){return parseInt(a['num'])-parseInt(b['num'])});

    var choices = '';
    for(i = 0; i < teamList.length; i++){
        var num = teamList[i]['num'];
        var nick = teamList[i]['nick']
        choices += '<option value="'+num+'">'+num+' - '+nick.substring(0,22)+'</option>\n';
    }
    document.getElementById('team').innerHTML = choices;
}

function status(m){
    document.getElementsByClassName('status')[0].innerHTML = m;
    // document.getElementsByClassName('status')[1].innerHTML = m;
}

document.addEventListener("DOMContentLoaded", function() {
    //Document ready function
    updateTeams(teamData);
    // $("#team").val($('#linknum').html());
    if (parseInt(document.getElementById('linknum').innerHTML) > 0){    
        document.getElementById('team').value = parseInt(document.getElementById('linknum').innerHTML); 
    }
    else {
        //no GET value specified
    }


    document.getElementById('team').addEventListener("change", function(){
        lookupTeamData();
        lookupMatchData();
        lookupPicture();
        // document.getElementById('robot_picture').src = "pics/"+document.getElementById('team').value+".jpg";
    });

    if (parseInt(document.getElementById('linknum').innerHTML) > 0){    
        lookupTeamData();
        lookupMatchData();
    }
    lookupPicture();

}); //end document ready function

</script>
</body>
</html>