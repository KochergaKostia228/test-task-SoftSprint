const deleteModal = document.getElementById("deleteItemsModal");
const deleteModalBody = document.getElementById("deleteModalBody");

function deleteUser(id) {
  fetch("api/deleteUser.php", {
    method: "POST",
    headers: { "Content-Type": "application/x-www-form-urlencoded" },
    body: `id=${id}`,
  })
    .then(res => res.json())
    .then(data => {
      if (data.status) {
        document.querySelector(`tr[data-id="${id}"]`)?.remove();
      }
    });
}

deleteModal.addEventListener("show.bs.modal", function (event) {
  const trigger = event.relatedTarget;

  if (!trigger) return;

  const userRow = trigger.closest("tr");
  if (!userRow) return;

  const userId = userRow.dataset.id;

  const confirmBtn = document.getElementById("confirmDeleteItemsBtn");

  fetch(`api/getUser.php?id=${userId}`)
    .then(res => res.json())
    .then(data => {
      if (data.status) {
        const user = data.user.user || data.user;

        if (deleteModalBody) {
          deleteModalBody.textContent =
            `Are you sure you want to delete ${user.first_name} ${user.last_name}?`;
        }
      }
    });

  confirmBtn.onclick = function () {
    deleteUser(userId);
    bootstrap.Modal.getInstance(deleteModal).hide();
  };
});