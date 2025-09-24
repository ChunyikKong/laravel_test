<template>
  <div>
    <h1>Testing Users</h1>

    <!-- Create -->
    <form @submit.prevent="createUser">
      <input v-model="newUser.name" placeholder="Name" required />
      <input v-model="newUser.email" placeholder="Email" required />
      <input v-model="newUser.phone_number" placeholder="Phone" required />
      <input v-model="newUser.password" type="password" placeholder="Password" required />
      <select v-model="newUser.status">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
      </select>
      <button type="submit">Add</button>
    </form>
    
    <!-- List -->
    <table border="1">
      <thead>
        <tr>
          <th><input type="checkbox" @change="toggleAll" /></th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="u in users.data" :key="u.id">
          <td><input type="checkbox" v-model="selectedIds" :value="u.id" /></td>
          <td>{{ u.name }}</td>
          <td>{{ u.email }}</td>
          <td>{{ u.phone_number }}</td>
          <td>{{ u.status }}</td>
          <td>
            <button @click="editUser(u)">Edit</button>
            <button @click="deleteUser(u.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <button :disabled="!users.prev_page_url" @click="fetchUsers(users.current_page - 1)">Prev</button>
    <span>Page {{ users.current_page }}</span>
    <button :disabled="!users.next_page_url" @click="fetchUsers(users.current_page + 1)">Next</button>

    <!-- Bulk delete -->
    <button @click="bulkDelete">Delete Selected</button>

    <!-- Edit -->
    <div v-if="editData">
      <h3>Edit</h3>
      <form @submit.prevent="updateUser">
        <input v-model="editData.name" required />
        <input v-model="editData.email" required />
        <input v-model="editData.phone_number" required />
        <select v-model="editData.status">
          <option value="active">Active</option>
          <option value="inactive">Inactive</option>
        </select>
        <button type="submit">Save</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";

const users = ref({ data: [] });
const newUser = ref({ name: "", email: "", phone_number: "", password: "", status: "active" });
const editData = ref(null);
const selectedIds = ref([]);

const API_URL = "http://127.0.0.1:8000/api/testing_users";

const fetchUsers = async (page = 1) => {
  const res = await axios.get(`${API_URL}?page=${page}&status=active`);
  users.value = res.data;
  // console.log(users.value.data);
};

const createUser = async () => {
  await axios.post(API_URL, newUser.value);
  await fetchUsers();
  newUser.value = { name: "", email: "", phone_number: "", password: "", status: "active" };
};

const editUser = (user) => {
  editData.value = { ...user };
};

const updateUser = async () => {
  await axios.put(`${API_URL}/${editData.value.id}`, editData.value);
  editData.value = null;
  await fetchUsers();
};

const deleteUser = async (id) => {
  await axios.delete(`${API_URL}/${id}`);
  await fetchUsers();
};

const bulkDelete = async () => {
  await axios.post(`${API_URL}/bulk-delete`, { ids: selectedIds.value });
  selectedIds.value = [];
  await fetchUsers();
};

const toggleAll = (e) => {
  if (e.target.checked) {
    selectedIds.value = users.value.data.map((u) => u.id);
  } else {
    selectedIds.value = [];
  }
};

onMounted(fetchUsers);
</script>
