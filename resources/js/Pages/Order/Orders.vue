<script>
export default {
  data() {
    return {
      forms: [],
      states: [],
      cities: [],
      filters: {
        departureDate: '',
        returnDate: '',
        state: '',
        city: '',
      },
    };
  },
  methods: {
    async fetchForms() {
      try {
        const response = await fetch('/api/orders/list', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(this.filters),
        });

        if (response.ok) {
          this.forms = await response.json();
        } else {
          console.error('Erro ao carregar a lista de formulários');
        }
      } catch (error) {
        console.error('Erro na requisição:', error);
      }
    },

    async fetchStates() {
      try {
        const response = await fetch('https://brasilapi.com.br/api/ibge/uf/v1');
        if (response.ok) {
          this.states = await response.json();
        } else {
          console.error('Erro ao carregar estados');
        }
      } catch (error) {
        console.error('Erro na requisição de estados:', error);
      }
    },

    async fetchCities() {
      if (this.filters.state) {
        try {
          
          const selectedState = this.states.find(
            (state) => state.nome === this.filters.state
          );

          const response = await fetch(
            `https://brasilapi.com.br/api/ibge/municipios/v1/${selectedState.sigla}`
          );
          if (response.ok) {
            this.cities = await response.json();
          } else {
            console.error('Erro ao carregar cidades');
          }
        } catch (error) {
          console.error('Erro na requisição de cidades:', error);
        }
      } else {
        this.cities = [];
      }
    },

    updateStatus(id, status) {
      status = !status;
      fetch(`/api/orders/${id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
        body: JSON.stringify({ status }),
      })
        .then((response) => {
          if (response.ok) {
            this.fetchForms();
          } else {
            console.error('Erro ao atualizar o status');
          }
        })
        .catch((error) => {
          console.error('Erro na requisição:', error);
        });
    },
  },

  watch: {
    'filters.state': 'fetchCities',
  },

  mounted() {
    this.fetchForms();
    this.fetchStates();
  },
};
</script>

<template>
  <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
    <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-5xl">
      <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Lista de Formulários</h1>

      <!-- Filtro -->
      <div class="mb-6 flex justify-between">
        <div class="flex gap-4">
          <div>
            <label for="departureDate" class="block text-gray-600">Data de Ida</label>
            <input
              type="date"
              id="departureDate"
              v-model="filters.departureDate"
              class="border border-gray-300 px-4 py-2 rounded"
            />
          </div>
          <div>
            <label for="returnDate" class="block text-gray-600">Data de Volta</label>
            <input
              type="date"
              id="returnDate"
              v-model="filters.returnDate"
              class="border border-gray-300 px-4 py-2 rounded"
            />
          </div>
        </div>

        <div class="flex gap-4">
          <div>
            <label for="state" class="block text-gray-600">Estado</label>
            <select
              id="state"
              v-model="filters.state"
              @change="fetchCities"
              class="border border-gray-300 px-4 py-2 rounded"
            >
              <option value="">Selecione um estado</option>
              <option v-for="state in states" :key="state.sigla" :value="state.nome">
                {{ state.nome }}
              </option>
            </select>
          </div>

          <div>
            <label for="city" class="block text-gray-600">Cidade</label>
            <select
              id="city"
              v-model="filters.city"
              class="border border-gray-300 px-4 py-2 rounded"
              :disabled="!filters.state"
            >
              <option value="">Selecione uma cidade</option>
              <option v-for="city in cities" :key="city.id" :value="city.nome">
                {{ city.nome }}
              </option>
            </select>
          </div>
        </div>

        <div>
          <button
            @click="fetchForms"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
          >
            Filtrar
          </button>
        </div>
      </div>

      <!-- Tabela -->
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
                class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500"
              >
                Alterar Status
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
