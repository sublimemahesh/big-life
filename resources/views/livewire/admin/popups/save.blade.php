<div>
    <div class="card">
        <div class="card-body">
            <form class="theme-form" enctype="multipart/form-data" wire:submit.prevent="save">
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="title">Title</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="title" placeholder="Title" type="text" wire:model.lazy="popup.title">
                        @error('popup.title')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="start_date">Start Date</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="start_date" placeholder="Start Date" type="date" wire:model.lazy="popup.start_date">
                        @error('popup.start_date')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="end_date">End Date</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="end_date" placeholder="End Date" type="date" wire:model.lazy="popup.end_date">
                        @error('popup.end_date')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                {{--<div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="image">Image</label>
                    <div class="col-sm-9">
                        <input class="form-control" id="image" type="file" accept="image/*" placeholder="Select Image">
                        @error('image')
                        <span class="text-danger mt-2">{{ $message }}</span>
                        @enderror
                        @if ($image && !$errors->has('image'))
                            <img class="img-thumbnail mt-2" src="{{ $image }}" width="300" alt="">
                        @elseif (!empty($popup->image_name))
                            <img class="img-thumbnail mt-2" src="{{ storage('popups/' . $popup->image_name) }}" width="300" alt="">
                        @endif
                    </div>
                </div>--}}
                <div class="form-group row mb-2">
                    <label class="col-sm-3 col-form-label" for="is_active">IS ACTIVE</label>
                    <div class="col-sm-9">
                        <div class="form-check custom-checkbox mb-3 check-xs">
                            <input type="checkbox" wire:model.lazy="popup.is_active" class="form-check-input" name="is_active" id="is_active">
                            <label class="form-check-label" for="is_active"></label>
                        </div>
                    </div>
                    @error('popup.is_active')
                    <span class="text-danger mt-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group row mb-2">
                    <div class="col-sm-12">
                        <label for="content">Content</label>
                        <textarea class="form-control" wire:model.lazy="popup.content" id="content" cols="30" rows="10"></textarea>
                    </div>
                </div>
                @error('popup.content')
                <span class="text-danger mt-2">{{ $message }}</span>
                @enderror


                <div class="form-group row">
                    <div class="col-sm-12">
                        <div class="loader pt-4" wire:loading.delay>
                            <div class="line bg-info"></div>
                            <div class="line bg-info"></div>
                            <div class="line bg-info"></div>
                            <div class="line bg-info"></div>
                        </div>
                        <button type="submit" class="btn btn-primary" wire:loading.remove>Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
        <script>
            // let image = document.getElementById('image')
            // // Upload a file:
            // image.addEventListener("change", (e) => {
            //     let file = e.target.files[0];
            //     canvasResize(file, {
            //         width: 1980,
            //         crop: false,
            //         quality: 80,
            //         //rotate: 90,
            //         callback: function (data, width, height) {
            //             @this.
            //             set('image', data)
            //             image.value = ''
            //         }
            //     });
            // });

            document.addEventListener("DOMContentLoaded", function () {
                initTinymce();
            })

            const initTinymce = () => {
                tinymce.init({
                    selector: 'textarea#content',
                    plugins: 'image code table lists',
                    toolbar: 'undo redo | link image | code | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | table',
                    /* enable title field in the Image dialog*/
                    image_title: true,
                    /* enable automatic uploads of images represented by blob or data URIs*/
                    automatic_uploads: true,
                    /*
                      URL of our upload handler (for more details check: https://www.tiny.cloud/docs/configure/file-image-upload/#images_upload_url)
                      images_upload_url: 'postAcceptor.php',
                      here we add custom filepicker only to Image dialog
                    */
                    file_picker_types: 'image',
                    /* and here's our custom image picker*/
                    file_picker_callback: function (cb, value, meta) {
                        var input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');

                        /*
                          Note: In modern browsers input[type="file"] is functional without
                          even adding it to the DOM, but that might not be the case in some older
                          or quirky browsers like IE, so you might want to add it to the DOM
                          just in case, and visually hide it. And do not forget do remove it
                          once you do not need it anymore.
                        */

                        input.onchange = function () {
                            var file = this.files[0];

                            var reader = new FileReader();
                            reader.onload = function () {
                                /*
                                  Note: Now we need to register the blob in TinyMCEs image blob
                                  registry. In the next release this part hopefully won't be
                                  necessary, as we are looking to handle it internally.
                                */
                                var id = 'blobid' + (new Date()).getTime();
                                var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                                var base64 = reader.result.split(',')[1];
                                var blobInfo = blobCache.create(id, file, base64);
                                blobCache.add(blobInfo);

                                /* call the callback and populate the Title field with the file name */
                                cb(blobInfo.blobUri(), {title: file.name});
                            };
                            reader.readAsDataURL(file);
                        };

                        input.click();
                    },
                    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }',
                    setup: (editor) => {
                        editor.on('init', (e) => {
                            console.log('The Editor has initialized.');
                        });
                        editor.on('blur', (e) => {
                            let content = tinymce.get("content").getContent();
                            @this.
                            set('popup.content', content);
                        });
                    }
                });
            }

            Livewire.hook('message.processed', (message, component) => {
                console.log('message.processed', component.serverMemo.data.popup)
                initTinymce();
                component.serverMemo.data.popup.content && tinymce.get('content').setContent(component.serverMemo.data.popup.content || '');
            });
        </script>
    @endpush
</div>
