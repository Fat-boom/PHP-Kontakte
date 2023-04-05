<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE-edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=PT+Serif&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'PT Serif', serif;
      background-color: #EAEDF8;
      margin: 0;
    }
    .footer {
      padding: 100px;
      text-align: center;
      background-color: red;
      color: white;
      margin-top: 250px;
    }

    .main{
      display: flex;
    }
    .menu{
      width: 20%;
      background-color: green;
      margin-right: 32px;
      padding-top: 150px;
      height: 100vh;
    }

    .menu a {
      display: block;
      text-decoration: none;
      color: black;
      padding: 8px;
      display: flex;
      align-items: center;
    }

    .menu img {
      margin-right: 8px;
    }

    .menu a:hover{
      background-color: rgba(255, 255, 255, 0.1);
    }
    .content{
      width: 80%;
      margin-top: 120px;
      margin-right: 32px;
      background-color: white;
      border-radius: 8px;
      padding: 16px;
      box-shadow : 2px 2px 2px rgb(0, 0, 0, 0.1);

    }

    .menubar {
      background-color: yellow;
      positon: absolute;
      left: 0;
      right:0;
      top: 0;
      height: 80px;
      box-shadow: 2px 2px 2px rgb(0, 0, 0, 0.1);
      padding-left: 50px;
      display: flex;
      justify-content: space-between;
    }
    .avatar {
      border-radius: 100%;
      background-color: pink;
      padding: 16px;
      width: 24px;
      height: 24px;
      display: flex;
      justify-content: center;
      align-items: center;
      margin-right: 8px;
    }

  .Myname{
    display: flex;
    margin-right: 50px;
    align-items: center;
  }

  .card {
    background-color: rgba(0, 0, 0, 0.05);
    margin-bottom: 16px;
    border-radius: 8px;
    padding: 8px;
    padding-left: 64px;
    position: relative;
    
  }

  .profile-picture {
    width: 48px;
    height: 48px;
    border-radius: 50px;
    border: 2px solid white;
    position: absolute;
    left: 8px;
  }
  .phonebutton {
    background-color: yellow;
    padding: 4px;
    color: black;
    text-decoration: underline;
    border-radius: 4px;
    position: absolute;
    right: 0px;
    top: 0px;
  }
  .phonebutton:hover {
    background-color: green;
  }
  .deletebutton {
    background-color: red;
    padding: 4px;
    color: black;
    text-decoration: none;
    border-radius: 4px;
    position: absolute;
    bottom: 0px;
    width: 60px;
    right: 0px;
  }
  </style>
</head>
<body>

<div class = "menubar">
  <h1> My php Projekt!</h1>
<div class="Myname">
  <div class ="avatar"> A</div> Andrej</div>

</div>
<div class = "main">
  <div class="menu">
    <a href='index.php?page=start'><img src="img/home.svg">Start</a>
    <a href='index.php?page=contacts'><img src="img/eyeglasses.svg">Kontakte</a>
    <a href='index.php?page=legal'><img src="img/mood.svg">Impressum</a>
    <a href='index.php?page=newcontacts'><img src="img/login.svg">Kontakte hinzufügen</a>
    <a href='index.php?page=delete'><img src="img/delete.svg">Kontakte gelöscht</a>
  </div>

  <div class="content">

  <?php 
      $headline = 'Herzlich Willkommen';
      $contacts= [];

      if(file_exists('Kontakte.txt')) {
        $text = file_get_contents('Kontakte.txt', true);
        $contacts = json_decode($text, true);
            
      }
      if(isset($_POST['name']) && isset($_POST['phone'])){
        echo 'Kontakt <b>' . $_POST['name'] . '</b> wurde hinzugefügt';
        $newContact = [
          'name' => $_POST['name'],
          'phone'=> $_POST['phone']
        ];
        array_push($contacts, $newContact);
        file_put_contents('Kontakte.txt', json_encode($contacts, JSON_PRETTY_PRINT));
      } 

      if ($_GET['page'] == 'delete') {
        $headline = 'Kontakt gelöscht!';
      }
     
      if($_GET['page'] == 'contacts') {
        $headline = 'Deine Kontakte';
      }

      if($_GET['page'] == 'legal') {
        $headline = 'Impressum';
      }

      if($_GET['page'] == 'newcontacts') {
        $headline = 'Kontakte hinzufügen';
      }
      
      echo '<h1>' . $headline . '</h1>';

      if ($_GET['page'] == 'contacts') {
        if ($_GET['page'] == 'delete') {
            echo '<p>Dein Kontakt wurde gelöscht</p>';
            # Wir laden die Nummer der Reihe aus den URL Parametern
            $index = $_GET['delete']; 

            # Wir löschen die Stelle aus dem Array 
            unset($contacts[$index]); 

            # Tabelle erneut speichern in Datei contacts.txt
            file_put_contents('contacts.txt', json_encode($contacts, JSON_PRETTY_PRINT));
      }
    }
      else if ($_GET['page'] == 'contacts') {
        echo "
            <p>Auf dieser Seite hast du einen Überblick über deine <b>Kontakte</b></p>
        ";

        foreach ($contacts as $row) {
        foreach ($contacts as $index=>$row) {
            $name = $row['name'];
            $phone = $row['phone'];

            echo "
            <div class='card'>
                <img class='profile-picture' src='img/profile-picture.png'>
                <b>$name</b><br>
                $phone
                <a class='phonebtn' href='tel:$phone'>Anrufen</a>
                <a class='deletebtn' href='?page=delete&delete=$index'>Löschen</a>
            </div>
            ";
        }
      }
    }
       else if($_GET['page'] == 'legal') {
        echo '
        Hier kommt das Impressum hin
        ';
       } 

       else if($_GET['page']== 'delete') {
        echo'
        Hier sind die gelöschten Kontakte.
        ';
       }
        
        else if($_GET['page'] == 'newcontacts') {
          echo '
          <div>
          Hier sehen Sie ihre Kontakte
          </div>

          <form action="?page=contacts" method="POST">
            <div>
            <input placeholder="Namen eingeben" name="name">
            </div>
            <div>  
            <input placeholder="Telefonnummer eingeben" name="phone">
            </div>

            
            <button type="submit">Absenden</button>
          </form>
          ';
        }else 
        {
        echo 'Du bist auf der Startseite';
      }
  ?> 

  </div>
</div>
<div class = "footer">
(C) 2023 Developer Andrej
</div>


</body>
</html>