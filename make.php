<html>

<head>
    <title>My First Web Page</title>
    <script src="fslightbox.js"></script>
</head>

<body>
    <?php
    $msg = "";
    $dire = "king-county-park";
    $msg .= OneLightbox($dire);
    print $msg;

    function OneLightbox($dire)
    {
        $file = "<html>
        <head>
        <title>$dire</title>
        <script src='fslightbox.js'></script>
        <style type='text/css'>
        .example-initial-animation {
            animation: initial-animation 2s ease;
        }
        </style>
        </head>
        <body>
            <h1>$dire</h1>
        <script>

var lightbox = new FsLightbox();
lightbox.props.sources = [";
        foreach (new DirectoryIterator($dire) as $fileInfo) {
            if ($fileInfo->isDot()) continue;
            if ($fileInfo->isDir()) continue;
            $filename = $fileInfo->getFilename();
            $file .= "'$dire/$filename',";
        }
        $file = substr($file, 0, -1); // remove last comma
        $file .= "];\n
   /// lightbox.props.showThumbsOnMount = true;
   // lightbox.props.initialAnimation = 'example-initial-animation';
    lightbox.open(0);
";

        /*  

        $file .= "
            lightbox.props.onInit = () => {
                console.log('Lightbox initialized');
            };
            lightbox.props.onOpen = () => {
                console.log('Lightbox opened');
            };
            lightbox.props.onClose = () => {
                console.log('Lightbox closed');
            };
            lightbox.props.onShow = (source) => {
                console.log('Source displayed', source);
            };
            lightbox.props.onClose = () => {
                console.log('Lightbox closed');
            };
            lightbox.props.onLoad = () => {
                console.log('Image loaded');
            };
            lightbox.props.onLoadError = (source) => {
                console.log('Error loading image', source);
            };
            lightbox.props.onSlideChange = (current, next) => {
                console.log('Slide changed', current, next);
            };
            lightbox.props.onAction = (action, source) => {
                console.log('User performed action', action, source);
                */
        $file .= "</script>
      
        </body>
        </html>";
        file_put_contents("$dire.html", $file);
        return "Created <a href='//127.0.0.1/lightbox/$dire.html' target='make'> $dire.html</a><br>";
    }



    ?>

</body>

</html>