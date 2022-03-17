<?php

    if (isset($_POST['submit'])) {
        $file = $_FILES['file'];
        $fileName = $_FILES['file']['name'];
        $filelocation = $_FILES['file']['tmp_name'];
        $uploadPath = "./" . $fileName; 

        $didUpload = move_uploaded_file($filelocation, $uploadPath);

    }

    class MyStruct {
        public $primery;
        public $forinkey;
        public $colum;
    }

    $file = fopen("nosql.sql", "r") or die("Unable to open file!");
    $list = [];

    while(!feof($file)) {
        $line = fgets($file);
        if (strstr($line, "INSERT INTO"))
        {
            $word =  strstr($line, "`");
            $colums = explode(" ", $word);
            array_pop($colums);

            for($i = 0; $i < count($colums); $i++)
                $colums[$i] = trim($colums[$i], "(`,)");

            $filename = "files/" . $colums[0] . ".json";
            array_shift($colums);
            fopen($filename, "w");
            file_put_contents($filename, "[");
            $line = fgets($file);

            while (strstr($line, "(")) {
                $value = explode(" ", $line);
                
                for($i = 0; $i < count($value); $i++) {    
                    $value[$i] = trim($value[$i], "(',) \n");
                }

                $old_content = file_get_contents($filename);
                file_put_contents($filename, $old_content ."\n\t{");

                for($i = 0; $i < count($colums); $i++) {
                        $old_content = file_get_contents($filename);
                        if ($i == count($colums) - 1)
                            file_put_contents($filename, $old_content . "\n". "\t\t\"" .$colums[$i] . "\" : \"" . $value[$i] . "\"");
                        else
                            file_put_contents($filename, $old_content . "\n". "\t\t\"" .$colums[$i] . "\" : \"" . $value[$i] . "\",");
                }

                $old_content = file_get_contents($filename);
                file_put_contents($filename, $old_content ."\n\t},");
                $line = fgets($file);
            }

            $old_content = file_get_contents($filename);
            $old_content = rtrim($old_content, ", ");
            file_put_contents($filename, $old_content . "\n" ."]");
        }

        if (strstr($line, "ALTER TABLE"))
        {
            $table_name = trim(strstr($line, "`"), "` \n");
            $line = fgets($file);

            if (strstr($line, "ADD CONSTRAINT"))
            {
                $obj = new MyStruct();
                
                $obj->primery = $table_name;
                $obj->forinkey = trim(explode(" ",strstr($line, "REFERENCES"))[1], "` \n");
                $obj->colum = trim(explode(" ",strstr($line, "KEY "))[1], "()` \n");

                array_push($list, $obj);
            }
        }
    }

    for($k = 0; $k < count($list); $k++) {
        $key = $list[$k]->colum;
        $string = file_get_contents("./files/" . $list[$k]->primery . ".json");
        $json_a = json_decode($string, true);
    
        $string_b = file_get_contents("./files/" . $list[$k]->forinkey . ".json");
        $json_b = json_decode($string_b, true);
        
        
        for ($j = 0; $j < count($json_a); $j++) {
            $val = array();
            for($i = 0; $i < count($json_b); $i++)
            {
                if (strcmp($json_b[$i]['id'], $json_a[$j][$key]) == 0)
                {
                    array_push($val, $json_b[$i]);
                }
            }
            
            $json_a[$j][$key] = [];
            foreach($val as $item)
            array_push($json_a[$j][$key], $item);
        }

        $filetowrite = $list[$k]->primery . "_" . $list[$k]->forinkey . ".json";
        fopen("./files/relation/" . $filetowrite, "w");
        file_put_contents("./files/relation/" . $filetowrite, json_encode($json_a, JSON_PRETTY_PRINT));
    }

    ?>

<?php
    
    $rootPath = realpath('files');

    
    $zip = new ZipArchive();
    $zip->open('file.zip', ZipArchive::CREATE | ZipArchive::OVERWRITE);

    /** @var SplFileInfo[] $files */
    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($rootPath),
        RecursiveIteratorIterator::LEAVES_ONLY
    );

    foreach ($files as $name => $file)
    {
        if (!$file->isDir())
        {
            $filePath = $file->getRealPath();
            $relativePath = substr($filePath, strlen($rootPath) + 1);

            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download files</title>
    <style>
        * {
            margin: 0;
            padding: 0;

        }
        body {
            width: 100vw;
            height: 100vh;
            display: grid;
            place-content: center;
        }

        .content {
            background-color: #4f8afe;
        }

        a {
            text-decoration: none;
            color: #fff;
            padding: 15px 50px;
            display: block;
        }
    </style>
</head>
<body>
    <div class="content">
        <a href="file.zip" download>download</a>
    </div>
</body>
</html>
