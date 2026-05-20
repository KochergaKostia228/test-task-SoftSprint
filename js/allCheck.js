const allCheck = document.getElementById('allCheck');
const tableUser = document.getElementById('usersTable');

allCheck.addEventListener('change', () => {
    const checkboxes = tableUser.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        checkbox.checked = allCheck.checked;
    });
});

tableUser.addEventListener('change', (e) => {
    if (e.target.type === 'checkbox') {
        const checkboxes = tableUser.querySelectorAll('input[type="checkbox"]');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        allCheck.checked = allChecked;
    }
});