<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sql to nosql</title>
    <link rel="stylesheet" href="./css/style.css">
    <style>
      body {
        display: flex;
        flex-direction: column;
      }

      .submit {
        padding: 15px 50px;
        background: #4f8afe;
        border: none;
        color: white;
        margin-top: 20px;
        cursor: pointer;
      }
    </style>
</head>
<body>
    <label for="file">
<div class="container">
  <div class="main-box">
      
    <div class="box-content">
      <div class="svg">
        <svg width="66" height="57" viewBox="0 0 66 57" fill="none">
                        <path d="M2.70977 0H19.4194C20.2733 0 21.0742 0.402215 21.5857 1.08315L25.3821 6.14266C25.8937 6.82361 26.6946 7.22581 27.5484 7.22581H62.3226C63.8185 7.22581 65.0323 8.43956 65.0323 9.93548V53.2903C65.0323 54.7862 63.8185 56 62.3226 56H2.70968C1.21376 56 0 54.7862 0 53.2903V2.70968C0 1.21375 1.21385 0 2.70977 0Z"
                            transform="translate(0.0177612 0.740387)" fill="#4F8AFE" />
                    </svg>
      </div>
      <div class="text">
        <p class="title">Upload File </p>
        <span>Sql to NOsql</span>
      </div>
      <div class="dots">
        <div></div>
        <div></div>
        <div></div>
      </div>
    </div>
    
  </div>
</div>
</label>

<form action="relation.php" method="post"  enctype="multipart/form-data">
    <input type="file" name="file" style="display: none" id="file">
    <input type="submit" name="submit" class="submit" value="convert">
</form>
</body>
</html>