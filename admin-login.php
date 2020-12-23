<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/geral.css">
    <link rel="stylesheet" href="css/admin.css">
    <title>11Champions-Admin</title>

</head>
<body>

<main>
    <div class="center">
        <div class="form">
            <form method="post" action="admin-login.php">

                <label> Inserir e-mail: <input type="email" name="mail"></label>
                <br>
                <label> Inserir password: <input type="password" name="pass"></label>
                <br>
                <input type="submit" name="submit" value="Submeter">
            </form>
        </div></div>

    <?php
    $str= "host=localhost port=5432 dbname=11champions user=postgres password=postgres";
    $conn = pg_connect($str) or die("Erro na ligação");

    if(isset($_POST['submit'])){

        $mail=$_POST['mail'];
        $pass=$_POST['pass'];

        $user = pg_query($conn, "select * from admin where email='".$mail."' and password='".$pass."'") or die;
        $count = pg_affected_rows($user);
        //se algum corresponder ao query a count será 1
        if($count ==1) {
         header("location: admin.php");
            echo "<p>certo</p>";
      }
        else {
            echo "<p>errado</p>";
      }
   }
    pg_close($conn);

    ?>

</main>

</body>
</html>

