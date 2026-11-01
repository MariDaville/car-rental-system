// This script handles the image preview functionality for the vehicle registration form.
// // It allows users to select multiple images, validates the file types and sizes, and displays a preview of the selected images in a card format.
// The first image is marked as the primary image with a badge.
document.addEventListener('DOMContentLoaded', function () {

    const imageInput = document.getElementById('vehicle_images');
    const imagePreview = document.getElementById('imagePreview');

    if (!imageInput || !imagePreview) {
        return;
    }

    imageInput.addEventListener('change', function () {

        imagePreview.innerHTML = '';

        const files = Array.from(this.files);

        if (files.length > 10) {
            alert('You can select a maximum of 10 images.');
            this.value = '';
            return;
        }

        const allowedTypes = [
            'image/jpeg',
            'image/png',
            'image/webp'
        ];

        files.forEach(function (file, index) {

            if (!allowedTypes.includes(file.type)) {
                alert('Only JPEG, PNG and WebP images are allowed.');
                imageInput.value = '';
                imagePreview.innerHTML = '';
                return;
            }

            if (file.size > 5 * 1024 * 1024) {
                alert('Each image must not exceed 5 MB.');
                imageInput.value = '';
                imagePreview.innerHTML = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {

                const column = document.createElement('div');
                column.className = 'col-6 col-md-4 col-lg-3';

                const card = document.createElement('div');
                card.className = 'card h-100 shadow-sm';

                const image = document.createElement('img');
                image.src = event.target.result;
                image.className = 'card-img-top';
                image.style.height = '150px';
                image.style.objectFit = 'cover';

                const body = document.createElement('div');
                body.className = 'card-body p-2 text-center';

                const label = document.createElement('small');
                label.className = 'text-muted d-block text-truncate';
                label.textContent = file.name;

                body.appendChild(label);

                if (index === 0) {
                    const badge = document.createElement('span');
                    badge.className = 'badge bg-primary mt-2';
                    badge.textContent = 'Primary Image';
                    body.appendChild(badge);
                }

                card.appendChild(image);
                card.appendChild(body);
                column.appendChild(card);

                imagePreview.appendChild(column);
            };

            reader.readAsDataURL(file);

        });

    });

});
