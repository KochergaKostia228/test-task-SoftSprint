import { roleMap } from "./roles.js";

const userId = document.getElementById("userId");
const firstName = document.getElementById("firstName");
const lastName = document.getElementById("lastName");
const statusUser = document.getElementById("statusSwitch");
const roleUser = document.getElementById("userRole");

const tableBody = document.getElementById("usersTable");
const addUserBtn = document.getElementById("addUserBtn");
const form = document.getElementById("userForm");
const userTitle = document.getElementById("userModalLabel");

let editMode = false;

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const url = editMode
    ? "api/editUser.php?id=" + userId.value
    : "api/createUser.php";
  const userTitleText = editMode ? "Edit User" : "Create User";

  fetch(`${url}`, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      id: userId.value || null,
      first_name: firstName.value,
      last_name: lastName.value,
      status: statusUser.checked ? 1 : 0,
      role: roleUser.value,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status) {
        if (editMode) {
          editUser(data.user);
        } else {
          createUser(data.user);
        }

        const checkboxes = tableBody.querySelectorAll('input[type="checkbox"]');
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });

        const checkAll = document.getElementById("allCheck");
        if (checkAll) {
          checkAll.checked = false;
        }
      }
    });
});

document.addEventListener("click", (e) => {
  const button = e.target.closest(".btn-edit");
  if (!button) return;

  editMode = true;

  userTitle.textContent = "Edit User";

  const userRow = button.closest("tr");
  const dataId = userRow.getAttribute("data-id");

  fetch(`api/getUser.php?id=${dataId}`)
    .then((res) => res.json())
    .then((data) => {
      if (!data.status) return;

      const user = data.user;

      userId.value = user.id;
      firstName.value = user.first_name;
      lastName.value = user.last_name;
      statusUser.checked = user.status == 1 ? true : false;
      roleUser.value = user.role;
    });
});

addUserBtn.addEventListener("click", () => {
  editMode = false;
  userId.value = "";
  userTitle.textContent = "Create User";
  form.reset();
});

function createUser(user) {
  let html = `
    <tr data-id="${user.id}">
      <th scope="row">
          <input class='form-check-input row-check' type='checkbox'>
      </th>
      <td class="first_name">${user.first_name}</td>
      <td class="last_name">${user.last_name}</td>
      <td class="status d-flex align-items-center">
          <div class="${user.status ? 'bg-success' : 'bg-secondary'} rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
          
          </div>
      </td>
      <td class="role">${roleMap[user.role]}</td>
      <td>
          <button type="button" class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#userModal">
              Edit
          </button>
          <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
              Delete
          </button>
      </td>
    </tr>
  `

  tableBody.insertAdjacentHTML("beforeend", html);

  closeModal();
}

function editUser(user) {
  const userRow = document.querySelector(`tr[data-id="${user.id}"]`);
  userRow.innerHTML = `
        <th scope="row">
            <input class='form-check-input row-check' type='checkbox'>
        </th>
        <td class="first_name">${user.first_name}</td>
        <td class="last_name">${user.last_name}</td>
        <td class="status d-flex align-items-center">
            <div class="${user.status ? 'bg-success' : 'bg-secondary'} rounded-circle d-flex align-items-center justify-content-center" style="width: 20px; height: 20px;">
            
            </div>
        </td>
        <td class="role">${roleMap[user.role]}</td>
        <td>
            <button type="button" class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#userModal">
                Edit
            </button>
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                Delete
            </button>
        </td>
    `;

  closeModal();
}

function closeModal() {
  const modalElement = document.getElementById("userModal");

  const modal = bootstrap.Modal.getInstance(modalElement);

  modal.hide();

  form.reset();

  editMode = false;

  userId.value = "";
}
