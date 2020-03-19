<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full">
            <h2 class="mt-6 mb-6 text-center text-3xl leading-9 font-extrabold text-gray-900"> Sign in to your account
            </h2>
            <ValidationObserver ref="observer">
                <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4" @submit.prevent="signUp">
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
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                            Name
                        </label>
                        <ValidationProvider name="name" rules="required|max:255" v-slot="{ errors }">
                            <input v-model="name"
                                   id="name"
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
                        <ValidationProvider name="password" rules="required|max:24|confirmed:password_confirmation"
                                            v-slot="{ errors }">
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
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="password_confirmation">
                            Password confirmation
                        </label>
                        <ValidationProvider vid="password_confirmation">
                            <input v-model="passwordConfirmation"
                                   type="password"
                                   id="password_confirmation"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   aria-label="Password confirmation"
                                   placeholder="Password confirmation"/>
                        </ValidationProvider>
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
                            Sign up
                        </button>
                    </div>

                    <hr>

                    <div class="mt-6 text-center">
                        <router-link to="/login" v-slot="{href, navigate}">
                            <a :href="href" @click="navigate"
                               class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150">
                                Sign in
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
  import {required, email, max, confirmed} from 'vee-validate/dist/rules';
  import {mapActions} from 'vuex';
  import {toastr} from '@/lib/toastr';

  extend('required', required);
  extend('email', email);
  extend('max', max);
  extend('confirmed', confirmed);

  export default {
    data() {
      return {
        email: null,
        name: null,
        password: null,
        passwordConfirmation: null
      };
    },
    components: {
      ValidationObserver
    },
    methods: {
      ...mapActions({
        register: 'user/register',
      }),
      async signUp() {
        const isValid = await this.$refs.observer.validate();

        if (!isValid) return;

        try {
          await this.register({
            email: this.email,
            name: this.name,
            password: this.password,
            password_confirmation: this.passwordConfirmation
          });
        } catch (e) {
          Object.values(e.response.data.errors).flat().forEach(toastr.error);
          return;
        }

        toastr.success('Registration was successful!');

        await this.$router.push({name: 'login'});
      }
    }
  }
</script>

