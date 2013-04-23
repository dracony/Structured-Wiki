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
            echo "<input type='hidden' id='section-" . $s->id . "' name='section-" . $s->id . "' />";
            echo "<ul id='list-section-" . $s->id . "' class='sortable simpleList'>";
            if ($s->raw != "") {
            $items = json_decode($s->raw);
            foreach ($items as $i) {
                ?>
<li class='ui-state-default' data-can-delete='yes'>
<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>
<span class='order'></span>
<span class='title'><?php echo $i[1]; ?></span>
<span class='editTitle'><input value='<?php echo $i[1]; ?>'/></span>
<input type='hidden' value='' />
<button>-</button>
</li>
                <?php
            }
            }
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



<div id='tmpSimpleList' class='template'>
<li class='ui-state-default' data-can-delete='yes'>
<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>
<span class='order'></span>
<span class='title'>Untitled</span>
<span class='editTitle'><input value='Untitled'/></span>
<input type='hidden' value='' />
<button>-</button>
</li>
</div>
