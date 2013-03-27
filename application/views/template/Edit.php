<form method='post'>
<h2>Template Name:<br /><small>(No spaces permitted, names are care insensitive but are case preserving)</small></h2>
<input type='text' id='templateName' name='templateName' value='<?php echo $templateName; ?>' />
<h2>Description (<span id='templateDescriptionCount'></span>):<br /><small>(Please briefly describe what this kinds of pages this template should be used for)</small></h2>
<textarea id='templateDescription' name='templateDescription' class='expanding' maxlength='512'><?php echo $templateDescription; ?></textarea>
<h2>Sections:<br /><small>(Every page has a summary, there is no need to add a summary section)</small><button id="btnAddSection">+</button></h2>
<input type='hidden' id='templateSections' name='templateSections' value='' />
<ol id='lstSections' class='sortable'>
<?php
foreach ($templateSections as $s) {
    echo "<li class='ui-state-default' data-can-delete='no'>";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>" . $s['name'] . "</span>";
    echo "<span class='editTitle'><input value='" . $s['name'] . "'/></span>";
    echo "<select>";
    echo "<option value='mu'>Markup</option>";
    echo "<option value='sl'>Simple List</option>";
    echo "<option value='dt'>Data Table</option>";
    echo "<option value='ig'>Image Gallery</option>";
    echo "<select>";
    echo "<input type='hidden' value='" . $s['name'] . "' />";
    echo "<button>-</button>";
    echo "</li>";
}
?>
</ol>
<h2>Attributes:<button id="btnAddAttribute">+</button></h2>
<ol id='lstAttributes' class='sortable smallColumns'>
<?php
    echo "<li class='ui-state-default'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>" . $s['name'] . "</span>";
    echo "<span class='editTitle'><input value='" . $s['name'] . "'/></span>";
    echo "<select>";
    echo "<option value='date'>Date</option>";
    echo "<option value='int'>Integer</option>";
    echo "<option value='float'>Decimal</option>";
    echo "<option value='cur'>Currency</option>";
    echo "<option value='text'>Text</option>";
    echo "<option value='page'>Link to Page</option>";
    echo "<option value='img'>Image</option>";
    echo "<option value='sep'>Separator</option>";
    echo "<select>";
    echo "<input type='hidden' value='" . $s['name'] . "' />";
    echo "<button>-</button>";
    echo "</li>";
?>
</ol>

<div id="buttonbar">
    <button>Save Template</button>
</div>


<?php
    echo "<div id='tmpAttribute' class='template'>";
    echo "<li class='ui-state-default' data-can-delete='yes'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>Untitled</span>";
    echo "<span class='editTitle'><input value='Untitled'/></span>";
    echo "<select>";
    echo "<option value='date'>Date</option>";
    echo "<option value='int'>Integer</option>";
    echo "<option value='float'>Decimal</option>";
    echo "<option value='cur'>Currency</option>";
    echo "<option value='text'>Text</option>";
    echo "<option value='page'>Link to Page</option>";
    echo "<option value='img'>Image</option>";
    echo "<option value='sep'>Separator</option>";
    echo "<select>";
    echo "<button>-</button>";
    echo "<input type='hidden' value='' />";
    echo "</li>";
    echo "</div>";

    echo "<div id='tmpSection' class='template'>";
    echo "<li class='ui-state-default' data-can-delete='yes'><span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>Untitled</span>";
    echo "<span class='editTitle'><input value='Untitled'/></span>";
    echo "<select>";
    echo "<option value='mu'>Markup</option>";
    echo "<option value='sl'>Simple List</option>";
    echo "<option value='dt'>Data Table</option>";
    echo "<option value='ig'>Image Gallery</option>";
    echo "<select>";
    echo "<button>-</button>";
    echo "<input type='hidden' value='' />";
    echo "</li>";
    echo "</div>";
?>

</form>

