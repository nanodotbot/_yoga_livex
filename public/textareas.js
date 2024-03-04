const textareas = document.querySelectorAll('.textarea');

textareas.forEach((textarea, index) => {
    textarea.oninput = () => {
        textarea.style.height = '';
        textarea.style.height = textarea.scrollHeight + 1 + "px";
    }
});