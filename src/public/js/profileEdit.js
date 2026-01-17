document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    const imagePreview = document.getElementById('image-preview');
    const imageBefore = document.getElementById('image-before');
    const hiddenInput = document.getElementById('image_preview_hidden');

    // ページ読み込み時に old() または $user->image がある場合は表示
    if (hiddenInput.value || imagePreview.querySelector('img')) {
        imagePreview.style.display = 'block';
        imageBefore.style.display = 'none';
    }

    imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            imagePreview.innerHTML = `<img src="${event.target.result}" alt="preview">`;
            imagePreview.style.display = 'block';
            imageBefore.style.display = 'none';

            hiddenInput.value = event.target.result;
        };
        reader.readAsDataURL(file);
    });
});