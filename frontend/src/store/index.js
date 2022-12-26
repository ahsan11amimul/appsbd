import { createStore } from 'vuex'
import axiosClient from '../axios';
const tmp = [
    {
        id: 1,
        name: 'mango',
        price: 10.00,
        image: "https://cdn.pixabay.com/photo/2016/06/20/13/16/greengrocers-1468809__340.jpg"
    },
    {
        id: 2,
        name: 'Apple',
        price: 20.00,
        image: "https://cdn.pixabay.com/photo/2016/06/20/13/16/greengrocers-1468809__340.jpg"
    },
    {
        id: 3,
        name: 'Banana',
        price: 30.00,
        image: "https://cdn.pixabay.com/photo/2016/06/20/13/16/greengrocers-1468809__340.jpg"
    },
];
const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem('TOKEN'),
        },
        products: [],
        cart: [],
        order: [],
    },
    getters: {},
    actions: {
        register({ commit }, user) {
            return axiosClient.post('/register', user)
                .then(({ data }) => {
                    //console.log(data);
                    commit('setUser', data);
                    return data;
                })
        },
        login({ commit }, user) {
            return axiosClient.post('/login', user)
                .then(({ data }) => {
                    commit('setUser', data);
                    return data;
                })
        },
        logout({ commit }) {
            return axiosClient.post('/logout')
                .then(response => {
                    commit('logout');
                    return response;
                })
        },
        getProducts({ commit }) {
            return axiosClient.get('/products').then(res => {
                commit('setProducts', res.data);
                //console.log(res.data);
                return res;
            })
        },
        saveProduct({ commit }, product) {
            let response;
            if (product.id) {
                response = axiosClient.put(`/products/${product.id}`, product).then((res) => {
                    commit('updateProduct', res.data);
                    return res;
                });
            } else {
                response = axiosClient.post('/products', product).then((res) => {
                    commit('saveProduct', res.data);
                    return res;
                });
            }
            return response;
        },
        add_to_cart({ commit }, id) {
            return axiosClient.post('/cart', { id }).then((res) => {
                commit('set_to_cart', res.data);
                return res;
            })

        },
        getCartItems({ commit }) {
            return axiosClient.get('/cart').then((res) => {

                commit('items_in_cart', res.data);
                return res;
            })
        },
        removeFromCart({ commit }, id) {
            return axiosClient.post('/cart/remove', { id }).then((res) => {
                commit('update_cart', res.data);
                return res;
            })
        },
        placeOrder({ commit }) {
            return axiosClient.post('/order').then((res) => {
                commit('updateOrder', res.data);
                return res;
            })
        },
        getOrder({ commit }) {
            return axiosClient.get('/order').then((res) => {
                commit('setOrder', res.data);
                return res;
            })
        }

    },
    mutations: {
        logout: (state) => {
            state.user.data = {};
            state.user.token = null;
            sessionStorage.removeItem('TOKEN');
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.data = userData.token;
            sessionStorage.setItem('TOKEN', userData.token);
        }, saveProduct: (state, product) => {
            state.products = [...state.products, product.data];
        },
        updateProduct: (state, product) => {
            state.products = state.products.map((s) => {
                if (s.id == product.data.id) {
                    return product.data;
                }
                return s;
            })
        }, saveProduct: (state, product) => {
            // console.log(product);
            state.products = product.data;
        }, setProducts: (state, products) => {
            //console.log(products.data);

            state.products = products.data;
        }, set_to_cart: (state, carts) => {

            state.cart = carts.data;

        }, items_in_cart: (state, carts) => {
            //console.log(carts.data);
            state.cart = carts.data;
            // console.log(state.cart);
        },
        update_cart: (state, carts) => {
            state.cart = carts.data;
        },
        updateOrder: (state, orders) => {
            state.order = orders.data;
        },
        setOrder: (state, orders) => {
            state.order = orders.data;
        }
    },
    modules: {}
});
export default store;