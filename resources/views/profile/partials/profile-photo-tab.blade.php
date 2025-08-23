<div class="bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-6">Profile Photo</h3>
        
        <!-- Success Messages -->
        @if(session('status') === 'photo-updated')
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
                Profile photo updated successfully.
            </div>
        @endif
        
        @if(session('status') === 'photo-deleted')
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 p-3 text-sm text-green-800 dark:border-green-900/40 dark:bg-green-900/20 dark:text-green-200">
                Profile photo deleted successfully.
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Current Profile Photo -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Current Photo</h4>
                <div class="flex flex-col items-center space-y-4">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100 dark:bg-gray-700 border-4 border-white dark:border-gray-600 shadow-lg">
                            @if($user->profile_photo_path && file_exists(public_path($user->profile_photo_path)))
                                <img src="{{ asset($user->profile_photo_path) }}" 
                                     alt="{{ $user->name }}" 
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-red-400 to-red-600">
                                    <span class="text-white text-2xl font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        @if($user->profile_photo_path)
                            <div class="absolute -bottom-2 -right-2">
                                <form method="POST" action="{{ route('profile.photo.delete') }}" 
                                      onsubmit="return confirm('Are you sure you want to delete your profile photo?')"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="flex items-center justify-center w-8 h-8 bg-red-500 hover:bg-red-600 text-white rounded-full shadow-lg transition duration-150 ease-in-out">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                        @if($user->profile_photo_path)
                            Click the delete button to remove your photo
                        @else
                            Upload a new photo to get started
                        @endif
                    </p>
                </div>
            </div>

            <!-- Upload New Photo -->
            <div class="space-y-4">
                <h4 class="text-md font-medium text-gray-900 dark:text-gray-100">Upload New Photo</h4>
                
                <!-- Image Preview Area -->
                <div id="preview-container" class="hidden">
                    <div class="relative w-full max-w-sm mx-auto">
                        <div class="w-64 h-64 mx-auto border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden bg-gray-50 dark:bg-gray-700">
                            <img id="preview-image" src="" alt="Preview" class="w-full h-full object-cover">
                        </div>
                        <div class="mt-4 flex justify-center space-x-2">
                            <button type="button" 
                                    id="crop-button" 
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Crop Image
                            </button>
                            <button type="button" 
                                    id="cancel-button" 
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Upload Options -->
                <div id="upload-options" class="space-y-4">
                    <!-- Camera Option -->
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-sm font-medium text-gray-900 dark:text-gray-100">Take a Photo</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Use your camera to take a new profile photo</p>
                                <button type="button" 
                                        id="camera-button" 
                                        class="mt-2 inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    </svg>
                                    Open Camera
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Option -->
                    <div class="border border-gray-300 dark:border-gray-600 rounded-lg p-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h5 class="text-sm font-medium text-gray-900 dark:text-gray-100">Choose from Device</h5>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Upload an image from your device</p>
                                <div class="mt-2">
                                    <label for="file-upload" class="cursor-pointer inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        Choose File
                                    </label>
                                    <input id="file-upload" 
                                           name="profile_photo" 
                                           type="file" 
                                           class="sr-only" 
                                           accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Camera Modal -->
                <div id="camera-modal" class="fixed inset-0 z-50 hidden overflow-y-auto">
                    <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
                        </div>
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                        <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                <div class="sm:flex sm:items-start">
                                    <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100 mb-4">
                                            Take a Photo
                                        </h3>
                                        <div class="mt-2">
                                            <video id="camera-video" class="w-full rounded-lg" autoplay playsinline></video>
                                            <canvas id="camera-canvas" class="hidden"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="button" 
                                        id="capture-button" 
                                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Capture
                                </button>
                                <button type="button" 
                                        id="close-camera" 
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-gray-600 shadow-sm px-4 py-2 bg-white dark:bg-gray-800 text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Form -->
                <form id="photo-upload-form" 
                      method="POST" 
                      action="{{ route('profile.photo.update') }}" 
                      enctype="multipart/form-data" 
                      class="hidden">
                    @csrf
                    <input type="hidden" id="cropped-image" name="profile_photo">
                </form>

                <!-- File size and format info -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                                Photo Requirements
                            </h3>
                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Maximum file size: 2MB</li>
                                    <li>Supported formats: JPEG, PNG, JPG, WEBP</li>
                                    <li>Recommended: Square images work best</li>
                                    <li>Minimum resolution: 200x200 pixels</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Cropper.js for image cropping -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<script>
let cropper = null;
let stream = null;

document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file-upload');
    const previewContainer = document.getElementById('preview-container');
    const previewImage = document.getElementById('preview-image');
    const uploadOptions = document.getElementById('upload-options');
    const cropButton = document.getElementById('crop-button');
    const cancelButton = document.getElementById('cancel-button');
    const cameraButton = document.getElementById('camera-button');
    const cameraModal = document.getElementById('camera-modal');
    const cameraVideo = document.getElementById('camera-video');
    const cameraCanvas = document.getElementById('camera-canvas');
    const captureButton = document.getElementById('capture-button');
    const closeCameraButton = document.getElementById('close-camera');
    const photoUploadForm = document.getElementById('photo-upload-form');
    const croppedImageInput = document.getElementById('cropped-image');

    // File input change handler
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                showPreview(e.target.result);
            };
            reader.readAsDataURL(file);
        }
    });

    // Camera button handler
    cameraButton.addEventListener('click', function() {
        openCamera();
    });

    // Close camera handlers
    closeCameraButton.addEventListener('click', closeCamera);
    cameraModal.addEventListener('click', function(e) {
        if (e.target === cameraModal) {
            closeCamera();
        }
    });

    // Capture photo
    captureButton.addEventListener('click', function() {
        capturePhoto();
    });

    // Crop button handler
    cropButton.addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 300,
                imageSmoothingQuality: 'high'
            });
            
            canvas.toBlob(function(blob) {
                const reader = new FileReader();
                reader.onload = function() {
                    const base64 = reader.result;
                    // Create a temporary file input with the cropped image
                    const dataTransfer = new DataTransfer();
                    const file = new File([blob], 'profile-photo.jpg', { type: 'image/jpeg' });
                    dataTransfer.items.add(file);
                    
                    // Create a new form data and submit
                    const formData = new FormData();
                    formData.append('profile_photo', file);
                    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                    
                    fetch('{{ route("profile.photo.update") }}', {
                        method: 'POST',
                        body: formData
                    }).then(response => {
                        if (response.ok) {
                            window.location.reload();
                        }
                    });
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg', 0.9);
        }
    });

    // Cancel button handler
    cancelButton.addEventListener('click', function() {
        hidePreview();
    });

    function showPreview(imageSrc) {
        previewImage.src = imageSrc;
        previewContainer.classList.remove('hidden');
        uploadOptions.classList.add('hidden');
        
        if (cropper) {
            cropper.destroy();
        }
        
        cropper = new Cropper(previewImage, {
            aspectRatio: 1,
            viewMode: 1,
            guides: false,
            center: false,
            highlight: false,
            background: false,
            autoCropArea: 0.8,
            movable: true,
            rotatable: true,
            scalable: true,
            zoomable: true,
            cropBoxMovable: true,
            cropBoxResizable: true,
        });
    }

    function hidePreview() {
        previewContainer.classList.add('hidden');
        uploadOptions.classList.remove('hidden');
        fileInput.value = '';
        
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    async function openCamera() {
        try {
            stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: { ideal: 1280 }, 
                    height: { ideal: 720 },
                    facingMode: 'user'
                } 
            });
            cameraVideo.srcObject = stream;
            cameraModal.classList.remove('hidden');
        } catch (error) {
            alert('Camera access denied or not available');
        }
    }

    function closeCamera() {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
            stream = null;
        }
        cameraModal.classList.add('hidden');
    }

    function capturePhoto() {
        const canvas = cameraCanvas;
        const video = cameraVideo;
        
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0);
        
        const imageData = canvas.toDataURL('image/jpeg', 0.9);
        
        closeCamera();
        showPreview(imageData);
    }
});
</script>