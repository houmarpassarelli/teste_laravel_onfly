<script>
  export default {
    data() {
      return {
        forms: [],
      };
    },
    methods: {
      async fetchForms() {
        try {
          const response = await fetch('/api/orders');
          if (response.ok) {
            this.forms = await response.json();
          } else {
            console.error('Erro ao carregar a lista de formulários');
          }
        } catch (error) {
          console.error('Erro na requisição:', error);
        }
      },
      async updateStatus(id, status) {
        try {

        status = !status;
        
          const response = await fetch(`/api/orders/${id}`, {
            method: 'PUT',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({ status }),
          });
  
          if (response.ok) {
            this.fetchForms(); // Atualiza a lista após o update
          } else {
            console.error('Erro ao atualizar o status');
          }
        } catch (error) {
          console.error('Erro na requisição:', error);
        }
      },
    },
    mounted() {
      this.fetchForms();
    },
  };
</script>
<!-- <template>
    <div class="p-4">
      <h1 class="text-2xl font-bold mb-4">Lista de Formulários</h1>
  
      <table class="table-auto w-full border-collapse border border-gray-300">
        <thead>
          <tr class="bg-gray-100">
            <th class="border border-gray-300 px-4 py-2">Nome Completo</th>
            <th class="border border-gray-300 px-4 py-2">Estado</th>
            <th class="border border-gray-300 px-4 py-2">Cidade</th>
            <th class="border border-gray-300 px-4 py-2">Data de Ida</th>
            <th class="border border-gray-300 px-4 py-2">Data de Volta</th>
            <th class="border border-gray-300 px-4 py-2">Status</th>
            <th class="border border-gray-300 px-4 py-2">Ações</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="form in forms" :key="form.id" class="text-center">
            <td class="border border-gray-300 px-4 py-2">
                <a :href="`/orders/${form.id}`">{{ form.fullName }}</a>
            </td>
            <td class="border border-gray-300 px-4 py-2">{{ form.state }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ form.city }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ form.departureDate }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ form.returnDate || 'Não especificado' }}</td>
            <td class="border border-gray-300 px-4 py-2">{{ form.status == 1 ? "Aprovado" : "Cancelado" }}</td>
            <td class="border border-gray-300 px-4 py-2">
              <button 
                @click="updateStatus(form.id, form.status)"
                class="bg-green-500 text-white px-4 py-2 rounded">
                Alterar Status
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template> -->
  <template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Lista de Formulários</h1>
  
        <table class="table-auto w-full border-collapse border border-gray-300">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="border border-gray-300 px-4 py-2">Nome Completo</th>
              <th class="border border-gray-300 px-4 py-2">Estado</th>
              <th class="border border-gray-300 px-4 py-2">Cidade</th>
              <th class="border border-gray-300 px-4 py-2">Data de Ida</th>
              <th class="border border-gray-300 px-4 py-2">Data de Volta</th>
              <th class="border border-gray-300 px-4 py-2">Status</th>
              <th class="border border-gray-300 px-4 py-2">Ações</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="form in forms" :key="form.id" class="text-center hover:bg-gray-50">
              <td class="border border-gray-300 px-4 py-3">
                <a :href="`/orders/resume/${form.id}`" class="text-blue-600 hover:underline">
                  {{ form.fullName }}
                </a>
              </td>
              <td class="border border-gray-300 px-4 py-3">{{ form.state }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ form.city }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ form.departureDate }}</td>
              <td class="border border-gray-300 px-4 py-3">{{ form.returnDate || 'Não especificado' }}</td>
              <td class="border border-gray-300 px-4 py-3">
                <span :class="form.status === 1 ? 'text-green-500' : 'text-red-500'">
                  {{ form.status === 1 ? 'Aprovado' : 'Cancelado' }}
                </span>
              </td>
              <td class="border border-gray-300 px-4 py-3">
                <button 
                  @click="updateStatus(form.id, form.status)"
                  class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500">
                  Alterar Status
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </template>