import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '@/store';
import middlewarePipeline from '@/router/middlewarePipeline';

import Home from '@/views/Home.vue';
import Login from '@/views/Login.vue';
import Register from '@/views/Register.vue';

import Layout from '@/views/Layout.vue';

import guest from '@/router/middleware/guest';
import authenticated from "./middleware/authenticated";

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    component: Layout,
    children: [
      {
        path: '/',
        name: 'home',
        component: Home,
        meta: {
          middleware: [
            authenticated,
          ]
        },
      }
    ]
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    meta: {
      middleware: [
        guest,
      ]
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    meta: {
      middleware: [
        guest,
      ]
    }
  }
];

const router = new VueRouter({routes});

router.beforeEach(async (to, from, next) => {
  if (!to.meta.middleware) {
    return next()
  }

  // check auth state once
  await store.dispatch('user/fetchUserOnce');

  const middleware = to.meta.middleware;
  const context = {to, from, next, store: store};

  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1)
  });

});

export default router;
