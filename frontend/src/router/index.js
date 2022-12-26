import { createRouter, createWebHistory } from 'vue-router';
import Dashboard from '../views/Dashboard.vue'
import DefaultLayout from '../components/DefaultLayout.vue'
import AuthLayout from '../components/AuthLayout.vue'
import Products from '../views/Products.vue'
import ProductView from '../views/ProductView.vue'
import Login from '../views/Login.vue'
import store from '../store';
import Register from '../views/Register.vue'
import Cart from '../views/Cart.vue'
import Order from '../views/Order.vue'
const routes = [
    {
        path: '/',
        redirect: '/dashboard',
        meta: { requiresAuth: true },
        component: DefaultLayout,
        children: [
            { path: '/dashboard', name: 'Dashboard', component: Dashboard },
            { path: '/products', name: 'Products', component: Products },
            { path: '/products/create', name: 'ProductCreate', component: ProductView },
            { path: '/products/:id', name: 'ProductView', component: ProductView },
            { path: '/cart', name: 'Cart', component: Cart },
            { path: '/order', name: 'Order', component: Order },
        ]
    },
    {
        path: '/auth',
        redirect: '/login',
        meta: { isGuest: true },
        component: AuthLayout,
        children: [
            {
                path: '/login',
                name: 'Login',
                component: Login
            },
            {
                path: '/register',
                name: 'Register',
                component: Register
            },
        ]
    }

];
const router = createRouter({
    history: createWebHistory(),
    routes
});
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'Login' })
    } else if (store.state.user.token && to.meta.isGuest) {
        next({ name: 'Dashboard' })
    }
    else {
        next();
    }
})
export default router;