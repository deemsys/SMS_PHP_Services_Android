<?php

session_start();

require("../config.php");

require('../twilio-php-master/Services/Twilio.php');

//require('C:\wamp\www\bcreasearchT\twilio-php-master\Services\Twilio.php');

$case = $_REQUEST['service'];

switch($case){

    case 'partinsert':{

//		$refuserid = $_POST['userid'];
        $username = $_POST['username1'];
        $firstname = $_POST['fname'];
        $mobile = $_POST['mobile_num'];
        $gender = $_POST['gender'];
        $city = $_POST['city'];
        $education = $_POST['education'];
        $medical = $_POST['medical_details'];
        $timeone = $_POST['time1'];
        $timem1 = $_POST['time1_am_pm'];
        $timetwo = $_POST['time2'];
        $timem2 = $_POST['time2_am_pm'];
        $timethree = $_POST['time3'];
        $timem3 = $_POST['time3_am_pm'];
        $provider = $_POST['Provider_name'];
        $group = $_POST['group_name'];
        $age = $_POST['age'];
        $email = $_POST['email'];
        $password= $_POST['pass'];
         $groupid1=$_POST['groupid1'];
        $groupname1=$_POST['groupname12'];
        $error='error';


        //$zipcode = $_POST['zipcode'];

        $sql = "SELECT * FROM login WHERE email_id ='".$email."'";
        $count1 = mysql_num_rows(mysql_query($sql));
         $sql7 = "SELECT * FROM login WHERE username ='".$username."'";
        $count7= mysql_num_rows(mysql_query($sql7)) ;
        
        $sql8 = "SELECT * FROM  participants_table WHERE mobile_num ='".$mobile."'";
        $count8= mysql_num_rows(mysql_query($sql8)) ;


        if($count8>0)
        {
            $json    = '{ "serviceresponse" : { "servicename" : "Signup", "username" : "NULL","success" : "No", "message" : "Mobile Number Exist" } }';
        }
        else
        {
        if($count7 >0)
        {
            $json    = '{ "serviceresponse" : { "servicename" : "Signup", "username" : "NULL","success" : "No", "message" : "Username Exist" } }';

        }
        else
        {

        if($count1 > 0)
        {
            $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "NULL",  "message" : "Already Exist" } }';
        }
        else
        {
            $userdetail ="INSERT INTO participants_table (participants_id, fname, username, mobile_num, gender, city, education, medical_details, time1,time1_am_pm, time2,time2_am_pm,time3,time3_am_pm,Provider_name, group_name, age, date_of_join, email_id, created_by, message) VALUES ('', '".$firstname."', '".$username."', '".$mobile."', '".$gender."', '".$city."', '".$education."', '".$medical."', '".$timeone."','".$timem1."', '".$timetwo."','".$timem2."', '".$timethree."', '".$timem3."','".$provider."', '".$group."', '".$age."', NOW(),'".$email."', 'Participant', '1');";

            mysql_query($userdetail);

            $indipat_id = mysql_insert_id();

            $patmed = "INSERT INTO login (login_id, username, password, email_id, role, status) VALUES ('".$indipat_id."', '".$username."', '".$password."', '".$email."', '0', '1')";

             mysql_query($patmed);
              $grouparray=explode("-",$groupname1);

            $groupidarray=explode("-",$groupid1);

          for($i=0;$i<count($grouparray);$i++)
            {
          //   echo($grouparray[$i]);
           //  echo "<br>";
           // echo($groupidarray[$i]);
           //  echo "<br>";

             $groupinsert="INSERT INTO participant_group (id, group_id, group_name, participant_id) VALUES ('','".$groupidarray[$i]."','".$grouparray[$i]."','".$indipat_id."') ";
//			$assignassessment ="INSERT INTO tbl_patientassessment_details (pa_patientassessment_patname, pa_patientassessment_patid, pa_patientassessment_providerid, pa_patientassessment_assid, pa_patientassessment_status) VALUES ('".$username."', '".$indipat_id."', '0', '1', '1'),('".$username."', '".$indipat_id."', '0', '3', '1');";
               mysql_query($groupinsert);

            }
            $day=7;
            for($i=1;$i<=12;$i++)
            {
                $sql1 = "insert into weekly_logs (log_id,participant_id,week,date_time,continous,count,status) values ('','".$indipat_id."','".$i."',NOW()+INTERVAL '".$day."' DAY,'0','0','0')";
                mysql_query($sql1);
                $day+=7;
            }
             $userlogs="insert into user_roles (USER_ROLE_ID,USER_ID,AUTHORITY) values ('','".$indipat_id."','ROLE_USER')";
            if(mysql_query($userlogs))
            {

                $json    = '{ "serviceresponse" : { "servicename" : "Signup", "success" : "Yes", "message" : "1" } }';



                //$json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "NULL",  "message" : "'.$error.'" } }';


            }
            else
            {
                $json	= '{ "serviceresponse" : { "servicename" : "Signup", "success" : "No", "emaill" : "NULL",  "message" : "'.$error.'" } }';
            }

        }
    }
        }
        echo $json;

        break;

    }


    case 'testing':
    {

        // piece1
        // Loads the library

// Your Account Sid and Auth Token from twilio.com/user/account
        $sid = "AC786e7d442679f6354ffad69c823e8293";
        $token = "1fa46f72637ea7c1f51b758c486f9e66";


       // $sid = getenv("$sid"); // Your Account SID from www.twilio.com/user/account
       // $token = getenv("@token"); // Your Auth Token from www.twilio.com/user/account

        $client = new Services_Twilio($sid, $token);
        try{
          //  $sms = $client->account->sms_messages-> get("SMf89d6914568946268e5b16fd6171fb8e");

       /* $message = $client->account->messages->sendMessage(
            "614-259-8990", // From a valid Twilio number
            "613-754-7143", // Text this number
            "Hello from Runnable!"*/

       // print $sms->body;
           // print"<br>";
           // print $sms->to;
            foreach ($client->account->sms_messages as $sms) {
                echo $sms->from;
                print"<br>";
                echo $sms->to;
                print"<br>";
                echo $sms->body;
                print"<br>";
                echo $sms->date_sent;
                print"<br>";
                echo $sms->status;
                print"<br>";
            }
        }
        catch (Services_Twilio_RestException $e) {
            echo $e;
        }
        break;
    }

    case 'weeklyevaluation':
    {
        $logid1=$_POST['loginid'];
        $ans1=$_POST['answer1'];
        $ans2=$_POST['answer2'];
        $ans3=$_POST['answer3'];
        $ques1='1001';
        $ques2='1002';
        $ques3='1003';
        $weeknumber1=$_POST['weeknum'];
        $weekdate1=$_POST['weekdate'];
        $weeklogid1=$_POST['weeklogid'];
        $countcol1=$_POST['countcol'];
        $error = 'error';




                    $insertquery="insert into weekly_answers(id,log_id,question1,answer1,question2,answer2,question3,answer3,attend_date,status)values('','".$weeklogid1."','".$ques1."','".$ans1."','".$ques2."','".$ans2."','".$ques3."','".$ans3."',NOW(),'1')";
                    $updateweek="update weekly_logs set continous='".$countcol1."',count='".$countcol1."',status='1' where week='".$weeknumber1."' and participant_id='".$logid1."' and log_id='".$weeklogid1."' and date_time='".$weekdate1."'";
                    if(mysql_query($insertquery))
                    {

                        if(mysql_query($updateweek))
                        {
                            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly Evaluation", "success" : "Yes","message" : "1" } }';
                        }
                        else
                        {
                            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly Evaluation", "success" : "No",  "message" : "'.$error.'" } }';
                        }

                    }
                    else
                    {
                        $json 		= '{ "serviceresponse" : { "servicename" : "Weekly Evaluation", "success" : "No",  "message" : "'.$error.'" } }';
                    }






echo $json;
        break;
    }
    case 'test':
    {
        $date1 = date("Y-m-d H:i:s");
        $date2 = date('Y-m-d H:i:s', strtotime($date1,'+0 days'));
        print $date1;
        print "<br>";
        print $date2;
        print "<br>";
        $date3 = date('Y-m-d h:i:s', strtotime('+7 days'));
        print $date3;
        print "<br>";
        break;
    }
    case 'audioinsert':
    {
        $flag = 0;
        $date = date('Y-m-d H:i:s');
        $error = 'error';
        $file = print_r($_FILES);

       $patient_id = $_POST['patientid'];
        $weeklog_id = $_POST['weeklogid'];
        //$patient_id = '12';
        //$weeklog_id = '12';


        if ($_FILES['patientaudio']['size'] >= 0)
        {
            $rand=rand(0,100000);
            $headerimage ='../uploadaudio/'.$rand. $_FILES['patientaudio']['name'];
            move_uploaded_file($_FILES['patientaudio']['tmp_name'],$headerimage);
        }

        $audio_url = $headerimage;

        $pataudio = "INSERT INTO weekly_audio (id,log_id, participant_id,audio) VALUES ('','".$weeklog_id."','".$patient_id."', '".$audio_url."')";

        if(mysql_query($pataudio))
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly audio Evaluation", "success" : "Yes","message" : "1" } }';
        }
        else
        {
            $json 		= '{ "serviceresponse" : { "servicename" : "Weekly audio Evaluation", "success" : "No",  "message" : "'.$error.'" } }';
        }








        echo $json;
        break;

    }

}


exit;


?>
