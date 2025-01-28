<script setup lang="ts">

defineProps<{
    order: any
}>();
</script>
<template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-2xl">
        <div class="flex justify-end mb-6">
        <a
          href="/logout"
          class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
        >
          Sair
        </a>
      </div>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Detalhes do Pedido</h1>
  
        <div class="space-y-6">
          <div class="flex justify-between items-center">
            <strong class="text-lg font-semibold text-gray-700">Nome Completo:</strong>
            <span class="text-gray-600">{{ order.fullName }}</span>
          </div>
          <div class="flex justify-between items-center">
            <strong class="text-lg font-semibold text-gray-700">Estado:</strong>
            <span class="text-gray-600">{{ order.state }}</span>
          </div>
          <div class="flex justify-between items-center">
            <strong class="text-lg font-semibold text-gray-700">Cidade:</strong>
            <span class="text-gray-600">{{ order.city }}</span>
          </div>
          <div class="flex justify-between items-center">
            <strong class="text-lg font-semibold text-gray-700">Data de Ida:</strong>
            <span class="text-gray-600">{{ order.departureDate }}</span>
          </div>
          <div class="flex justify-between items-center">
            <strong class="text-lg font-semibold text-gray-700">Data de Volta:</strong>
            <span class="text-gray-600">{{ order.returnDate || 'Não especificado' }}</span>
          </div>
        </div>
      </div>
    </div>
  </template>