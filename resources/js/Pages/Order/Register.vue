<script>
  export default {
    data() {
      return {
        form: {
          fullName: localStorage.getItem('fullName') || '',
          state: '',
          city: '',
          departureDate: '',
          returnDate: ''
        },
        states: [],
        cities: [],
        errors: {}
      };
    },
    methods: {
      async fetchStates() {
        try {
          const response = await fetch('https://brasilapi.com.br/api/ibge/uf/v1');
          this.states = await response.json();
        } catch (error) {
          console.error('Erro ao buscar estados:', error);
        }
      },
      async fetchCities() {
        const selectedState = this.states.find(
          (state) => state.nome === this.form.state
        );
        if (!selectedState) return;
  
        try {
          const response = await fetch(
            `https://brasilapi.com.br/api/ibge/municipios/v1/${selectedState.sigla}`
          );
          this.cities = await response.json();
        } catch (error) {
          console.error('Erro ao buscar cidades:', error);
        }
      },
      validateForm() {
        this.errors = {};
  
        if (!this.form.state) {
          this.errors.state = true;
        }
        if (!this.form.city) {
          this.errors.city = true;
        }
        if (!this.form.departureDate) {
          this.errors.departureDate = true;
        }
  
        return Object.keys(this.errors).length === 0;
      },
      async handleSubmit() {
        if (!this.validateForm()) return;
  
        const formData = {
          fullName: this.form.fullName,
          state: this.form.state,
          city: this.form.city,
          departureDate: this.form.departureDate,
          returnDate: this.form.returnDate || null
        };
  
        try {
          const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json',
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
          });
  
          if (response.ok) {
            alert('Pedido enviado com sucesso!');
            this.resetForm();
          } else {
            console.error('Erro ao enviar o pedido');
          }
        } catch (error) {
          console.error('Erro no envio do pedido:', error);
        }
      },
      resetForm() {
        this.form = {
          fullName: localStorage.getItem('fullName') || '',
          state: '',
          city: '',
          departureDate: '',
          returnDate: ''
        };
        this.errors = {};
        this.cities = [];
      }
    },
    mounted() {
      this.fetchStates();
    }
  };
  </script>
  <template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-blue-500 to-teal-500">
      <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
        <div class="flex justify-end mb-6">
        <a
          href="/logout"
          class="bg-purple-600 text-white px-6 py-2 rounded-lg hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500"
        >
          Sair
        </a>
      </div>
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Registro de Pedido</h1>
        <form @submit.prevent="handleSubmit" @reset="resetForm" class="space-y-6">

          <div>
            <label for="fullName" class="block text-sm font-semibold text-gray-700 mb-2">Nome Completo</label>
            <input
              type="text"
              id="fullName"
              v-model="form.fullName"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
              placeholder="Digite seu nome completo"
            />
          </div>
  

          <div>
            <label for="state" class="block text-sm font-semibold text-gray-700 mb-2">Estado</label>
            <input
              type="text"
              id="state"
              list="states"
              v-model="form.state"
              @change="fetchCities"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
              placeholder="Selecione seu estado"
            />
            <datalist id="states">
              <option v-for="state in states" :key="state.sigla" :value="state.nome"></option>
            </datalist>
            <p v-if="errors.state" class="text-red-500 text-xs mt-1">Esse campo deve ser preenchido</p>
          </div>
  

          <div>
            <label for="city" class="block text-sm font-semibold text-gray-700 mb-2">Cidade</label>
            <input
              type="text"
              id="city"
              list="cities"
              v-model="form.city"
              :disabled="!form.state || cities.length === 0"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
              placeholder="Selecione sua cidade"
            />
            <datalist id="cities">
              <option v-for="city in cities" :key="city.id" :value="city.nome"></option>
            </datalist>
            <p v-if="errors.city" class="text-red-500 text-xs mt-1">Esse campo deve ser preenchido</p>
          </div>
  

          <div>
            <label for="departureDate" class="block text-sm font-semibold text-gray-700 mb-2">Data de Ida</label>
            <input
              type="date"
              id="departureDate"
              v-model="form.departureDate"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
            />
            <p v-if="errors.departureDate" class="text-red-500 text-xs mt-1">Esse campo deve ser preenchido</p>
          </div>
  

          <div>
            <label for="returnDate" class="block text-sm font-semibold text-gray-700 mb-2">Data de Volta (Opcional)</label>
            <input
              type="date"
              id="returnDate"
              v-model="form.returnDate"
              class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500"
            />
          </div>
  

          <div class="flex space-x-4 justify-center">
            <button
              type="submit"
              class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500"
            >
              Enviar
            </button>
            <button
              type="reset"
              class="bg-gray-500 text-white px-6 py-3 rounded-lg shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500"
            >
              Resetar
            </button>
          </div>
        </form>
      </div>
    </div>
  </template>