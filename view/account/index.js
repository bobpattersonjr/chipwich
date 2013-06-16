$(document).ready(function(){
    $('#bootstrapped-fine-uploader').fineUploader({
          sizeLimit: 10495728,
          request: {
            endpoint: 'account/upload_image',
            forceMultipart: true
          },
          text: {
            uploadButton: '<i class="icon-upload-alt"></i> Upload Photo'
          },
          template: '<br/><div class="qq-uploader">' +
                      '<pre class="qq-upload-drop-area"><span>{dragZoneText}</span></pre>' +
                      '<div class="qq-upload-button btn" style="background: #e6e6e6;color: #333333;width: auto;">{uploadButtonText}</div>' +
                      '<span class="qq-drop-processing"><span>{dropProcessingText}</span><span class="qq-drop-processing-spinner"></span></span>' +
                      '<ul class="qq-upload-list" style="margin-top: 10px; text-align: center;"></ul>' +
                    '</div>'
        });
});