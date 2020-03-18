<template>
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
        <div class="flex-1 flex justify-between sm:hidden">
            <a href="#"
               class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Previous
            </a>
            <a href="#"
               class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                Next
            </a>
        </div>
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm leading-5 text-gray-700">
                    Showing
                    <span class="font-medium">{{ from }}</span>
                    to
                    <span class="font-medium">{{ to }}</span>
                    of
                    <span class="font-medium">{{ total }}</span>
                    results
                </p>
            </div>
            <div>
      <span class="relative z-0 inline-flex shadow-sm">
        <button v-if="page > 1" @click="changePage(page - 1)" type="button"
                class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                  clip-rule="evenodd"/>
          </svg>
        </button>
        <button v-if="page > 3" @click="changePage(page - 3)" type="button"
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
          {{ page - 3 }}
        </button>
        <button v-if="page > 2" @click="changePage(page - 2)" type="button"
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
          {{ page - 2 }}
        </button>
        <button v-if="page > 1" @click="changePage(page - 1)" type="button"
                class="hidden md:inline-flex -ml-px relative items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
          {{ page - 1 }}
        </button>
        <span class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-green-100 text-sm leading-5 font-medium text-gray-700">
          {{ page }}
        </span>
        <button v-if="lastPage > page" @click="changePage(page + 1)" type="button"
                class="hidden md:inline-flex -ml-px relative items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
          {{ page + 1 }}
        </button>
        <button v-if="lastPage > (page + 1)" @click="changePage(page + 2)" type="button"
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
            {{ page + 2 }}
        </button>
        <button v-if="lastPage > (page + 2)" @click="changePage(page + 3)" type="button"
                class="-ml-px relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
          {{ page + 3 }}
        </button>
        <button v-if="lastPage > page" @click="changePage(page + 1)" type="button"
                class="-ml-px relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm leading-5 font-medium text-gray-500 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150">
          <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                  d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                  clip-rule="evenodd"/>
          </svg>
        </button>
      </span>
            </div>
        </div>
    </div>
</template>

<script>
  export default {
    props: {
      page: {
        type: Number,
        required: true
      },
      perPage: {
        type: Number,
        required: true
      },
      total: {
        type: Number,
        required: true
      }
    },
    computed: {
      from: function () {
        return this.page > 1 ? (this.perPage > 1 ? this.page - 1 : this.page) * this.perPage : (this.total > 0 ? 1 : 0);
      },
      to: function () {
        return this.page > 1 ? this.page * this.perPage : (this.total > 0 ? (this.total > this.perPage ? this.perPage : this.total) : 0);
      },
      lastPage: function () {
        return this.total && this.perPage ? Math.ceil(this.total / this.perPage) : 0;
      }
    },
    methods: {
      changePage(page) {
        this.$emit('page-changed', page);
      }
    }
  }
</script>