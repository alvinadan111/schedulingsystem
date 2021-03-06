<?php
session_start();


require 'database.php';
$isRegistered = false;
$isDuplicated = false;
$isIncomplete = false;

if(isset($_POST['add'])){

    $pdo=Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $FN = $_POST['First_Name'];
    $MN = $_POST['Middle_Name'];
    $LN = $_POST['Last_Name'];
    $ID = $_POST['ID_Number'];
    $pw = $_POST['pas'];
    
    if( empty($_POST['departmentlist']) || empty($_POST['questions'])){
 
        $isIncomplete = true;
 
    }else{
        $dept = $_POST['departmentlist'];
        $question = $_POST['questions'];
        $ans = $_POST['Answer'];


        $q = $pdo->prepare("SELECT * FROM account where idNum = ? ");
        $q->execute(array($ID));
        $result = $q->rowCount();

        if($result > 0){
           $isDuplicated = true;
        }else{

            $stmt = $pdo->prepare("INSERT INTO account (FName, MName, LName, idNum, dept,  pw, accessLevel, secretQuestion, answer)
            VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($FN,$MN,$LN,$ID,$dept,$pw,"student",$question,$ans));
            $isRegistered = true;
            header("refresh:3; url = index.php");
        }
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="UI/AddAccount.css">
    <title>Registration</title>
  </head>
  <body>
  <h1 class="h1"> Add Student Account </h1> 
    <div class="btncontainer">
        <a class="navtop" href="index.php" > Login <i class="fas fa-chevron-right"></i> </a>
        <a class="navtop" href="addAccount.php" > Add Student's Account </a>
    </div>
    <div class="container">
        <form class="container2" method = "POST">

            <table>

                <tr>
                    <td><input type="text" placeholder="First Name" name="First_Name" required></td>
                    <td><input type="text" placeholder="Middle Name" name="Middle_Name"></td>
                    <td><input type="text" placeholder="Last Name" name="Last Name" required></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="text" placeholder="Username" name="ID_Number" required></td>
                </tr>
                <tr>
                    <td colspan="3"><input type="password" placeholder="Password" name="pas" required></td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align:left" > 
                        <label for="department"> Department </label>
                        <select id="department" name="departmentlist">

                            <option value=" " selected disabled></option>
                                <?php
                                $pdo=Database::connect();
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt = $pdo->query("SELECT deptID, deptName FROM department");
                                while ($row = $stmt->fetch()) { ?>

                            <option value="<?php echo $row['deptID']; ?>"> <?php echo $row['deptName'];  ?> </option>
                                    
                            <?php }?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:left">
                        <label for="question" title = "If you forget your password, We'll ask for your secret answer to verify your identity">Secret Question:</label>
                        <select name="questions">
                            <option value=" " selected disabled></option>
                            <option value="What is your childhood nickname?">What is your childhood nickname?</option>
                            <option value="What is the name of the first school you attended?">What is the name of the first school you attended?</option>
                            <option value="What is your first pet's name?">What is your first pet's name?</option>
                        </select>
                    </td>
                </tr>
                <tr><td colspan="3"><input type="text" placeholder="Answer" name="Answer" required></td></tr>
                <tr>
                    <td colspan="3">
                        <button type="submit" name = "add" class="addbtn">Add Account</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="bootstrap/js/sweetalert.min.js"></script>
      
    <?php if($isDuplicated == true){ ?>
        <script>
            swal({
            title: "Duplicate Username",
            text: "Username already registered",
            icon: "error",
            });
    </script>
    <?php }  ?>
    <?php if($isRegistered == true){ ?>
        <script>
            swal({
            title: "Successfully Registered",
            text: "Proceed to Login",
            icon: "success",
            });
    </script>
    <?php }  ?>
    <?php if($isIncomplete == true){ ?>
        <script>
            swal({
            title: "Incomplete input",
            text: "Please fill up all required fields",
            icon: "warning",
            });
    </script>
    <?php }  ?>

  </body>
</html>