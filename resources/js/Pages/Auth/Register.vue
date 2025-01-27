<script setup lang="ts">
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => {
            form.reset('password', 'password_confirmation');
        },
    });
};
</script>

<!-- <template>
    <GuestLayout>
        <Head title="Register" />

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel
                    for="password_confirmation"
                    value="Confirm Password"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <div class="mt-4 flex items-center justify-end">
                <Link
                    :href="route('login')"
                    class="rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Already registered?
                </Link>

                <PrimaryButton
                    class="ms-4"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template> -->
<template>
    <section class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
      <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Registro</h2>
  
        <!-- Formulario -->
        <form @submit.prevent="submit" class="space-y-4">
  
          <!-- Nome -->
          <div>
            <label for="name" class="block text-lg font-medium text-gray-700">Nome</label>
            <input
              id="name"
              type="text"
              class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              v-model="form.name"
              required
              autofocus
              autocomplete="name"
            />
            <span v-if="form.errors.name" class="text-red-500 text-sm mt-2">{{ form.errors.name }}</span>
          </div>
  
          <!-- Email -->
          <div>
            <label for="email" class="block text-lg font-medium text-gray-700">Email</label>
            <input
              id="email"
              type="email"
              class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              v-model="form.email"
              required
              autocomplete="username"
            />
            <span v-if="form.errors.email" class="text-red-500 text-sm mt-2">{{ form.errors.email }}</span>
          </div>
  
          <!-- Senha -->
          <div>
            <label for="password" class="block text-lg font-medium text-gray-700">Senha</label>
            <input
              id="password"
              type="password"
              class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              v-model="form.password"
              required
              autocomplete="new-password"
            />
            <span v-if="form.errors.password" class="text-red-500 text-sm mt-2">{{ form.errors.password }}</span>
          </div>
  
          <!-- Confirmar Senha -->
          <div>
            <label for="password_confirmation" class="block text-lg font-medium text-gray-700">Confirmação de Senha</label>
            <input
              id="password_confirmation"
              type="password"
              class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
              v-model="form.password_confirmation"
              required
              autocomplete="new-password"
            />
            <span v-if="form.errors.password_confirmation" class="text-red-500 text-sm mt-2">{{ form.errors.password_confirmation }}</span>
          </div>
  
          <!-- Links e Botões -->
          <div class="mt-6 flex items-center justify-between">
            <a href="/login" class="text-sm text-gray-600 hover:text-gray-900 underline">Possui conta? Acessar</a>
            <button
              type="submit"
              :class="[{
                'opacity-25': form.processing
              }, 'bg-blue-500 text-white py-3 px-6 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500']"
              :disabled="form.processing"
            >
              Registrar
            </button>
          </div>
        </form>
      </div>
    </section>
  </template>