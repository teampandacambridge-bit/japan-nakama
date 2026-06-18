// document.addEventListener('DOMContentLoaded', () => {
//     const triggers = document.querySelectorAll('.faq__trigger');

//     triggers.forEach((trigger) => {
//         trigger.addEventListener('click', () => {
//             const content = document.getElementById(trigger.getAttribute('aria-controls'));
//             const isOpen = trigger.getAttribute('aria-expanded') === 'true';

//             // Close all others (single-open mode)
//             triggers.forEach((other) => {
//                 if (other !== trigger) {
//                     other.setAttribute('aria-expanded', 'false');
//                     const otherContent = document.getElementById(other.getAttribute('aria-controls'));
//                     otherContent.hidden = true;
//                     otherContent.classList.remove('is-open');
//                     otherContent.style.maxHeight = null;
//                 }
//             });

//             // Toggle current
//             if (isOpen) {
//                 trigger.setAttribute('aria-expanded', 'false');
//                 content.style.maxHeight = null;
//                 content.classList.remove('is-open');
//                 setTimeout(() => { content.hidden = true; }, 300);
//             } else {
//                 content.hidden = false;
//                 trigger.setAttribute('aria-expanded', 'true');
//                 // Force reflow then animate
//                 requestAnimationFrame(() => {
//                     content.classList.add('is-open');
//                     content.style.maxHeight = content.scrollHeight + 'px';
//                 });
//             }
//         });
//     });
// });
