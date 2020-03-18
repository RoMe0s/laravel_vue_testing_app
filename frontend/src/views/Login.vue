<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <h2 class="mt-6 mb-6 text-center text-3xl leading-9 font-extrabold text-gray-900">
                Sign in to your account
            </h2>
            <ValidationObserver ref="observer">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="login">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email
                        </label>
                        <ValidationProvider name="email" rules="required|email" v-slot="{ errors }">
                            <input v-model="email"
                                   type="email"
                                   id="email"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   :class="{'border-red-500 mb-3': !!errors.length}"
                                   aria-label="Email address"
                                   placeholder="Email address"/>
                            <p class="text-red-500 text-xs italic" v-for="error of errors" :key="error">{{ error }}</p>
                        </ValidationProvider>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                            Password
                        </label>
                        <ValidationProvider name="password" rules="required" v-slot="{ errors }">
                            <input v-model="password"
                                   type="password"
                                   id="password"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   :class="{'border-red-500 mb-3': !!errors.length}"
                                   aria-label="Password"
                                   placeholder="Password"/>
                            <p class="text-red-500 text-xs italic" v-for="error of errors" :key="error">{{ error }}</p>
                        </ValidationProvider>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <div class="flex items-center">
                            <input v-model="remember"
                                   id="remember_me"
                                   type="checkbox"
                                   class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"/>
                            <label for="remember_me" class="ml-2 block text-sm leading-5 text-gray-900">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit"
                                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:border-indigo-700 focus:shadow-outline-indigo active:bg-indigo-700 transition duration-150 ease-in-out">
                                  <span class="absolute left-0 inset-y pl-3">
                                    <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400 transition ease-in-out duration-150"
                                         fill="currentColor" viewBox="0 0 20 20">
                                      <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd"/>
                                    </svg>
                                  </span>
                            Sign in
                        </button>
                    </div>

                    <div class="mt-6 text-center">
                        <router-link to="/register" v-slot="{href, navigate}">
                            <a :href="href" @click="navigate"
                               class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                Sign up
                            </a>
                        </router-link>
                    </div>

                </form>
            </ValidationObserver>
        </div>
    </div>
</template>
<script>
  import {ValidationObserver} from 'vee-validate';
  import {extend} from 'vee-validate';
  import {required, email} from 'vee-validate/dist/rules';
  import {mapActions} from 'vuex';
  import {toastr} from '@/lib/toastr';

  extend('required', required);
  extend('email', email);

  export default {
    data() {
      return {
        email: null,
        password: null,
        remember: false
      };
    },
    components: {
      ValidationObserver
    },
    methods: {
      ...mapActions({
        authorize: 'user/authorize',
      }),
      async login() {
        const isValid = await this.$refs.observer.validate();

        if (!isValid) return;

        try {
          await this.authorize({email: this.email, password: this.password, remember: this.remember});
        } catch (e) {
          Object.values(e.response.data.errors).flat().forEach(toastr.error);
          return;
        }

        await this.$router.push({name: 'home'});
      }
    }
  }
</script>
