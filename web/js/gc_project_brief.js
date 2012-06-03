(function( gc_project_brief, $, undefined ) {

    var imgPath = "/img/";

    //Public Methods
    gc_project_brief.onRemoveTag = function(tag) {
        var project_id = $("form[id^='project']").attr("id").split("-")[1]         
        $.post(Routing.generate('project_remove_tag', { 
                "id": project_id, 
                "tag": tag 
            }
        ));
    }

    gc_project_brief.initSWFUpload = function() {
        console.log("init swfupload: " + Routing.generate('asset_upload', {"id": project_id}) + "?" + $("#session_name").val() + "=" + $("#session_id").val());
        var project_id = $("form[id^='project']").attr("id").split("-")[1]                 
        gc_project_brief.swfu = new SWFUpload({
            // Backend Settings
            upload_url: Routing.generate('asset_upload', {"id": project_id}) + "?" + $("#session_name").val() + "=" + $("#session_id").val(),

            // File Upload Settings
            file_size_limit : "1000 MB",   // 12MB
            file_types : "*.jpg; *.jpeg, *.png; *.gif; *.avi; *.mp4; *.m4v; *.mpg; *.mpeg",
            file_types_description : "Images and Videos",
            file_upload_limit : "0",

            // Event Handler Settings - these functions as defined in Handlers.js
            //  The handlers are not part of SWFUpload but are part of my website and control how
            //  my website reacts to the SWFUpload events.
            file_queue_error_handler : fileQueueError,
            file_dialog_complete_handler : fileDialogComplete,
            upload_progress_handler : uploadProgress,
            upload_error_handler : uploadError,
            upload_success_handler : uploadSuccess,
            upload_complete_handler : uploadComplete,

            // Button Settings
            button_image_url : imgPath + "upload-btn.png",
            button_placeholder_id : "spanButtonPlaceholder",
            button_width: 191,
            button_height: 34,
            // button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
            // button_cursor: SWFUpload.CURSOR.HAND,
            
            // Flash Settings
            flash_url : "/swfupload.swf",

            custom_settings : {
                upload_target : "divFileProgressContainer"
            },
            
            // Debug Settings
            debug: false
        });
    };

    //Private Methods
    function fileQueueError(file, errorCode, message) {
        console.log("fileQueueError: " + message);        
        try {
            var source = $("#file-upload-template").html();
            var template = Handlebars.compile(source);
            if (errorCode === SWFUpload.errorCode_QUEUE_LIMIT_EXCEEDED) {
                errorName = "You have attempted to queue too many files.";
            }

            // if (errorName !== "") {
            //     alert(errorName);
            //     return;
            // }

            switch (errorCode) {
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
                imageName = "zerobyte.gif";
                break;
            case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
                var html = template({percentage: "0", "message": "Sorry, that file is too big!", "messagetype": "alert-error"});
                $("#divFileProgressContainer").html(html);
                break;
            case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
            case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
            default:
                alert(message);
                break;
            }

        } catch (ex) {
            this.debug(ex);
        }

    }

    function fileDialogComplete(numFilesSelected, numFilesQueued) {
        console.log("fileDialogComplete: " + numFilesQueued);        
        try {
            if (numFilesQueued > 0) {
                this.startUpload();
            }
        } catch (ex) {
            this.debug(ex);
        }
    }

    function uploadProgress(file, bytesLoaded) {
        console.log("uploadProgress: " + bytesLoaded);
        try {
            var percent = Math.ceil((bytesLoaded / file.size) * 100);

            var progress = new FileProgress(file,  this.customSettings.upload_target);
            progress.setProgress(100);
            if (percent === 100) {
                progress.setStatus("Creating thumbnail...");
                progress.toggleCancel(false, this);
            } else {
                progress.setStatus("Uploading " + file.name + "...");
                progress.toggleCancel(true, this);
            }
        } catch (ex) {
            this.debug(ex);
        }
    }

    function uploadSuccess(file, serverData) {
        console.log("uploadSuccess");        
        try {
            var progress = new FileProgress(file,  this.customSettings.upload_target);
            var response = JSON.parse(serverData);

            if (response.OK == 1) {
                addRealImage(response.data.uri, response.data.thumb, response.data.id);

                progress.setStatus("Your file is uploaded!");
                progress.toggleCancel(false);
            } else {
                progress.setStatus("Oops! Something went wrong =(");
                progress.toggleCancel(false);
            }

        } catch (ex) {
            this.debug(ex);
        }
    }

    function uploadComplete(file) {
        console.log("uploadComplete");
        try {
            /*  I want the next upload to continue automatically so I'll call startUpload here */
            if (this.getStats().files_queued > 0) {
                this.startUpload();
            } else {
                var progress = new FileProgress(file,  this.customSettings.upload_target);
                progress.setComplete();             
                //progress.toggleCancel(false);
            }
        } catch (ex) {
            this.debug(ex);
        }
    }

    function uploadError(file, errorCode, message) {
        console.log("uploadError: " + message);        
        var imageName =  "error.gif";
        var progress;
        try {
            switch (errorCode) {
            case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
                try {
                    progress = new FileProgress(file,  this.customSettings.upload_target);
                    progress.setCancelled();
                    progress.setStatus("Cancelled");
                    progress.toggleCancel(false);
                }
                catch (ex1) {
                    this.debug(ex1);
                }
                break;
            case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
                try {
                    progress = new FileProgress(file,  this.customSettings.upload_target);
                    progress.setCancelled();
                    progress.setStatus("Stopped");
                    progress.toggleCancel(true);
                }
                catch (ex2) {
                    this.debug(ex2);
                }
            case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
                imageName = "uploadlimit.gif";
                break;
            default:
                alert(message);
                break;
            }

        } catch (ex3) {
            this.debug(ex3);
        }

    }


    function addRealImage(full, thumb, id) {
        var source   = $("#asset-thumbnail-template").html();
        var template = Handlebars.compile(source);
        var context = {id: id, uri: full, thumbUri: thumb}
        var html = template(context);
        var node = $(html);
        var newImg = $(node).find('img')[0];
        $("#thumbnails").append(node);
        if (newImg.filters) {
            try {
                newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
            } catch (e) {
                // If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
                newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 0 + ')';
            }
        } else {
            newImg.style.opacity = 0;
        }

        newImg.onload = function () {
            fadeIn(newImg, 0);
        };
        newImg.src = src;
    }

    function fadeIn(element, opacity) {
        var reduceOpacityBy = 5;
        var rate = 30;  // 15 fps


        if (opacity < 100) {
            opacity += reduceOpacityBy;
            if (opacity > 100) {
                opacity = 100;
            }

            if (element.filters) {
                try {
                    element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
                } catch (e) {
                    // If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
                    element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ')';
                }
            } else {
                element.style.opacity = opacity / 100;
            }
        }

        if (opacity < 100) {
            setTimeout(function () {
                fadeIn(element, opacity);
            }, rate);
        }
    }

    /* ******************************************
     *  FileProgress Object
     *  Control object for displaying file info
     * ****************************************** */

    function FileProgress(file, targetID) {
        var source   = $("#file-upload-template").html();
        this.template = Handlebars.compile(source);
        var context = {percentage: "100", message: "Your file is <strong>Uploading...</strong>", messagetype: "alert-info"}
        var html = this.template(context);

        $("#divFileProgressContainer").html(html);
        this.fileProgressID = "divFileProgress";

    }
    FileProgress.prototype.setProgress = function (percentage) {
        var html = this.template({percentage: percentage, message: "Your file is <strong>Uploading...</strong>", messagetype: "alert-info"});
        $("#divFileProgressContainer").html(html);
    };
    FileProgress.prototype.setComplete = function () {
        var html = this.template({percentage: 100, message: "Your file is <strong>Uploaded!</strong>", messagetype: "alert-success"});
        $("#divFileProgressContainer").html(html).find("div.progress").removeClass("active");
        setTimeout(function(){
            $("#divFileProgress").fadeOut();
        }, 2000);
    };
    FileProgress.prototype.setError = function () {
        var html = this.template({percentage: 0, message: "<strong>Oops!</strong> Something went wrong =(", messagetype: "alert-error"});
        $("#divFileProgressContainer").html(html);        

    };
    FileProgress.prototype.setCancelled = function () {
        var html = this.template({percentage: 0, message: "Your file upload was <strong>Cancelled</strong>", messagetype: ""});
        $("#divFileProgressContainer").html(html);        
    };

    FileProgress.prototype.setStatus = function (status) {
        $("#file-upload-message").html(status);        
    };

    FileProgress.prototype.toggleCancel = function (show, swfuploadInstance) {
        var visibility = show ? "visible" : "hidden";
        $("#divFileProgressContainer").css("visibility", visibility);
        if (swfuploadInstance) {
            var fileID = this.fileProgressID;
            $("#divFileProgressContainer").click(function() {
                swfuploadInstance.cancelUpload(fileID);
                return false;
            });
        }
    };        
 
}( window.gc_project_brief = window.gc_project_brief || {}, jQuery ));


$(document).ready(function() {

    $(".gc-control-label > label").addClass("control-label");
    // $(".gc-radio label").addClass("radio");
    $(".tag-widget").tagsInput({
        'width': '320px',
        'placeholderColor': '#369BD7',
        'onRemoveTag': gc_project_brief.onRemoveTag
    });

    gc_project_brief.initSWFUpload();

    $("#upload-btn").click(function() {
        var project_id = $("form[id^='project']").attr("id").split("-")[1];        
        $.post(Routing.generate('asset_from_web', { "id": project_id }), {
                url: $("#projectDescription_web_upload").val()
            }, function(data) {
                alert("yay!: " + data);
            }, "json"
        );
        return false;
    });

    $(".thumbnail button.close").on("click", function() {
        var project_id = $("form[id^='project']").attr("id").split("-")[1];
        var asset_id = $(this).closest('li').attr('id').split('-')[1];
        $.post(Routing.generate('asset_delete', {'id': project_id, 'aid': asset_id}), function(data) {
            if(data.responseCode == "200") {
                $(this).closest('li').fadeOut(function() {
                    $(this).remove();
                })
            } else {
                alert("error!");
            }
        })
    })  ;

    $(".yoxview").yoxview({ 
        skin: "top_menu",
        backgroundColor: "#ffffff" });
});