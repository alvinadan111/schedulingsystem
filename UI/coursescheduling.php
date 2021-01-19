<?php session_start();
require '../database.php';

$pdo=Database::connect();

?>

<!DOCTYPE html>
<html>
<head>
     <title>Course Scheduling</title>
      <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     <link rel="stylesheet" href="coursescheduling.css">
     <script src="https://kit.fontawesome.com/a076d05399.js"></script>
     <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>  
</head>
<body>
    <div class="container">
         <form method="post" >
        <table class="table"> 
            <h1 class="textcolor" colspan="3"> Course Scheduling </h1>
            <div class="btncontainer">
                <a class="navtop" href="menu.php"> Home <i class="fas fa-chevron-right"></i> </a>
                <a class="navtop" href="coursescheduling.html"> Course Scheduling </a>
            </div>
            <tr>
                <th colspan="3"> Academic Programs </th>
            </tr>
            <tr>
                <td>
                    <label for="acadprog"> Academic Program </label>
                    <select id="acadprog" name="acadlist"  required>
                   <option value=" " selected disabled></option>
                            <?php
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT acadProgID, progCode FROM academicprog");
                                while ($row = $stmt->fetch()) { ?>

                                <option value="<?php echo $row['acadProgID']; ?>"> <?php echo $row['progCode'];  ?> </option>
                                    
                            <?php }?>     
                    </select>
                     
                </td>
                <td>
                    <label for="level"> Level </label>
                    <select id="level" name="levellist"  required>
                     <option value=" " selected disabled></option>
                            <?php
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT levelID, levelDesc FROM lvl");
                                while ($row = $stmt->fetch()) { ?>

                                <option value="<?php echo $row['levelID']; ?>"> <?php echo $row['levelDesc'];  ?> </option>
                                    
                            <?php }?>   
                    </select>
                </td>
                <td>
                    <label for="period"> Period </label>
                    <select id="period" name="periodlist"  required>
                        <option value=" " selected disabled></option>
                            <?php
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT periodID, periodDesc FROM period");
                                while ($row = $stmt->fetch()) { ?>

                                <option value="<?php echo $row['periodID']; ?>"> <?php echo $row['periodDesc'];  ?> </option>
                                    
                            <?php }?> 
                    </select>
                    <input type="submit" name="btnSearch" value="Search">
                </td>
            </tr>
        </table>
         </form>
        <br>
<?php if(isset($_POST['btnSearch']))
    { 
       if(empty($_POST['periodlist']) || empty($_POST['levellist']) || empty($_POST['acadlist'])){ ?>
 
            </div>
            <!-- Warning Alert -->
            <div id="myAlert" class="alert alert-warning alert-dismissible fade show">
            <strong>Warning!</strong> &nbsp Please make sure all fields are filled.
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            </div>

<?php  }else{ ?>

        <table class="table">
              <thead>
                <tr>
                <th>Course Code</th>
                <th>Description</th>
                <th>Schedule</th>
                <th>Action </th>                      
                </tr>
              </thead>
   <?php
    $pdo=Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $acadlists = $_POST['acadlist'];
    $levellists = $_POST['levellist'];
    $periodlists = $_POST['periodlist'];

     
        $stmt=$pdo->prepare("select course.courseCode, course.courseName from curriculum c 
            left outer join course ON c.courseID=course.courseID 
            left outer join academicprog ON c.acadProgID=academicprog.acadProgID  
            left outer join lvl ON c.levelID=lvl.levelID
            left outer join period ON c.periodID=period.periodID
            where (c.periodID = ?) and (c.levelID = ?) and (c.acadProgID = ?)
            order by curID ");
        $stmt->execute(array($acadlists, $levellists,  $periodlists));
        while ($row = $stmt->fetch()) 
        {
            $courseCode=$row['courseCode'];
            $courseName=$row['courseName'];

    ?>
                <tr>
                <td><?php echo $courseCode;?></td>
                <td><?php echo $courseName;?></td>
                <td></td>
            
                <td style="text-align: center;"> <a href="courseschedulingdata.html" class="btn"><i
                            class="fas fa-edit"></i></a> </td> 
                </tr>
 <?php } } } Database::disconnect(); ?>                       
</table> 
</div>


<!-- bootstrap JS-->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
     $(document).ready(function()
     {
        setTimeout(function (){
            $('#myAlert').hide('fade');
        }, 5000); 

     });
        
    </script>

</body>
</html>