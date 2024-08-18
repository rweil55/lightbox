<html>

<head>
    <title>Build slide decks</title>
</head>

<body>
    <!-- <a href="make2.php" target="make">make2.php</a> -->
    See Demo at <a href="https://www.lightgalleryjs.com/demos/carousel-gallery/" target="demo">Carousel Gallery</a><br>
    See Documentation at <a href="https://www.lightgalleryjs.com/docs/getting-started/" target="docs">lightGallery geting started</a> <br><br>
    <?php
    $msg = "";
    $direList = array("walks-Collection");
    foreach ($direList as $dire) {
        $msg .= OneLightbox($dire);
    }
    print "$msg<br>Files created on " . date("Y-m-d H:i:s");
    exit(0);

    function OneLightbox($dire, $photographer = "", $photoDate = "")
    {
        $template =  file_get_contents("make2Template.html");
        $template = str_replace("<title>", "<title>$dire", $template);
        $template = str_replace("<h1>", "<h1>$dire", $template);
        $images = "";
        foreach (new DirectoryIterator($dire) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            if ($fileInfo->isDir()) continue;
            $fileName = $fileInfo->getFilename();
            $thumbFilename = "thumbs/thumbs_$fileName";
            if (!file_exists("$dire/$thumbFilename")) {
                $cmd = "convert $dire/$fileName -resize 240x240 $dire/$thumbFilename";
                exec($cmd);
            }

            $images .= "{
                src:
                    '$dire/$fileName?auto=format&fit=crop&w=1400&q=80',
                responsive:
                    '$dire/$fileName?auto=format&fit=crop&w=480&q=80 480, $dire/$fileName?auto=format&fit=crop&w=800&q=80 800',
                thumb:
                    '$dire/thumbs/thumbs_$fileName?auto=format&fit=crop&w=240&q=80',
                subHtml: 
                    `<div class=\"lightGallery-captions\">";
            if ($photographer)
                $images .= "<h4>Photo by <a href=\"$photographer\">$photographer</a></h4>";
            if ($photoDate)
                $images .= "<p>Published on $photoDate</p>";

            $images .= "</div>`
            },
        ";
        }
        $template = str_replace('dynamicEl: [', 'dynamicEl: ['  . $images, $template);

        file_put_contents("$dire.html", $template);
        return "Created <a href='//127.0.0.1/lightbox/$dire.html' target='make'> $dire.html</a><br>";
    }
    ?>

</body>

</html>
