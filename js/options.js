const errorOptionsModalBody = document.getElementById("errorOptionsModalBody");


function fetchSelectedUsers(ids, status) {
  const formData = new FormData();

  ids.forEach(id => formData.append("ids[]", id));
  formData.append("status", status);

  fetch("api/editStatusUsers.php", {
    method: "POST",
    body: formData
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status) {
        ids.forEach((id) => {
          const userRow = document.querySelector(`tr[data-id="${id}"]`);
          if (userRow) {
            const statusCell = userRow.querySelector(".status");
            if (statusCell) {
              statusCell.innerHTML = `<div class="status ${status == 1 ? "active" : ""} rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;"></div>`;
            }
          }
        });

        const checkboxes = tableUser.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });

        const checkAll = document.getElementById("allCheck");
        if (checkAll) {
          checkAll.checked = false;
        }
      }
    });
}

function deleteSelectedUsers(ids) {
  const formData = new FormData();

  ids.forEach(id => formData.append("ids[]", id));
  formData.append("status", status);

  fetch("api/deleteUsers.php", {
    method: "POST",
    body: formData
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.status) {
        data.user.ids.forEach((id) => {
          const userRow = document.querySelector(`tr[data-id="${id}"]`);
          if (userRow) {
            userRow.remove();
          }
        });

        const checkAll = document.getElementById("allCheck");
        if (checkAll) {
          checkAll.checked = false;
        }
      }
    });
}

document.querySelectorAll(".options-block").forEach((block) => {
  const optionsBtn = block.querySelector(".optionsBtn");

  const optionsSelector = block.querySelector(".optionsSelector");

  optionsBtn.addEventListener("click", () => {
    const selectedOption = optionsSelector.value;

    const modalElement = document.getElementById("optionsErrorModal");

    if (selectedOption === "none") {
      if (errorOptionsModalBody) {
        errorOptionsModalBody.textContent = "Please select an option.";
      }

      if (!modalElement) return;

      bootstrap.Modal.getOrCreateInstance(modalElement).show();

      return;
    }

    const selectedUserIds = Array.from(
      document.querySelectorAll(".row-check:checked"),
    )
      .map((cb) => cb.closest("tr")?.dataset.id)
      .filter(Boolean);

    if (selectedUserIds.length === 0) {
      if (errorOptionsModalBody) {
        errorOptionsModalBody.textContent = "Please select at least one user.";
      }

      if (!modalElement) return;

      bootstrap.Modal.getOrCreateInstance(modalElement).show();

      return;
    }

    if (selectedOption === "delete") {
      const modalElement = document.getElementById("deleteItemsModal");
      const confirmBtn = document.getElementById("confirmDeleteItemsBtn");

      if (!modalElement) return;

      const deleteItemsModalBody = document.getElementById("deleteModalBody");
      if (deleteItemsModalBody) {
        deleteItemsModalBody.textContent = `Are you sure you want to delete ${selectedUserIds.length} selected user(s)?`;
      }

      bootstrap.Modal.getOrCreateInstance(modalElement).show();

      confirmBtn.onclick = function () {
        deleteSelectedUsers(selectedUserIds);
        const modal = bootstrap.Modal.getInstance(modalElement);
        modal.hide();
      };
    } else {
      fetchSelectedUsers(selectedUserIds, selectedOption);
    }
  });
});
