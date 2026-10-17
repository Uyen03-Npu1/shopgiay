document.querySelectorAll('form').forEach(form => {
  form.addEventListener('submit', () => {
    const btn = form.querySelector('button[type="submit"], button.btn');
    if (btn && !form.action.includes('add_to_cart')) {
      btn.dataset.oldText = btn.innerText;
      btn.innerText = 'Đang xử lý...';
    }
  });
});