<!--Test Oracle file for UBC CPSC304 2018 Winter Term 1
  Created by Jiemin Zhang
  Modified by Simona Radu
  Modified by Jessica Wong (2018-06-22)
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  Specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "demoTable" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

  <html>
    <head>
        <title>CPSC 304 PHP/Oracle Demonstration</title>
    </head>
    <script language="javascript">
        var mapping = {
            Goalie: ["hockey_player_id","goalie_type"],
            Defense: ["hockey_player_id","defense_position","defense_type"],
            Forward: ["hockey_player_id","forward_position","forward_type"],
            Statistics_Of: ["stat_id","games_played","goals","assists","points","goals_against_average","save_percentage","hockey_player_id"],
            Injury_Can_Have: ["injury_id", "injury_type", "injury_date", "hockey_player_id"],
            Hockey_Player_ID: ["hockey_player_id", "jersey_number", "team_name"],
            Hockey_Player_In: ["team_name", "jersey_number", "first_name","last_name","age","handedness"],
            Record_Has_A: ["friendly_team_name", "opposing_team_name", "record_date","friendly_team_score","opposing_team_score","winning_team"],
            Staff_In: ["staff_id", "first_name", "last_name","stanley_cups_won","team_name"],
            Team_Part_Of: ["team_name", "city", "league_name"],
            Arena: ["city", "arena"],
            Awards: ["name", "a_year","league_name"],
            League: ["league_name"],
            Trophy: ["name", "t_year", "winner"]
        }
        function addSelectAttributes(attributes){
            for(var i = 0; i<attributes.length;i++){
                var elem1 = "selectAttribute" + (i+1).toString() + "span";
                var elem2 = "selectAttribute" + (i+1).toString() + "input";
                document.getElementById(elem1).innerHTML = attributes[i];
                document.getElementById(elem2).value = attributes[i];
                document.getElementById(elem1).style.display = "block";
                document.getElementById(elem2).style.display = "block";
            }
        }
        function addAttributes(action, attributes){
            for(var i = 0; i<attributes.length;i++){
                var elem1 = action + "Attribute" + (i+1).toString() + "span";
                var elem2 = action + "Attribute" + (i+1).toString() + "input";
                document.getElementById(elem1).innerHTML = attributes[i];
                document.getElementById(elem1).style.display = "block";
                document.getElementById(elem2).style.display = "block";
            }
        }
        
        function addIndividualAttribute(attributes){
            for(var i = 0; i<attributes.length;i++){
                var elem1 = "1-option" + i.toString();
                var elem2 = "2-option" + i.toString();
                document.getElementById(elem1).innerHTML = attributes[i];
                document.getElementById(elem1).style.display = "block";
                document.getElementById(elem1).value = attributes[i];;
                document.getElementById(elem2).innerHTML = attributes[i];
                document.getElementById(elem2).style.display = "block";
                document.getElementById(elem2).value = attributes[i];
            }
        }
        function removeIndividualAttribute(start){
            for(var i = start; i<= 9;i++){
                var elem1 = "1-option" + i.toString();
                var elem2 = "2-option" + i.toString();
                document.getElementById(elem1).style.display = "none";
                document.getElementById(elem2).style.display = "none";
            }
        }
        
        function remove(action, start){
            for(var i = start; i<= 10;i++){
                var elem1 = action + "Attribute" + i.toString() + "span";
                var elem2 = action + "Attribute" + i.toString() + "input";
                document.getElementById(elem1).style.display = "none"
                document.getElementById(elem2).style.display = "none"
            }
        }
        function onUpdate(){
            var x = document.getElementById("theTablesForUpdate").value;
            let attributes = mapping[x];
            addAttributes("update",attributes);
            remove("update", attributes.length+1);
        }
        function onInsert(){
            var x = document.getElementById("theTablesForInsert").value;
            let attributes = mapping[x];
            addAttributes("insert", attributes);
            remove("insert",attributes.length+1);
        }
        function onSelect(){
            var x = document.getElementById("theTablesForSelect").value;
            let attributes = mapping[x];
            addSelectAttributes(attributes);
            remove("select",attributes.length+1);
            removeIndividualAttribute(0);
            addIndividualAttribute(attributes);
            removeIndividualAttribute(attributes.length+1);
        }

    </script>

    <body>
        <h2>Reset</h2>
        <p>If you wish to reset the table press on the reset button. If this is the first time you're running this page, you MUST use reset</p>

        <form method="POST" action="project.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <p><input type="submit" value="Reset" name="reset"></p>
        </form>

        <hr />

        <h2>Insert Values into DemoTable</h2>
        <form method="POST" action="project.php" id = "insert"> <!--refresh page when submitted-->
            Table To Insert :  
            <select id="theTablesForInsert" name ="theTablesForInsert" onchange="onInsert()">  
            <option value="0">Select a table to insert into</option>
            <option value="Goalie">Goalie</option>  
            <option value="Defense">Defense</option>  
            <option value="Forward">Forward</option>  
            <option value="Statistics_Of">Statistics_Of</option>  
            <option value="Injury_Can_Have">Injury_Can_Have</option>  
            <option value="Hockey_Player_ID">Hockey_Player_ID</option>  
            <option value="Hockey_Player_In">Hockey_Player_In</option>  
            <option value="Record_Has_A">Record_Has_A</option>  
            <option value="Staff_In">Staff_In</option>
            <option value="Team_Part_Of">Team_Part_Of</option>
            <option value="Arena">Arena</option>
            <option value="Awards">Awards</option>
            <option value="Trophy">Trophy</option>
            <option value="League">League</option>
            </select><br /><br />
            <input type="hidden" id="insertQueryRequest" name="insertQueryRequest">            
            <span id ="insertAttribute1span" style="display:none"></span><input type="text" id ="insertAttribute1input" name="insertAttribute1" style="display:none">
            <span id ="insertAttribute2span" style="display:none"></span><input type="text" id ="insertAttribute2input" name="insertAttribute2" style="display:none">
            <span id ="insertAttribute3span" style="display:none"></span><input type="text" id ="insertAttribute3input" name="insertAttribute3" style="display:none">
            <span id ="insertAttribute4span" style="display:none"></span><input type="text" id ="insertAttribute4input" name="insertAttribute4" style="display:none">
            <span id ="insertAttribute5span" style="display:none"></span><input type="text" id ="insertAttribute5input" name="insertAttribute5" style="display:none">
            <span id ="insertAttribute6span" style="display:none"></span><input type="text" id ="insertAttribute6input" name="insertAttribute6" style="display:none">
            <span id ="insertAttribute7span" style="display:none"></span><input type="text" id ="insertAttribute7input" name="insertAttribute7" style="display:none">
            <span id ="insertAttribute8span" style="display:none"></span><input type="text" id ="insertAttribute8input" name="insertAttribute8" style="display:none">
            <span id ="insertAttribute9span" style="display:none"></span><input type="text" id ="insertAttribute9input" name="insertAttribute9" style="display:none">
            <span id ="insertAttribute10span" style="display:none"> </span><input type="text" id ="insertAttribute10input" name= "insertAttribute10"  style="display:none">
            <input type="submit" value="Insert" name="insertSubmit"></p>
            
        </form>
        <hr />
        <h2>Update Values into DemoTable</h2>
        <form method="POST" action="project.php" id = "update"> <!--refresh page when submitted-->
            Table To Update :  
            <select id="theTablesForUpdate" name ="theTablesForUpdate" onchange="onUpdate()">  
            <option value="0">Select a table to insert into</option>
            <option value="Goalie">Goalie</option>  
            <option value="Defense">Defense</option>  
            <option value="Forward">Forward</option>  
            <option value="Statistics_Of">Statistics_Of</option>  
            <option value="Injury_Can_Have">Injury_Can_Have</option>  
            <option value="Hockey_Player_ID">Hockey_Player_ID</option>  
            <option value="Hockey_Player_In">Hockey_Player_In</option>  
            <option value="Record_Has_A">Record_Has_A</option>  
            <option value="Staff_In">Staff_In</option>
            <option value="Team_Part_Of">Team_Part_Of</option>
            <option value="Arena">Arena</option>
            <option value="Awards">Awards</option>
            <option value="Trophy">Trophy</option>
            <option value="League">League</option>
            </select><br /><br />
            <input type="hidden" id="updateQueryRequest" name="updateQueryRequest">            
            <span id ="updateAttribute1span" style="display:none"></span><input type="text" id ="updateAttribute1input" name="updateAttribute1" style="display:none">
            <span id ="updateAttribute2span" style="display:none"></span><input type="text" id ="updateAttribute2input" name="updateAttribute2" style="display:none">
            <span id ="updateAttribute3span" style="display:none"></span><input type="text" id ="updateAttribute3input" name="updateAttribute3" style="display:none">
            <span id ="updateAttribute4span" style="display:none"></span><input type="text" id ="updateAttribute4input" name="updateAttribute4" style="display:none">
            <span id ="updateAttribute5span" style="display:none"></span><input type="text" id ="updateAttribute5input" name="updateAttribute5" style="display:none">
            <span id ="updateAttribute6span" style="display:none"></span><input type="text" id ="updateAttribute6input" name="updateAttribute6" style="display:none">
            <span id ="updateAttribute7span" style="display:none"></span><input type="text" id ="updateAttribute7input" name="updateAttribute7" style="display:none">
            <span id ="updateAttribute8span" style="display:none"></span><input type="text" id ="updateAttribute8input" name="updateAttribute8" style="display:none">
            <span id ="updateAttribute9span" style="display:none"></span><input type="text" id ="updateAttribute9input" name="updateAttribute9" style="display:none">
            <span id ="updateAttribute10span" style="display:none"> </span><input type="text" id ="updateAttribute10input" name= "updateAttribute10"  style="display:none">
            <input type="submit" value="Update" name="updateSubmit"></p>
            
        </form>

        <hr />

        <h2>Delete Player from a Team</h2>
        <form method="POST" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="deleteQueryRequest" name="deleteQueryRequest">
            First Name: <input type="text" name="firstName"> <br /><br />
            Last Name: <input type="text" name="lastName"> <br /><br />
            Team Name: <input type="text" name="teamName"> <br /><br />
            <input type="submit" value="Delete" name="deleteSubmit"></p>
        </form>

        <hr />

        <h2>Select from a Table</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            Table To Select :  
            <select id="theTablesForSelect" name ="theTablesForSelect" onchange="onSelect()">  
            <option value="0">Select a table to insert into</option>
            <option value="Goalie">Goalie</option>  
            <option value="Defense">Defense</option>  
            <option value="Forward">Forward</option>  
            <option value="Statistics_Of">Statistics_Of</option>  
            <option value="Injury_Can_Have">Injury_Can_Have</option>  
            <option value="Hockey_Player_ID">Hockey_Player_ID</option>  
            <option value="Hockey_Player_In">Hockey_Player_In</option>  
            <option value="Record_Has_A">Record_Has_A</option>  
            <option value="Staff_In">Staff_In</option>
            <option value="Team_Part_Of">Team_Part_Of</option>
            <option value="Arena">Arena</option>
            <option value="Awards">Awards</option>
            <option value="Trophy">Trophy</option>
            <option value="League">League</option>
            </select><br /><br />
            Attribute 1 To Select :  
            <select id="attribute1" name ="attribute1">  
            <option id="1-option0" style="display:none">0</option>
            <option id="1-option1" style="display:none">1</option>  
            <option id="1-option2" style="display:none">2</option>  
            <option id="1-option3" style="display:none">3</option>  
            <option id="1-option4" style="display:none">4</option>  
            <option id="1-option5" style="display:none">5</option>  
            <option id="1-option6" style="display:none">6</option>  
            <option id="1-option7" style="display:none">7</option>  
            <option id="1-option8" style="display:none">8</option>  
            <option id="1-option9" style="display:none">9</option>
            </select><br /><br />
            Attribute 1 Value: <input type="text" name="A1Value"> <br /><br />
            Attribute 2 To Select :  
            <select id="attribute2" name ="attribute2">  
            <option id="2-option0" style="display:none">0</option>
            <option id="2-option1" style="display:none">1</option>  
            <option id="2-option2" style="display:none">2</option>  
            <option id="2-option3" style="display:none">3</option>  
            <option id="2-option4" style="display:none">4</option>  
            <option id="2-option5" style="display:none">5</option>  
            <option id="2-option6" style="display:none">6</option>  
            <option id="2-option7" style="display:none">7</option>  
            <option id="2-option8" style="display:none">8</option>  
            <option id="2-option9" style="display:none">9</option>
            </select><br /><br />
            Attribute 2 Value: <input type="text" name="A2Value"> <br /><br />
            <p>Query: SELECT ... FROM ... WHERE A1 = V1 AND A2 > V2</p>
            <input type="hidden" id="selectQueryRequest" name="selectQueryRequest">            
            <span id ="selectAttribute1span" style="display:none"></span><input type="checkbox" id ="selectAttribute1input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute2span" style="display:none"></span><input type="checkbox" id ="selectAttribute2input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute3span" style="display:none"></span><input type="checkbox" id ="selectAttribute3input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute4span" style="display:none"></span><input type="checkbox" id ="selectAttribute4input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute5span" style="display:none"></span><input type="checkbox" id ="selectAttribute5input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute6span" style="display:none"></span><input type="checkbox" id ="selectAttribute6input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute7span" style="display:none"></span><input type="checkbox" id ="selectAttribute7input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute8span" style="display:none"></span><input type="checkbox" id ="selectAttribute8input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute9span" style="display:none"></span><input type="checkbox" id ="selectAttribute9input" name="selectAttribute[]" style="display:none">
            <span id ="selectAttribute10span" style="display:none"> </span><input type="checkbox" id ="selectAttribute10input" name = "selectAttribute[]"  style="display:none">
            <input type="submit" value="Select" name="selectSubmit"></p>
        </form>

        <hr />

        <h2>Get Statistics of Players on Team</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="statisticsOfPlayerRequest" name="statisticsOfPlayerRequest">
            First Name: <input type="text" name="firstName"> <br /><br />
            Last Name: <input type="text" name="lastName"> <br /><br />
            Team Name: <input type="text" name="teamName"> <br /><br />
            <input type="submit" value="Get Statistics" name="statisticsTuple"></p>
        </form>
        <hr />

        <h2>Project the values you want from the table Statistics_Of</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="" name="">
            <input type="checkbox" id="stat_id_projection" name="stat_id_projection" value="SO.stat_id">
            <label for="stat_id_projection">stat_id</label><br>
            
            <input type="checkbox" id="games_played_projection" name="games_played_projection" value="SO.games_played">
            <label for="games_played_projection">games_played</label><br>

            <input type="checkbox" id="goals_projection" name="goals_projection" value="SO.goals">
            <label for="goals_projection">goals</label><br>

            <input type="checkbox" id="assists_projection" name="assists_projection" value="SO.assists">
            <label for="assists_projection">assists</label><br>

            <input type="checkbox" id="points_projection" name="points_projection" value="SO.points">
            <label for="points_projection">points</label><br>

            <input type="checkbox" id="goals_against_average_projection" name="goals_against_average_projection" value="SO.goals_against_average">
            <label for="goals_against_average_projection">goals_against_average</label><br>

            <input type="checkbox" id="save_percentage_projection" name="save_percentage_projection" value="SO.save_percentage">
            <label for="save_percentage">save_percentage</label><br>
            
            <input type="checkbox" id="hockey_player_id_projection" name="hockey_player_id_projection" value="SO.hockey_player_id">
            <label for="hockey_player_id_projection">hockey_player_id</label><br>
            
            
            <input type="hidden" id="projectionRequest" name="projectionRequest">
            <input type="submit" value="Project" name="projectTuples"></p>
        </form>
        <hr />

        <h2>Aggregation by group</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            Select Aggregation :  
            <select id="aggregationDropDown" name ="aggregationDropDown">  
            <option value="min">min</option>
            <option value="max">max</option>  
            <option value="average">average</option>  
            <option value="count">count</option>  
            </select><br /><br />
             

            <input type="hidden" id="aggregationByGroupRequest" name="aggregationByGroupRequest">
            <input type="submit" value="Aggregate" name="aggregationByGroupTuples"></p>
        </form>
        <hr />
        
        
        <h2>Aggregation with having</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="aggregationHavingRequest" name="aggregationHavingRequest">
            Goal Threshold: <input type="text" id="goalThresh" name="goalThresh">
            <input type="submit" value="Aggregate" name="aggregationWithHavingTuples"></p>
        </form>
        <hr />

        <h2>Division</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="divisionRequest" name="divisionRequest">
            <input type="submit" value="Divide" name="divisionTuples"></p>
        </form>
        <hr />

        <h2>Nested Aggregation</h2>
        <form method="GET" action="project.php"> <!--refresh page when submitted-->
            <input type="hidden" id="nestedAggregationRequest" name="nestedAggregationRequest">
            <input type="submit" value="Aggregate" name="nestedAggregationTuples"></p>
        </form>
        <hr />

        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP
        $mapping =  [
            "Goalie" => ["hockey_player_id","goalie_type"],
            "Defense" => ["hockey_player_id","defense_position","defense_type"],
            "Forward" => ["hockey_player_id","forward_position","forward_type"],
            "Statistics_Of" => ["stat_id","games_played","goals","assists","points","goals_against_average","save_percentage","hockey_player_id"],
            "Injury_Can_Have" => ["injury_id", "injury_type", "injury_date", "hockey_player_id"],
            "Hockey_Player_ID" => ["hockey_player_id", "jersey_number", "team_name"],
            "Hockey_Player_In" => ["team_name", "jersey_number", "first_name","last_name","age","handedness"],
            "Record_Has_A" => ["friendly_team_name", "opposing_team_name", "record_date","friendly_team_score","opposing_team_score","winning_team"],
            "Staff_In" => ["staff_id", "first_name", "last_name","stanley_cups_won","team_name"],
            "Team_Part_Of" => ["team_name", "city", "league_name"],
            "Arena" => ["city", "arena"],
            "Awards" => ["name", "a_year","league_name"],
            "League" => ["league_name"],
            "Trophy" => ["name", "t_year", "winner"]
        ];
        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr); 

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection. 
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($array, $result) { //prints results from a select statement
            echo "<table>";
            echo "<tr>";
            foreach($array as $attribute){
                echo "<th>{$attribute}</th>";
            }
            echo "</tr>";
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr>";
                for($start = 0; $start<count($row);$start++){
                    echo "<td>".$row[$start]."</td>";
                }
                echo "</tr>";
            }
            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example, 
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_stefan5", "a92508084", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;
            global $mapping;
            $theTableToInsertInto = $_POST['theTablesForUpdate'];
            $attribute1 = $_POST["updateAttribute1"];
            $attribute2 = $_POST["updateAttribute2"];
            $attribute3 = $_POST["updateAttribute3"];
            $attribute4 = $_POST["updateAttribute4"];
            $attribute5 = $_POST["updateAttribute5"];
            $attribute6 = $_POST["updateAttribute6"];
            $attribute7 = $_POST["updateAttribute7"];
            $attribute8 = $_POST["updateAttribute8"];
            $attribute9 = $_POST["updateAttribute9"];
            $attribute10 = $_POST["updateAttribute10"];

            // you need the wrap the old name and new name values with single quotations
            $query;
            if($theTableToInsertInto=="Goalie"){
                $query = "UPDATE {$theTableToInsertInto} SET goalie_type='{$attribute2}' WHERE hockey_player_id='{$attribute1}'";
            }else if ($theTableToInsertInto=="Defense"){
                $query = "UPDATE {$theTableToInsertInto} SET defense_position='{$attribute2}', defense_type='{$attribute3}' WHERE hockey_player_id='{$attribute1}'";
            }else if ($theTableToInsertInto=="Forward"){
                $query = "UPDATE {$theTableToInsertInto} SET forward_position='{$attribute2}', forward_type='{$attribute3}' WHERE hockey_player_id='{$attribute1}'";
            }else if($theTableToInsertInto=="Statistics_Of"){
                $query = "UPDATE {$theTableToInsertInto} SET games_played='{$attribute2}', goals='{$attribute3}', assists='{$attribute4}', points='{$attribute5}', goals_against_average='{$attribute6}', save_percentage='{$attribute7}' WHERE stat_id='{$attribute1}'";
            }else if($theTableToInsertInto=="Injury_Can_Have"){
                $query = "UPDATE {$theTableToInsertInto} SET injury_type='{$attribute2}', injury_date='{$attribute3}', hockey_player_id='{$attribute4}' WHERE injury_id='{$attribute1}'";
            }else if($theTableToInsertInto=="Hockey_Player_ID"){
                $query = "UPDATE {$theTableToInsertInto} SET jersey_number='{$attribute2}', team_name='{$attribute3}' WHERE hockey_player_id='{$attribute1}'";
            }else if($theTableToInsertInto=="Hockey_Player_In"){
                $query = "UPDATE {$theTableToInsertInto} SET first_name='{$attribute3}', last_name='{$attribute4}', age='{$attribute5}', handedness='{$attribute6}' WHERE team_name='{$attribute1}' AND jersey_number='{$attribute2}'";
            }else if($theTableToInsertInto=="Record_Has_A"){
                $query = "UPDATE {$theTableToInsertInto} SET friendly_team_score='{$attribute4}', opposing_team_score='{$attribute5}', winning_team='{$attribute6}' WHERE friendly_team_name='{$attribute1}' AND opposing_team_name='{$attribute2}' AND record_date='{$attribute3}'";
            }else if($theTableToInsertInto=="Staff_In"){
                $query = "UPDATE {$theTableToInsertInto} SET first_name='{$attribute2}', last_name='{$attribute3}', stanley_cups_won='{$attribute4}', team_name='{$attribute5}' WHERE staff_id='{$attribute1}'";
            }else if($theTableToInsertInto=="Team_Part_Of"){
                $query = "UPDATE {$theTableToInsertInto} SET city='{$attribute2}', league_name='{$attribute3}' WHERE team_name='{$attribute1}'";
            }else if($theTableToInsertInto=="Arena"){
                $query = "UPDATE {$theTableToInsertInto} SET arena='{$attribute2}' WHERE city='{$attribute1}'";
            }else if($theTableToInsertInto=="Awards"){
            }else if($theTableToInsertInto=="League"){
            }else if($theTableToInsertInto=="Trophy"){
                $query = "UPDATE {$theTableToInsertInto} SET winner='{$attribute3}' WHERE name='{$attribute1}' AND t_year='{$attribute2}'";
            }
            if($query){
                print($query);
                executePlainSQL($query);
                $result = executePlainSQL("SELECT * FROM {$theTableToInsertInto}");
                printResult($mapping[$theTableToInsertInto], $result);
            }else{
                print("Error Can not execute query");
            }
            OCICommit($db_conn);
        }

        function handleResetRequest() {
            global $db_conn;
            $file = fopen("HockeyDB.sql", "r") or die("Unable to open file!");
            while(($line = stream_get_line($file, 1024*1024, ";"))!=false){
                executePlainSQL($line);
            }
            fclose($file);
            
            OCICommit($db_conn);
        }

        function handleInsertRequest() {
            global $db_conn;
            global $mapping;
            $theTableToInsertInto = $_POST['theTablesForInsert'];
            $attribute1 = $_POST["insertAttribute1"];
            $attribute2 = $_POST["insertAttribute2"];
            $attribute3 = $_POST["insertAttribute3"];
            $attribute4 = $_POST["insertAttribute4"];
            $attribute5 = $_POST["insertAttribute5"];
            $attribute6 = $_POST["insertAttribute6"];
            $attribute7 = $_POST["insertAttribute7"];
            $attribute8 = $_POST["insertAttribute8"];
            $attribute9 = $_POST["insertAttribute9"];
            $attribute10 = $_POST["insertAttribute10"];
            // you need the wrap the old name and new name values with single quotations
            $query;
            if($theTableToInsertInto=="Goalie"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}')";
            }else if ($theTableToInsertInto=="Defense"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}')";
            }else if ($theTableToInsertInto=="Forward"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}')";
            }else if($theTableToInsertInto=="Statistics_Of"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}','{$attribute4}','{$attribute5}','{$attribute6}','{$attribute7}','{$attribute8}')";
            }else if($theTableToInsertInto=="Injury_Can_Have"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}','{$attribute4}')";
            }else if($theTableToInsertInto=="Hockey_Player_ID"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}')";
            }else if($theTableToInsertInto=="Hockey_Player_In"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}','{$attribute4}','{$attribute5}','{$attribute6}')";
            }else if($theTableToInsertInto=="Record_Has_A"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}','{$attribute4}','{$attribute5}','{$attribute6}')";
            }else if($theTableToInsertInto=="Staff_In"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}','{$attribute4}','{$attribute5}')";
            }else if($theTableToInsertInto=="Team_Part_Of"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}')";
            }else if($theTableToInsertInto=="Arena"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}')";
            }else if($theTableToInsertInto=="Awards"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}')";
            }else if($theTableToInsertInto=="League"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}')";
            }else if($theTableToInsertInto=="Trophy"){
                $query = "INSERT INTO {$theTableToInsertInto} VALUES ('{$attribute1}', '{$attribute2}','{$attribute3}')";
            }
            if($query){
                print($query);
                executePlainSQL($query);
                $result = executePlainSQL("SELECT * FROM {$theTableToInsertInto}");
                printResult($mapping[$theTableToInsertInto], $result);
                
            }else{
                print("Error Can not execute query");
            }

            OCICommit($db_conn);
        }

        function handleSelectRequest() {
            global $db_conn;
            global $mapping;

            $theTableToInsertInto = $_GET['theTablesForSelect'];
            $array = $_GET["selectAttribute"];
            $query = "SELECT ";
            if(count($array) ==0){
                print("No attributes selected!");
                return;
            }
            foreach ($array as $attribute){
                $query .= "{$attribute}, ";
            }
 
            // Remove the comma and the space from the last attribute
            $query = substr($query,0,-2);

            $A1 = $_GET['attribute1'];
            $A1V = $_GET['A1Value'];
            $A2 = $_GET['attribute2'];
            $A2V = $_GET['A2Value'];
            $query .= " FROM {$theTableToInsertInto} WHERE {$A1}='{$A1V}' AND {$A2}>'{$A2V}'";
            $result=executePlainSQL($query);
            print($query);
            printResult($array, $result);
        }


        function handleDeleteRequest() {
            global $db_conn;
            global $mapping;
            $first_name = $_POST["firstName"];
            $last_name = $_POST['lastName'];
            $team_name = $_POST['teamName'];

            $query = "DELETE FROM Hockey_Player_In WHERE first_name='" .$first_name. "' AND last_name='" .$last_name. "' AND team_name='" .$team_name. "'";
            $result = executePlainSQL($query);
            if($query){
                print($query);
                executePlainSQL($query);
                $result = executePlainSQL("SELECT * FROM Hockey_Player_In");
                printResult($mapping["Hockey_Player_In"], $result);
            }else{
                print("Error Can not execute query");
            }
            OCICommit($db_conn);
        }

        function handleCountRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT Count(*) FROM Trophy");

            if (($row = oci_fetch_row($result)) != false) {
                echo "<br> The number of tuples in demoTable: " + $row[0] + "<br>";
            }
        }

        function handleJoinRequest() {
            global $db_conn;
            global $mapping;
            $first_name = $_GET["firstName"];
            $last_name = $_GET['lastName'];
            $team_name = $_GET['teamName'];
            $query = "SELECT SO.games_played, SO.goals, SO.assists, SO.points, SO.goals_against_average, SO.save_percentage
            FROM Statistics_Of SO, Hockey_Player_ID HPID, Hockey_Player_In HPIN 
            WHERE HPIN.first_name='" .$first_name. "' AND HPIN.last_name='" .$last_name. "' AND HPIN.team_name='" .$team_name. "' 
            AND HPIN.jersey_number = HPID.jersey_number AND HPID.hockey_player_id = SO.hockey_player_id";
            $result = executePlainSQL($query);

            if($query){
                print($query);
                $array = ["GP", "G", "A", "Pts", "GAA", "Save%"];
                printResult($array, $result);
            }else{
                print("Error Can not execute query");
            }
        }

        function handleProjectionRequest() {
            global $db_conn;

            $attribute1 = $_GET['stat_id_projection'];
            $attribute2 = $_GET['games_played_projection'];
            $attribute3 = $_GET['goals_projection'];
            $attribute4 = $_GET['assists_projection'];
            $attribute5 = $_GET['points_projection'];
            $attribute6 = $_GET['goals_against_average_projection'];
            $attribute7 = $_GET['save_percentage_projection'];
            $attribute8 = $_GET['hockey_player_id_projection'];

            $theArray = array($attribute1, $attribute2, $attribute3, $attribute4, $attribute5, $attribute6, $attribute7, $attribute8);
            
            $theNewArray = implode(', ', array_filter($theArray));
            $query = "SELECT " . $theNewArray . " FROM Statistics_Of SO";
            $result = executePlainSQL($query);

            if($query){
                print($query);
                printResult(array_filter($theArray), $result);
            }else{
                print("Error Can not execute query");
            }
        }

        function handleAggregationByGroupRequest() {
            global $db_conn;
            
            $command = $_GET['aggregationDropDown'];
            $query;
            $array;
            $result;
            if($command == "min" || $command == "max" || $command == "average") {
                if($command == "average") {
                    $command = "avg";
                }
                $query = "SELECT " .$command."(HP.age), HP.team_name FROM hockey_player_in HP Group By HP.team_name";
                $array = ["age", "team_name"];
                $result = executePlainSQL($query);
            }
            // show number of people on each team group by team
            else if($command == "count") {
                $query = "SELECT " .$command."(HP.hockey_player_id), HP.team_name FROM hockey_player_id HP Group By HP.team_name";
                $result = executePlainSQL($query);
                $array = ["num players", "team_name"];
                
            }
            if($query){
                echo "<br>{$query}</br>";
                if($command=="count"){
                    echo "<br>Retrieving number of players on each team</br>";
                }else{
                    echo "<br>Retrieving {$command} age of each team:</br>";
                }
                echo"<br>";
                printResult($array, $result);
            }else{
                print("Error Can not execute query");
            }
        }

        function handleAggregationWithHavingRequest() {
            global $db_conn;

            $goalThresh = $_GET["goalThresh"];
            $query = "SELECT HPID.team_name, MAX(SO.goals)
            FROM Statistics_Of SO, Hockey_Player_ID HPID
            WHERE SO.hockey_player_id = HPID.hockey_player_id AND SO.goals > {$goalThresh}
            GROUP BY HPID.team_name
            HAVING COUNT(*) > 1";
            $result = executePlainSQL($query);

            $array = ["Team Name", "Goals"];
            if($query){
                echo "<br>{$query}</br>";
                echo "<br>Retrieved the most goals for each team with 2 or more players above {$goalThresh}:</br>";
                echo "<br>";
                printResult($array, $result);
            }else{
                print("Error Can not execute query");
            }
        }

        function handleDivisionRequest() {
            global $db_conn;
            $query = "SELECT HPIN.first_name, HPIN.last_name FROM Hockey_Player_In HPIN
            WHERE NOT EXISTS (SELECT A.name FROM Awards A WHERE A.A_YEAR=2021
            AND NOT EXISTS (SELECT * FROM Trophy WHERE Trophy.t_year = 2021 AND Trophy.name = A.name AND TRIM(Trophy.winner) = (TRIM(HPIN.FIRST_NAME) || ' ' || TRIM(HPIN.LAST_NAME))))";
            echo "<br>{$query}</br>";
            echo "<br>Retrieved the players who have won all the awards in 2021 {$goalThresh}:</br>";
            $result = executePlainSQL($query);
            $array = ['first_name', 'last_name'];
            echo "<br>";
            printResult($array, $result);
        }

        function handleNestedAggregationRequest() {
            global $db_conn;

            // select all the hockey players that play for a team that plays in all the leagues
            $query = "SELECT AVG(HPI.age), HPI.handedness
            FROM hockey_player_in HPI
            GROUP BY hpi.handedness
            HAVING 7 < (SELECT count(*) FROM hockey_player_in HPI2 WHERE HPI.handedness = HPI2.handedness)";
            $result = executePlainSQL($query);
            echo "<br>{$query}</br>";
            echo "<br>Retrieved the average age of players who are left or right handed if more than 7 players contribute to the average:<br>";
            $result = executePlainSQL($query);
            $array = ['Average Age', 'Handedness'];
            echo "<br>";
            printResult($array, $result);
        }

    // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('resetTablesRequest', $_POST)) {
                    handleResetRequest();
                } else if (array_key_exists('updateQueryRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('insertQueryRequest', $_POST)) {
                    handleInsertRequest();
                } else if (array_key_exists('deleteQueryRequest', $_POST)) {
                    handleDeleteRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('countTuples', $_GET)) {
                    handleCountRequest();
                } 
                else if (array_key_exists('statisticsTuple', $_GET)) {
                    handleJoinRequest();
                }
                else if (array_key_exists('projectTuples', $_GET)) {
                    handleProjectionRequest();
                }
                else if (array_key_exists('aggregationByGroupTuples', $_GET)) {
                    handleAggregationByGroupRequest();
                }
                else if (array_key_exists('selectSubmit', $_GET)) {
                    handleSelectRequest();
                }
                else if (array_key_exists('aggregationWithHavingTuples', $_GET)) {
                    handleAggregationWithHavingRequest();
                }
                else if (array_key_exists('nestedAggregationTuples', $_GET)) {
                    handleNestedAggregationRequest();
                }
                else if (array_key_exists('divisionTuples', $_GET)) {
                    handleDivisionRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['reset']) || isset($_POST['updateSubmit']) || isset($_POST['insertSubmit']) || isset($_POST['deleteSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['countTupleRequest']) || isset($_GET['statisticsOfPlayerRequest']) 
                                                     || isset($_GET['projectionRequest'])
                                                     || isset($_GET['aggregationByGroupRequest'])
                                                     || isset($_GET['selectQueryRequest'])
                                                     || isset($_GET['aggregationHavingRequest'])
                                                     || isset($_GET['nestedAggregationRequest'])
                                                     || isset($_GET['divisionRequest'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>

