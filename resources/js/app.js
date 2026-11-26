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

document.querySelectorAll('[data-toggle-target]').forEach((button) => {
    button.addEventListener('click', () => {
        const target = document.querySelector(button.dataset.toggleTarget);
        if (!target) return;
        target.classList.toggle('hidden');
        button.setAttribute('aria-expanded', String(!target.classList.contains('hidden')));
    });
});

document.querySelectorAll('[data-custom-select]').forEach((select) => {
    const trigger = select.querySelector('[data-select-trigger]');
    const menu = select.querySelector('[data-select-menu]');
    const input = select.querySelector('[data-select-input]');
    const label = select.querySelector('[data-select-label]');
    const options = [...select.querySelectorAll('[data-select-option]')];
    const close = () => {
        menu.classList.add('hidden');
        trigger.setAttribute('aria-expanded', 'false');
    };

    trigger.addEventListener('click', () => {
        const opening = menu.classList.contains('hidden');
        document.querySelectorAll('[data-select-menu]').forEach((other) => other.classList.add('hidden'));
        document.querySelectorAll('[data-select-trigger]').forEach((other) => other.setAttribute('aria-expanded', 'false'));
        menu.classList.toggle('hidden', !opening);
        trigger.setAttribute('aria-expanded', String(opening));
        if (opening) (options.find((option) => option.getAttribute('aria-selected') === 'true') ?? options[0])?.focus();
    });

    options.forEach((option, index) => {
        option.addEventListener('click', () => {
            input.value = option.dataset.value;
            label.textContent = option.querySelector('span').textContent;
            options.forEach((item) => {
                const selected = item === option;
                item.setAttribute('aria-selected', String(selected));
                item.querySelector('[data-select-check]').textContent = selected ? '✓' : '';
            });
            close();
            trigger.focus();
        });
        option.addEventListener('keydown', (event) => {
            if (event.key === 'ArrowDown' || event.key === 'ArrowUp') {
                event.preventDefault();
                options[(index + (event.key === 'ArrowDown' ? 1 : -1) + options.length) % options.length].focus();
            }
        });
    });

    select.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            close();
            trigger.focus();
        }
    });
    document.addEventListener('click', (event) => {
        if (!select.contains(event.target)) close();
    });
});
