<html>
    <head>
        <title><?php echo $browserTitle; ?></title>
        <link rel="stylesheet" href="/css/layoutCommon.css" type="text/css" />
        <link rel="stylesheet" href="/css/layoutSpecial.css" type="text/css" />
        <script type="text/javascript" src="/js/jquery-1.8.3.min.js"></script>
    </head>
    <body>
        <div class="page">
        <form id='specialForm' method='post'>
            <?php if (isset($pageView) && $pageView != '') { include($pageView); } ?>
        </form>
        <div class="pageFooter">
            I'm the footer
        </div>
        </div>
    </body>
</html>