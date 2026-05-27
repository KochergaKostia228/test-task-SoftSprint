const deleteModal = document.getElementById("deleteModal");
const deleteModalBody = document.getElementById("deleteModalBody");

function deleteUser(id) {
  fetch("api/deleteUser.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: id }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status) {
        document.querySelector(`tr[data-id="${id}"]`).remove();
      }
    });
}

deleteModal.addEventListener("show.bs.modal", function (event) {
  const userRow = event.relatedTarget.closest("tr");
  const userId = userRow.getAttribute("data-id");

  const confirmBtn = document.getElementById("confirmDeleteBtn");

  fetch(`api/getUser.php?id=${userId}`)
    .then((res) => res.json())
    .then((data) => {
      if (data.status) {
        const user = data.user;
        if (deleteModalBody) {
          deleteModalBody.textContent = `Are you sure you want to delete ${user.first_name} ${user.last_name}?`;
        }
      }
    });

  confirmBtn.onclick = function () {
    deleteUser(userId);

    const modal = bootstrap.Modal.getInstance(deleteModal);
    modal.hide();

    const checkboxes = tableUser.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach((checkbox) => {
      checkbox.checked = false;
    });

    const checkAll = document.getElementById("allCheck");
    if (checkAll) {
      checkAll.checked = false;
    }
  };
});
