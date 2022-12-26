<template>
    <PageComponent>
        <template v-slot:header>
            <div class="flex justify-between items-center">
               <h1 class="text-3xl font-bold text-gray-900">Products</h1>
               <router-link
               :to="{name : 'ProductCreate'}"
               class="py-2 px-3 text-white bg-emerald-500 rounded-md hover:bg-emerald-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-6 h-6 -mt-1 inline-block">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
 
               add new product
               </router-link> 
            </div>
             
        </template>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3">
           <div v-for="product in products"
           :key="product.id"
           class="flex flex-col py-4 px-6 shadow-md bg-white hover:bg-gray-50 h-[470px]">
           <img :src="product.image_url" alt="" class="w-full h-48 object-cover"/>
           <div class="flex justify-between items-center">
            <h4 class="mt-4 text-lg font-bold">{{ product.name }}</h4>
            <h4 class="mt-4 text-lg font-bold">${{ product.price }}</h4>
           </div>
           <h5 class="mt-2 text-lg text-gray-300">{{  product.description}}</h5>
           <div class="flex justify-between items-center mt-3">
           
            <button v-if="product.id" type="button" @click="addToCart(product.id)"
            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
             Add To Cart

                
            </button>
           </div>
            

           </div>
        </div>
    </PageComponent>
</template>

<script setup>
import PageComponent from '../components/PageComponent.vue';
import store from '../store';
import { computed } from 'vue';
store.dispatch('getProducts');
const products=computed(()=>store.state.products)
function addToCart(id)
{
  store.dispatch('add_to_cart',id)
  .then(({data})=>{
  console.log(data);
  })
}
</script>