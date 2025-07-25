<template>
  <div>
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Users Overview</h3>
    <div class="overflow-x-auto bg-white rounded-xl shadow">
      <table class="min-w-full text-left text-sm text-gray-600">
        <thead class="bg-gray-100 text-gray-700 font-medium">
          <tr>
            <th class="px-6 py-3">Name</th>
            <th class="px-6 py-3">Email</th>
            <th class="px-6 py-3">Total Tasks</th>
            <th class="px-6 py-3">Completed</th>
            <th class="px-6 py-3">Pending</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="user in users.data"
            :key="user.id"
            class="border-b hover:bg-gray-50"
          >
            <td class="px-6 py-3">{{ user.name }}</td>
            <td class="px-6 py-3">{{ user.email }}</td>
            <td class="px-6 py-3">{{ user.tasks.length }}</td>
            <td class="px-6 py-3 text-green-600">
              {{ user.tasks.filter((t) => t.status === 'completed').length }}
            </td>
            <td class="px-6 py-3 text-yellow-600">
              {{ user.tasks.filter((t) => t.status === 'pending').length }}
            </td>
            <td class="px-6 py-3">
              <button
                class="text-blue-600 hover:underline cursor-pointer"
                @click="$emit('view-tasks', user)"
              >
                View Tasks
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="flex justify-center items-center gap-2 mt-4 px-4 flex-wrap">
      <button
        v-for="link in users.links"
        :key="link.label"
        :disabled="!link.url"
        @click="$emit('paginate', getPageFromUrl(link.url))"
        class="px-3 py-1 rounded border text-sm transition"
        :class="[
          link.active
            ? 'bg-blue-500 text-white border-blue-500'
            : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100',
          !link.url ? 'opacity-50 cursor-not-allowed' : '',
        ]"
        v-html="link.label"
      ></button>
    </div>
  </div>
</template>

<script setup>
const props = defineProps(['users'])
const getPageFromUrl = (url) => new URL(url).searchParams.get('page') || 1
</script>
