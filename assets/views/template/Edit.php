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
    if ($s->inuse === 0) {
        echo "<li class='ui-state-default' data-can-delete='yes'>";
    } else {
        echo "<li class='ui-state-default' data-can-delete='no'>";
    }
    echo "<input type='hidden' value='" . $s->title . "' />";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>" . $s->title . "</span>";
    echo "<span class='editTitle'><input value='" . $s->title . "'/></span>";
    if ($s->inuse === 0) {
        echo "<select class='type'>";
        if($s->type === 'mu') {
            echo "<option value='mu' selected>Markup</option>";
        } else {
            echo "<option value='mu'>Markup</option>";
        }
        if($s->type === 'sl') {
            echo "<option value='sl' selected>Simple List</option>";
        } else {
            echo "<option value='sl'>Simple List</option>";
        }
        if($s->type === 'dt') {
            echo "<option value='dt' selected>Data Table</option>";
        } else {
            echo "<option value='dt'>Data Table</option>";
        }
        if($s->type === 'ig') {
            echo "<option value='ig' selected>Image Gallery</option>";
        } else {
            echo "<option value='ig'>Image Gallery</option>";
        }
        echo "<select>";
        echo "<button>-</button>";
    } else {
        echo "<input type='hidden' class='type' value='" . $s-> type . "' />";
    }
    echo "</li>";
}
?>
</ol>
<h2>Attributes:<br /><small>(Each attribute is a single definitive item, a brithdate, coordinates, name, etc.)</small><button id="btnAddAttribute">+</button></h2>
<input type='hidden' id='templateAttributes' name='templateAttributes' value='' />
<ol id='lstAttributes' class='sortable smallColumns'>
<?php
foreach ($templateAttributes as $a) {
    if ($s->inuse === 0) {
        echo "<li class='ui-state-default' data-can-delete='yes'>";
    } else {
        echo "<li class='ui-state-default' data-can-delete='no'>";
    }
    echo "<input type='hidden' value='" . $a->title . "' />";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>" . $a->title . "</span>";
    echo "<span class='editTitle'><input value='" . $a->title . "'/></span>";
    if ($a->inuse === 0) {
        echo "<select class='type'>";
        if($a->type === 'date') {
            echo "<option value='date' selected>Date</option>";
        } else {
            echo "<option value='date'>Date</option>";
        }
        if($a->type === 'int') {
            echo "<option value='int' selected>Integer</option>";
        } else {
            echo "<option value='int'>Integer</option>";
        }
        if($a->type === 'float') {
            echo "<option value='float' selected>Decimal</option>";
        } else {
            echo "<option value='float'>Decimal</option>";
        }
        if($a->type === 'cur') {
            echo "<option value='cur' selected>Currency</option>";
        } else {
            echo "<option value='cur'>Currency</option>";
        }
        if($a->type === 'text') {
            echo "<option value='text' selected>Text</option>";
        } else {
            echo "<option value='text'>Text</option>";
        }
        if($a->type === 'link') {
            echo "<option value='link' selected>Link to Page</option>";
        } else {
            echo "<option value='link'>Link to Page</option>";
        }
        if($a->type === 'img') {
            echo "<option value='img' selected>Image</option>";
        } else {
            echo "<option value='img'>Image</option>";
        }
        if($a->type === 'hdr') {
            echo "<option value='hdr' selected>Header</option>";
        } else {
            echo "<option value='hdr'> Header </option>";
        }
        echo "<select>";
        echo "<button>-</button>";
    } else {
        echo "<input type='hidden' class='type' value='" . $a->type . "' />";
    }
    echo "<input type='hidden' value='" . $s->title . "' />";
    echo "</li>";
}
?>
</ol>

<div id="buttonbar">
    <button>Save Template</button>
</div>


<?php
    echo "<div id='tmpAttribute' class='template'>";
    echo "<li class='ui-state-default' data-can-delete='yes'>";
    echo "<input type='hidden' value='-' />";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>Untitled</span>";
    echo "<span class='editTitle'><input value='Untitled'/></span>";
    echo "<select class='type'>";
    echo "<option value='date' selected>Date</option>";
    echo "<option value='int'>Integer</option>";
    echo "<option value='float'>Decimal</option>";
    echo "<option value='cur'>Currency</option>";
    echo "<option value='text'>Text</option>";
    echo "<option value='link'>Link to Page</option>";
    echo "<option value='img'>Image</option>";
    echo "<option value='hdr'>Header</option>";
    echo "<select>";
    echo "<input type='hidden' value='' />";
    echo "<button>-</button>";
    echo "</li>";
    echo "</div>";

    echo "<div id='tmpSection' class='template'>";
    echo "<li class='ui-state-default' data-can-delete='yes'>";
    echo "<input type='hidden' value='-' />";
    echo "<span class='ui-icon ui-icon-arrowthick-2-n-s'></span>";
    echo "<span class='order'></span>";
    echo "<span class='title'>Untitled</span>";
    echo "<span class='editTitle'><input value='Untitled'/></span>";
    echo "<select class='type'>";
    echo "<option value='mu' selected>Markup</option>";
    echo "<option value='sl'>Simple List</option>";
    echo "<option value='dt'>Data Table</option>";
    echo "<option value='ig'>Image Gallery</option>";
    echo "<select>";
    echo "<input type='hidden' value='' />";
    echo "<button>-</button>";
    echo "</li>";
    echo "</div>";
?>

</form>

