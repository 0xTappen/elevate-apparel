document.querySelectorAll('[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (event) => {
        if (!window.confirm(form.dataset.confirm)) event.preventDefault();
    });
});

document.querySelectorAll('[data-image-input]').forEach((input) => {
    input.addEventListener('change', () => {
        const preview = document.querySelector(input.dataset.imageInput);
        if (preview && input.files[0]) preview.src = URL.createObjectURL(input.files[0]);
    });
});
