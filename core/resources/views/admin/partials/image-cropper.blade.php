@php
	$inputFile      = $inputFile ?? '#image';
	$inputImageData = $inputImageData ?? 'image-data';
	$previewer      = $previewer ?? '#img-preview';
	$cropRatio      = $cropRatio ?? 1;
@endphp

<link rel="stylesheet" href="{{asset('/assets/admin/css/cropper.min.css')}}" />
<style type="text/css">
	.image-upload .thumb .profilePicPreview { height: auto !important; }
</style>
<script type="text/javascript" src="{{asset('/assets/admin/js/cropper.min.js')}}"></script>

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="img-container">
                <img id="croppable-image" src="https://avatars0.githubusercontent.com/u/3456749">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="crop">Crop</button>
            </div>
        </div>
    </div>
</div>

<script>
    'use strict';
    window.addEventListener('DOMContentLoaded', function () {
        var avatar = $("{{$previewer}}")[0];
        var image = $('#croppable-image')[0];
        var input = $("{{$inputFile}}");
        var $modal = $('#modal');
        var cropper;

        $(document).on('change', "{{$inputFile}}", function (e) {
            var files = e.target.files;
            var done = function (url) {
                input.value = '';
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;

            if (files && files.length > 0) {
                file = files[0];

                if (URL) {
                    done(URL.createObjectURL(file));
                } 
                else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });

        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: {{$cropRatio}},
                viewMode: 2,
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });

        $(document).on('click', '#crop', function () {
            var initialAvatarURL;
            var canvas;

            $modal.modal('hide');

            if (cropper) {
                canvas = cropper.getCroppedCanvas({
                    // width: 800,
                    // height: 600,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high',
                });

                initialAvatarURL = avatar.src;
                input.value = avatar.src = canvas.toDataURL('image/jpeg', 1);

                $("{{$inputImageData}}").val(input.value);

                // canvas.toBlob(function (blob) {
                //     $('#postImageUpload').val('');
                //     input.value = blob;
                //     $('#postImageUpload').val(blob);
                // });
            }
        });
    });
</script>