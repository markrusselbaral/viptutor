<template>
  <aside class="w-full md:w-64 bg-white shadow-md px-6 py-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-8">Admin</h1>
    <nav class="space-y-4">
      <a
        href="/admin-dashboard"
        :class="[
          'block font-medium hover:text-blue-600',
          $route.path === '/admin-dashboard' ? 'text-blue-600' : 'text-gray-700',
        ]"
      >
        Dashboard
      </a>
    </nav>
  </aside>
</template>
