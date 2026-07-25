// Dark Mode Initialization
if (
  localStorage.getItem('color-theme') === 'dark' ||
  (!localStorage.getItem('color-theme') &&
    window.matchMedia('(prefers-color-scheme: dark)').matches)
) {
  document.documentElement.classList.add('dark');
} else {
  document.documentElement.classList.remove('dark');
}

// Alpine.js Initialization
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();
