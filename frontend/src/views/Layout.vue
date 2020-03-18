<template>
    <div>
        <nav class="bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline">
                                <router-link to="/" v-slot="{href, navigate, isActive}">
                                    <a :href="href" @click="navigate"
                                       class="px-3 py-2 rounded-md text-sm font-medium text-white focus:outline-none focus:text-white focus:bg-gray-700"
                                       :class="{'bg-gray-900': isActive}">
                                        Sites
                                    </a>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <div class="ml-3 relative">
                                <div>
                                    <button class="max-w-xs flex items-center text-sm rounded-full text-white focus:outline-none"
                                            @click="showDropDown = !showDropDown"
                                            :class="{'focus:shadow-solid': showDropDown}">
                                        <img class="h-8 w-8 rounded-full" :src="avatar" alt="Avatar"/>
                                    </button>
                                </div>
                                <div v-if="showDropDown"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95"
                                     class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg">
                                    <div class="py-1 rounded-md bg-white shadow-xs">
                                        <button class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                                @click.prevent="handleLogout">
                                            Sign out
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <router-view/>
    </div>
</template>
<script>
  import {mapActions, mapGetters} from 'vuex';
  import gravatar from 'gravatar';

  export default {
    data() {
      return {
        showDropDown: false,
      }
    },
    computed: {
      ...mapGetters({
        user: 'user/getUser',
      }),
      avatar: function () {
        return this.user ? gravatar.url(this.user.email, {s: '32'}) : null;
      }
    },
    methods: {
      ...mapActions({
        logout: 'user/logout',
      }),
      handleLogout() {
        this.logout();
        this.$router.push({name: 'login'});
      }
    }
  }
</script>