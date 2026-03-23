<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - IndusRent</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-filter.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @stack('styles')
</head>
<body class="admin-body">
    <div class="admin-wrap">
        @include('admin.partials.sidebar')

        <main class="admin-main">
            @include('admin.partials.header')

            <div class="admin-content">
                @if(session('message'))
                    <div class="admin-alert admin-alert-success">{{ session('message') }}</div>
                @endif
                @yield('content')
            </div>
        </main>
    </div>

    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/translations/vi.js"></script>
    <script>
        class Base64UploadAdapter {
            constructor(loader) {
                this.loader = loader;
            }
            
            upload() {
                return this.loader.file.then(file => new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = function() {
                        resolve({ default: reader.result });
                    };
                    reader.onerror = function(error) {
                        reject(error);
                    };
                    reader.readAsDataURL(file);
                }));
            }
            
            abort() {
                // Abort upload
            }
        }
        
        function Base64UploadAdapterPlugin(editor) {
            editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
                return new Base64UploadAdapter(loader);
            };
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            const textareas = document.querySelectorAll('textarea.tinymce-editor');
            
            textareas.forEach(function(textarea) {
                ClassicEditor
                    .create(textarea, {
                        extraPlugins: [Base64UploadAdapterPlugin],
                        toolbar: {
                            items: [
                                'undo', 'redo',
                                '|', 'heading',
                                '|', 'bold', 'italic', 'underline',
                                '|', 'link', 'imageUpload', 'blockQuote',
                                '|', 'bulletedList', 'numberedList',
                                '|', 'outdent', 'indent',
                                '|', 'alignment'
                            ],
                            shouldNotGroupWhenFull: true
                        },
                        language: 'vi',
                        image: {
                            toolbar: [
                                'imageTextAlternative', '|',
                                'imageStyle:inline', 'imageStyle:block', 'imageStyle:side'
                            ],
                            styles: [
                                'inline', 'block', 'side'
                            ]
                        },
                        heading: {
                            options: [
                                { model: 'paragraph', title: 'Đoạn văn', class: 'ck-heading_paragraph' },
                                { model: 'heading2', view: 'h2', title: 'Tiêu đề 2', class: 'ck-heading_heading2' },
                                { model: 'heading3', view: 'h3', title: 'Tiêu đề 3', class: 'ck-heading_heading3' }
                            ]
                        }
                    })
                    .then(editor => {
                        const form = textarea.closest('form');
                        if (form) {
                            form.addEventListener('submit', function(e) {
                                textarea.value = editor.getData();
                            });
                        }
                    })
                    .catch(error => {
                        console.error('CKEditor initialization error:', error);
                    });
            });
        });
    </script>
    <style>
        .ck-editor__editable {
            min-height: 400px;
        }
        .ck.ck-editor {
            margin-bottom: 16px;
        }
        .ck-content img {
            max-width: 100%;
            height: auto;
        }
    </style>
    
    <script src="{{ asset('js/admin-image-validator.js') }}"></script>
    <script src="{{ asset('js/admin-image-preview.js') }}"></script>
    <script src="{{ asset('js/cascading-location.js') }}"></script>
    <script src="{{ asset('js/admin-filter.js') }}"></script>
    @stack('scripts')
</body>
</html>
