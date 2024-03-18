<html>

<head>
    <title>My First Web Page</title>
</head>

<body>
    <?php
    $msg = "";
    $dire = "king-county-park";
    $msg .= OneLightbox($dire);
    print $msg . date("Y-m-d H:i:s");

    function OneLightbox($dire)
    {
        $template =  file_get_contents("makeTemplate.html");
        $template = str_replace("<title>", "<title>$dire", $template);
        $images = "\n";
        foreach (new DirectoryIterator($dire) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            if ($fileInfo->isDir()) continue;
            $fileName = $fileInfo->getFilename();
            $images .= "<a href='$dire/$fileName' data-lg-size='1600-2400'>
            <img alt='file Name is $fileName' src='$dire/thumbs/thumbs_$fileName' />
        </a>
        ";
        }
        $template = str_replace('dynamicEl: [', 'dynamicEl: [' . $images, $template);

        file_put_contents("$dire.html", $template);
        return "Created <a href='//127.0.0.1/lightbox/$dire.html' target='make'> $dire.html</a><br>";
    }
    ?>

</body>

</html>