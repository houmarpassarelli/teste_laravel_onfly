<script setup lang="ts">
  import { useForm } from '@inertiajs/vue3';

  const form = useForm({
    email: '',
    password: '',
    remember: false,
  });

  const submit = () => {
    form.post(route('login'), {
      onFinish: () => {
        form.reset('password');
      },
    });
  };
</script>

<template>
  <section class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-lg">
      <div class="text-center mb-6">
        <h2>Acesso</h2>
      </div>
      <form role="form" class="space-y-4" @submit.prevent="submit">
        <div>
          <input 
            v-model="form.email"
            type="email" 
            placeholder="Email" 
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
            :class="{'border-red-500': form.errors.email}"
          />
          <span v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</span>
        </div>
        <div>
          <input 
            v-model="form.password"
            type="password" 
            placeholder="Senha" 
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500" 
            :class="{'border-red-500': form.errors.password}"
          />
          <span v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</span>
        </div>
        <div class="text-center">
          <button 
            type="submit" 
            class="bg-blue-500 text-white py-2 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Acessar
          </button>
        </div>
      </form>
      <div class="flex justify-between mt-6">
        <a href="/register" class="text-sm text-blue-500 hover:underline">Criar nova conta</a>
      </div>
    </div>
  </section>
</template>