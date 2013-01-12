<!DOCTYPE HTML>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <link rel="stylesheet" href="/<?php echo $cssLayout; ?>" type="text/css" />
        <link rel="stylesheet" href="/layoutCommon.css" type="text/css" />
    </head>
    <body>
        <div class="page">
        <div class="topBar">
        Login
        &nbsp;&nbsp;|&nbsp;&nbsp;
        Register
        </div>
        <div class="pageAttributes">
            <?php include($attributeView); ?>
        </div>
        <?php if ($canEdit === true || $canTalk === true) { ?>
        <div class="pageMenu">
            <?php if($mode === "view") { ?>
            <div class="button selected">View</div>
            <?php } else { ?>
            <div class="button" onclick="window.location.href='/<?php echo $id; ?>'">View</div>
            <?php } ?>
            <?php if ($canEdit === true) { if($mode === "edit") { ?>
            <div class="button selected">Edit</div>
            <?php } else { ?>
            <div class="button" onclick="window.location.href='/edit/<?php echo $id; ?>'">Edit</div>
            <?php } } ?>
            <?php if ($canTalk === true) { if($mode === "talk") { ?>
            <div class="button selected">Talk</div>
            <?php } else { ?>
            <div class="button" onclick="window.location.href='/talk/<?php echo $id; ?>'">Talk</div>
            <?php } } ?>
            
            <?php if($mode === "view") { ?>
            <div class="search">
            Search:&nbsp;&nbsp;
            <input type="text" id="searchItem" />
            </div>
            <?php } else if($mode === "edit") { ?>
            <div class="search">
            Upload File
            </div>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="pageContent">
            <?php include($pageView); ?>
        </div>
        <div class="pageFooter">
            I'm the footer
        </div>
        </div>
    </body>
</html>
