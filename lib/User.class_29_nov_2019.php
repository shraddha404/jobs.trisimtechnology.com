<?php chdir(dirname(__FILE__));
   include_once 'lib.php';
   include_once 'PHPMailer/class.phpmailer.php';
   include_once 'candidateSearch_dbq.php';
   include_once 'candidatesearch_dbq_employer.php';
   
   class User {
   
       //class variables
       var $user_id = null;
       var $user_type = null;
       var $error = null;
       var $error_code = null;
       var $app_config = null;
       var $pdo = null;
   
       function __construct($user_id) {
           $this->initializeDB();
           if (!empty($user_id)) {
               $this->user_type = $this->getUserType();
               $this->user_profile = $this->getUserDetails($user_id);
           }
           $this->app_config = $this->getConfig();
       }
   
       public function resetPassword($id, $password) {
   
   
           //$stmt =$this->pdo->prepare("SELECT * FROM users WHERE id=? AND tokenCode=?");
           //$stmt->execute(array($id, $code));
           //$rows = $stmt->fetch(PDO::FETCH_ASSOC);
          // echo $id."/n".md5($password);
           try{
           $stmt = $this->pdo->prepare("UPDATE users SET password='".md5($password)."' WHERE id=".$id);
               $stmt->execute();
           }
    catch (Exception $e)
    {
        return $e->getMessage();
    }
          return true;
           
       }
       public function getUserEmail($username) {
    $select = "SELECT email FROM `users` WHERE username='".$username."'";
               $res = $this->pdo->query($select);
               $email = $res->fetchColumn();
               return $email;
       }
       public function forgotpassword($username,$email) {
     $config = $this->getConfig();
    //echo $_SERVER['SERVER_NAME'];exit;
           $stmt = $this->pdo->prepare("SELECT id,first_name FROM users WHERE username=? LIMIT 1");
           $stmt->execute(array($username));
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           //echo $stmt->rowCount();exit;
           if ($stmt->rowCount() == 1) {
               $id = base64_encode($row['id']);
               $code = md5(uniqid(rand()));
   
               $stmt = $this->pdo->prepare("UPDATE users SET tokenCode=? WHERE username=?");
               $stmt->execute(array($code, $username));
   
               $message = "
          Hello , $email
          <br /><br />
          We got requested to reset your password, if you do this then just click the following link to reset your password, if not just ignore this email,
          <br /><br />
          Click Following Link To Reset Your Password 
          <br /><br />
          <a href='http://" . $config["http_host"] . "/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
          
          <br /><br />
          thank you :)<br /><br />
          Regards,<br />
          Team Trisim Technology
          
   
          ";
                     // <a href='http://" . $config["http_host"] . "/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
   //<a href='" . $_SERVER['SERVER_NAME']. "/resetpass.php?id=$id&code=$code'>click here to reset your password</a>
              // <a href= http://' . $config["http_host"] . '/login.php?id=' . base64_encode($user_id) . '>CLICK HERE</a>
               $subject = "Password Reset";
   
               if ($this->sendSMTPEmail($email,$row['first_name'], $subject,$message)) {
                   return true;
               } else {
                   return false;
               }
           }
    else {
        return false;
    }
       }
   
       public function resgistrationActivation($id) {
   
           try {
   
               $select = $this->pdo->prepare("SELECT * from users where id = ?");
               $select->execute(array($id));
   
               $result = $select->fetchAll();
   
               if (count($result) > 0) {
   
                   if ($result[0]["status"] == "1") {
                       $msg = "Your account has already been activated.";
                       $msgType = "info";
                   } else {
                       $sql = "UPDATE `users` SET  `status` =  '1' WHERE `id` = ?";
                       $stmt = $this->pdo->prepare($sql);
   
                       $stmt->execute(array($id));
                       $msg = "Your account has been activated.";
                       $msgType = "success";
                   }
               } else {
                   $msg = "No account found";
                   $msgType = "warning";
               }
           } catch (Exception $ex) {
               echo $ex->getMessage();
           }
           return $msg;
       }
   
       public function sendEmail($to, $name, $subject, $body) {
   
           $mail = new PHPMailer(true);
           $mail->IsSMTP();
           //$mail->Port = 465;// set mailer to use SMTP
           $mail->Host = 'smtp.gmail.com';  // specify main and backup server
           $mail->SMTPAuth = true;     // turn on SMTP authentication
           $mail->Username = "rutuja.thakre09@gmail.com";  // SMTP username
           $mail->Password = "123rutudinu"; // SMTP password
           $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
           $mail->SMTPDebug = 0;
   
           $mail->From = "patilrupalib@gmail.com";
           $mail->FromName = "Trisim Technology";
           //$mail->SetFrom("patilrupalib@gmail.com","Resume Portal");
   
           $mail->AddAddress($to, $name);
           $mail->AddAddress("rutuja.thakre09@gmail.com",'rutuja');
           $mail->IsHTML(true);                                  // set email format to HTML
           $mail->Subject = $subject;
           $mail->Body = $body;
   
           if (!$mail->Send()) {
               $error = 'Mail error: ' . $mail->ErrorInfo;
               return false;
           } else {
               $error = 'Message sent!';
               return true;
           }
       }
   
       public function initializeDB() {
           include_once 'db_connect.php';
           try {
               $this->pdo = new db("mysql:host=localhost;dbname=$db", $db_user, $db_pass);
               //$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
           } catch (PDOException $e) {
               echo "Err: " . $e->getMessage();
           }
       }
   
       public function __call($functionName, $argumentsArray) {
           //$log = debug_backtrace();
           //$this->createActionLog($log,0);
           //$this->setStdError('undefined_function');
       }
   
       public function getConfig() {
           $select = "SELECT * FROM config";
           $res = $this->pdo->query($select);
   
           $app_config = array();
           while ($row = $res->fetch(PDO::FETCH_ASSOC)) {
               $app_config[$row['param']] = $row['value'];
           }
           return $app_config;
       }
   
       /*
         function setError()
         assign error to the class variable $error.
        */
   
       public function setError($error) {
           $this->error = $error;
       }
   
       /*
         function getError()
         return true if class varible has some error value else return false.
        */
   
       function hasError() {
           if (empty($this->error)) {
               return false;
           }
           return true;
       }
   
   ###################################
   
       public function authenticate($username, $password) {
   ##### newly added code on 8 June 2017
   
           if ($this->authenticateLocal($username, $password)) {
               //echo $this->user_id;
               return true;
           } else {
               
           }
   
   
           //error_log("User creation");
           //$this->user_id = $this->getUserIdFromUsername($username);
           //error_log($this->user_id);
           if (empty($this->user_id)) {
               //$this->setError('Could not find your account in Ansys Travel Portal');
               $this->setError('Invalid username or password');
               return false;
           }
   
           return true;
       }
   
   ###################################
   
       public function authenticateLocal($username, $password) {
   
           try {
               $select = $this->pdo->prepare("SELECT id FROM users WHERE username = ? AND password = ?");
               $select->execute(array($username, md5($password)));
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           $row = $select->fetch(PDO::FETCH_ASSOC);
           if ($row['id']) {
               $this->user_id = $row['id'];
               $_SESSION['user_id'] = $this->user_id;
               $user_profile = $this->getUserDetails($row['id']);
               //$this->user_type = $user_profile['userType'];
               $action_details = array();
   
               return true;
           }
           $this->setError("Invalid username or password.");
           return false;
       }
   
       public function getError() {
           return $this->error;
       }
   
       function createUserFolder($user_id) {
   
           if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id)) {
               return mkdir($_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id, 0777);
           }
           return false;
       }
   
       /*
         Get user details
        */
   
       function getUserDetails($user_id) {
   
   //echo $select;
             $select = $this->pdo->prepare("SELECT *,users.id AS id,users.first_name AS first_name,users.middle_name AS middle_name,users.last_name AS last_name,users.mobile_number AS mobile_number,users.gender AS gender,user_profile.profile_photo AS profile_photo,user_types.type AS userType, user_profile.permanent_address as permanent_address, user_profile.passport_number as passport_number, user_profile.pin_code as pin_code , user_profile.profile_photo as profile_photo , user_profile.work_exp_years, user_profile.work_exp_months , user_profile.resume_file_data ,  user_profile.contact_person,user_profile.expected_salary,user_profile.expected_designation,user_profile.achivements,user_profile.domain,user_profile.company_profile,user_profile.skills_expertise,user_profile.preferred_job_location  FROM users
   		LEFT JOIN user_profile ON users.id = user_profile.user_id
   		LEFT JOIN user_types ON users.user_type = user_types.id 
   		WHERE users.id=?");
   
           $select->execute(array($user_id));
   
           $user_details = $select->fetchAll(PDO::FETCH_ASSOC);
   
           return $user_details;
       }
   
       /*
         Update Employment details
        */
   
       function UpdateEmployment($data) {
   
           try {
   
               $this->pdo->update('user_employment', $data, '`id`=' . $data['id']);
               if ($data['current_company'] == 'yes') {
                   $query = "UPDATE `user_employment` SET `current_company` = 'no',`noticeperiod`='',`current_ctc`=''  WHERE `user_id` =" . $data['user_id'] . " and `id`!=" . $data['id'] . "";
   
                   $select = $this->pdo->prepare($query);
                   $select->execute();
               }
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               //$this->setError('Record Not Inserted');
               return false;
           }
       }
   
       /* user details */
   
       function userDetails($user_id) {
          $select = $this->pdo->prepare("SELECT *,users.id AS id,users.first_name AS first_name,users.middle_name AS middle_name,users.last_name AS last_name,users.mobile_number AS mobile_number,users.gender AS gender,user_profile.profile_photo AS profile_photo,user_types.type AS userType, user_profile.permanent_address as permanent_address, user_profile.passport_number as passport_number, user_profile.pin_code as pin_code , user_profile.profile_photo as profile_photo , user_profile.work_exp_years, user_profile.work_exp_months , user_profile.resume_file_data ,  user_profile.contact_person,user_profile.expected_salary,user_profile.expected_designation,user_profile.achivements,user_profile.domain,user_profile.company_profile,user_profile.skills_expertise,user_profile.preferred_job_location  FROM users
   		LEFT JOIN user_profile ON users.id = user_profile.user_id
   		LEFT JOIN user_types ON users.user_type = user_types.id 
   		WHERE users.id=?");
           $select->execute(array($user_id));
           $user_details = $select->fetch(PDO::FETCH_ASSOC);
           return $user_details;
       }
   
       /*
         Get user resume_headline details
        */
   
       function getUserResumeHeadlineDetails($user_id) {
   
   //echo $select;
           $select = $this->pdo->prepare("SELECT * FROM user_resume_headline WHERE user_id=?");
           $select->execute(array($user_id));
   
           $user_details = $select->fetchAll(PDO::FETCH_ASSOC);
   
           return $user_details;
       }
   
       /*
         Get user Employment details
        */
       /* user details */
   
       function userfileDetails($user_id) {
           $select = $this->pdo->prepare("SELECT resume_file_data,resume_file_name,first_name,last_name FROM user_profile left join users on user_profile.user_id=users.id WHERE user_id=?");
           $select->execute(array($user_id));
           $user_details = $select->fetch(PDO::FETCH_ASSOC);
           return $user_details;
       }
   
       function getUserEmploymentDetails($user_id) {
   
   //echo $select;
           $select = $this->pdo->prepare("SELECT *, user_employment.id as id FROM user_employment
   		LEFT JOIN users ON user_employment.user_id = users.id
   		WHERE users.id=?");
           $select->execute(array($user_id));
   
           while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
               $user_details[] = $row;
           }
   
           return $user_details;
       }
   
       /*
         Get user Education details
        */
   
       function getUserEducationDetails($user_id) {
   
   //echo $select;
           $select = $this->pdo->prepare("SELECT *, user_educations.id as educationsid  FROM user_educations
   		LEFT JOIN users ON user_educations.user_id = users.id
   		WHERE users.id=?");
           $select->execute(array($user_id));
   
           while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
               $user_details[] = $row;
           }
   
           return $user_details;
       }
   
       /* Insert Jobs details */
   
       function createJobs($data) {
   //print_r($data);exit;
   
           if (!empty($data['valid_till'])) {
   
               $res2 = explode("/", $data['valid_till']);
               $valid_till = $res2[2] . "-" . $res2[0] . "-" . $res2[1];
   
   //$dateV = DateTime::createFromFormat("m/d/Y" , $data['valid_till']);
   //$valid_till = $dateV->format('Y-m-d');
           }
   //print_r($valid_till);exit;
   
           try {    //Insert basic details
               $select = $this->pdo->prepare("INSERT INTO `jobs` (`job_name`, `location`, `company_name`,  `description`, `posted_on`,  `posted_by`,`ug_qualification`,`pg_qualification`,`experience_min`,`experience_max`,`ctc`,`no_of_vaccencies`) VALUES (?,?,?,?,NOW(),?,?,?,?,?,?,?)");
               $select->execute(array($data['job_name'], $data['location'], $data['company_name'],  $data['description'], $data['posted_by'], $data['ug_qualification'], $data['pg_qualification'], $data['experience_min'], $data['experience_max'], $data['ctc'], $data['no_of_vaccencies']));
               $id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               //$this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
   
       function updateJob($data) {
           if (!empty($data['valid_till'])) {
               $res2 = explode("/", $data['valid_till']);
               $valid_till = $res2[2] . "-" . $res2[0] . "-" . $res2[1];
   
   //$dateV = DateTime::createFromFormat("m/d/Y" , $data['valid_till']);
   //$valid_till = $dateV->format('Y-m-d');
           }
   
           try {

               $stmt = $this->pdo->prepare("UPDATE `jobs` SET `job_name`=?, `location`=?, `company_name`=?,  `description`=?,  `posted_by`=? ,`posted_on`=NOW(),`ug_qualification`=?,`pg_qualification`=?,`experience_min`=?,`experience_max`=?,`ctc`=?,`no_of_vaccencies`=? WHERE id=?");
   
//echo "UPDATE `jobs` SET `job_name`='".$data['job_name']."', `location`='".$data['location']."', `company_name`='".$data['company_name']."', `posted_on`=NOW(), `description`='".$data['description']."',  `posted_by`='".$data['posted_by']."' WHERE id=".$data['id']." ";
  //exit;
               $stmt->execute(array($data['job_name'], $data['location'], $data['company_name'],  $data['description'],  $data['posted_by'], $data['ug_qualification'], $data['pg_qualification'], $data['experience_min'], $data['experience_max'], $data['ctc'], $data['no_of_vaccencies'],$data['id']));
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               //$this->setError('Record Not Inserted');
               return false;
           }
           return true;
       }
   
       /* Update Resume Headline details */
   
       function UpdateResumeHeadline($data) {
   
   
           try {    //Insert basic details
               $stmt = $this->pdo->prepare("UPDATE user_resume_headline SET resume_headline=? WHERE user_id=?");
               $stmt->execute(array($data['resume_headline'], $data['idheadline']));
           } catch (PDOException $e) {
   
   
               $this->setError('Record Not Inserted');
   
   
               return false;
           }
           return $id;
       }
   
       /* Update Skills details */
   
       function UpdateSkills($data) {
           //print_r($data);
   
           try {
               $stmt = $this->pdo->prepare("UPDATE user_skills SET `skill_id`=?,`version`=?,`last_used`=?,`experience_year`=?,`experience_month`=? ,`proficiency_level`=?, `operating_systems`=?  WHERE id=?");
               $stmt->execute(array($data['skill_id'], $data['version'], $data['last_used'], $data['experience_year'], $data['experience_month'], $data['proficiency_level'],$data['operating_systems'], $data['us_id']));
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
   
       /* Update Skills details */
   
       function UpdateTools($data) {
           //print_r($data);
           try {
               $stmt = $this->pdo->prepare("UPDATE user_tools SET `tool_id`=?,`version`=?,`last_used`=?,`knowledge_source`=? ,`proficiency_level`=? WHERE id=?");
               $stmt->execute(array($data['tool_id'], $data['tool_version'], $data['last_used'], $data['source'], $data['proficiency_level'], $data['tooledit_id']));
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
   
       /* Insert Resume Headline details */
   
       function addResumeHeadline($data) {
   
   
           try {    //Insert basic details
               $this->pdo->insert('user_resume_headline', $data);
   
               $id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
   
   
               $this->setError('Record Not Inserted');
   
   
               return false;
           }
           return $id;
       }
   
       /* Insert Emploment details */
   
       function addEmployment($data) {
           try {
               $sql = "INSERT INTO `user_employment`( `user_id`, `designation`, `organization`, `current_company`, `started_working_year`, `started_working_month`, `worked_till_year`, `worked_till_month`, `description`, `noticeperiod`, `current_ctc`) VALUES (" . $data['user_id'] . ", '" . $data['designation'] . "','" . $data['organization'] . "','" . $data['current_company'] . "','" . $data['started_working_year'] . "','" . $data['started_working_month'] . "','" . $data['worked_till_year'] . "','" . $data['worked_till_month'] . "','" . $data['description'] . "','" . $data['noticeperiod'] . "','" . $data['current_ctc'] . "')";
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute();
               $id = $this->pdo->lastInsertId();
   
               if ($data['current_company'] == 'yes') {
                   echo "inside update" . $data['current_company'];
                   $query = "UPDATE `user_employment` SET `current_company` = 'no',`noticeperiod`='',`current_ctc`=''  WHERE `user_id` =" . $data['user_id'] . " and `id`!=" . $id . "";
   
                   $select = $this->pdo->prepare($query);
                   $select->execute();
               }
   
               $query = "UPDATE `users` SET `is_experienced` = 'yes'  WHERE `id` =" . $data['user_id'] . "";
   
               $select = $this->pdo->prepare($query);
               $select->execute();
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
   
       /* Insert Skills details */
   
       function addSkills($data) {
           try {    //Insert basic details
               $sql = "INSERT INTO `user_skills`( `user_id`, `skill_id`, `version`, `last_used`, `experience_year`, `experience_month`,`proficiency_level`,`operating_systems`) VALUES (" . $data['user_id'] . ", " . $data['skill_id'] . ",'" . $data['version'] . "'," . $data['last_used'] . "," . $data['experience_year'] . ",'" . $data['experience_month'] . "','" . $data['proficiency_level'] . "','" . $data['operating_systems'] . "')";
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute();
               $id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
   
       /* Insert Tools details */
   
       function addTools($data) {
           try {    //Insert basic details
               echo("insert tools");
               $sql = "INSERT INTO `user_tools`( `user_id`, `tool_id`, `version`, `last_used`, `knowledge_source`,`proficiency_level`) VALUES (" . $data['user_id'] . ", " . $data['tool_id'] . ",'" . $data['tool_version'] . "'," . $data['last_used'] . ",'" . $data['source'] . "','" . $data['proficiency_level'] . "')";
               echo($sql);
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute();
               $id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
   
       /* Insert Education details */
    function addSkillsTools($data) {
       
         $data['skill_id'] = implode(":", $data['skill_id']);
       $data['tool_id'] = implode(",", $data['tool_id']);
        //print_r($data);exit;
           try {    //Insert basic details
               $sql = "INSERT INTO `user_skills_tools`( `user_id`, `skill_id`,`tool_id`, `version`, `last_used`, `source_of_learning`,`proficiency_level`,`operating_systems`) VALUES (" . $data['user_id'] . ", '" . $data['skill_id'] . "','" . $data['tool_id'] . "','" . $data['tool_version'] . "','" . $data['last_used'] . "','" . $data['source'] . "','" . $data['proficiency_level'] . "','" . $data['operating_systems'] . "')";
               //echo $sql;exit;
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute();
               $id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
       }
       function UpdateSkillsTools($data) {
       
         $data['skill_id'] = implode(":", $data['skill_id']);
       $data['tool_id'] = implode(",", $data['tool_id']);
           try {    //Insert basic details
               $sql = "Update user_skills_tools SET  `skill_id`=?,`tool_id`=?, `version`=?, `last_used`=?, `source_of_learning`=?,`proficiency_level`=?, `operating_systems`=?  where `id`=?";
               //echo $sql;exit;
               $stmt = $this->pdo->prepare($sql);
               $stmt->execute(array($data['skill_id'], $data['tool_id'], $data['tool_version'], $data['last_used'], $data['source'], $data['proficiency_level'], $data['operating_systems'],$data['us_id']));
               $id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
               $this->setError('Record Not Inserted');
               return false;
           }
           return $id;
           
       }
   
       function addEducation($data) {
           try {
               //console . log($data);
   //Insert basic details
               if (!empty($data['10th_spcl'])) {
   
                   $data['qualification_id'] = $this->getQualificationidbyNames('10th');
                   $data['qualification_name'] = '10th';
                   $query = 'INSERT INTO `xth_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['10th_spcl'] . '","' . $data['10th_school'] . '","' . $data['10th_university'] . '","' . $data['10th_percentage'] . '","' . $data['10th_marks'] . '","' . $data['10th_Pyear'] . '")';
                   $select = $this->pdo->prepare($query);
                   $select->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
               if (!empty($data['12th_spcl'])) {
                   $data['qualification_id'] = $this->getQualificationidbyNames('12th');
                   $data['qualification_name'] = '12th';
                   $query1 = 'INSERT INTO `xiith_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`, `physics_marks`, `chemistry_marks`, `maths_marks`) VALUES (' . $data['user_id'] . ',"' . $data['12th_spcl'] . '","' . $data['12th_school'] . '","' . $data['12th_university'] . '","' . $data['12th_percentage'] . '","' . $data['12th_marks'] . '","' . $data['12th_Pyear'] . '",' . $data['12th_physics_marks'] . ',' . $data['12th_chemistry_marks'] . ',' . $data['12th_maths_marks'] . ')';
                   $select1 = $this->pdo->prepare($query1);
                   $select1->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
   
               if (!empty($data['be_spcl'])) {
                   $data['qualification_id'] = $this->getQualificationidbyNames('BE');
                   $data['qualification_name'] = 'BE';
                   $query2 = 'INSERT INTO `BE_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['be_spcl'] . '","' . $data['be_school'] . '","' . $data['be_university'] . '","' . $data['be_percentage'] . '","' . $data['be_marks'] . '","' . $data['be_Pyear'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
                   $query = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select = $this->pdo->prepare($query);
                   $select->execute();
               }
               if (!empty($data['me_spcl'])) {
                   //echo "insert be";
                   $data['qualification_id'] = $this->getQualificationidbyNames('ME');
                   $data['qualification_name'] = 'ME';
                   $query3 = 'INSERT INTO `ME_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['me_spcl'] . '","' . $data['me_school'] . '","' . $data['me_university'] . '","' . $data['me_percentage'] . '","' . $data['me_marks'] . '","' . $data['me_Pyear'] . '")';
                   $select3 = $this->pdo->prepare($query3);
                   $select3->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
               if (!empty($data['mtech_spcl'])) {
                   //echo "insert be";
                   $data['qualification_id'] = $this->getQualificationidbyNames('M.Tech');
                   $data['qualification_name'] = 'M.Tech';
                   $query4 = 'INSERT INTO `MTech_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['mtech_spcl'] . '","' . $data['mtech_school'] . '","' . $data['mtech_university'] . '","' . $data['mtech_percentage'] . '","' . $data['mtech_marks'] . '","' . $data['mtech_Pyear'] . '")';
                   $select4 = $this->pdo->prepare($query4);
                   $select4->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
               if (!empty($data['btech_spcl'])) {
                   //echo "insert be";
                   $data['qualification_id'] = $this->getQualificationidbyNames('B.Tech');
                   $data['qualification_name'] = 'B.Tech';
                   $query5 = 'INSERT INTO `BTech_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['btech_spcl'] . '","' . $data['btech_school'] . '","' . $data['btech_university'] . '","' . $data['btech_percentage'] . '","' . $data['btech_marks'] . '","' . $data['btech_Pyear'] . '")';
                   $select5 = $this->pdo->prepare($query5);
                   $select5->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
               if (!empty($data['msc_spcl'])) {
                   //echo "insert be";
                   $data['qualification_id'] = $this->getQualificationidbyNames('M.Sc');
                   $data['qualification_name'] = 'M.Sc';
                   $query6 = 'INSERT INTO `MSc_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['msc_spcl'] . '","' . $data['msc_school'] . '","' . $data['msc_university'] . '","' . $data['msc_percentage'] . '","' . $data['msc_marks'] . '","' . $data['msc_Pyear'] . '")';
                   $select6 = $this->pdo->prepare($query6);
                   $select6->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
               if (!empty($data['phd_spcl'])) {
                   //echo "insert be";
                   $data['qualification_id'] = $this->getQualificationidbyNames('PhD');
                   $data['qualification_name'] = 'PhD';
                   $query7 = 'INSERT INTO `PhD_details` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $data['user_id'] . ',"' . $data['phd_spcl'] . '","' . $data['phd_school'] . '","' . $data['phd_university'] . '","' . $data['phd_percentage'] . '","' . $data['phd_marks'] . '","' . $data['phd_Pyear'] . '")';
                   $select7 = $this->pdo->prepare($query7);
                   $select7->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
               if (!empty($data['gate_score'])) {
   
                   $data['qualification_id'] = $this->getQualificationidbyNames('GATE');
                   $data['qualification_name'] = 'GATE';
                   $query7 = 'INSERT INTO `GATE_details` (`user_id`,`domain`, `all_india_score`,  `year_of_passing`) VALUES (' . $data['user_id'] . ',"' . $data['domain'] . '",' . $data['gate_score'] . ',' .  $data['gate_Pyear'] . ')';
   
                   $select7 = $this->pdo->prepare($query7);
                   $select7->execute();
                   $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $data['user_id'] . ',' . $data['qualification_id'] . ',"' . $data['qualification_name'] . '")';
                   $select2 = $this->pdo->prepare($query2);
                   $select2->execute();
               }
   
   
   
               //$id = $this->pdo->lastInsertId();
           } catch (PDOException $e) {
   
   
               $this->setError('Record Not Inserted');
               echo ($e->getMessage());
   
   
               return ($e->getMessage());
           }
           //return $id;
           return true;
       }
   
       function getEducationDetails($user_id) {
           $user_details = array();
           $select = $this->pdo->prepare("SELECT * FROM `xth_details` WHERE user_id=?");
           $select->execute(array($user_id));
   
           $user_details['10th'] = $select->fetchAll(PDO::FETCH_ASSOC);
           $select1 = $this->pdo->prepare("SELECT * FROM `xiith_details` WHERE user_id=?");
           $select1->execute(array($user_id));
           $user_details['12th'] = $select1->fetchAll(PDO::FETCH_ASSOC);
           $select2 = $this->pdo->prepare("SELECT * FROM `BE_details` WHERE user_id=?");
           $select2->execute(array($user_id));
           $user_details['BE'] = $select2->fetchAll(PDO::FETCH_ASSOC);
           $select3 = $this->pdo->prepare("SELECT * FROM `ME_details` WHERE user_id=?");
           $select3->execute(array($user_id));
           $user_details['ME'] = $select3->fetchAll(PDO::FETCH_ASSOC);
           $select4 = $this->pdo->prepare("SELECT * FROM `BTech_details` WHERE user_id=?");
           $select4->execute(array($user_id));
           $user_details['B.Tech'] = $select4->fetchAll(PDO::FETCH_ASSOC);
           $select5 = $this->pdo->prepare("SELECT * FROM `MTech_details` WHERE user_id=?");
           $select5->execute(array($user_id));
           $user_details['M.Tech'] = $select5->fetchAll(PDO::FETCH_ASSOC);
           $select6 = $this->pdo->prepare("SELECT * FROM `MSc_details` WHERE user_id=?");
           $select6->execute(array($user_id));
           $user_details['M.Sc'] = $select6->fetchAll(PDO::FETCH_ASSOC);
           $select7 = $this->pdo->prepare("SELECT * FROM `PhD_details` WHERE user_id=?");
           $select7->execute(array($user_id));
           $user_details['PhD'] = $select7->fetchAll(PDO::FETCH_ASSOC);
           $select8 = $this->pdo->prepare("SELECT * FROM `GATE_details` WHERE user_id=?");
           $select8->execute(array($user_id));
           $user_details['GATE'] = $select8->fetchAll(PDO::FETCH_ASSOC);
   
   
   
           //print_r($user_details);
   
           return $user_details;
       }
   
       function getEducationSubjectDetails($user_id) {
           $user_details = array();
           $select = $this->pdo->prepare("SELECT * FROM `subject_marks` WHERE user_id=? and qualifications_id=1");
           $select->execute(array($user_id));
           $user_details['10th_subjects'] = $select->fetchAll(PDO::FETCH_ASSOC);
           $select1 = $this->pdo->prepare("SELECT * FROM `subject_marks` WHERE user_id=? and qualifications_id=2");
           $select1->execute(array($user_id));
           $user_details['12th_subjects'] = $select1->fetchAll(PDO::FETCH_ASSOC);
           $select2 = $this->pdo->prepare("SELECT * FROM `subject_marks` WHERE user_id=? and qualifications_id=3");
           $select2->execute(array($user_id));
           $user_details['be_subjects'] = $select2->fetchAll(PDO::FETCH_ASSOC);
           return $user_details;
       }
   
       function countEducationDetails($user_id) {
           $user_details = array();
           $select = $this->pdo->prepare("SELECT count(*) FROM `xth_details` WHERE user_id=?");
           $select->execute(array($user_id));
   
           $user_details['10th'] = $select->fetchColumn();
           $select1 = $this->pdo->prepare("SELECT count(*) FROM `xiith_details` WHERE user_id=?");
           $select1->execute(array($user_id));
           $user_details['12th'] = $select1->fetchColumn();
           $select2 = $this->pdo->prepare("SELECT count(*) FROM `BE_details` WHERE user_id=?");
           $select2->execute(array($user_id));
           $user_details['BE'] = $select2->fetchColumn();
           $select3 = $this->pdo->prepare("SELECT count(*) FROM `BTech_details` WHERE user_id=?");
           $select3->execute(array($user_id));
           $user_details['B.Tech'] = $select3->fetchColumn();
           $select4 = $this->pdo->prepare("SELECT count(*) FROM `ME_details` WHERE user_id=?");
           $select4->execute(array($user_id));
           $user_details['ME'] = $select4->fetchColumn();
           $select5 = $this->pdo->prepare("SELECT count(*) FROM `MTech_details` WHERE user_id=?");
           $select5->execute(array($user_id));
           $user_details['M.Tech'] = $select5->fetchColumn();
           $select6 = $this->pdo->prepare("SELECT count(*) FROM `MSc_details` WHERE user_id=?");
           $select6->execute(array($user_id));
           $user_details['M.Sc'] = $select6->fetchColumn();
           $select7 = $this->pdo->prepare("SELECT count(*) FROM `PhD_details` WHERE user_id=?");
           $select7->execute(array($user_id));
           $user_details['PhD'] = $select7->fetchColumn();
           $select8 = $this->pdo->prepare("SELECT count(*) FROM `GATE_details` WHERE user_id=?");
           $select8->execute(array($user_id));
           $user_details['GATE'] = $select8->fetchColumn();
   
   
           //print_r($user_details);
   
           return $user_details;
       }
   
       function updateEducationDetails($data) {
           if (!empty($data['10th_spcl'])) {
               $query = 'UPDATE `xth_details` SET `specialisation`="' . $data['10th_spcl'] . '",`school`="' . $data['10th_school'] . '",`board`="' . $data['10th_university'] . '",`percentage`="' . $data['10th_percentage'] . '",`marks`="' . $data['10th_marks'] . '",`passing_year`="' . $data['10th_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
               $data['qualification_id'] = $this->getQualificationidbyNames('10th');
           }
           if (!empty($data['12th_spcl'])) {
               $query = 'UPDATE `xiith_details` SET `specialisation`="' . $data['12th_spcl'] . '",`school`="' . $data['12th_school'] . '",`board`="' . $data['12th_university'] . '",`percentage`="' . $data['12th_percentage'] . '",`marks`="' . $data['12th_marks'] . '",`passing_year`="' . $data['12th_Pyear'] . '",`physics_marks`="' . $data['12th_physics_marks'] . '",`chemistry_marks`="' . $data['12th_chemistry_marks'] . '",`maths_marks`="' . $data['12th_maths_marks'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               //console.log($select);
               $select->execute();
               $data['qualification_id'] = $this->getQualificationidbyNames('12th');
           }
           if (!empty($data['be_spcl'])) {
               $query = 'UPDATE `BE_details` SET `specialisation`="' . $data['be_spcl'] . '",`school`="' . $data['be_school'] . '",`board`="' . $data['be_university'] . '",`percentage`="' . $data['be_percentage'] . '",`marks`="' . $data['be_marks'] . '",`passing_year`="' . $data['be_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
               $data['qualification_id'] = $this->getQualificationidbyNames('BE');
           }
           if (!empty($data['btech_spcl'])) {
               $query = 'UPDATE `BTech_details` SET `specialisation`="' . $data['btech_spcl'] . '",`school`="' . $data['btech_school'] . '",`board`="' . $data['btech_university'] . '",`percentage`="' . $data['btech_percentage'] . '",`marks`="' . $data['btech_marks'] . '",`passing_year`="' . $data['btech_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
           }
           if (!empty($data['me_spcl'])) {
               $query = 'UPDATE `ME_details` SET `specialisation`="' . $data['me_spcl'] . '",`school`="' . $data['me_school'] . '",`board`="' . $data['me_university'] . '",`percentage`="' . $data['me_percentage'] . '",`marks`="' . $data['me_marks'] . '",`passing_year`="' . $data['me_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
           }
           if (!empty($data['mtech_spcl'])) {
               $query = 'UPDATE `MTech_details` SET `specialisation`="' . $data['mtech_spcl'] . '",`school`="' . $data['mtech_school'] . '",`board`="' . $data['mtech_university'] . '",`percentage`="' . $data['mtech_percentage'] . '",`marks`="' . $data['mtech_marks'] . '",`passing_year`="' . $data['mtech_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
           }
           if (!empty($data['msc_spcl'])) {
               $query = 'UPDATE `MSc_details` SET `specialisation`="' . $data['msc_spcl'] . '",`school`="' . $data['msc_school'] . '",`board`="' . $data['msc_university'] . '",`percentage`="' . $data['msc_percentage'] . '",`marks`="' . $data['msc_marks'] . '",`passing_year`="' . $data['msc_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
           }
           if (!empty($data['phd_spcl'])) {
               $query = 'UPDATE `PhD_details` SET `specialisation`="' . $data['phd_spcl'] . '",`school`="' . $data['phd_school'] . '",`board`="' . $data['phd_university'] . '",`percentage`="' . $data['phd_percentage'] . '",`marks`="' . $data['phd_marks'] . '",`passing_year`="' . $data['phd_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
           }
           if (!empty($data['gate_score'])) {
               $query = 'UPDATE `GATE_details` SET `domain`="' . $data['domain'] . '",`all_india_score`="' . $data['gate_score'] . '",`marks`="' . $data['gate_marks'] . '",`year_of_passing`="' . $data['gate_Pyear'] . '" WHERE `user_id`=' . $data['user_id'] . '';
               $select = $this->pdo->prepare($query);
               $select->execute();
           }
       }
   
       /*
         Create New Employers
        */
   
       function createNewEmployers($data, $files) {
   
   
           $user_types = $this->getUserTypes();
           $user_type_id = 0;
           $photoname = $files['uploadphoto']['name'];
   
           $config = $this->getConfig();
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'Employer') {
                   $user_type_id = $v['id'];
               }
           }
   
   
           try {    //Insert basic details
               $stmt = "INSERT INTO `users` (`username`,`password`, `user_type`,`email`, `first_name`, `middle_name`, `last_name`,`mobile_number`, `name_of_company`, `desgination`, `firm_address`,`website`,`company_email`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
               $stmt = $this->pdo->prepare($stmt);
               $stmt->execute(array($data['username'], md5($data['password']), $user_type_id, $data['email'], $data['first_name'], $data['middle_name'], $data['lastname'], $data['mobile_number'], $data['company'], $data['desgination'], $data['address'], $data['website'], $data['cemail']));
               $user_id = $this->pdo->lastInsertId();
   
   
               $stmt1 = "INSERT INTO `user_profile` (`user_id`,`profile_photo`,`company_profile`,`contact_person`) VALUES (?,?,?,?)";
               $stmt1 = $this->pdo->prepare($stmt1);
               //print_r($data['work_exp_years']);exit;
               $stmt1->execute(array($user_id, $photoname,$data['company_profile'], $data['contact_person']));
               $select = "SELECT email FROM `users` WHERE username='admin'";
               $res = $this->pdo->query($select);
               $admin_email = $res->fetchColumn();
   
   
   
               $name = $data['first_name'] . " " . $data['middle_name'] . " " . $data['lastname'];
   
               $subject = "Registration Details for Trisim Technology - http://jobs.trisimtechnology.com/";
               $to = $data['email'];
               $message = '<html><head>
   						   <title>Email Verification</title>
   						   </head>
   						   <body>';
               $message .= '<p>Hello ' . $name . ',<br><br>';
               $message .= 'Thank you for creating account at Jobs portal(http://jobs.trisimtechnology.com).<br><br>Click on the below link to activate your account.<br>'
                       . '<a href= http://' . $config["http_host"] . '/activate.php?id=' . base64_encode($user_id) . '>CLICK HERE</a>'
                       . ' <br><br>Regards,<br>Team Trisim Technology';
               $message .= '</body></html>';
               $subject_admin = "New Employers Registered -http://jobs.trisimtechnology.com/";
               $message_admin = '<html><head>
   						   <title>New Employers Registered</title>
   						   </head>
   						   <body>';
               $message_admin .= '<p>Hello Admin,<br><br>';
               /* $message_admin .= 'New Employers Registered!!!<br><br>Here are the Details :<br><br>'
                 . 'Name:' . $name . '<br> Usename:' . $data[username] . '<br>Email:' . $data['email'] . '<br><br>Regards,<br>'
                 . 'Team Trisim Technology </p>'; */
               $message_admin .= 'New Employers Registered!!!<br><br>Here are the Details :<br><br>'
                       . 'Name:' . $name . '<br><br>Regards,<br>'
                       . 'Team Trisim Technology </p>';
               $message_admin .= '</body></html>';
               $resmail = $this->sendSMTPEmail($to, $name, $subject, $message);
               $resmailadmin = $this->sendSMTPEmail($admin_email, '', $subject_admin, $message_admin);
               if ($files['uploadphoto']['type'] == "image/jpg" || $files['uploadphoto']['type'] == "image/jpeg" || $files['uploadphoto']['type'] == "image/gif" || $files['uploadphoto']['type'] == "image/png" || $files['uploadphoto']['type'] == "image/bmp" || $files['uploadphoto']['type'] == "image/tiff") {
   
                   $photoname = $files['uploadphoto']['name'];
                   $path = $this->createUserFolder($user_id);
   
                   if ($path) {
                       $result = move_uploaded_file($files['uploadphoto']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id . '/' . $photoname);
                       if ($result == 1) {
                           $msg = "<p>Your profile  file uploaded successfully</p>";
                       } else {
                           $msg = "<p>Sorry, Error happened while uploading . </p>";
                       }
                   }#end if($path){
               } // endIF
           } catch (PDOException $e) {
               // check if username already exists in the system
               $this->setError($e->getMessage());
               return false;
           }
           //return $user_id;
           //return $resmail;
           return true;
       }
   
       /*
         Create New User Single Sign On
        */
   
       function createNewUser($data, $files) {
   
           if (!empty($data['date_of_birth'])) {
               $dateo = DateTime::createFromFormat("d M, yy", $data['date_of_birth']);
               $date_of_birth = $dateo->format('Y-m-d');
           }
           $user_types = $this->getUserTypes();
   
           $user_type_id = 0;
           $photoname = $files['uploadphoto']['name'];
           // $name = $files['resume_file']['name'];
           //$mime = $files['resume_file']['type'];
           $config = $this->getConfig();
   
           /* if (!empty($mime)) {
             if ($mime != "application/pdf") {
             $this->setError("Upload only pdf file");
             return false;
             }
             }
   
             $datafile = file_get_contents($files['resume_file']['tmp_name']);
             $size = intval($files['resume_file']['size']); */
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'User') {
                   $user_type_id = $v['id'];
               }
           }
           try {    //Insert basic details
               $stmt = "INSERT INTO `users` (`username`,`password`, `user_type`,`email`, `first_name`, `middle_name`, `last_name`, `mobile_number`, `date_of_birth`, `is_experienced`) VALUES (?,?,?,?,?,?,?,?,?,?)";
               $stmt = $this->pdo->prepare($stmt);
               $stmt->execute(array($data['username'], md5($data['password']), $user_type_id, $data['email'], $data['first_name'], $data['middle_name'], $data['lastname'], $data['mobile_number'], $date_of_birth, $data['is_experienced']));
               $user_id = $this->pdo->lastInsertId();
   
   
   
   
               if ($data['is_experienced'] == 'no') {
                   //Insert Personal details
                   //$stmt1 = "INSERT INTO `user_profile` (`work_exp_years`, `work_exp_months`,`user_id`,`education`, `subject`, `city`, `resume_file_data`,`resume_file_name`, `resume_file_size`, `resume_file_type`,`profile_photo`,`date_of_birth`,`permanent_address`,`university`,`percentage`,`skills_expertise`,`preferred_job_location`,`current_ctc_lakhs`,`expected_salary`,`expected_designation`,`achivements`,`domain`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                   $stmt1 = "INSERT INTO `user_profile` (`work_exp_years`, `work_exp_months`,`user_id`,`education`, `subject`, `city`,`profile_photo`,`date_of_birth`,`permanent_address`,`university`,`percentage`,`skills_expertise`,`preferred_job_location`,`current_ctc_lakhs`,`expected_salary`,`expected_designation`,`achivements`,`domain`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
   
                   $stmt1 = $this->pdo->prepare($stmt1);
                   //print_r($data['work_exp_years']);exit;
                   //$stmt1->execute(array($data['work_exp_years'], $data['work_exp_months'], $user_id, $data['education'], $data['subject'], $data['city'], $datafile, $name, $size, $mime, $photoname, $date_of_birth, $data['address'], $data['university'], $data['percentage'], $data['key_words'], $data['preferred_job_location'], $data['curr_ctc'], $data['fresher_exp_annual_ctc'], $data['e_designation'], $data['fresher_achievements'], $data['job_type']));
                   $stmt1->execute(array($data['work_exp_years'], $data['work_exp_months'], $user_id, $data['education'], $data['subject'], $data['city'], $photoname, $date_of_birth, $data['address'], $data['university'], $data['percentage'], $data['key_words'], $data['preferred_job_location'], $data['curr_ctc'], $data['fresher_exp_annual_ctc'], $data['e_designation'], $data['fresher_achievements'], $data['job_type']));
   
   //Insert fresher details
                   $stmt2 = "INSERT INTO `user_fresher`( `user_id`, `domain_id`, `expected_designation`, `expected_annual_ctc`, `achivements`) VALUES (?,?,?,?,?)";
                   $stmt2 = $this->pdo->prepare($stmt2);
                   $stmt2->execute(array($user_id, $data['job_type'], $data['e_designation'], $data['fresher_exp_annual_ctc'], $data['fresher_achievements']));
               }
               if ($data['is_experienced'] == 'yes') {
                   //Insert Personal details
                   //$stmt1 = "INSERT INTO `user_profile` (`work_exp_years`, `work_exp_months`,`user_id`,`education`, `subject`, `city`, `resume_file_data`,`resume_file_name`, `resume_file_size`, `resume_file_type`,`profile_photo`,`date_of_birth`,`permanent_address`,`university`,`percentage`,`skills_expertise`,`preferred_job_location`,`current_ctc_lakhs`,`expected_salary`,`expected_designation`,`achivements`,`notice_period`,`domain`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                   $stmt1 = "INSERT INTO `user_profile` (`work_exp_years`, `work_exp_months`,`user_id`,`education`, `subject`, `city`,`profile_photo`,`date_of_birth`,`permanent_address`,`university`,`percentage`,`skills_expertise`,`preferred_job_location`,`current_ctc_lakhs`,`expected_salary`,`expected_designation`,`achivements`,`notice_period`,`domain`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                   $stmt1 = $this->pdo->prepare($stmt1);
                   //print_r($data['work_exp_years']);exit;
                   //$stmt1->execute(array($data['work_exp_years'], $data['work_exp_months'], $user_id, $data['education'], $data['subject'], $data['city'], $datafile, $name, $size, $mime, $photoname, $date_of_birth, $data['address'], $data['university'], $data['percentage'], $data['key_words'], $data['preferred_job_location'], $data['curr_ctc'], $data['exp_exp_annual_ctc'], $data['expected_designation'], $data['exp_achievements'], $data['notice_period'], $data['job_type_experience']));
                   $stmt1->execute(array($data['work_exp_years'], $data['work_exp_months'], $user_id, $data['education'], $data['subject'], $data['city'], $photoname, $date_of_birth, $data['address'], $data['university'], $data['percentage'], $data['key_words'], $data['preferred_job_location'], $data['curr_ctc'], $data['exp_exp_annual_ctc'], $data['expected_designation'], $data['exp_achievements'], $data['notice_period'], $data['job_type_experience']));
   
                   $stmt3 = "INSERT INTO `user_employment` (`user_id`, `designation`,  `current_company`,  `description`, `noticeperiod`, `current_ctc`) VALUES (?,?, ?, ?, ?, ?)";
                   $stmt3 = $this->pdo->prepare($stmt3);
                   $stmt3->execute(array($user_id, $data['curr_designation'], 'yes', $data['exp_description'], $data['notice_period'], $data['curr_ctc']));
                   //Insert experience details
                   $stmt2 = "INSERT INTO `user_experience`( `user_id`, `current_designation`, `brief_work_profile`, `experience_years`, `expected_designation`, `current_ctc`, `expected_annual_ctc`, `notice_period`, `achivements`) VALUES (?,?,?,?,?,?,?,?,?)";
                   $stmt2 = $this->pdo->prepare($stmt2);
                   $stmt2->execute(array($user_id, $data['curr_designation'], $data['exp_description'], $data['work_exp_years'], $data['expected_designation'], $data['curr_ctc'], $data['exp_exp_annual_ctc'], $data['notice_period'], $data['exp_achievements']));
               }
   
   
               //Insert highest education details
   
               $select1 = $this->pdo->prepare("SELECT qualification_table_name FROM `qualification_tables` WHERE qualification_id=?");
               $select1->execute(array($data['education']));
               $table_name = $select1->fetchColumn();
               //echo $table_name;
               $select1 = $this->pdo->prepare("SELECT qualification FROM `qualifications` WHERE id=?");
               $select1->execute(array($data['education']));
               $qualification_name = $select1->fetchColumn();
   
               if ($table_name == 'GATE_details') {
                   $query = 'INSERT INTO `' . $table_name . '` (`user_id`, `domain`, `all_india_score`, `marks`, `year_of_passing`) VALUES (' . $user_id . ',"","","' . $data['percentage'] . '","")';
                   $select = $this->pdo->prepare($query);
                   $select->execute();
               } else {
                   $query = 'INSERT INTO `' . $table_name . '` (`user_id`, `specialisation`, `school`, `board`, `percentage`, `marks`, `passing_year`) VALUES (' . $user_id . '," ","","' . $data['university'] . '","' . $data['percentage'] . '","","")';
                   //echo $query;exit;
                   $select = $this->pdo->prepare($query);
                   $select->execute();
               }
               try {
                   if ($data['is_gate'] == 'yes') {
                       $query = 'INSERT INTO `GATE_details`  (`user_id`,`domain`, `all_india_score`, `marks`, `year_of_passing`) VALUES (' . $user_id . ',"' . $data['domain'] . '",' . $data['gate_score'] . ',"","")';
                       $select = $this->pdo->prepare($query);
                       $select->execute();
                       $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $user_id . ',9,"GATE")';
                       $select2 = $this->pdo->prepare($query2);
                       $select2->execute();
                   }
               } catch (Exception $e) {
                   echo $e->getMessage();
                   exit;
               }
               $query2 = 'INSERT INTO `user_education_details`(`user_id`, `qualifications_id`, `qualification_name`) VALUES (' . $user_id . ',' . $data['education'] . ',"' . $qualification_name . '")';
               $select2 = $this->pdo->prepare($query2);
               $select2->execute();
   
   
               //send email to admin
               $select = "SELECT email FROM `users` WHERE username='admin'";
               $res = $this->pdo->query($select);
               $admin_email = $res->fetchColumn();
   
   
   
               $name = $data['first_name'] . " " . $data['middle_name'] . " " . $data['lastname'];
   
               $subject = "Registration Details for Trisim Technology - http://jobs.trisimtechnology.com/";
               $to = $data['email'];
               $message = '<html><head>
   						   <title>Email Verification</title>
   						   </head>
   						   <body>';
               $message .= '<p>Hello ' . $name . ',<br><br>';
               $message .= 'Thank you for creating account at Jobs portal(http://jobs.trisimtechnology.com).<br><br>Click on the below link to activate your account.<br>'
                       . '<a href= http://' . $config["http_host"] . '/login.php?id=' . base64_encode($user_id) . '>CLICK HERE</a>'
                       . ' <br><br>Regards,<br>Team Trisim Technology';
               $message .= '</body></html>';
               $subject_admin = "New User Registered - http://jobs.trisimtechnology.com/";
               $message_admin = '<html><head>
   						   <title>New User Registered</title>
   						   </head>
   						   <body>';
               $message_admin .= '<p>Hello Admin,<br><br>';
               /* $message_admin .= 'New User Registered!!!<br><br>Here are the Details :<br><br>'
                 . 'Name:' . $name . '<br> Usename:' . $data[username] . '<br>Email:' . $data['email'] . '<br><br>Regards,<br>'
                 . 'Team Trisim Technology </p>'; */
               $message_admin .= 'New User Registered!!!<br><br>Here are the Details :<br><br>'
                       . 'Name:' . $name . '<br><br>Regards,<br>'
                       . 'Team Trisim Technology </p>';
               $message_admin .= '</body></html>';
               $resmail = $this->sendSMTPEmail($to, $name, $subject, $message);
               $resmailadmin = $this->sendSMTPEmail($admin_email, '', $subject_admin, $message_admin);
               if ($files['uploadphoto']['type'] == "image/jpg" || $files['uploadphoto']['type'] == "image/jpeg" || $files['uploadphoto']['type'] == "image/gif" || $files['uploadphoto']['type'] == "image/png" || $files['uploadphoto']['type'] == "image/bmp" || $files['uploadphoto']['type'] == "image/tiff") {
   
                   $photoname = $files['uploadphoto']['name'];
                   $path = $this->createUserFolder($user_id);
   
                   if ($path) {
                       $result = move_uploaded_file($files['uploadphoto']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id . '/' . $photoname);
                       if ($result == 1) {
                           $msg = "<p>Your profile  file uploaded successfully</p>";
                       } else {
                           $msg = "<p>Sorry, Error happened while uploading . </p>";
                       }
                   }#end if($path){
               } // endIF
           } catch (PDOException $e) {
               // check if username already exists in the system
               $this->setError($e->getMessage());
               return false;
           }
           //return $user_id;
           //return $resmail;
           return true;
       }
   
       function higher_education_details($name) {
           
       }
   
       /* Get All users */
   
       function getUsersold($data) {
   //print_r($data);exit;
           /*  if($data['subject']){
             $subject_name=$this->getmarks($data['subject']);
             } */
           /* $sel = "SELECT users.*,user_profile.*,(user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) ,subject_marks.*, users.id AS id,user_types.type AS userType, qualifications.qualification as Education 
             FROM users
             LEFT JOIN user_profile ON users.id = user_profile.user_id
             LEFT JOIN user_types ON users.user_type = user_types.id
             LEFT JOIN qualifications ON user_profile.education = qualifications.id
             LEFT JOIN subject_marks ON users.id = subject_marks.user_id
             WHERE 1=1 "; */
           /* $sel= "SELECT users.*,user_profile.*,(user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) , users.id AS id,user_types.type AS userType FROM users LEFT JOIN user_profile ON users.id = user_profile.user_id LEFT JOIN user_types ON users.user_type = user_types.id LEFT JOIN subject_marks ON users.id = subject_marks.user_id  WHERE 1=1 ";
   
             if (!empty($data['name'])) {
             $sel .= " AND username LIKE '%" . $data['name'] . "%' ";
             }
             if (!empty($data['email'])) {
             //$data['email'] = str_replace('@','%40',$data['email']);
             $sel .= " AND email LIKE '%" . $data['email'] . "%' ";
             }
             if (!empty($data['subject'])) { */
           /* $sel .= " AND (subject_marks.subject1 LIKE '%" . $data['subject'] . "%' or subject_marks.subject2 LIKE '%" . $data['subject'] . "%'  or subject_marks.subject3 LIKE '%" . $data['subject'] . "%'  or subject_marks.subject4 LIKE '%" . $data['subject'] . "%'  or subject_marks.subject5 LIKE '%" . $data['subject'] . "%' )"; */
           /* $sel.=" AND subject_marks.qualifications_id = ".$data['subject']." and user_profile.user_id=subject_marks.user_id ";
             }
   
             if (!empty($data['marks'])) {
             if($data['subject_marks']=='greater'){$sel .= " AND subject_marks.".$subject_name.">=". $data['marks']. "";}
             if($data['subject_marks']=='less'){$sel .= " AND subject_marks.".$subject_name."<=". $data['marks']. "";}
   
             }
             if (!empty($data['education'])) {
             //$sel .= " AND subject_marks.qualifications_id LIKE '%" . $data['education'] . "%' ";
             $sel.=" AND subject_marks.qualifications_id = ".$data['education']." and user_profile.user_id=subject_marks.user_id ";
             }
             if (!empty($data['location'])) {
             $sel .= " AND city LIKE '%" . $data['location'] . "%' ";
             }
             if (strlen($data['exp_years']) > 0  && strlen($data['exp_months']) === 0 ) {
             $sel .= " AND (user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) BETWEEN " . ($data['exp_years']*365+$data['exp_months']*31) . " AND " . ($data['to_exp_years']*365+$data['to_exp_months']*31 ). " ";
             }
             if (strlen($data['exp_months']) > 0  && strlen($data['exp_years']) ===0 ) {
             $sel .= " AND work_exp_months  BETWEEN '" . $data['exp_months'] . "' AND '" . $data['to_exp_months'] . "'AND work_exp_years  BETWEEN '" . $data['exp_years'] . "' AND '" . $data['to_exp_years'] . "' ";
             }
             if (strlen($data['exp_years']) > 0 && strlen($data['exp_months']) > 0 ) {
             $sel .= " AND (user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) BETWEEN " . ($data['exp_years']*365+$data['exp_months']*31) . " AND " . ($data['to_exp_years']*365+$data['to_exp_months']*31 ). " ";
   
             }
             $sel.=" order by users.id"; */
   
           // print_r($candidate->query($data));exit;
           try {
               $res = $this->pdo->query($candidate->query());
               $data = $res->fetchAll(PDO::FETCH_ASSOC);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return $data;
       }
   
       function getUsers($data) {
   
           $user_types = $this->getUserTypes();
           $user_type_id = 0;
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'User') {
                   $user_type_id = $v['id'];
               }
           }
   $location=trim($data['location']);
           $qualification_id_10th = $this->getQualificationidbyNames('10th');
           $qualification_id_12th = $this->getQualificationidbyNames('12th');
           $qualification_id_be = $this->getQualificationidbyNames('BE');
           $candidate = new candidateSearch($user_type_id);
           if (!empty($data['name'])) {
               $candidate->byName(trim($data['name']));
           }
           if (!empty($data['email'])) {
               $candidate->byEmail(trim($data['email']));
           }
           if (!empty($location)) { 
               $candidate->byLocation($location);
           }
           if (!empty($data['education'])) {
               $candidate->byQualification($data['education'], $qualification_id_10th, $qualification_id_12th, $qualification_id_be);
           }
           if (!empty($data['user_id'])) {
              $candidate->byUserId($data['user_id']);
           }
           if (!empty($data['marks'])) {
               if (($data['subject']) && $data['education']) {
                   //$subject_name = $this->getmarks(trim($data['subject']),$data['education']);
                   $candidate->byMarks($data);
               }
               //echo "hi".$data['subject'].$subject_name,$data['education'];
               //$candidate->byMarks($data, $subject_name);
           }
           if (!empty($data['exp_years'])) {
               $candidate->byYearsExperience($data);
           }
          /* if (strlen($data['exp_years']) > 0 && strlen($data['exp_months']) === 0) {
               $candidate->byYearsExperience($data);
           }
           if (strlen($data['exp_months']) > 0 && strlen($data['exp_years']) === 0) {
               $candidate->byMonthsExperience($data);
           }
           if (strlen($data['exp_years']) > 0 && strlen($data['exp_months']) > 0) {
               $candidate->byYMExperience($data);
           }*/
           //$candidate->byDateWise($data);
//print_r($candidate->query($data));
           try {
               $res = $this->pdo->query($candidate->query());
               $data_res = $res->fetchAll(PDO::FETCH_ASSOC);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return $data_res;
       }
   
       function getmarks($subject, $q_id) {
   
           $sel = "SELECT * from subject_marks where qualifications_id=" . $q_id;
           $res = $this->pdo->query($sel);
           $res = $res->fetchall(PDO::FETCH_ASSOC);
           //print_r($res);
           if (!$res) {
               echo "no row found";
           }
   
           foreach ($res as $result) {
               foreach ($result as $key => $val) {
                   //echo "<div class='title'>" . $key . "</div>\n";
                   //echo "<div class='story'>" . $val . "</div>\n";
                   $this->like_match('%' . $subject . '%', $val);
                   //if ($subject == $val) {
                   if ($this->like_match('%' . $subject . '%', $val)) {
                       return $key . '_marks';
                   }
               }
           }
       }
   
       function like_match($pattern, $subject) {
           $pattern = str_replace('%', '.*', preg_quote($pattern, '/'));
   
           return (bool) preg_match("/^{$pattern}$/i", $subject);
       }
   
       function getUsersTest($data) {
   //print_r($data);exit;
           $sel = "SELECT users.*,user_profile.*, users.id AS id,user_types.type AS userType, qualifications.qualification as Education 
   		FROM users
   		LEFT JOIN user_profile ON users.id = user_profile.user_id
                   LEFT JOIN user_types ON users.user_type = user_types.id
                   LEFT JOIN qualifications ON user_profile.education = qualifications.id            
   		WHERE 1=1 ";
   
           if (!empty($data['username'])) {
               $sel .= " AND username LIKE '%" . $data['username'] . "%' ";
           }
           if (!empty($data['email'])) {
               $sel .= " AND email LIKE '%" . $data['email'] . "%' ";
           }
           if (!empty($data['subject'])) {
               $sel .= " AND subject LIKE '%" . $data['subject'] . "%'  ";
           }
           if (!empty($data['marks'])) {
               $sel .= " AND marks" . $data['subject_marks'] . $data['marks'] . "";
           }
           if (!empty($data['education'])) {
               $sel .= " AND education LIKE '%" . $data['education'] . "%' ";
           }
           if (!empty($data['location'])) {
               $sel .= " AND city LIKE '%" . $data['location'] . "%' ";
           }
           if (strlen($data['exp_years']) > 0 || strlen($data['to_exp_years']) > 0) {
               $sel .= " AND work_exp_years  BETWEEN '" . $data['exp_years'] . "' AND '" . $data['to_exp_years'] . "' ";
           }
           if (strlen($data['exp_months']) > 0 || strlen($data['to_exp_months']) > 0) {
               $sel .= " AND work_exp_months  BETWEEN '" . $data['exp_months'] . "' AND '" . $data['to_exp_months'] . "' ";
           }
   
   //print_r($sel);exit;
           try {
               $res = $this->pdo->query($sel);
               $data = $res->fetchAll(PDO::FETCH_ASSOC);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return $data;
       }
   
       /* Get Employment By Id */
   
       function getEmploymentById($id) {
           $select = "SELECT * FROM user_employment WHERE id=?";
           $select = $u->pdo->prepare($select);
           $select->execute(array($id));
   
           $row = $select->fetch(PDO::FETCH_ASSOC);
           return $row;
       }
   
       /* Get All Jobs */
   
       function getJobs() {
   
           $select = "SELECT DISTINCT * FROM jobs ORDER BY 	posted_on DESC";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       function getuniquelocation() {
   
           $select = "SELECT DISTINCT `location` FROM `jobs` WHERE 1";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       function getuniquedesignation() {
   
           $select = "SELECT DISTINCT `designation` FROM `jobs` WHERE 1";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       /* Get All qualifications */
   
       function getQualifications() {
   
           $select = "SELECT * FROM qualifications";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       function getQualificationNames() {
   
           $select = "SELECT qualification FROM qualifications";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       function getQualificationidbyNames($name) {
   
           $select = "SELECT id FROM qualifications where qualification='" . $name . "'";
           $res = $this->pdo->query($select);
           return $res->fetchColumn();
       }
   
       /* Get All getSkills */
   
       function getSkills() {
   
           $select = "SELECT * FROM skills";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       /* Get All skills */
   
       /*public function getUserSkillsDetails($user_id) {
   
   //echo $select;
           $select = $this->pdo->prepare("SELECT *,user_skills.id as us_id ,skills.name as name  FROM user_skills
   		LEFT JOIN users ON user_skills.user_id = users.id
    LEFT JOIN skills ON user_skills.skill_id = skills.id
   		WHERE users.id=?");
           $select->execute(array($user_id));
   
           while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
               $user_skills[] = $row;
           }
   
           return $user_skills;
       }*/
        public function getUserSkillsDetails($user_id) {
   
   //echo $select;
           $select = $this->pdo->prepare("SELECT *  FROM user_skills_tools WHERE user_skills_tools.user_id=?");
           $select->execute(array($user_id));
   
           while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
               $user_skills[] = $row;
           }
   
           return $user_skills;
       }
   
       /* Get  User Skills by id */
   
       function getUserSkillsById($id) {
   
   
           $select = "SELECT *,user_skills.id as us_id,skills.name as name  FROM user_skills
   		LEFT JOIN skills ON user_skills.skill_id = skills.id 
   		WHERE user_skills.id=?";
   
           try {
               $select = $this->pdo->prepare($select);
               $select->execute(array($id));
               $row = $select->fetch(PDO::FETCH_ASSOC);
               //print_r($row);
               //return $row['qualification'];
               return $row;
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
       }
         function getUserSkillsToolsById($id) {
   
   
           $select = "SELECT * FROM user_skills_tools WHERE user_skills_tools.id=?";
   
           try {
               $select = $this->pdo->prepare($select);
               $select->execute(array($id));
               $row = $select->fetch(PDO::FETCH_ASSOC);
               //print_r($row);
               //return $row['qualification'];
               return $row;
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
       }
   
       function getTools() {
   
           $select = "SELECT * FROM tools";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
   
       /* Get All skills */
   
       public function getUserToolsDetails($user_id) {
   
   //echo $select;
           $select = $this->pdo->prepare("SELECT *,user_tools.id as us_id ,tools.name as name  FROM user_tools
   		LEFT JOIN users ON user_tools.user_id = users.id
    LEFT JOIN tools ON user_tools.tool_id = tools.id
   		WHERE users.id=?");
           $select->execute(array($user_id));
   
           while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
               $user_skills[] = $row;
           }
   
           return $user_skills;
       }
   
       /* Get  User Skills by id */
   
       function getUserToolsById($id) {
           $select = "SELECT *,user_tools.id as us_id,tools.name as name  FROM user_tools
   		LEFT JOIN tools ON user_tools.tool_id = tools.id 
   		WHERE user_tools.id=?";
           //echo($select);
   
           try {
               $select = $this->pdo->prepare($select);
               $select->execute(array($id));
               $row = $select->fetch(PDO::FETCH_ASSOC);
               //print_r($row);
               //return $row['qualification'];
               return $row;
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
       }
   
       /* Get  qualification by id */
   
       function getSkillsById($id) {
   
           $select = "SELECT * from skills WHERE id=?";
           try {
               $select = $this->pdo->prepare($select);
               $select->execute(array($id));
               $row = $select->fetch(PDO::FETCH_ASSOC);
               //return $row['name'];
               return $row;
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
       }
   
       /* Get  qualification by id */
   
       function getQualificationById($id) {
   
   
           $select = "SELECT * FROM qualifications WHERE id=?";
           try {
               $select = $this->pdo->prepare($select);
               $select->execute(array($id));
               $row = $select->fetch(PDO::FETCH_ASSOC);
               //return $row['qualification'];
               return $row;
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
       }
   
       function getJobById($id) {
   
           $select = "SELECT * FROM jobs WHERE id=?";
           try {
               $select = $this->pdo->prepare($select);
               $select->execute(array($id));
               $row = $select->fetch(PDO::FETCH_ASSOC);
               return $row;
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
       }
   
       /*
         Update user Basic Detail details
        */
   
       function updateBasicDetails($data, $files) {
           // echo 'hi1';
           //  print_r($files); 
   
           try { //echo "UPDATE `user_profile` SET `current_ctc_lakhs`=".$data['current_ctc_lakhs'].",`current_ctc_thousands`=".$data['current_ctc_thousands'].",`work_exp_years`=".$data['work_exp_years'].",`work_exp_months`=".$data['work_exp_months'].",`city`=".$data['city']." WHERE user_id=".$this->user_id;exit;
               $data['preferred_job_location'] = $data['multiple-checkboxes'] . "," . $data['multiple-checkboxes1'] . "," . $data['multiple-checkboxes2'];
               //print_r($data);exit;
               // console.log($data);
               $user_id = $data['user_id'];
               $photoname = $files['name'];
   
               if (!empty($data['current_ctc_lakhs']) || !empty($data['work_exp_years'])) {
                   $is_experienced = 'yes';
               }
   
               if (empty($photoname)) {
   
                   $update_qry = $this->pdo->prepare("UPDATE `user_profile` SET `current_ctc_lakhs`=?,`current_ctc_thousands`=?,`work_exp_years`=?,`work_exp_months`=?,`city`=?,`expected_salary`=?,`expected_designation`=?,`achivements`=?,`domain`=?,`skills_expertise`=?,`preferred_job_location`=? WHERE user_id=?");
                   $update_qry->execute(array($data['current_ctc_lakhs'], $data['current_ctc_thousands'], $data['work_exp_years'], $data['work_exp_months'], $data['city'], $data['expected_annual_ctc'], $data['expected_designation'], $data['achievements'], $data['job_type'], $data['key_words'], $data['preferred_job_location'], $data['user_id']));
               } else {
                   $update_qry = $this->pdo->prepare("UPDATE `user_profile` SET `current_ctc_lakhs`=?,`current_ctc_thousands`=?,`work_exp_years`=?,`work_exp_months`=?,`profile_photo`=?,`city`=?,`expected_salary`=?,`expected_designation`=?,`achivements`=?,`domain`=?,`skills_expertise`=?,`preferred_job_location`=? WHERE user_id=?");
                   $update_qry->execute(array(($data['current_ctc_lakhs']), $data['current_ctc_thousands'], $data['work_exp_years'], $data['work_exp_months'], $photoname, $data['city'], $data['expected_annual_ctc'], $data['expected_designation'], $data['achievements'], $data['job_type'], $data['key_words'], $data['preferred_job_location'], $data['user_id']));
               }$pn = urldecode($data['profile_name']);
               $email = addslashes($data['email']);
               $data['email'] = urldecode($data['email']);
               if ($is_experienced == 'yes') {
                   $update_user = $this->pdo->prepare("UPDATE `users` SET `profile_name`=?,`email`=?,`mobile_number`=?,`username`=?,`is_experienced`=?  WHERE id=?");
                   $update_user->execute(array($pn, $data['email'], $data['mobile_number'], $data['username'], 'yes', $user_id,));
               } else {
   
                   $update_user = $this->pdo->prepare("UPDATE `users` SET `profile_name`=?,`email`=?,`mobile_number`=?,`username`=? WHERE id=?");
                   $update_user->execute(array($pn, $data['email'], $data['mobile_number'], $data['username'], $user_id,));
               }
   ///Upload user profile photo
               if (!empty($photoname)) {//
                   if ($files['type'] == "image/jpg" || $files['type'] == "image/jpeg" || $files['type'] == "image/gif" || $files['type'] == "image/png" || $files['type'] == "image/bmp" || $files['type'] == "image/tiff") {
   
                       $photoname = $files['name'];
                       $path = $this->createUserFolder($user_id);
   
                       //if ($path) {
                       $result = move_uploaded_file($files['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id . '/' . $photoname);
                       if ($result == 1) {
                           $msg = "<p>Your profile  file uploaded successfully</p>";
                       } else {
                           $msg = "<p>Sorry, Error happened while uploading . </p>";
                       }
                       //}#end if($path){
                   } // endIF
               }
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
   
           return true;
       }
   
       /*
         function isAdmin()
         return true if logged in user type is Admin other wise return false with error message.
        */
   
       function isAdmin() {
   
           if ($this->user_type == 'Admin') {
               return true;
           }
           return false;
       }
   
       function isCandidate() {
   //echo $this->user_type;exit;
           if ($this->user_type == 'Candidate') {
               return true;
           }
           return false;
       }
   
       function isUser() {
   
           //if($this->user_type == 'Employee'){
           return true;
           //}
           //return false;
       }
   
       /*
         function getUserType()
         return user type of logged in user.
        */
   
       function getUserType() {
           //return $this->user_profile['user_type'];
           $select = $this->pdo->prepare("SELECT user_types.type FROM user_types, users WHERE user_types.id = users.user_type AND users.id = ?");
           $select->execute(array($this->user_id));
           $row = $select->fetch(PDO::FETCH_ASSOC);
//echo $row['type'];
           return $row['type'];
       }
   
       function getUsrTypeById($id) {
           $select = $this->pdo->prepare("SELECT user_types.type FROM user_types WHERE id = ?");
           $select->execute(array($id));
           $user_type = $select->fetch(PDO::FETCH_ASSOC);
           return $user_type;
       }
   
       /*
         function _loginRedirect()
         function redirect user to the index page.
        */
   
       function _loginRedirect() {
           // send user to the login page
           header("Location:/login.php");
       }
   
       function getUserTypes() {
           return $this->pdo->select('user_types');
       }
   
       function sendSMTPEmail($to, $name, $email_subject, $email_body) {
           if (empty($to)) {
               return false;
           }
   ############ Send mail by SMTP
           $app_config = $this->app_config;
           //print_r($app_config);
           $mail = new PHPMailer();
           $mail->IsSMTP(true);
           $mail->Host = $app_config['mail_host'];
           $mail->SMTPAuth = true;
           $mail->Username = $app_config['mail_username'];  // SMTP username
           $mail->Password = $app_config['mail_password']; // SMTP password
           $mail->Port = $app_config['port']; // not 587 for ssl
           $mail->SMTPSecure = $app_config['SMTPSecure'];
           $mail->SetFrom('carvingtesting@gmail.com', 'Jobs Portal');
           $mail->AddAddress($to, $name);
           $mail->AddAddress('rutuja@carvingit.com', $name);
           //$mail->AddAddress('gayatri@trisimtechnology.com', $name);
           $mail->AddAddress('jadhavpriyanka26@gmail.com');
           $mail->AddAddress('shweta@carvingit.com');
   
           $mail->SMTPDebug = 1;
           $mail->IsHTML(true);
           $mail->Subject = $email_subject;
           $mail->Body = $email_body;
   
           if (!$mail->Send()) {
               //echo "Mailer Error: " . $mail->ErrorInfo;
               $this->setError("<span class=\"message\" style='color:#FF0000'>Mailer Error:" . $mail->ErrorInfo . "</span>");
               echo $this->setError();
               return false;
           }
           ///Upload user profile photo
   
           return true;
       }
   
       function addUser($data) {
   //print_r($data);exit;
           try {
               $stmt = "INSERT INTO `users` (`username`,`password`, `user_type`,`email`, `first_name`, `middle_name`, `last_name`, `mobile_number`, `date_of_birth`, `gender`,`profile_name`,`tokencode`) VALUES (?,?,?,?,?,?,?,?,?,?,?,0)";
               $stmt = $this->pdo->prepare($stmt);
               $stmt->execute(array($data['username'], md5($data['password']), $data['user_type'], $data['email'], $data['first_name'], $data['middle_name'], $data['last_name'], $data['mobile_number'], $data['date_of_birth'], $data['gender'], $data['profile_name']));
               //$this->pdo->insert('users',$data);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function addSkill($data) {
           try {
               $this->pdo->insert('skills', $data);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function addQualification($data) {
           try {
               $stmt = "INSERT INTO `qualifications` (`qualification`) VALUES (?)";
               $stmt = $this->pdo->prepare($stmt);
               $stmt->execute(array($data['qualification']));
               //$this->pdo->insert('qualifications',$data);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function addPersonal($data) {
           //print_r($data);
           try {
               $update = $this->pdo->prepare("UPDATE `user_profile` SET `date_of_birth`=?,`permanent_address`=?,`current_address`=?,`pin_code`=?,`passport_number`=? WHERE user_id = ?");
   
               $update->execute(array($data['date_of_birth'], $data['permanent_address'], $data['current_address'], $data['pin_code'], $data['passport_number'], $data['get_id']));
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function UpdateResume($data, $files) {
           //print_r($data);
           try {
               if (!empty($files['resume_file']['tmp_name'])) {
                   $datafile = @file_get_contents($files['resume_file']['tmp_name']);
                   $size = intval($files['resume_file']['size']);
                   $name = $files['resume_file']['name'];
                   $mime = $files['resume_file']['type'];
                   $update = $this->pdo->prepare("UPDATE `user_profile` SET  `resume_file_data`=?, `resume_file_name`=?, `resume_file_size`=?, `resume_file_type`=?, `profile_photo`=?  WHERE user_id=?");
   
                   $update->execute(array($datafile, $name, $size, $mime, $photoname, $data['id']));
               } else {
                   //$datafile = @file_get_contents($data['resumefile']);
               }
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function updateUser($data, $files) {
   //print_r($files);exit;
           if (!empty($data['date_of_birth'])) {
   //f$dateo = DateTime::createFromFormat("m-d-Y" , $data['date_of_birth']);
   //$date_of_birth = $dateo->format('Y-m-d');
               $date_of_birth = date("Y-m-d", strtotime($data['date_of_birth']));
           }
           $user_types = $this->getUserTypes();
           $user_type_id = 0;
           $photoname = $files['uploadphoto']['name'];
   
           if (!empty($files['resume_file']['tmp_name'])) {
               $datafile = @file_get_contents($files['resume_file']['tmp_name']);
               $size = intval($files['resume_file']['size']);
               $name = $files['resume_file']['name'];
               $mime = $files['resume_file']['type'];
           } else {
               //$datafile = @file_get_contents($data['resumefile']);
           }
   
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'Candidate') {
                   $user_type_id = $v['id'];
               }
           }
           try {
               $update_qry = $this->pdo->prepare("UPDATE `users` SET `username`=?, `user_type`=?, `email`=?, `first_name`=?, `middle_name`=?, `last_name`=?, `mobile_number`=?, `date_of_birth`=?, `gender`=?, `profile_name`=? WHERE id = ?");
   
               $update_qry->execute(array($data['username'], $data['user_type'], $data['email'], $data['first_name'], $data['middle_name'], $data['last_name'], $data['mobile_number'], $date_of_birth, $data['gender'], $data['profile_name'], $data['id']));
   
   
               if (!empty($photoname) && !empty($photoname)) {
                   $update = $this->pdo->prepare("UPDATE `user_profile` SET `current_ctc_lakhs`=?, `current_ctc_thousands`=?, `work_exp_years`=?, `work_exp_months`=?, `city`=?, `subject`=?, `education`=?, `resume_file_data`=?, `resume_file_name`=?, `resume_file_size`=?, `resume_file_type`=?, `profile_photo`=?  WHERE user_id=?");
   
                   $update->execute(array($data['current_ctc_lakhs'], $data['current_ctc_thousands'], $data['work_exp_years'], $data['work_exp_months'], $data['city'], $data['subject'], $data['education'], $datafile, $name, $size, $mime, $photoname, $data['id']));
               } else if (empty($photoname) && empty($mime)) {
   
                   $update = $this->pdo->prepare("UPDATE `user_profile` SET `current_ctc_lakhs`=?, `current_ctc_thousands`=?, `work_exp_years`=?, `work_exp_months`=?, `city`=?, `subject`=?, `education`=?  WHERE user_id=?");
   
                   $update->execute(array($data['current_ctc_lakhs'], $data['current_ctc_thousands'], $data['work_exp_years'], $data['work_exp_months'], $data['city'], $data['subject'], $data['education'], $data['id']));
               } else if (!empty($photoname) && empty($mime)) {
   
                   $update = $this->pdo->prepare("UPDATE `user_profile` SET `current_ctc_lakhs`=?, `current_ctc_thousands`=?, `work_exp_years`=?, `work_exp_months`=?, `city`=?, `subject`=?, `education`=?,  `profile_photo`=?  WHERE user_id=?");
   
                   $update->execute(array($data['current_ctc_lakhs'], $data['current_ctc_thousands'], $data['work_exp_years'], $data['work_exp_months'], $data['city'], $data['subject'], $data['education'], $photoname, $data['id']));
               } else if (empty($photoname) && !empty($mime)) {
   
                   $update = $this->pdo->prepare("UPDATE `user_profile` SET `current_ctc_lakhs`=?, `current_ctc_thousands`=?, `work_exp_years`=?, `work_exp_months`=?, `city`=?, `subject`=?, `education`=?, `resume_file_data`=?, `resume_file_name`=?, `resume_file_size`=?, `resume_file_type`=?  WHERE user_id=?");
   
                   $update->execute(array($data['current_ctc_lakhs'], $data['current_ctc_thousands'], $data['work_exp_years'], $data['work_exp_months'], $data['city'], $data['subject'], $data['education'], $datafile, $name, $size, $mime, $data['id']));
               }
   
   
   
               if (!empty($photoname)) {
                   if ($files['uploadphoto']['type'] == "image/jpg" || $files['uploadphoto']['type'] == "image/jpeg" || $files['uploadphoto']['type'] == "image/gif" || $files['uploadphoto']['type'] == "image/png" || $files['uploadphoto']['type'] == "image/bmp" || $files['uploadphoto']['type'] == "image/tiff") {
                       $photoname = $files['uploadphoto']['name'];
                       $path = $this->createUserFolder($data['id']);
   
   
                       $user_id = $data['id'];
   
                       $result = move_uploaded_file($files['uploadphoto']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id . '/' . $photoname);
                       if ($result == 1) {
                           $msg = "<p>Your profile  file uploaded successfully</p>";
                       } else {
                           $msg = "<p>Sorry, Error happened while uploading . </p>";
                       }
                       //}#end if($path){
                   } // endIF
               }//if(!empty($name)){
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function updateSkill($data) {
           try {
               //$update_qry = $this->pdo->prepare("UPDATE `skills` SET `name`=? WHERE id=?");
               //$update_qry->execute(array($data['name'],$data['id']));
               $this->pdo->update('skills', $data, "id=$data[id]");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
    function disableJob($id) {
           try {
               $update_qry = $this->pdo->prepare("UPDATE `jobs` SET `active`=? WHERE id=?");
               $update_qry->execute(array("0",$id));
               //$this->pdo->update('jobs', $data, "id=$data[id]");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
        function enableJob($id) {
           try {
               $update_qry = $this->pdo->prepare("UPDATE `jobs` SET `active`=? WHERE id=?");
               $update_qry->execute(array("1",$id));
               //$this->pdo->update('jobs', $data, "id=$data[id]");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
       function refreshJob($id) {
           try {
               $update_qry = $this->pdo->prepare("UPDATE `jobs` SET `posted_on`=now() WHERE id=?");
               $update_qry->execute(array($id));
               //$this->pdo->update('jobs', $data, "id=$data[id]");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
       function updateQualification($data) {
   //print_r($data);exit;
           try {
               $this->pdo->update('qualifications', $data, "id=$data[id]");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function deleteUser($id) {
           try {
               $this->pdo->delete('users', "id = $id");
               $this->pdo->delete('user_profile', "user_id = $id");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function deleteSkill($id) {
           try {
               $this->pdo->delete('skills', "id = $id");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function deleteQualification($id) {
           try {
               $this->pdo->delete('qualifications', "id = $id");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function deleteJob($id) {
           try {
               $this->pdo->delete('jobs', "id = $id");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
       function displayEducationDetails($education, $name, $str) {
		     
   
           echo'<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> <tr><th  width="40%"  style="border: none;">' . $name. '</th> </tr>
   <tr><th  width="40%"  style="border: none;">Specialization</th><td style="border: none;">' . $education[0]['specialisation'] . '</td></tr><tr> <th  width="40%"  style="border: none;">School/Institute</th><td style="border: none;">' . $education[0]['school'] . '</td></tr><tr> <th  width="40%"  style="border: none;">University/Board</th><td style="border: none;">' . $education[0]['board'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Percentage/CGPA</th><td style="border: none;">' . $education[0]['percentage'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Marks Obtained</th> <td style="border: none;">' . $education[0]['marks'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Year of Passing</th>   <td style="border: none;">' . $education[0]['passing_year'] . '</td></tr>';
    echo'</table></div>';	  
   if($_SESSION['user_type'] !='Admin'){
          echo' <div class="col-md-2">	<input type="button" name="edit" onclick="clickMeEditEducation(\''.$str.'\')" value="Edit" id=' . $education[0]['user_id'] . '  edu_find=' . $str . ' class_name=' . $name . ' class="btn btn-info btn-xs edit_education' . $str . '"  /><br/></div>';
       }
       }
   
       function display12thDetails($education, $name, $str) {
   
           echo '<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> <tr><th  width="40%"  style="border: none;">' . $name . '</th> </tr>
   <tr><th  width="40%"  style="border: none;">Specialization</th><td style="border: none;">' . $education[0]['specialisation'] . '</td></tr><tr> <th  width="40%"  style="border: none;">School/Institute</th><td style="border: none;">' . $education[0]['school'] . '</td></tr><tr> <th  width="40%"  style="border: none;">University/Board</th><td style="border: none;">' . $education[0]['board'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Percentage/CGPA</th><td style="border: none;">' . $education[0]['percentage'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Marks Obtained</th> <td style="border: none;">' . $education[0]['marks'] . '</td></tr>'
           . '<tr>  <th  width="40%"  style="border: none;">Year of Passing</th>   <td style="border: none;">' . $education[0]['passing_year'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Physics Marks</th>   <td style="border: none;">' . $education[0]['physics_marks'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Chemistry Marks</th>   <td style="border: none;">' . $education[0]['chemistry_marks'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Maths Marks</th>   <td style="border: none;">' . $education[0]['maths_marks'] . '</td></tr>';
   
   
           echo'</table></div>';	  
    if($_SESSION['user_type'] !='Admin'){	echo'<div class="col-md-2">	<input type="button" name="edit" onclick="clickMeEditEducation(\''.$str.'\')" value="Edit" id=' . $education[0]['user_id'] . '  edu_find=' . $str . ' class_name=' . $name . ' class="btn btn-info btn-xs edit_education' . $str . '"  /><br/></div>';
       }
       
       }
   
       /* function displayGateDetails($education, $name, $str) {
   
         echo'<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> <tr><th  width="40%"  style="border: none;">' . $name . '</th> </tr>
         <tr><th  width="40%"  style="border: none;">Domain</th><td style="border: none;">' . $education[0]['domain'] . '</td></tr><tr><th  width="40%"  style="border: none;">All India Rank</th><td style="border: none;">' . $education[0]['all_india_score'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Marks</th><td style="border: none;">' . $education[0]['marks'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Year Of Passing</th><td style="border: none;">' . $education[0]['year_of_passing'] . '</td></tr> </table></div>
         <div class="col-md-2">	<input type="button" name="edit" value="Edit" id=' . $education[0]['user_id'] . '  edu_find=' . $str . ' class_name=' . $name . ' class="btn btn-info btn-xs edit_education' . $str . '"  /><br/></div>';
         } */
   
       function displayGateDetails($education, $name, $str) {
   
           $education='<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> 
   <tr><th  width="40%"  style="border: none;">Domain</th><td style="border: none;">' . $education[0]['domain'] . '</td></tr><tr><th  width="40%"  style="border: none;">All India Rank</th><td style="border: none;">' . $education[0]['all_india_score'] . '</td></tr><!--tr> <th  width="40%"  style="border: none;">Marks</th><td style="border: none;">' . $education[0]['marks'] . '</td></tr--><tr> <th  width="40%"  style="border: none;">Year Of Passing</th><td style="border: none;">' . $education[0]['year_of_passing'] . '</td></tr> </table></div>';
     if($_SESSION['user_type']!='Admin'){
      $education.='<div class="col-md-2">	<input type="button" name="edit" value="Edit" id="edit_gatedetails"   class="btn btn-info btn-xs "  user_id="' . $_SESSION['user_id'] . '"/><br/></div>';
   	}
     echo $education;
       }
   
       function job_pagination_pages($no_of_records_per_page) {
           $query = "select count(*) from jobs where active='1' ORDER BY posted_on DESC";
           $select = $this->pdo->prepare($query);
           $select->execute();
           $num_of_rows = $select->fetchColumn();
           $total_pages = ceil($num_of_rows / $no_of_records_per_page);
           return $total_pages;
       }
   
       function job_pagination_records($no_of_records_per_page, $offset) {
           $query = "select * from jobs  where active='1' ORDER BY posted_on DESC limit $offset,$no_of_records_per_page ";
           $select = $this->pdo->prepare($query);
           $select->execute();
           return $select->fetchAll(PDO::FETCH_ASSOC);
       }
   
       function job_search($data) {
           $query = "select * from jobs where active='1' AND  job_name=" . $data['job_name'] . " and location=" . $data['location'] . "  ORDER BY posted_on DESC ";
           $select = $this->pdo->prepare($query);
           $select->execute();
           return $select->fetchAll(PDO::FETCH_ASSOC);
       }
   
       function jobsearch_pagination_pages($no_of_records_per_page, $data) {
           try {
               $query = "select count(*) from jobs where active='1' AND  job_name='" . $data['job_name'] . "' and 
                   location='" . $data['location'] . "' and 
                   designation='" . $data['role'] . "' ORDER BY posted_on DESC ";
               $select = $this->pdo->prepare($query);
               $select->execute();
               $num_of_rows = $select->fetchColumn();
               $total_pages = ceil($num_of_rows / $no_of_records_per_page);
               return $total_pages;
           } catch (PDOException $e) {
               return $this->setError($e->getMessage());
           }
       }
   
       function jobsearch_pagination_records($no_of_records_per_page, $offset, $data) {
           $query = "select * from jobs where active='1' AND  job_name='" . $data['job_name'] . "' and 
                   location='" . $data['location'] . "' and 
                   designation='" . $data['role'] . "'  ORDER BY posted_on DESC  limit $offset,$no_of_records_per_page";
           $select = $this->pdo->prepare($query);
           $select->execute();
           return $select->fetchAll(PDO::FETCH_ASSOC);
       }
       
     function UpdateUserJobsCount($data) {
           try {
              
               $update = $this->pdo->prepare("UPDATE `jobs` SET `count`= `count` + 1   WHERE id=?");
   
           $update->execute(array($data['jobid']));
             
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
       
       function addUserJobs($data) {
		   $uid=$data['userid'];
					$jobs = array();

					$select1 = 'SELECT jobs_id FROM `user_jobs` WHERE user_id=' . $data['userid'] . ' ';
					$select1 = $this->pdo->prepare($select1);
					$select1->execute();
					$se_result = $select1->fetchAll(PDO::FETCH_ASSOC);

					foreach ($se_result as $res) {//echo $res['jobs_id'];
					echo $select2 = 'SELECT * FROM `jobs` WHERE id=' . $res['jobs_id'] . ' AND active=1';
					$select2 = $this->pdo->prepare($select2);
					$select2->execute();
					$jobs[] = $select2->fetchAll(PDO::FETCH_ASSOC);
					}     //print_r($result);exit;
					$adminEmail= $this->getUserAdminEmail();
					$config = $this->app_config;
					$userdetails = $this->getUserDetails($_SESSION['user_id']);
					$name=    $userdetails[0]['first_name'];

					 if(empty($name)){ $name=    $userdetails[0]['username'];}
					  if($row['gender']=="Male"){$g="his";}else{$g="her";}
		   
		   
					   $select = 'SELECT id FROM `user_jobs` WHERE user_id=' . $data['userid'] . ' and jobs_id=' . $data['jobid'] . '';
					   $select = $this->pdo->prepare($select);
					   $select->execute();
					   $result = $select->fetchColumn();

						
						 if (!$result) {
						   try {
							$count = $this->UpdateUserJobsCount($data);
			   
							   $stmt = 'INSERT INTO `user_jobs`(`user_id`, `jobs_id`) VALUES (' . $data['userid'] . ',' . $data['jobid'] . ')';
							   
							   $stmt = $this->pdo->prepare($stmt);
							   $stmt->execute();
							   //print_r($stmt);
						   } catch (PDOException $e) {
							   $this->setError($e->getMessage());
							   return $e->getMessage();
						   }
					
					
								$message = "
								Hello Admin,
								<br /><br />
								$name Candidate have applied for a job. 
								<br /><br />
								Click on the following link to view candidate details,
								<br /><br />
								<a href='http://" . $config["http_host"] . "/candidate_list.php?id=$uid'>Click here to view candidates details</a>
								<br /><br />
								Thank you :)<br /><br />
								Regards,<br />
								Team Trisim Technology";
								
								$subject = "Candidate have applied for a job";
				   
								if ($this->sendSMTPEmail($adminEmail,$row['first_name'], $subject,$message)) {
									//	return true;
								} else {
									//return false;
								}
								$jobs['msg']="suc";
               //return "You have sucessfully applied to this job";
           } else {
              // return "You have already applied to this job";
              $jobs['msg']="unsuc";
           }
           return $jobs; 
       }
   function getJob($data) {
        
            $select1 = 'SELECT user_id FROM `user_jobs` WHERE  jobs_id='.$data['id'].' ';
           $select1 = $this->pdo->prepare($select1);
           $select1->execute();
           $u = $select1->fetchAll(PDO::FETCH_COLUMN);
           
           foreach ($u as $res) {
            $data['user_id']=$res;
            $users[]=$this->getUsers($data);
           }
           
           return $users;
         
       }
       
       
           function appliedJobs($data) {
					$result = array();
					$uid=$data['userid'];
					$result = array();

					$select = 'SELECT jobs_id FROM `user_jobs` WHERE user_id=' . $data['userid'] . ' ';
					$select = $this->pdo->prepare($select);
					$select->execute();
					$se_result = $select->fetchAll(PDO::FETCH_ASSOC);

					foreach ($se_result as $res) {//echo $res['jobs_id'];
					$select = 'SELECT * FROM `jobs` WHERE id=' . $res['jobs_id'] . '';
					$select = $this->pdo->prepare($select);
					$select->execute();
					$result[] = $select->fetchAll(PDO::FETCH_ASSOC);
					}     //print_r($result);exit;
					$adminEmail= $this->getUserAdminEmail();
					$config = $this->app_config;
					$userdetails = $this->getUserDetails($_SESSION['user_id']);
					$name=    $userdetails[0]['first_name'];

					 if(empty($name)){ $name=    $userdetails[0]['username'];}
					  if($row['gender']=="Male"){$g="his";}else{$g="her";}
								$message = "
								Hello Admin,
								<br /><br />
								$name Candidate have applied for a job. 
								<br /><br />
								Click on the following link to view candidate details,
								<br /><br />
								<a href='http://" . $config["http_host"] . "/candidate_list.php?id=$uid'>Click here to view candidates details</a>
								<br /><br />
								Thank you :)<br /><br />
								Regards,<br />
								Team Trisim Technology";
								
								$subject = "Candidate have applied for a job";
				   
								if ($this->sendSMTPEmail($adminEmail,$row['first_name'], $subject,$message)) {
									//	return true;
								} else {
									//return false;
								}
						   
           
           
           return $result;
       }
    function getUserAdminEmail() {
       
        $select = $this->pdo->prepare("SELECT users.email FROM user_types, users WHERE user_types.id = users.user_type AND user_types.type = 'Admin'");
        $select->execute();
        $row = $select->fetch(PDO::FETCH_ASSOC);

        return $row['email'];
    } 
       function checkUsername($username) {
           $select = $this->pdo->prepare("SELECT count(*) FROM `users` WHERE username=?");
           $select->execute(array($username));
           $user_count = $select->fetchColumn();
           //echo $user_count;
           return $user_count;
       }
   
       function getJobType($domain_name) {
           $select = $this->pdo->prepare("SELECT id FROM `Domain` WHERE Name=?");
           $select->execute(array($domain_name));
           $domainId = $select->fetchColumn();
           $select1 = $this->pdo->prepare("SELECT Name FROM `job_type` WHERE domain_id=?");
           $select1->execute(array($domainId));
           $job_type = $select1->fetchAll(PDO::FETCH_COLUMN);
           return $job_type;
           //print_r($job_type);
       }
   
       /* function getJobTypeDropDown() {
         $select = $this->pdo->prepare("SELECT id,Name FROM `Domain`");
         $select->execute(array());
         $domain = $select->fetchAll(PDO::FETCH_ASSOC);
         // print_r($domainId);
         foreach ($domain as $dmn) {
         echo '<option value="" disabled="disabled" style="color: red; font-weight: bold; font-style: italic;">' . $dmn['Name'] . '</option>';
         //echo $dmn['Name'];
         $select1 = $this->pdo->prepare("SELECT id,Name FROM `job_type` WHERE domain_id=?");
         $select1->execute(array($dmn['id']));
         $job_type = $select1->fetchAll(PDO::FETCH_ASSOC);
         foreach ($job_type as $type) {
         echo
         "<option value = '" . $type['id'] . "'>&nbsp;
         &nbsp;
         --" . $type['Name'] . "</option>";
         }
         }
         } */
   
       function getJobTypeDropDown() {
           $select = $this->pdo->prepare("SELECT id,Name FROM `Domain`");
           $select->execute(array());
           $domain = $select->fetchAll(PDO::FETCH_ASSOC);
           // print_r($domainId);
           foreach ($domain as $dmn) {
               echo '<option value="' . $dmn['id'] . '"  font-weight: bold; font-style: italic;">' . $dmn['Name'] . '</option>';
           }
       }
   
       /* function getJobTypeDropDownSelected($job_type_selected) {
         $select = $this->pdo->prepare("SELECT id,Name FROM `Domain`");
         $select->execute(array());
         $domain = $select->fetchAll(PDO::FETCH_ASSOC);
         // print_r($domainId);
         foreach ($domain as $dmn) {
         echo '<option value="" disabled="disabled" style="color: red; font-weight: bold; font-style: italic;">' . $dmn['Name'] . '</option>';
         //echo $dmn['Name'];
         $select1 = $this->pdo->prepare("SELECT id,Name FROM `job_type` WHERE domain_id=?");
         $select1->execute(array($dmn['id']));
         $job_type = $select1->fetchAll(PDO::FETCH_ASSOC);
         foreach ($job_type as $type) {
         if ($job_type_selected == $type['id']) {
         echo
         "<option value = '" . $type['id'] . "' selected='selected'>&nbsp;
         &nbsp;
         --" . $type['Name'] . "</option>";
         } else {
         echo
         "<option value = '" . $type['id'] . "'>&nbsp;
         &nbsp;
         --" . $type['Name'] . "</option>";
         }
         }
         }
         } */
   
       function getJobTypeDropDownSelected($job_type_selected) {
           $select = $this->pdo->prepare("SELECT id,Name FROM `Domain`");
           $select->execute(array());
           $domain = $select->fetchAll(PDO::FETCH_ASSOC);
           foreach ($domain as $dmn) {
               if ($job_type_selected == $dmn['id']) {
                   echo '<option value="' . $dmn['id'] . '"  font-weight: bold; font-style: italic;" selected="selected">' . $dmn['Name'] . '</option>';
               } else {
                   echo '<option value="' . $dmn['id'] . '"   font-weight: bold; font-style: italic;">' . $dmn['Name'] . '</option>';
               }
           }
       }
   
       function getEmployerExport() {
   
            $user_types = $this->getUserTypes();
           $user_type_id = 0;
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'Employer') {
                   $user_type_id = $v['id'];
               }
           }
   
          $query = "SELECT users.*,user_profile.*,(user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) , users.id AS id,user_types.type AS userType ,user_employment.organization,user_employment.current_ctc from users
                           LEFT JOIN user_profile ON users.id = user_profile.user_id LEFT JOIN user_types ON users.user_type = user_types.id LEFT JOIN user_employment ON users.id = user_employment.user_id AND user_employment.current_company = 'yes'
            where user_type=" . $user_type_id . " group by users.id
            order by users.id  ";
           //print_r($query);exit;
           $select = $this->pdo->prepare($query);
           $select->execute();
           return $select->fetchAll(PDO::FETCH_ASSOC);
          
       }
       function getUsersExport() {
   
           $user_types = $this->getUserTypes();
           //$firstArray=array();
           //$secondArray=array();
           $user_type_id = 0;
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'User') {
                   $user_type_id = $v['id'];
               }
           }
   
           $query = "SELECT users.*,user_profile.*,(user_profile.work_exp_years*365)+(user_profile.work_exp_months*31) , users.id AS id,user_types.type AS userType ,user_employment.organization,user_employment.current_ctc from users
                           LEFT JOIN user_profile ON users.id = user_profile.user_id LEFT JOIN user_types ON users.user_type = user_types.id LEFT JOIN user_employment ON users.id = user_employment.user_id AND user_employment.current_company = 'yes'
            where user_type=" . $user_type_id . " 
            order by users.id";
           //print_r($query);exit;
           $select = $this->pdo->prepare($query);
           $select->execute();
           return $select->fetchAll(PDO::FETCH_ASSOC);
       }
    function getJobsExport() {
   
            $select = "SELECT DISTINCT * FROM jobs ORDER BY 	posted_on DESC";
           $res = $this->pdo->query($select);
           return $res->fetchAll(PDO::FETCH_ASSOC);
       }
       function displayEducationDetailstoEmployer($education, $name, $str) {
   
           echo'<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> <tr><th  width="40%"  style="border: none;">' . $name . '</th> </tr>
   <tr><th  width="40%"  style="border: none;">Specialization</th><td style="border: none;">' . $education[0]['specialisation'] . '</td></tr><tr> <th  width="40%"  style="border: none;">School/Institute</th><td style="border: none;">' . $education[0]['school'] . '</td></tr><tr> <th  width="40%"  style="border: none;">University/Board</th><td style="border: none;">' . $education[0]['board'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Percentage/CGPA</th><td style="border: none;">' . $education[0]['percentage'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Marks Obtained</th> <td style="border: none;">' . $education[0]['marks'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Year of Passing</th>   <td style="border: none;">' . $education[0]['passing_year'] . '</td></tr>';
   
   
           echo'</table></div>';
       }
   
       function display12thDetailstoEmployer($education, $name, $str) {
   
           echo'<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> <tr><th  width="40%"  style="border: none;">' . $name . '</th> </tr>
   <tr><th  width="40%"  style="border: none;">Specialization</th><td style="border: none;">' . $education[0]['specialisation'] . '</td></tr><tr> <th  width="40%"  style="border: none;">School/Institute</th><td style="border: none;">' . $education[0]['school'] . '</td></tr><tr> <th  width="40%"  style="border: none;">University/Board</th><td style="border: none;">' . $education[0]['board'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Percentage/CGPA</th><td style="border: none;">' . $education[0]['percentage'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Marks Obtained</th> <td style="border: none;">' . $education[0]['marks'] . '</td></tr>'
           . '<tr>  <th  width="40%"  style="border: none;">Year of Passing</th>   <td style="border: none;">' . $education[0]['passing_year'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Physics Marks</th>   <td style="border: none;">' . $education[0]['physics_marks'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Chemistry Marks</th>   <td style="border: none;">' . $education[0]['chemistry_marks'] . '</td></tr><tr>  <th  width="40%"  style="border: none;">Maths Marks</th>   <td style="border: none;">' . $education[0]['maths_marks'] . '</td></tr>';
   
   
           echo'</table></div>';
           //<div class="col-md-2">	<input type="button" name="edit" value="Edit" id=' . $education[0]['user_id'] . '  edu_find=' . $str . ' class_name=' . $name . ' class="btn btn-info btn-xs edit_education' . $str . '"  /><br/></div>';
       }
   
       function displayGateDetailstoEmployer($education, $name, $str) {
   
           echo '<div class="form-group col-md-10"><table class="table table-bordered" style="border: none;"> <tr><th  width="40%"  style="border: none;">' . $name . '</th> </tr>
   <tr><th  width="40%"  style="border: none;">Domain</th><td style="border: none;">' . $education[0]['domain'] . '</td></tr><tr><th  width="40%"  style="border: none;">All India Rank</th><td style="border: none;">' . $education[0]['all_india_score'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Marks</th><td style="border: none;">' . $education[0]['marks'] . '</td></tr><tr> <th  width="40%"  style="border: none;">Year Of Passing</th><td style="border: none;">' . $education[0]['year_of_passing'] . '</td></tr> </table></div>';
           //<div class="col-md-2">	<input type="button" name="edit" value="Edit" id=' . $education[0]['user_id'] . '  edu_find=' . $str . ' class_name=' . $name . ' class="btn btn-info btn-xs edit_education' . $str . '"  /><br/></div>';
       }
   
       function getUsersForEmployer($data) {
   
           $user_types = $this->getUserTypes();
           $user_type_id = 0;
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'User') {
                   $user_type_id = $v['id'];
               }
           }
           $qualification_id_10th = $this->getQualificationidbyNames('10th');
           $qualification_id_12th = $this->getQualificationidbyNames('12th');
           $qualification_id_be = $this->getQualificationidbyNames('BE');
           $candidate = new candidateSearchforEmployer($user_type_id);
   
           if (!empty($data['location_search'])) {
               $candidate->byLocation(trim($data['location_search']));
           }
           if (!empty($data['education'])) {
               $candidate->byQualification($data['education']);
           }
   
           if (!empty($data['experience'])) {
               $candidate->byExperience($data['experience'], $data['experience_year']);
           }
   
           if (!empty($data['job_type'])) {
               $candidate->byDomain($data['job_type']);
           }
      //print_r($candidate->query($data));exit;
           try {
               $res = $this->pdo->query($candidate->query());
               $data_res = $res->fetchAll(PDO::FETCH_ASSOC);
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return $data_res;
       }
   
   //get employer details
       public function getEmployerDetails($user_id) {
           //echo 'hi';exit;
   
   
           try {
               $select = $this->pdo->prepare("Select users.id,username,password, user_type,email, first_name, middle_name, last_name,mobile_number,email, name_of_company, desgination, firm_address,website,company_email,user_profile.profile_photo  from users  LEFT JOIN user_profile ON users.id = user_profile.user_id where users.id=" . $user_id . "");
   
               $select->execute();
   
               $user_details = $select->fetchAll(PDO::FETCH_ASSOC);
   
   
               return $user_details;
           } catch (Exception $e) {
               echo $e->getMessage();
           }
       }
   
       function updateEmployee($data, $files) {
           $update_qry = $this->pdo->prepare("UPDATE `users` SET  `email`=?, `first_name`=?, `middle_name`=?, `last_name`=?,`mobile_number`=?, `name_of_company`=?, `desgination`=?, `firm_address`=?, `website`=?,`company_email`=? WHERE id = ?");
           $update_qry->execute(array($data['email'], $data['first_name'], $data['middle_name'], $data['lastname'], $data['lastname'], $data['company'], $data['desgination'], $data['address'], $data['website'], $data['cemail'], $data['user_id']));
   
           $photoname = $files['uploadphoto']['name'];
           //$path = $this->createUserFolder($data['user_id']);
           //echo $path;exit;
           //echo $photoname;exit;
           try {
               if (!empty($photoname)) {
                   if ($files['uploadphoto']['type'] == "image/jpg" || $files['uploadphoto']['type'] == "image/jpeg" || $files['uploadphoto']['type'] == "image/gif" || $files['uploadphoto']['type'] == "image/png" || $files['uploadphoto']['type'] == "image/bmp" || $files['uploadphoto']['type'] == "image/tiff") {
                       $photoname = $files['uploadphoto']['name'];
                       $path = $this->createUserFolder($data['user_id']);
   
                       $user_id = $data['user_id'];
   
                       $result = move_uploaded_file($files['uploadphoto']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . '/uploads/photos/' . $user_id . '/' . $photoname);
                       if ($result == 1) {
                           $msg = "<p>Your profile  file uploaded successfully</p>";
   
                           $update_user_profile = $this->pdo->prepare("UPDATE `user_profile` SET  `profile_photo`=? WHERE user_id = ?");
                           $update_user_profile->execute(array($photoname, $data['user_id']));
                       } else {
                           $msg = "<p>Sorry, Error happened while uploading . </p>";
                       }
                       //}#end if($path){
                   } // endIF
               }//i
           } catch (Exception $e) {
               echo $e->getMessage();
           }
           return true;
       }
   
       public function getallEmployerDetails() {
           //echo 'hi';exit;
           $user_types = $this->getUserTypes();
           $user_type_id = 0;
           foreach ($user_types as $k => $v) {
               if ($v['type'] == 'Employer') {
                   $user_type_id = $v['id'];
               }
           }
   
           try {
               $select = $this->pdo->prepare("Select users.id,username,password, user_type,email, first_name, middle_name, last_name,email, name_of_company, desgination, firm_address,website,company_email,user_profile.profile_photo  from users  LEFT JOIN user_profile ON users.id = user_profile.user_id where user_type=" . $user_type_id." order by users.id DESC");
   
               $select->execute();
   
               $user_details = $select->fetchAll(PDO::FETCH_ASSOC);
   
   
               return $user_details;
           } catch (Exception $e) {
               echo $e->getMessage();
           }
       }
   
       function deleteEmployer($id) {
           //echo $id;exit;
           try {
               $this->pdo->delete('users', "id = $id");
               $this->pdo->delete('user_profile', "user_id = $id");
           } catch (PDOException $e) {
               $this->setError($e->getMessage());
               return false;
           }
           return true;
       }
   
   ################################################
   }
   
   //User class ends here	
   ?>
