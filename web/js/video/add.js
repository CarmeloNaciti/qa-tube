$(function() {
    var $mediaObjectStory = $('#media_object_story');

    $mediaObjectStory.on('blur', function() {
        $.ajax({
            'url' : Routing.generate('_jira_get_story', {'story' : $mediaObjectStory.val()})
        }).success(function(result) {
            result = $.parseJSON(result);

            if ("storyData" in result) {
                populateFormData(result.storyData);
                $('#storyError').text("");
            } else {
                $('#storyError').text(result.message);
            }
        });
    });
});

function populateFormData(data) {
    $('#media_object_title').val(data.summary);
    $('#media_object_description').val(data.description);
    // $('#media_object_user').val(data.assignee);
    //$('#media_object_tags');
    //$('#media_object_team');
}