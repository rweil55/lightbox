<html>

<head>
    <title>My First Web Page</title>
</head>

<body>
    <?php
    $msg = "";
    $direList = array("Gordon-Collection", "Holland-Commuters", "Josh-Collection", "King-County-Park", "They-Working", "Yockactomac-Trek");
    foreach ($direList as $dire) {
        $msg .= OneLightbox($dire);
    }
    print $msg . date("Y-m-d H:i:s");

    function OneLightbox($dire, $photographer = "", $photoDate = "")
    {
        $template =  file_get_contents("make2Template.html");
        $template = str_replace("<title>", "<title>$dire", $template);
        $template = str_replace("<h1>", "<h1>$dire", $template);
        $images = "\n";
        if (!is_dir($dire))
            return "No such directory $dire<br>";
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
                    '/$dire/$fileName?auto=format&fit=crop&w=1400&q=80',
                responsive:
                    '/$dire/$fileName?auto=format&fit=crop&w=480&q=80 480, $dire/$fileName?auto=format&fit=crop&w=800&q=80 800',
                thumb:
                    '/$dire/thumbs/thumbs_$fileName?auto=format&fit=crop&w=240&q=80',
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