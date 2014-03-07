/*
 * Project Name:            blog
 * Project Description:     force add file
 */
$(function(){
    
    var checkAddFile_1  = false,
        checkAddFile_2  = false,
        checkTitle      = false,
        embedFile       = "li.embed-item",
        $buttonAddFile  = $(".embed-control-blog_description"),
        $videoTitle     = $("input#blog_title");
    $buttonAddFile.click(function(e){
       checkAddFile_1 = true;
    });
    $("body").delegate(embedFile, "click", function(e){
       checkAddFile_2 = true;
    });
    $("form.elgg-form-blog-save").submit(function(){
        var errors = [];
        if($videoTitle.val().length == 0){
            errors.push(elgg.echo('forceAddFile:title'));
        } else {
            checkTitle = true;
        }
        if(!checkAddFile_1 || !checkAddFile_2){
            errors.push(elgg.echo('forceAddFile:filerequired'));
        }
        if(checkAddFile_1 && checkAddFile_2 && checkTitle){
            return true;
        } else {
            var errorsString = "";
            for(var i=0; i<errors.length; i++){
                errorsString+= errors[i] + "\n";
            }
            alert(errorsString);
            return false; 
        }
    });
    
});