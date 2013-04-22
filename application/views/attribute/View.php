<div class='pageImage'>
    <img src='<?php echo $pageImage; ?>' />
    <label>Hello World</label>
</div>

<?php
foreach ($articleAttributes as $a) {
    if ($a->type == "hdr") {
        echo "<h1>" . $a->title . "</h1>";
    } else {
        if ($a->value != "") {
            echo "<div class=\"row\">";
            switch($a->type) {
                default:
                    echo "<label>" . $a->title . "</label>";
                    echo "<data>" . $a->value . "</data>";
                    break;
            }
            echo "</div>";
        }
    }
}
?>

<h1>Article Information</h1>
<div class="row">
    <label>Template</label>
    <data><a href="!<?php echo $articleTemplate ?>"><?php echo $articleTemplate ?></a></data>
</div>
<div class="row">
    <label>Last Updated</label>
    <data><?php echo $lastUpdated ?></data>
</div>
