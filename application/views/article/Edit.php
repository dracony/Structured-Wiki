<h2>Page Title:</h2>
<input type='text' id='articleTitle' name='articleTitle' value='<?php echo $articleTitle; ?>' />

<h2>Page Summary (<span id='articleSummaryCount'></span>):</h2>
<textarea id='articleSummary' name='articleSummary' class='expanding' maxlength='2048'><?php echo $articleSummary; ?></textarea>

<?php if (count($templateList) > 0) { ?>
<h2>Template<br /><small>(Once a template is choosen and the articlege is created it becomes more difficult to
chane the template. For a change to be made, the article needs to be blank.)</small></h1>
<select id='articleTemplate' name='articleTemplate'>
<?php
foreach ($templateList as $t) {
    if($t->id == $selectedTemplateID) {
        echo "<option value='" . $t->id . "' selected>" . $t->name . " - " . $t->description . "</option>";
    } else {
        echo "<option value='" . $t->id . "'>" . $t->name . " - " . $t->description . "</option>";
    }
}
?>
</select>
<?php } ?>

<?php if (isset($articleSections) > 0) { ?>
<div id='articleSections'>
<?php
foreach ($articleSections as $s) {
    switch ($s->type) {
        case 'sl':
            echo "<h2>" . $s->title . "<button id='add-section-" . $s->id . "' class='addSimpleList'>+</button></h2>";
            echo "<ul class='simpleList'>";
            echo "</ul>";
            break;
        default:
            echo "<h2>" . $s->title . "</h2>";
            echo "<textarea class='markup expanding' id='section-" . $s->id . "' name='section-" . $s->id . "'>" . $s->raw . "</textarea>";
            break;
    }
}
?>
</div>
<?php } ?>

<div id="buttonbar">
    <button>Save Article</button>
</div>

