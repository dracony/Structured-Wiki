$(document).ready(function() {

    // Limit textareas
	$('textarea[maxlength]').keyup(function(){
		//get the limit from maxlength attribute
		var limit = parseInt($(this).attr('maxlength'));
		//get the current text inside the textarea
		var text = $(this).val();
		//count the number of characters in the text
		var chars = text.length;

		//check if there are more characters then allowed
		if(chars > limit){
			//and if there are use substr to get the text before the limit
			var new_text = text.substr(0, limit);

			//and change the current text with the new text
			$(this).val(new_text);
		}
		
		// Update counters
		$('#' + $(this).attr('id') + 'Count').html(chars + '/' + limit);
	});
	
	
	// Initilize counters
	$('textarea[maxlength]').each(function() {
		//get the limit from maxlength attribute
		var limit = parseInt($(this).attr('maxlength'));
		//get the current text inside the textarea
		var text = $(this).val();
		//count the number of characters in the text
		var chars = text.length;

		$('#' + $(this).attr('id') + 'Count').html(chars + '/' + limit);
	});
	
	
	// Initilize order of sortables
    UpdateListCounts();

	// turn on sortable items
    $(".sortable").sortable({
        placeholder: "ui-state-highlight", 
        update : function(event, ui) {
            UpdateListCounts();
        }
    });
    $(".sortable").disableSelection();
    $(document).on('change', '.sortable > li > select', function(e) {
        UpdateListCounts();
    });
        
    
    // Add to list buttons
    $('.addSimpleList').on('click', function(e) {
        $('#tmpSimpleList li').clone().appendTo('#' + $(this).attr('id').replace('add-', 'list-'));
        UpdateListCounts();
        e.preventDefault();
    });
    
    // Edit
   $(document).on('click', '.sortable > li > .title', function(e) {
        $(this).hide();
        $(this).parent().children('.editTitle').show().children('input').focus();
    });
   $(document).on('blur', '.sortable > li > .editTitle > input', function(e) {
        $(this).parent().hide();
        $(this).parent().parent().children('.title').show().html($(this).val());
        UpdateListCounts();
    });
    
    // Delete
   $(document).on('click', '.sortable > li > button', function(e) {
        if ($(this).parent().attr('data-can-delete') === 'yes') {
            $(this).parent().remove();
            UpdateListCounts();
        } else {
            alert('This item is in use by at least one page so it can not be removed.');
        }
        e.preventDefault();
    });
    
    ////
    // Attributes
    ////
    
    
    // Date
    $('.attribute-date').datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd'
    });
    
    // Integers
    $('.attribute-int').spinner({
        numberFormat: 'n'
    });

});

// Update the order values on the list and
// update the lists json data
function UpdateListCounts() {
    $(".sortable").each(function(index) {
        $(this).children("li").each(function(index) {
            $(this).children(".order").text(index + 1);
        });
    });
    UpdateSimpleListData();
}

// Store the sections list in json
function UpdateSimpleListData() {
    $(".simpleList").each(function(index) {
        var data = Array();
        $(this).children("li").each(function(index) {
            $(this).children(".order").text(index + 1);
            data[index] = Array(index, $(this).children(".title").html());
        });
        var dataText = JSON.stringify(data, null, 2);
        $('#' + $(this).attr('id').replace('list-', '')).val(dataText);
    });
}


